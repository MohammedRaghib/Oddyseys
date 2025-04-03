<?php

$dbFilePath = './oddyseys.db';


$pdo = new PDO("sqlite:" . $dbFilePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $rawData = $_POST['invoice'];
    $P_DATA = json_decode($rawData, true);


    $data = [
        'DateIssue' => $P_DATA['DateIssue'] ?? '',
        'Customer Name 1' => $P_DATA['CustomerName1'] ?? '',
        'Days' => $P_DATA['Days'] ?? '',
        'ConservartionAdultCost' => $P_DATA['ConservationAdultCost'] ?? 0,
        'ConcessionAdultCost' => $P_DATA['ConcessionAdultCost'] ?? 0,
        'ConservartionChildrenCost' => $P_DATA['ConservationChildrenCost'] ?? 0,
        'ConcessionChildrenCost' => $P_DATA['ConcessionChildrenCost'] ?? 0,
        'ConservartionAdultCount' => $P_DATA['ConservationAdultCount'] ?? 0,
        'ConcessionAdultCount' => $P_DATA['ConcessionAdultCount'] ?? 0,
        'ConservartionChildrenCount' => $P_DATA['ConservationChildrenCount'] ?? 0,
        'ConcessionChildrenCount' => $P_DATA['ConcessionChildrenCount'] ?? 0,
        'ConservationTotal' => $P_DATA['ConservationTotal'] ?? 0,
        'ConcessionTotal' => $P_DATA['ConcessionTotal'] ?? 0,
        'HotelTotal' => $P_DATA['HotelTotal'] ?? 0,
        'CarHireTotal' => $P_DATA['CarHireTotal'] ?? 0,
        'FlightTotal' => $P_DATA['FlightTotal'] ?? 0,
        'ExtraTotal' => $P_DATA['ExtraTotal'] ?? 0,
        'Total' => $P_DATA['invoice_amount'] ?? 0,
        'Balance Due' => $P_DATA['invoice_amount'] ?? 0,
        'Balance Remaining' => $P_DATA['invoice_amount'] ?? 0,
        'Customer Name 2' => $P_DATA['CustomerName'] ?? '',
    ];

    $outputFile = __DIR__ . '/invoice.pdf';

    $invoiceData = [
        'invoice_date' => date('Y-m-d'),
        'customer_name' => $P_DATA['CustomerName'],
        'invoice_amount' => $P_DATA['invoice_amount'],
        'paid' => 0,
        'start_date' => $P_DATA['Dates']['StartDate'],
        'end_date' => $P_DATA['Dates']['EndDate'],
        'hotel_name' => $P_DATA['hotel_name'] ?? '',
        'park_name' => $P_DATA['park_name'],
        'extras_amount' => $P_DATA['extras_amount'] ?? 0.00,
        'extras_description' => $P_DATA['extras_desc'] ?? '',
        'discount_amount' => $P_DATA['discount_amount'] ?? 0.00,
        'cost_amount' => $P_DATA['cost_amount']
    ];

    $stmt = $pdo->prepare("
    INSERT INTO invoices (
        invoice_date, customer_name, invoice_amount, paid,
        start_date, end_date, hotel_name, park_name,
        extras_amount, extras_description, discount_amount, cost_amount
    ) VALUES (
        :invoice_date, :customer_name, :invoice_amount, :paid,
        :start_date, :end_date, :hotel_name, :park_name,
        :extras_amount, :extras_description, :discount_amount, :cost_amount
    )
");
    $stmt->execute($invoiceData);
    echo 'Succesfully created invoice!';
}
