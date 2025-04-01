<?php

require 'vendor/autoload.php';

use mikehaertl\pdftk\Pdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Define the path to your template PDF file
    $pdfFile = 'form.pdf';

    // Map the incoming POST data to the PDF fields
    $data = [
        'DateIssue' => $_POST['DateIssue'] ?? '',
        'Customer Name 1' => $_POST['CustomerName1'] ?? '',
        'Days' => $_POST['Days'] ?? '',
        'ConservartionAdultCost' => $_POST['ConservationAdultCost'] ?? 0,
        'ConcessionAdultCost' => $_POST['ConcessionAdultCost'] ?? 0,
        'ConservartionChildrenCost' => $_POST['ConservationChildrenCost'] ?? 0,
        'ConcessionChildrenCost' => $_POST['ConcessionChildrenCost'] ?? 0,
        'ConservartionAdultCount' => $_POST['ConservationAdultCount'] ?? 0,
        'ConcessionAdultCount' => $_POST['ConcessionAdultCount'] ?? 0,
        'ConservartionChildrenCount' => $_POST['ConservationChildrenCount'] ?? 0,
        'ConcessionChildrenCount' => $_POST['ConcessionChildrenCount'] ?? 0,
        'ConservationTotal' => $_POST['ConservationTotal'] ?? 0,
        'ConcessionTotal' => $_POST['ConcessionTotal'] ?? 0,
        'HotelTotal' => $_POST['HotelTotal'] ?? 0,
        'CarHireTotal' => $_POST['CarHireTotal'] ?? 0,
        'FlightTotal' => $_POST['FlightTotal'] ?? 0,
        'ExtraTotal' => $_POST['ExtraTotal'] ?? 0,
        'Total' => $_POST['Total'] ?? 0,
        'Balance Due' => $_POST['BalanceDue'] ?? 0,
        'Balance Remaining' => $_POST['BalanceRemaining'] ?? 0,
        'Customer Name 2' => $_POST['CustomerName2'] ?? '',
    ];

    $pdf = new Pdf($pdfFile);

    $outputFile = 'invoice_' . $_POST['CustomerName2'] . '.pdf';

    // Fill and flatten the form
    $result = $pdf->fillForm($data)
        ->flatten()
        ->saveAs($outputFile);

    if (!$result) {
        // Handle errors
        echo 'Error: ' . $pdf->getError();
    } else {
        echo "PDF generated successfully: $outputFile";
    }
}
