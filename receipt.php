<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipts</title>
</head>

<body>
    <?php
    $dbFilePath = './oddyseys.db';


    $pdo = new PDO("sqlite:" . $dbFilePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $table = 'invoices';
    $stmt = $pdo->prepare("SELECT * FROM $table;");
    $stmt->execute();
    $all_invoices = '';
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $all_invoices = $all_invoices . '';
    }
    ?>

    <div class="invoice">
        <span class="customer_name">$row['customer_name']</span>
    </div>
</body>


</html>