<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin: 20px 0;
        }

        .Form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .Form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .Form input[type="text"],
        .Form input[type="date"],
        .Form input[type="number"],
        .Form select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .Form select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="currentColor" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 16px;
        }

        .Form button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .Form button:hover {
            background-color: #0056b3;
        }

        .customer_info,
        .park_info {
            background-color: #e9f5ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .customer_info h2,
        .park_info h2 {
            color: #007bff;
            margin-top: 0;
        }

        .park_details,
        .customer_details {
            display: flex;
            flex-direction: column;
        }

        .customer_details span,
        .park_details span {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h1>ODYSSEYS FROM AFRICA</h1>
    <form action="index.php" class="Form" method="post" onsubmit="stop(event)">
        <label for="customer_name">Customer Name:</label>
        <input type="text" class="customer_name" id="customer_name" name="customer_name" required>

        <label for="start_date">Start Date:</label>
        <input type="date" class="start_date" id="start_date" name="start_date" required>

        <label for="start_date">End Date</label>
        <input type="date" class="end_date" id="end_date" name="end_date" required>

        <label for="country">Country</label>
        <select name="country" id="country" required>
            <option value="">Select Country</option>
            <option value="kenya">Kenya</option>
            <option value="tanzania">Tanzania</option>
        </select>

        <label for="parks" id="parksLabel" style="display: none;">Parks</label>
        <select name="parks" id="parks" style="display: none;" required></select>

        <label for="visitor_type">Visitor Type</label>
        <select name="visitor_type" id="visitor_type" required>
            <option value="">Select Visitor Type</option>
            <option value="ea_citizen">EA CItizen</option>
            <option value="non_ea_citizen">Non EA Citizen</option>
            <option value="tz_resident">TZ Resident</option>
        </select>

        <label for="people" id="peopleLabel">Number of people</label>
        <table class="people">
            <thead>
                <th>
                <td>Adult</td>
                <td>Child (5-15)</td>
                <td>Child (0-4)</td>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>EA citizens</td>
                    <td><input type="number" name="EA-Adult" class="table-input" min=0></td>
                    <td><input type="number" name="EA-Child" class="table-input" min=0></td>
                    <td><input type="number" name="EA-Infant" class="table-input" min=0></td>
                </tr>
                <tr>
                    <td>Non EA citizens</td>
                    <td><input type="number" name="Non-EA-Adult" class="table-input" min=0></td>
                    <td><input type="number" name="Non-EA-Child" class="table-input" min=0></td>
                    <td><input type="number" name="Non-EA-Infant" class="table-input" min=0></td>
                </tr>
                <tr>
                    <td>TZ residents</td>
                    <td><input type="number" name="TZ-Adult" class="table-input" min=0></td>
                    <td><input type="number" name="TZ-Child" class="table-input" min=0></td>
                    <td><input type="number" name="TZ-Infant" class="table-input" min=0></td>
                </tr>
            </tbody>
        </table>

        <button type="submit">Submit</button>
    </form>
    <script>
        document.getElementById('country').addEventListener('change', function() {
            let selectedCountry = this.value;
            let parksSelect = document.getElementById('parks');
            let parksLabel = document.getElementById('parksLabel');

            if (selectedCountry) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_parks.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
                        parksSelect.innerHTML = this.responseText;
                        parksSelect.style.display = 'block';
                        parksLabel.style.display = 'block';
                    } else {
                        parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                        parksSelect.style.display = 'block';
                        parksLabel.style.display = 'block';
                    }
                };
                xhr.onerror = function() {
                    parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                    parksSelect.style.display = 'block';
                    parksLabel.style.display = 'block';
                };
                xhr.send('country=' + encodeURIComponent(selectedCountry));
            } else {
                parksSelect.style.display = 'none';
                parksLabel.style.display = 'none';
            }
        });
        const stop = (e) => {
            e.preventDefault()

        }
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customerName = $_POST['customer_name'];
        $dateOfIssue = $_POST['date_of_issue'];
        $selectedPark = $_POST['parks'];
        $season = $_POST['season'];
        $season_sql = $season . '_seasonal_';

        /* 
        Child16 means children from age 5-15
        Child5 means children from age 0-4

        For all Child5 fees are $0
        */ 

        $EA_Adult = !empty($_POST['EA-Adult']) ? $_POST['EA-Adult'] : 0;
        $EA_Child = !empty($_POST['EA-Child']) ? $_POST['EA-Child'] : 0;
        $EA_Infant = !empty($_POST['EA-Infant']) ? $_POST['EA-Infant'] : 0;

        $Non_EA_Adult = !empty($_POST['Non-EA-Adult']) ? $_POST['Non-EA-Adult'] : 0;
        $Non_EA_Child = !empty($_POST['Non-EA-Child']) ? $_POST['Non-EA-Child'] : 0;
        $Non_EA_Infant = !empty($_POST['Non-EA-Infant']) ? $_POST['Non-EA-Infant'] : 0;

        $TZ_Adult = !empty($_POST['TZ-Adult']) ? $_POST['TZ-Adult'] : 0;
        $TZ_Child = !empty($_POST['TZ-Child']) ? $_POST['TZ-Child'] : 0;
        $TZ_Infant = !empty($_POST['TZ-Infant']) ? $_POST['TZ-Infant'] : 0;

        $dbFilePath = './oddyseys.db';

        try {
            $pdo = new PDO("sqlite:" . $dbFilePath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $get_park_query = 'SELECT * FROM parks WHERE name = :parkName';
            $park_stmt = $pdo->prepare($get_park_query);
            $park_stmt->execute([':parkName' => $selectedPark]);

            $park_details = $park_stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        };

        $EA_Adult_FEE = $park_details->$season_sql . 'adult_ea_citizen_fee' * $EA_Adult;
        $EA_Child_FEE = $park_details->$season_sql . 'child_ea_citizen_fee' * $EA_Child;
        
        $Non_EA_Adult_FEE = $park_details->$season_sql . 'adult_non_ea_citizen_fee' * $Non_EA_Adult;
        $Non_EA_Child_FEE = $park_details->$season_sql . 'child_non_ea_citizen_fee' * $Non_EA_Child;
        
        $TZ_Adult_FEE = $park_details->$season_sql . 'adult_tz_residents_fee' * $TZ_Adult;
        $TZ_Child_FEE = $park_details->$season_sql . 'child_tz_residents_fee' * $TZ_Child;
        
        $totalFees = $EA_Adult_FEE + $EA_Child_FEE + 
                    $Non_EA_Adult_FEE + $Non_EA_Child_FEE + 
                    $TZ_Adult_FEE + $TZ_Child_FEE;
    }
    ?>
</body>

</html>