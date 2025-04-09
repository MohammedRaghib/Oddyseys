<?php

$dbFilePath = './travel.db';

try {
    $pdo = new PDO("sqlite:" . $dbFilePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    header('Content-Type: application/json');

    if (isset($_POST['country']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedCountry = $_POST['country'];

        $get_parks_query = 'SELECT parks.name FROM parks WHERE country = :country';
        $park_stmt = $pdo->prepare($get_parks_query);
        $park_stmt->execute([':country' => $selectedCountry]);

        $parks = [];
        while ($park_row = $park_stmt->fetch(PDO::FETCH_ASSOC)) {
            $parks[] = ['name' => htmlspecialchars($park_row['name'])];
        }

        echo json_encode(['status' => 'success', 'parks' => $parks]);
    }

    if (isset($_POST['park']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedPark = $_POST['park'];

        $get_hotels_query = 'SELECT park_hotels.hotel FROM park_hotels 
                             JOIN parks ON park_hotels.park_id = parks.id 
                             WHERE parks.name = :park 
                             ORDER BY park_hotels.hotel ASC';
        $hotel_stmt = $pdo->prepare($get_hotels_query);
        $hotel_stmt->execute([':park' => $selectedPark]);

        $hotels = [];
        while ($row = $hotel_stmt->fetch(PDO::FETCH_ASSOC)) {
            $hotels[] = ['hotel' => htmlspecialchars($row['hotel'])];
        }

        echo json_encode(['status' => 'success', 'hotels' => $hotels]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $for = $_GET['for'] ?? '';

        if ($for === 'hotelpage') {
            try {
                $get_parks_query = 'SELECT name, country, id FROM parks ORDER BY name ASC';
                $park_stmt = $pdo->prepare($get_parks_query);
                $park_stmt->execute();

                $parks = [];
                while ($park_row = $park_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $parks[] = [
                        'name' => htmlspecialchars($park_row['name']),
                        'country' => htmlspecialchars($park_row['country']),
                        'id' => htmlspecialchars($park_row['id']),
                    ];
                }

                $get_hotels_query = 'SELECT 
                                park_hotels.id AS id,
                                park_hotels.hotel,
                                park_hotels.park_id,
                                parks.name AS park_name
                            FROM 
                                park_hotels
                            JOIN 
                                parks 
                            ON 
                                park_hotels.park_id = parks.id
                            ORDER BY 
                                park_hotels.hotel ASC;';
                $hotel_stmt = $pdo->prepare($get_hotels_query);
                $hotel_stmt->execute();

                $hotels = $hotel_stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode(['status' => 'success', 'parks' => $parks, 'hotels' => $hotels]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            }
        }else if($for = 'hotel_info'){
            $id = $_GET['id'] ?? '';

            $get_park_id_query = 'SELECT park_id FROM park_hotels WHERE id = :id';
            $park_id_stmt = $pdo ->prepare($get_park_id_query);
            $park_id_stmt->execute([':id' => $id]);

            $get_hotel_detail_query = 'SELECT * FROM hotel_rates WHERE hotel = :hotel';
            $hotel_detail_stmt = $pdo ->prepare($get_hotel_detail_query);
            $hotel_detail_stmt->execute([':hotel' => $id]);

            $hotel_detail = $hotel_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
            $park_id_row = $park_id_stmt->fetchAll(PDO::FETCH_ASSOC);
            $park_id = $park_id_row[0]['park_id'];

            $hotel_info = [
                'parkID'=> $park_id,
                'ranges' => $hotel_detail,
            ];
            echo json_encode(['status' => 'success', 'hotel_info' => $hotel_info]);
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
