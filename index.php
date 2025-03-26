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
        }

        .grid-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            align-items: center;
            justify-content: center;
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
            margin: 20px;
        }

        .Form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .Form input[type="text"],
        .Form input[type="date"],
        .Form input[type="number"],
        .Form select,
        .Form textarea {
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

        .preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5rem;
        }

        .preview-people-cost input {
            width: 85%;
            margin: 5px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1>ODYSSEYS FROM AFRICA</h1>
    <main class="grid-wrapper">
        <form action="index.php" class="Form" method="post">
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

            <label for="hotels" id="hotelsLabel" style="display: none;">Hotels</label>
            <select name="hotels" id="hotels" style="display: none;" required></select>

            <label for="hotel-cost-initial" id="hotelscostLabel" style="display: none;">Hotel Cost</label>
            <input type="number" id="hotel-cost-initial" style="display: none;">

            <label for="extra-desc" id="extraLabel">Extra Description</label>
            <textarea id="extra-desc" placeholder="Separate by commas"></textarea>

            <label for="extra-cost-initial">Extra Cost</label>
            <input type="number" id="extra-cost-initial">

            <label for="profit">Profit %</label>
            <input type="number" id="profit">

            <label for="people" id="peopleLabel">Number of people</label>
            <table class="people">
                <thead>
                    <tr>
                        <th></th>
                        <th>Adult</th>
                        <th>Child</th>
                        <th>Infant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>EA citizens</td>
                        <td><input type="number" name="EA-Adult" class="table-input" id="EA-Adult" min=0></td>
                        <td><input type="number" name="EA-Child" class="table-input" id="EA-Child" min=0></td>
                        <td><input type="number" name="EA-Infant" class="table-input" id="EA-Infant" min=0></td>
                    </tr>
                    <tr>
                        <td>Non EA citizens</td>
                        <td><input type="number" name="Non-EA-Adult" class="table-input" id="Non-EA-Adult" min=0></td>
                        <td><input type="number" name="Non-EA-Child" class="table-input" id="Non-EA-Child" min=0></td>
                        <td><input type="number" name="Non-EA-Infant" class="table-input" id="Non-EA-Infant" min=0></td>
                    </tr>
                    <tr>
                        <td>TZ residents</td>
                        <td><input type="number" name="TZ-Adult" class="table-input" id="TZ-Adult" min=0></td>
                        <td><input type="number" name="TZ-Child" class="table-input" id="TZ-Child" min=0></td>
                        <td><input type="number" name="TZ-Infant" class="table-input" id="TZ-Infant" min=0></td>
                    </tr>
                </tbody>
            </table>

            <label for="invoice-amount">Invoice Amount</label>
            <input type="number" id="invoice-amount">

            <label for="total-cost">Total Cost</label>
            <input type="number" id="total-cost">

            <button type="submit">Submit</button>
        </form>
        <section class="preview">
            <table>
                <thead>
                    <tr>
                        <th>COSTS</th>
                        <th>Adult</th>
                        <th>Child</th>
                        <th>Infant</th>
                    </tr>
                </thead>
                <tbody class="preview-people-cost">
                    <tr>
                        <td><b>EA citizens</b></td>
                        <td class="EA_Adult"></td>
                        <td class="EA_Child"></td>
                        <td class="EA_Infant"></td>
                    </tr>
                    <tr>
                        <td><b>Non EA citizens</b></td>
                        <td class="Non_EA_Adult"></td>
                        <td class="Non_EA_Child"></td>
                        <td class="Non_EA_Infant"></td>
                    </tr>
                    <tr>
                        <td><b>TZ residents</b></td>
                        <td class="TZ_Adult"></td>
                        <td class="TZ_Child"></td>
                        <td class="TZ_Infant"></td>
                    </tr>
                </tbody>
            </table>
            <div class="other-costs">
                <label for="extra-cost">Extras</label>
                <input type="number" id="extra-cost">
                <br>
                <br>
                <label for="hotel-cost">Hotel</label>
                <input type="number" id="hotel-cost">
                <br>
                <br>
                <label for="invoice-amount">Invoice Amount</label>
                <input type="number" id="invoice-amount">
                <br>
                <br>
                <label for="total-cost">Total Cost</label>
                <input type="number" id="total-cost">
            </div>
        </section>
    </main>
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

        document.getElementById('parks').addEventListener('change', function() {
            let selectedPark = this.value;
            let ParkSelect = document.getElementById(this.id);
            let hotelsSelect = document.getElementById('hotels');
            let hotelsLabel = document.getElementById('hotelsLabel');
            let hotelsCost = document.getElementById('hotel-cost-initial');
            let hotelsCostLabel = document.getElementById('hotelscostLabel');

            if(ParkSelect.style.display == 'none'){
                hotelsSelect.style.display = 'none';
                hotelsLabel.style.display = 'none';
                hotelsCost.style.display = 'none';
                hotelsCostLabel.style.display = 'none';
            }

            if (selectedPark) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_parks.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
                        console.table(xhr.responseText)
                        hotelsSelect.innerHTML = xhr.responseText;
                        hotelsSelect.style.display = 'block';
                        hotelsLabel.style.display = 'block';
                        hotelsCost.style.display = 'block';
                        hotelsCostLabel.style.display = 'block';
                    } else {
                        hotelsSelect.innerHTML = '<option value="">Error loading hotels.</option>';
                        hotelsSelect.style.display = 'block';
                        hotelsLabel.style.display = 'block';
                        hotelsCost.style.display = 'block';
                        hotelsCostLabel.style.display = 'block';
                    }
                };
                xhr.onerror = function() {
                    hotelsSelect.innerHTML = '<option value="">Error loading hotels.</option>';
                    hotelsSelect.style.display = 'block';
                    hotelsLabel.style.display = 'block';
                    hotelsCost.style.display = 'block';
                    hotelsCostLabel.style.display = 'block';
                };
                xhr.send('park=' + encodeURIComponent(selectedPark));
            }
        });

        document.querySelectorAll('.table-input').forEach(input => {
            input.addEventListener('change', () => {
                let people = {
                    EA_Adult: document.getElementById('EA-Adult').value || 0,
                    EA_Child: document.getElementById('EA-Child').value || 0,
                    EA_Infant: document.getElementById('EA-Infant').value || 0,
                    Non_EA_Adult: document.getElementById('Non-EA-Adult').value || 0,
                    Non_EA_Child: document.getElementById('Non-EA-Child').value || 0,
                    Non_EA_Infant: document.getElementById('Non-EA-Infant').value || 0,
                    TZ_Adult: document.getElementById('TZ-Adult').value || 0,
                    TZ_Child: document.getElementById('TZ-Child').value || 0,
                    TZ_Infant: document.getElementById('TZ-Infant').value || 0,
                };

                let all_data = {
                    hotel: document.getElementById('hotel-cost-initial').value || 0,
                    people: people,
                    extras: document.getElementById('extra-cost-initial').value || 0,
                    date_range: {
                        start_date: document.getElementById('start_date').value,
                        end_date: document.getElementById('end_date').value,
                    },
                    profit: document.getElementById('profit').value || 0,
                }

                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'compute.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        let response = JSON.parse(xhr.responseText);
                        let people_response = response['people']

                        for (let [key, val] of Object.entries(people_response)) {
                            let input = document.querySelector(`.${key}`);
                            input.value = val;
                        }

                        let extra_input = document.getElementById('extra-cost')
                        extra_input.textContent = response['extras']

                        let total_input = document.querySelectorAll('#total-cost')
                        total_input.forEach((tinput) => {
                            tinput.textContent = response['total']
                        })
                    } else {
                        console.error('Error loading data from compute.php');
                    }
                };

                xhr.onerror = function() {
                    console.error('AJAX request failed.');
                };

                xhr.send('data=' + encodeURIComponent(JSON.stringify(all_data)));
            });
        });
    </script>
</body>

</html>