<?php
/* Fees:
    1. Park fee - varies with visitor type and date
    2. Concession fee - varies visitor type and date. Is also per night
    3. Hotel fee - varies with date. Is also per night
    4. Car hire - days * rate
    5. Special fees - check for each park if there is one and add
    6. Extras - right now it is one amount just need to add to total, may need to be changed
    7. Flight - one amount just need to add to total
*/
/* All fees to check or calculate for each park:
    Ea adult - park fee
    Ea child - park fee
    Ea infant - park fee
    Non ea adult - park fee
    Non ea child - park fee
    Non ea infant - park fee
    TZ adult - park fee
    TZ child - park fee
    TZ infant - park fee
    Ea adult - concession fee
    Ea child - concession fee
    Ea infant - concession fee
    Non ea adult - concession fee
    Non ea child - concession fee
    Non ea infant - concession fee
    TZ adult - concession fee
    TZ child - concession fee
    TZ infant - concession fee
    total people * hotel fee
    total days * car hire
    special fees (if any)
*/
/* Tables (In sqlite format): 
    CREATE TABLE parks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        country TEXT CHECK(country IN ('kenya', 'tanzania')) NOT NULL
    );

    CREATE TABLE park_conservation_fees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        park_id INTEGER NOT NULL,
        visitor_type TEXT NOT NULL,
        start_date TEXT NOT NULL,
        end_date TEXT NOT NULL,
        currency TEXT CHECK(currency IN ('USD', 'KES', 'TZS')) NOT NULL,
        rate REAL NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );

    CREATE TABLE hotel_consession_fees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        country TEXT CHECK(country IN ('kenya', 'tanzania')) NOT NULL,
        visitor_type TEXT NOT NULL,
        start_date TEXT NOT NULL,
        end_date TEXT NOT NULL,
        currency TEXT CHECK(currency IN ('USD', 'KES', 'TZS')) NOT NULL,
        rate REAL NOT NULL
    );

    CREATE TABLE park_hotels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hotel TEXT NOT NULL,
        park_id INTEGER NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );

    CREATE TABLE hotel_rates (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hotel INTEGER NOT NULL,
        start_date TEXT NOT NULL,
        end_date TEXT NOT NULL,
        rate REAL NOT NULL,
        FOREIGN KEY (hotel) REFERENCES park_hotels(id) ON DELETE CASCADE
    );
*/
$pdo = new PDO("sqlite:./travel.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $people = $data['people'];
    $extras = $data['extras'];
    $flight = $data['flight'];
    $total = $data['total'];
    $profit = $data['profit'];
    $discount = $data['discount'];
    $invoice_amount = $data['invoice_amount'];
    $parks = $data['parks'];

    $parksData = [];
    foreach ($parks as $park) {
        $parkId = $park['park'];
        $sql = "SELECT * FROM parks WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $parkId]);
        $parkInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM park_conservation_fees WHERE park_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $parkId]);
        $parkInfo['conservation_fees'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hotel = $park['hotel'];
        $sql = "SELECT * FROM hotel_rates WHERE hotel = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $hotel]);
        $parkInfo['hotel_rates'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $parksData[] = $parkInfo;
        /* Format of the parkInfo array: [
            'id' => (int) Park ID,
            'name' => (string) Park Name,
            'country' => (string) Country,
            'conservation_fees' => [
                [
                    'id' => (int) Fee ID,
                    'park_id' => (int) Park ID,
                    'visitor_type' => (string) Visitor Type,
                    'start_date' => (string) Start Date,
                    'end_date' => (string) End Date,
                    'currency' => (string) Currency,
                    'rate' => (float) Rate
                ],
            ],
            'hotel_rates' => [
                [
                    'id' => (int) Rate ID,
                    'hotel' => (int) Hotel ID,
                    'start_date' => (string) Start Date,
                    'end_date' => (string) End Date,
                    'rate' => (float) Rate,
                ],
            ],
        
        ] */
    }


    echo json_encode($parksData);
    exit;
}
