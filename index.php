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
                <h2 class="section-title">Conservation Fees</h2>

                <div class="item-row conservation-adult conservation-section">
                    <div><span class="conservation-adult-count">0</span> Adults @ USD <span class="conservation-adult-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="conservation-adult-total">0</span></div>
                </div>
                <div class="item-row conservation-child conservation-section">
                    <div><span class="conservation-child-count">0</span> Children @ USD <span class="conservation-child-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="conservation-child-total">0</span></div>
                </div>
                <div class="item-row conservation-infant conservation-section">
                    <div><span class="conservation-infant-count">0</span> Infants @ USD <span class="conservation-infant-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="conservation-infant-total">0</span></div>
                </div>

                <h2 class="section-title">Concession Fees</h2>

                <div class="item-row concession-adult concession-section">
                    <div><span class="concession-adult-count">0</span> Adults @ USD <span class="concession-adult-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="concession-adult-total">0</span></div>
                </div>
                <div class="item-row concession-child concession-section">
                    <div><span class="concession-child-count">0</span> Children @ USD <span class="concession-child-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="concession-child-total">0</span></div>
                </div>
                <div class="item-row concession-infant concession-section">
                    <div><span class="concession-infant-count">0</span> Infants @ USD <span class="concession-infant-cost">0</span></div>
                    <span></span>
                    <div>= USD <span class="concession-infant-total">0</span></div>
                </div>

                <div class="total-row hotel hotel-section">
                    <div><span class="hotel-count no-line">0</span> DAYS HOTEL @ USD <span class="hotel-cost no-line">0</span></div>
                    <span></span>
                    <div>= USD <span class="hotel-total">0</span></div>
                </div>
                <div class="total-row car_hire car_hire-section">
                    <div>CAR HIRE</div>
                    <span></span>
                    <div>= USD <span class="car_hire-total">0</span></div>
                </div>
                <div class="total-row flight flight-section">
                    <div>FLIGHT</div>
                    <span></span>
                    <div>= USD <span class="flight-total">0</span></div>
                </div>
                <div class="total-row extras extras-section">
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
                parksSelect.style.display = 'none';
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
                hotelsSelect.style.display = 'none';
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
        document.getElementById('profit').addEventListener('change', compute);
        document.getElementById('discount').addEventListener('change', compute);


        function compute() {
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
            xhr.open('POST', 'compute.php', true);
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

        function updatePreview(data) {
            // Update Conservation Fees
            document.querySelector('.conservation-adult-count').textContent = data.conservation.adult.count;
            document.querySelector('.conservation-adult-cost').textContent = data.conservation.adult.per;
            document.querySelector('.conservation-adult-total').textContent = data.conservation.adult.total;
            toggleVisibility('.conservation-adult', data.conservation.adult.total);

            document.querySelector('.conservation-child-count').textContent = data.conservation.child.count;
            document.querySelector('.conservation-child-cost').textContent = data.conservation.child.per;
            document.querySelector('.conservation-child-total').textContent = data.conservation.child.total;
            toggleVisibility('.conservation-child', data.conservation.child.total);

            document.querySelector('.conservation-infant-count').textContent = data.conservation.infant.count;
            document.querySelector('.conservation-infant-cost').textContent = data.conservation.infant.per;
            document.querySelector('.conservation-infant-total').textContent = data.conservation.infant.total;
            toggleVisibility('.conservation-infant', data.conservation.infant.total);

            // Update Concession Fees
            document.querySelector('.concession-adult-count').textContent = data.consession.adult.count;
            document.querySelector('.concession-adult-cost').textContent = data.consession.adult.per;
            document.querySelector('.concession-adult-total').textContent = data.consession.adult.total;
            toggleVisibility('.concession-adult', data.consession.adult.total);

            document.querySelector('.concession-child-count').textContent = data.consession.child.count;
            document.querySelector('.concession-child-cost').textContent = data.consession.child.per;
            document.querySelector('.concession-child-total').textContent = data.consession.child.total;
            toggleVisibility('.concession-child', data.consession.child.total);

            document.querySelector('.concession-infant-count').textContent = data.consession.infant.count;
            document.querySelector('.concession-infant-cost').textContent = data.consession.infant.per;
            document.querySelector('.concession-infant-total').textContent = data.consession.infant.total;
            toggleVisibility('.concession-infant', data.consession.infant.total);

            //hotel
            document.querySelector('.hotel-count').textContent = data.hotel.count;
            document.querySelector('.hotel-cost').textContent = data.hotel.per;
            document.querySelector('.hotel-total').textContent = data.hotel.total;
            toggleVisibility('.hotel', data.hotel.total);

            // Update Other Costs
            document.querySelector('.car_hire-total').textContent = data.car_hire;
            toggleVisibility('.car_hire', data.car_hire);
            document.querySelector('.flight-total').textContent = data.flight;
            toggleVisibility('.flight', data.flight);
            document.querySelector('.extras-total').textContent = data.extras;
            toggleVisibility('.extras', data.extras);

            let total = document.querySelector('.total');
            let profit = document.getElementById('profit').value || 0;
            let discount = document.getElementById('discount').value || 0;
            let invoice = document.getElementById('invoice-amount').value || 0;
            let data_total = parseFloat(data.total);

            total.textContent = data.total;

            let calculated = data_total + (data_total * (profit / 100));
            calculated = calculated - (calculated * (discount / 100)); 
            invoice = calculated.toFixed(1);

            document.getElementById('invoice-amount').value = invoice;
            document.getElementById('total-cost').value = data.total;
        }

        function toggleVisibility(selector, value) {
            let element = document.querySelector(selector);
            if (value === 0) {
                element.classList.add('hidden');
            } else {
                element.classList.remove('hidden');
            }
        }
        const generate_invoice = (e) => {
            e.preventDefault();
            let StartDate = document.getElementById('start_date').value;
            let EndDate = document.getElementById('end_date').value;

            let date1 = new Date(StartDate);
            let date2 = new Date(EndDate);
            let currentDate = new Date();

            let Difference_In_Time = date2.getTime() - date1.getTime();

            let Days = Math.round(Difference_In_Time / (1000 * 3600 * 24));
            let invoice_amount = document.getElementById('invoice-amount').value || 0;

            let invoice = {
                CustomerName: document.getElementById('customer_name').value,
                Dates: {
                    StartDate: StartDate,
                    EndDate: EndDate,
                },
                Days: Days,
                DateIssue: currentDate.toLocaleDateString(),
                CarHire: parseFloat(document.querySelector('.car_hire-total').textContent) || 0,
                Flight: parseFloat(document.querySelector('.flight-total').textContent) || 0,
                Extras: parseFloat(document.querySelector('.extras-total').textContent) || 0,
                CostAdult: parseFloat(document.querySelector('.conservation-adult-cost').textContent) + parseFloat(document.querySelector('.concession-adult-cost').textContent) || 0,
                Adults: parseInt(document.querySelector('.conservation-adult-count').textContent) + parseInt(document.querySelector('.concession-adult-count').textContent) || 0,
                CostChildren: parseFloat(document.querySelector('.conservation-child-cost').textContent) + parseFloat(document.querySelector('.concession-child-cost').textContent) || 0,
                Children: parseInt(document.querySelector('.conservation-child-count').textContent) + parseInt(document.querySelector('.concession-child-count').textContent) + parseInt(document.querySelector('.conservation-infant-count').textContent) + parseInt(document.querySelector('.concession-infant-count').textContent) || 0,
                SubTotal: parseFloat(document.querySelector('.total').textContent) || 0,
                Total: document.querySelector('.total').textContent || 0,
                BalanceDue: invoice_amount,
                BalanceRemaining: invoice_amount,
                park_name: document.getElementById('parks').value,
                hotel_name: document.getElementById('hotels').value || '',
                discount: document.getElementById('discount').value || 0,
            };

            console.table(invoice)
        }
    </script>
</body>

</html>