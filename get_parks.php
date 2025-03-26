<?php

$dbFilePath = './oddyseys.db';

try {
    $pdo = new PDO("sqlite:" . $dbFilePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['country']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedCountry = $_POST['country'];

        $get_parks_query = 'SELECT name FROM park_conservation_fees WHERE country = :country';
        $park_stmt = $pdo->prepare($get_parks_query);
        $park_stmt->execute([':country' => $selectedCountry]);

        $options = '';
        $parks = [];
        while ($park_row = $park_stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!in_array($park_row['name'], $parks)) {
                $options .= '<option value="' . htmlspecialchars($park_row['name']) . '">' . htmlspecialchars($park_row['name']) . '</option>';
                array_push($parks, $park_row['name']);
            }
        }

        echo $options;
    }
    if (isset($_POST['park']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedPark = $_POST['park'];

        $get_hotels_query = 'SELECT hotel FROM park_hotels WHERE park = :park ORDER BY hotel ASC';
        $hotel_stmt = $pdo->prepare($get_hotels_query);
        $hotel_stmt->execute([':park' => $selectedPark]);

        $options = '';
        $options .= '<option value="' . htmlspecialchars("-SELECT HOTEL-") . '">' . htmlspecialchars("-SELECT HOTEL-") . '</option>';
        $hotels = [];

        while ($row = $hotel_stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!in_array($row['hotel'], $hotels)) {
                $options .= '<option value="' . htmlspecialchars($row['hotel']) . '">' . htmlspecialchars($row['hotel']) . '</option>';
                array_push($hotels, $row['hotel']);
            }
        }

        echo $options;
    }
} catch (PDOException $e) {
    echo '<option value="">Error: ' . htmlspecialchars($e->getMessage()) . '</option>';
}
