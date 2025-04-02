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
            margin: 20px auto;
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
            margin: 20px auto;
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

        .container {
            width: 90%;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .section-title {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .item-row span {
            border-bottom: 1px dotted #ccc;
            flex-grow: 1;
            margin-left: 10px;
            padding-bottom: 2px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-weight: bold;
        }

        .total-row span {
            border-bottom: 1px solid #ccc;
            flex-grow: 1;
            margin-left: 10px;
            padding-bottom: 2px;
        }

        .total-row span.no-line {
            margin-left: 0;
            border-bottom: none;
        }

        table.people {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.people thead th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        table.people tbody td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        table.people tbody td input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        table.people tbody td input:focus {
            border-color: #007bff;
            outline: none;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <h1>ODYSSEYS FROM AFRICA</h1>
    <main class="grid-wrapper">
        <form action="index.php" class="Form" onsubmit="generate_invoice(event)">
            <label for="customer_name">Customer Name:</label>
            <input type="text" class="customer_name" id="customer_name" name="customer_name" required>

            <label for="start_date">Start Date:</label>
            <input type="date" class="start_date" id="start_date" name="start_date" required>

            <label for="end_date">End Date</label>
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
            <select name="hotels" id="hotels" style="display: none;"></select>

            <label for="hotel-cost-initial" id="hotelscostLabel" style="display: none;">Hotel Cost Per Day</label>
            <input type="number" id="hotel-cost-initial" style="display: none;" name="hotel_cost_initial">

            <label for="extra-desc" id="extraLabel">Extra Description</label>
            <textarea id="extra-desc" name="extra_desc" placeholder="Separate by commas"></textarea>

            <label for="extra-cost-initial">Extra Cost</label>
            <input type="number" id="extra-cost-initial" step="0.01" name="extra_cost_initial">

            <label for="flight-cost-initial">Flight</label>
            <input type="number" id="flight-cost-initial" step="0.01" name="flight_cost_initial">

            <label for="car_hire-cost-initial">Car Hire Cost Per Day</label>
            <input type="number" id="car_hire-cost-initial" step="0.01" name="car_hire_cost_initial">

            <label for="people" id="peopleLabel">Number of people</label>
            <table class="people" id="people">
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
                        <td><input type="number" name="EA-Adult" class="table-input" id="EA-Adult" min=0 value="0"></td>
                        <td><input type="number" name="EA-Child" class="table-input" id="EA-Child" min=0 value="0"></td>
                        <td><input type="number" name="EA-Infant" class="table-input" id="EA-Infant" min=0 value="0"></td>
                    </tr>
                    <tr>
                        <td>Non EA citizens</td>
                        <td><input type="number" name="Non-EA-Adult" class="table-input" id="Non-EA-Adult" min=0 value="0"></td>
                        <td><input type="number" name="Non-EA-Child" class="table-input" id="Non-EA-Child" min=0 value="0"></td>
                        <td><input type="number" name="Non-EA-Infant" class="table-input" id="Non-EA-Infant" min=0 value="0"></td>
                    </tr>
                    <tr>
                        <td>TZ residents</td>
                        <td><input type="number" name="TZ-Adult" class="table-input" id="TZ-Adult" min=0 value="0"></td>
                        <td><input type="number" name="TZ-Child" class="table-input" id="TZ-Child" min=0 value="0"></td>
                        <td><input type="number" name="TZ-Infant" class="table-input" id="TZ-Infant" min=0 value="0"></td>
                    </tr>
                </tbody>
            </table>

            <label for="total-cost">Total Cost</label>
            <input type="number" id="total-cost" step="0.01" name="total_cost">

            <label for="profit">Profit %</label>
            <input type="number" id="profit" step="0.01" name="profit">

            <label for="discount">Discount %</label>
            <input type="number" id="discount" step="0.01" name="discount">

            <label for="invoice-amount">Invoice Amount</label>
            <input type="number" id="invoice-amount" step="0.01" name="invoice_amount">

            <button type="submit">Submit</button>
        </form>
        <section class="preview">
            <div class="container">
                <h2 class="section-title">Cost Details</h2>

                <!-- Conservation Fees -->
                <h3>Conservation Fees (18% TAX INCLUDED IN ALL AMOUNTS)</h3>
                <div id="conservation-ea-section">
                    <h4>EA Citizens</h4>
                    <div class="item-row conservation-ea-adult">
                        <div><span class="conservation-ea-adult-count">0</span> Adults @ USD <span class="conservation-ea-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-ea-adult-total">0</span></div>
                    </div>
                    <div class="item-row conservation-ea-child">
                        <div><span class="conservation-ea-child-count">0</span> Children @ USD <span class="conservation-ea-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-ea-child-total">0</span></div>
                    </div>
                    <div class="item-row conservation-ea-infant">
                        <div><span class="conservation-ea-infant-count">0</span> Infants @ USD <span class="conservation-ea-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-ea-infant-total">0</span></div>
                    </div>
                </div>

                <div id="conservation-non-ea-section">
                    <h4>Non EA Citizens</h4>
                    <div class="item-row conservation-non-ea-adult">
                        <div><span class="conservation-non-ea-adult-count">0</span> Adults @ USD <span class="conservation-non-ea-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-non-ea-adult-total">0</span></div>
                    </div>
                    <div class="item-row conservation-non-ea-child">
                        <div><span class="conservation-non-ea-child-count">0</span> Children @ USD <span class="conservation-non-ea-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-non-ea-child-total">0</span></div>
                    </div>
                    <div class="item-row conservation-non-ea-infant">
                        <div><span class="conservation-non-ea-infant-count">0</span> Infants @ USD <span class="conservation-non-ea-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-non-ea-infant-total">0</span></div>
                    </div>
                </div>

                <div id="conservation-tz-section">
                    <h4>TZ Residents</h4>
                    <div class="item-row conservation-tz-adult">
                        <div><span class="conservation-tz-adult-count">0</span> Adults @ USD <span class="conservation-tz-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-tz-adult-total">0</span></div>
                    </div>
                    <div class="item-row conservation-tz-child">
                        <div><span class="conservation-tz-child-count">0</span> Children @ USD <span class="conservation-tz-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-tz-child-total">0</span></div>
                    </div>
                    <div class="item-row conservation-tz-infant">
                        <div><span class="conservation-tz-infant-count">0</span> Infants @ USD <span class="conservation-tz-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="conservation-tz-infant-total">0</span></div>
                    </div>
                </div>

                <!-- Concession Fees -->
                <h3>Concession Fees (18% TAX INCLUDED IN ALL AMOUNTS)</h3>
                <div id="concession-ea-section">
                    <h4>EA Citizens</h4>
                    <div class="item-row concession-ea-adult">
                        <div><span class="concession-ea-adult-count">0</span> Adults @ USD <span class="concession-ea-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-ea-adult-total">0</span></div>
                    </div>
                    <div class="item-row concession-ea-child">
                        <div><span class="concession-ea-child-count">0</span> Children @ USD <span class="concession-ea-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-ea-child-total">0</span></div>
                    </div>
                    <div class="item-row concession-ea-infant">
                        <div><span class="concession-ea-infant-count">0</span> Infants @ USD <span class="concession-ea-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-ea-infant-total">0</span></div>
                    </div>
                </div>

                <div id="concession-non-ea-section">
                    <h4>Non EA Citizens</h4>
                    <div class="item-row concession-non-ea-adult">
                        <div><span class="concession-non-ea-adult-count">0</span> Adults @ USD <span class="concession-non-ea-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-non-ea-adult-total">0</span></div>
                    </div>
                    <div class="item-row concession-non-ea-child">
                        <div><span class="concession-non-ea-child-count">0</span> Children @ USD <span class="concession-non-ea-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-non-ea-child-total">0</span></div>
                    </div>
                    <div class="item-row concession-non-ea-infant">
                        <div><span class="concession-non-ea-infant-count">0</span> Infants @ USD <span class="concession-non-ea-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-non-ea-infant-total">0</span></div>
                    </div>
                </div>

                <div id="concession-tz-section">
                    <h4>TZ Residents</h4>
                    <div class="item-row concession-tz-adult">
                        <div><span class="concession-tz-adult-count">0</span> Adults @ USD <span class="concession-tz-adult-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-tz-adult-total">0</span></div>
                    </div>
                    <div class="item-row concession-tz-child">
                        <div><span class="concession-tz-child-count">0</span> Children @ USD <span class="concession-tz-child-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-tz-child-total">0</span></div>
                    </div>
                    <div class="item-row concession-tz-infant">
                        <div><span class="concession-tz-infant-count">0</span> Infants @ USD <span class="concession-tz-infant-cost">0</span></div>
                        <span></span>
                        <div>= USD <span class="concession-tz-infant-total">0</span></div>
                    </div>
                </div>

                <!-- Other Costs -->
                <div class="total-row hotel">
                    <div><span class="hotel-count no-line">0</span> DAYS HOTEL @ USD <span class="hotel-cost no-line">0</span></div>
                    <span></span>
                    <div>= USD <span class="hotel-total">0</span></div>
                </div>
                <div class="total-row car_hire">
                    <div>CAR HIRE</div>
                    <span></span>
                    <div>= USD <span class="car_hire-total">0</span></div>
                </div>
                <div class="total-row flight">
                    <div>FLIGHT</div>
                    <span></span>
                    <div>= USD <span class="flight-total">0</span></div>
                </div>
                <div class="total-row extras">
                    <div>EXTRAS</div>
                    <span></span>
                    <div>= USD <span class="extras-total">0</span></div>
                </div>
                <div class="total-row total-section">
                    <div>TOTAL</div>
                    <span></span>
                    <div>= USD <span class="total">0</span></div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.min.js"></script>
    <script>
        document.getElementById('country').addEventListener('change', function() {
            let selectedCountry = this.value;
            let parksSelect = document.getElementById('parks');
            let parksLabel = document.getElementById('parksLabel');
            let hotelsSelect = document.getElementById('hotels');
            let hotelsLabel = document.getElementById('hotelsLabel');
            let hotelsCostLabel = document.getElementById('hotelscostLabel');
            let hotelsCostInput = document.getElementById('hotel-cost-initial');

            if (selectedCountry) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_parks.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
                        parksSelect.innerHTML = this.responseText;
                        parksSelect.style.display = 'block';
                        parksLabel.style.display = 'block';
                        hotelsSelect.style.display = 'none';
                        hotelsLabel.style.display = 'none';
                        hotelsCostInput.style.display = 'none';
                        hotelsCostLabel.style.display = 'none';
                    } else {
                        parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                        parksSelect.style.display = 'block';
                        parksLabel.style.display = 'block';
                        hotelsSelect.style.display = 'none';
                        hotelsLabel.style.display = 'none';
                        hotelsCostInput.style.display = 'none';
                        hotelsCostLabel.style.display = 'none';
                    }
                };
                xhr.onerror = function() {
                    parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                    parksSelect.style.display = 'block';
                    parksLabel.style.display = 'block';
                    hotelsSelect.style.display = 'none';
                    hotelsLabel.style.display = 'none';
                    hotelsCostInput.style.display = 'none';
                    hotelsCostLabel.style.display = 'none';
                };
                xhr.send('country=' + encodeURIComponent(selectedCountry));
            } else {
                parksSelect.style.display = ' none';
                parksLabel.style.display = 'none';
                hotelsSelect.style.display = 'none';
                hotelsLabel.style.display = 'none';
                hotelsCostInput.style.display = 'none';
                hotelsCostLabel.style.display = 'none';
            }
        });

        document.getElementById('parks').addEventListener('change', function() {
            let selectedPark = this.value;
            let hotelsSelect = document.getElementById('hotels');
            let hotelsLabel = document.getElementById('hotelsLabel');
            let hotelsCost = document.getElementById('hotel-cost-initial');
            let hotelsCostLabel = document.getElementById('hotelscostLabel');

            if (selectedPark) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_parks.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
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
            } else {
                hotelsSelect.style.display = ' none';
                hotelsLabel.style.display = 'none';
                hotelsCost.style.display = 'none';
                hotelsCostLabel.style.display = 'none';
            }
        });

        document.querySelectorAll('.table-input').forEach(input => {
            input.addEventListener('change', compute)
        });
        document.getElementById('start_date').addEventListener('change', compute);
        document.getElementById('end_date').addEventListener('change', compute);
        document.getElementById('hotel-cost-initial').addEventListener('change', compute);
        document.getElementById('extra-cost-initial').addEventListener('change', compute);
        document.getElementById('flight-cost-initial').addEventListener('change', compute);
        document.getElementById('car_hire-cost-initial').addEventListener('change', compute);
        document.getElementById('total-cost').addEventListener('change', compute);
        document.getElementById('profit').addEventListener('change', compute);
        document.getElementById('discount').addEventListener('change', compute);


        async function compute() {
            let people = {
                EA_Adult: parseInt(document.getElementById('EA-Adult').value) || 0,
                EA_Child: parseInt(document.getElementById('EA-Child').value) || 0,
                EA_Infant: parseInt(document.getElementById('EA-Infant').value) || 0,
                Non_EA_Adult: parseInt(document.getElementById('Non-EA-Adult').value) || 0,
                Non_EA_Child: parseInt(document.getElementById('Non-EA-Child').value) || 0,
                Non_EA_Infant: parseInt(document.getElementById('Non-EA-Infant').value) || 0,
                TZ_Adult: parseInt(document.getElementById('TZ-Adult').value) || 0,
                TZ_Child: parseInt(document.getElementById('TZ-Child').value) || 0,
                TZ_Infant: parseInt(document.getElementById('TZ-Infant').value) || 0,
            };

            let all_data = {
                park_name: document.getElementById('parks').value,
                hotel_cost_per_day: parseFloat(document.getElementById('hotel-cost-initial').value) || 0,
                car_hire_cost_per_day: parseFloat(document.getElementById('car_hire-cost-initial').value) || 0,
                flight: parseFloat(document.getElementById('flight-cost-initial').value) || 0,
                people: people,
                extras: parseFloat(document.getElementById('extra-cost-initial').value) || 0,
                date_range: {
                    start_date: document.getElementById('start_date').value,
                    end_date: document.getElementById('end_date').value,
                },
                profit: parseFloat(document.getElementById('profit').value) || 0,
            };

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_cost.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    let response = JSON.parse(xhr.responseText);
                    updatePreview(response);
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Computing request failed.');
            };

            xhr.send('data=' + encodeURIComponent(JSON.stringify(all_data)));
        };

        async function updatePreview(data) {
            // Update Conservation Fees
            updateSection(' .conservation-ea-adult', data.conservation.ea.adult);
            updateSection('.conservation-ea-child', data.conservation.ea.child);
            updateSection('.conservation-ea-infant', data.conservation.ea.infant);
            toggleSectionVisibility('#conservation-ea-section', [data.conservation.ea.adult, data.conservation.ea.child, data.conservation.ea.infant]);

            updateSection('.conservation-non-ea-adult', data.conservation.non_ea.adult);
            updateSection('.conservation-non-ea-child', data.conservation.non_ea.child);
            updateSection('.conservation-non-ea-infant', data.conservation.non_ea.infant);
            toggleSectionVisibility('#conservation-non-ea-section', [data.conservation.non_ea.adult, data.conservation.non_ea.child, data.conservation.non_ea.infant]);

            updateSection('.conservation-tz-adult', data.conservation.tz.adult);
            updateSection('.conservation-tz-child', data.conservation.tz.child);
            updateSection('.conservation-tz-infant', data.conservation.tz.infant);
            toggleSectionVisibility('#conservation-tz-section', [data.conservation.tz.adult, data.conservation.tz.child, data.conservation.tz.infant]);

            // Update Concession Fees
            updateSection('.concession-ea-adult', data.consession.ea.adult);
            updateSection('.concession-ea-child', data.consession.ea.child);
            updateSection('.concession-ea-infant', data.consession.ea.infant);
            toggleSectionVisibility('#concession-ea-section', [data.consession.ea.adult, data.consession.ea.child, data.consession.ea.infant]);

            updateSection('.concession-non-ea-adult', data.consession.non_ea.adult);
            updateSection('.concession-non-ea-child', data.consession.non_ea.child);
            updateSection('.concession-non-ea-infant', data.consession.non_ea.infant);
            toggleSectionVisibility('#concession-non-ea-section', [data.consession.non_ea.adult, data.consession.non_ea.child, data.consession.non_ea.infant]);

            updateSection('.concession-tz-adult', data.consession.tz.adult);
            updateSection('.concession-tz-child', data.consession.tz.child);
            updateSection('.concession-tz-infant', data.consession.tz.infant);
            toggleSectionVisibility('#concession-tz-section', [data.consession.tz.adult, data.consession.tz.child, data.consession.tz.infant]);

            // Update Other Costs
            updateElement('.hotel', data.hotel);
            updateElement('.car_hire', {
                total: data.car_hire
            });
            updateElement('.flight', {
                total: data.flight
            });
            updateElement('.extras', {
                total: data.extras
            });

            document.querySelector('.total').textContent = data.total;
            let total_input = parseFloat(document.getElementById('total-cost').value) || 0;
            let profit_input = parseFloat(document.getElementById('profit').value) || 0;
            let discount_input = parseFloat(document.getElementById('discount').value) || 0;

            let calced = (data.total * (1 + (profit_input / 100))) * (1 - (discount_input / 100));

            document.getElementById('invoice-amount').value = calced.toFixed(2);
        }

        function updateSection(selector, data) {
            let countElement = document.querySelector(selector + '-count');
            let costElement = document.querySelector(selector + '-cost');
            let totalElement = document.querySelector(selector + '-total');

            countElement.textContent = data.count;
            costElement.textContent = data.per;
            totalElement.textContent = data.total;

            toggleVisibility(selector, data.total);
        }

        function updateElement(selector, data) {
            let countElement = document.querySelector(selector + '-count');
            let costElement = document.querySelector(selector + '-cost');
            let totalElement = document.querySelector(selector + '-total');

            if (countElement) countElement.textContent = data.count || '';
            if (costElement) costElement.textContent = data.per || '';
            totalElement.textContent = data.total;

            toggleVisibility(selector, data.total);
        }

        function toggleVisibility(selector, value) {
            let element = document.querySelector(selector);
            if (value === 0) {
                element.classList.add('hidden');
            } else {
                element.classList.remove('hidden');
            }
        }

        function toggleSectionVisibility(sectionSelector, dataArray) {
            let totalCount = dataArray.reduce((acc, data) => acc + data.count, 0);
            let sectionElement = document.querySelector(sectionSelector);
            if (totalCount === 0) {
                sectionElement.classList.add('hidden');
            } else {
                sectionElement.classList.remove('hidden');
            }
        }
        const generate_invoice = async (e) => {
            e.preventDefault();
            let StartDate = document.getElementById("start_date").value;
            let EndDate = document.getElementById("end_date").value;

            let date1 = new Date(StartDate);
            let date2 = new Date(EndDate);
            let currentDate = new Date();

            let Difference_In_Time = date2.getTime() - date1.getTime();
            let Days = Math.round(Difference_In_Time / (1000 * 3600 * 24));

            let invoice_amount = document.getElementById("invoice-amount").value || 0;

            let invoice = {
                CustomerName: document.getElementById("customer_name").value,
                Dates: {
                    StartDate: StartDate,
                    EndDate: EndDate,
                },
                Days: Days,
                DateIssue: currentDate.toLocaleDateString(),
                HotelTotal: parseFloat(document.querySelector(".hotel-total").textContent) || 0,
                CarHire: parseFloat(document.querySelector(".car_hire-total").textContent) || 0,
                Flight: parseFloat(document.querySelector(".flight-total").textContent) || 0,
                Extras: parseFloat(document.querySelector(".extras-total").textContent) || 0,
                ConservationAdultCost: parseFloat(
                        document.querySelector(".conservation-ea-adult-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-non-ea-adult-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-tz-adult-cost").textContent
                    ) || 0,
                ConcessionAdultCost: parseFloat(
                        document.querySelector(".concession-ea-adult-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-non-ea-adult-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-tz-adult-cost").textContent
                    ) || 0,
                ConservationAdultCount: parseInt(
                        document.querySelector(".conservation-ea-adult-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-non-ea-adult-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-tz-adult-count").textContent
                    ) || 0,
                ConcessionAdultCount: parseInt(
                        document.querySelector(".concession-ea-adult-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-non-ea-adult-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-tz-adult-count").textContent
                    ) || 0,
                ConservationChildrenCost: parseFloat(
                        document.querySelector(".conservation-ea-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-ea-infant-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-non-ea-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-non-ea-infant-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-tz-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".conservation-tz-infant-cost").textContent
                    ) || 0,
                ConcessionChildrenCost: parseFloat(
                        document.querySelector(".concession-ea-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-ea-infant-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-non-ea-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-non-ea-infant-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-tz-child-cost").textContent
                    ) +
                    parseFloat(
                        document.querySelector(".concession-tz-infant-cost").textContent
                    ) || 0,
                ConservationChildrenCount: parseInt(
                        document.querySelector(".conservation-ea-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-ea-infant-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-non-ea-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-non-ea-infant-count")
                        .textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-tz-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".conservation-tz-infant-count").textContent
                    ) || 0,
                ConcessionChildrenCount: parseInt(
                        document.querySelector(".concession-ea-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-ea-infant-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-non-ea-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-non-ea-infant-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-tz-child-count").textContent
                    ) +
                    parseInt(
                        document.querySelector(".concession-tz-infant-count").textContent
                    ) || 0,
                invoice_amount: invoice_amount,
                park_name: document.getElementById("parks").value,
                hotel_name: document.getElementById("hotels").value || "",
                discount_amount: document.getElementById("discount").value || 0,
                extras_desc: document.getElementById("extra-desc").value || "",
                cost_amount: document.querySelector(".total").textContent || 0,
            };

            /* This is for creating invoice in db table, using ajax */
            const xhr = new XMLHttpRequest()
            xhr.open('POST', 'invoice_generation.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                console.log(xhr.responseText);
            };

            xhr.onerror = function() {
                console.log(xhr.responseText);
                console.error('Computing request failed.');
            };
            xhr.send('invoice=' + encodeURIComponent(JSON.stringify(invoice)));
        };
    </script>
</body>

</html>