<?php

$dbHost = 'localhost';
$dbName = 'angeligh_huss';
$dbUser = 'husszain$2024';
$dbPass = 'angeligh_new';

$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_hotel') {
    $hotels = $_POST['hotel'] ?? [];
    $parks = $_POST['park'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $rates = $_POST['rate'] ?? [];

    if (
        is_array($hotels) && is_array($parks) &&
        is_array($start_dates) && is_array($end_dates) &&
        is_array($rates) && count($hotels) === count($parks) &&
        count($parks) === count($start_dates) &&
        count($start_dates) === count($end_dates) &&
        count($end_dates) === count($rates)
    ) {
        try {
            $pdo->beginTransaction();

            for ($i = 0; $i < count($hotels); $i++) {
                $stmt = $pdo->prepare('INSERT INTO park_hotels (hotel, park, start_date, end_date, rate) VALUES (:hotel, :park, :start_date, :end_date, :rate)');
                $stmt->execute([
                    ':hotel' => $hotels[$i],
                    ':park' => $parks[$i],
                    ':start_date' => $start_dates[$i],
                    ':end_date' => $end_dates[$i],
                    ':rate' => $rates[$i],
                ]);
            }

            $pdo->commit();
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Hotels added successfully']);
        } catch (PDOException $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data or mismatched array lengths.']);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['ID', 'hotel', 'park', 'start_date', 'end_date', 'rate'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            die("Error: The field '$field' is required.");
        }
    }

    $id = intval($_POST['ID']);
    $name = htmlspecialchars($_POST['hotel']);
    $park = htmlspecialchars($_POST['park']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $rate = floatval($_POST['rate']);

    $sql = "UPDATE park_hotels SET hotel = :hotel, park = :park, start_date = :start_date, end_date = :end_date, rate = :rate WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':hotel', $name, PDO::PARAM_STR);
        $stmt->bindParam(':park', $park, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $stmt->bindParam(':rate', $rate, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Hotel updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update hotel."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
}