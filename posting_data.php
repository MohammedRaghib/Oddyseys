<?php

$dbFilePath = './travel.db';
$pdo = new PDO("sqlite:" . $dbFilePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    if ($action === 'add_hotel') {
        handleAddHotel($pdo, $_POST);
    } elseif ($action === 'update_hotel') {
        handleUpdateHotel($pdo, $_POST);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
}

function handleAddHotel($pdo, $postData)
{
    $input = file_get_contents('php://input');
    $postData = json_decode($input, true);
    $hotels = $postData['hotel'] ?? [];
    $seasons = $postData['seasons'] ?? [];

    if (empty($hotels['name']) || empty($hotels['park']) || !is_array($seasons)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        return;
    }

    $hotel_query = 'INSERT INTO park_hotels (hotel, park_id) VALUES (:name, :park)';
    $hotel_stmt = $pdo->prepare($hotel_query);

    try {
        $pdo->beginTransaction();

        $hotel_stmt->execute([':name' => $hotels['name'], ':park' => $hotels['park']]);
        $hotel_id = $pdo->lastInsertId();

        foreach ($seasons as $season) {
            $start_date = $season['start_date'];
            $end_date = $season['end_date'];
            $rate = $season['rate'];

            $query = 'INSERT INTO hotel_rates (hotel, start_date, end_date, rate) VALUES (:hotel, :start_date, :end_date, :rate)';
            $hotel_rate_stmt = $pdo->prepare($query);
            $hotel_rate_stmt->execute([
                ':hotel' => $hotel_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':rate' => $rate
            ]);
        }

        $pdo->commit();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Hotel added successfully!', 'hotel_id' => $hotel_id]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to add the hotel and its rates. Error: ' . $e->getMessage()]);
    }
}

function handleUpdateHotel($pdo, $postData)
{
    $input = file_get_contents('php://input');
    $postData = json_decode($input, true);

    $hotels = $postData['hotel'] ?? [];
    $seasons = $postData['seasons'] ?? [];
    $id = $hotels['ID'] ?? 0;

    if (empty($id) || empty($hotels['name']) || empty($hotels['park']) || !is_array($seasons)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        return;
    }

    $hotel_query = 'UPDATE park_hotels SET hotel = :name, park_id = :park WHERE id = :id';
    $hotel_stmt = $pdo->prepare($hotel_query);
    $hotel_stmt->execute([
        ':name' => $hotels['name'],
        ':park' => $hotels['park'],
        ':id' => $id
    ]);

    foreach ($seasons as $season) {
        $start_date = $season['start_date'] ?? null;
        $end_date = $season['end_date'] ?? null;
        $rate = $season['rate'] ?? null;
        $rate_id = $season['id'] ?? null;
    
        error_log("Processing season: " . json_encode($season)); 
    
        if ($rate_id) {
            // Update existing season
            $query = 'UPDATE hotel_rates SET start_date = :start_date, end_date = :end_date, rate = :rate WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':rate' => $rate,
                ':id' => $rate_id
            ]);
        } else {
            // Insert new season
            $query = 'INSERT INTO hotel_rates (hotel, start_date, end_date, rate) VALUES (:hotel, :start_date, :end_date, :rate)';
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':hotel' => $id, // Pass the current hotel ID
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':rate' => $rate
            ]);
        }
    
        error_log("Executed query for season: " . json_encode($season));
    }
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Hotel updated successfully!']);
}
