<?php

require 'vendor/autoload.php';

use mikehaertl\pdftk\Pdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdftkPath = __DIR__ . '/pdftk.exe';

    $pdfFile = 'form.pdf';

    $data = [
        'DateIssue' => $_POST['DateIssue'] ?? '',
        'Customer Name 1' => $_POST['CustomerName1'] ?? '',
        'Days' => $_POST['Days'] ?? '',
        'Car Hire' => $_POST['CarHire'] ?? '',
        'Flight' => $_POST['Flight'] ?? '',
        'Extras' => $_POST['Extras'] ?? '',
        'Cost Adult' => $_POST['CostAdult'] ?? '',
        'Adults' => $_POST['Adults'] ?? '',
        'Cost Children' => $_POST['CostChildren'] ?? '',
        'Children' => $_POST['Children'] ?? '',
        'SubTotal' => $_POST['invoice_amount'] ?? '',
        'Total' => $_POST['invoice_amount'] ?? '',
        'Balance Due' => $_POST['invoice_amount'] ?? '',
        'Balance Remaining' => $_POST['BalanceRemaining'] ?? '',
        'Customer Name 2' => $_POST['CustomerName2'] ?? '',
    ];

    $pdf = new Pdf($pdfFile, ['command' => $pdftkPath]);

    $pdf->fillForm($data)
        ->flatten()
        ->saveAs('invoice.pdf');

    if ($pdf->getError()) {
        echo 'Error: ' . $pdf->getError();
    } else {
        echo 'PDF form fields filled successfully!';
    }
};
