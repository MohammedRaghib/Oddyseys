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
        $selectedCountry = $_POST['park'];

        $get_parks_query = 'SELECT name FROM park_hotels WHERE park = :park';
        $hotel_stmt = $pdo->prepare($get_parks_query);
        $hotel_stmt->execute([':park' => $selectedCountry]);

        $options = '';
        $hotels = [];
        while ($hotel_row = $hotel_stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!in_array($hotel_row['name'], $parks)) {
                $options .= '<option value="' . htmlspecialchars($hotel_row['name']) . '">' . htmlspecialchars($park_row['name']) . '</option>';
                array_push($hotels, $hotel_row['name']);
            }
        }

        echo $options;
    }
} catch (PDOException $e) {
    echo '<option value="">Error: ' . htmlspecialchars($e->getMessage()) . '</option>';
}
