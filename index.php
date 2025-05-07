<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odysseys Costing</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            color: #333;
            line-height: 1.6;
        }

        main.all_tables {
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            gap: 20px;
        }

        .input_tables,
        .preview {
            padding: 25px;
            border-radius: 8px;
            background: #f9f9f9;
        }

        h1,
        h2 {
            color: #008080;
            text-align: left;
            margin-bottom: 20px;
        }

        .input_tables h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 0.95em;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background: #008080;
            color: white;
            font-weight: 600;
        }

        table tbody tr:nth-child(even) {
            background: #f2f2f2;
        }

        table tbody tr:hover {
            background: #e0f7f7;
            transition: background 0.3s ease;
        }

        .double {
            display: flex;
            align-items: center;
        }

        .double input[type="text"] {
            width: 70%;
            margin-right: 10px;
        }

        button {
            background: linear-gradient(to right, #008080, #00b3b3);
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(to right, #00b3b3, #008080);
            transform: scale(1.05);
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #008080;
            box-shadow: 0px 0px 8px rgba(0, 128, 128, 0.3);
            outline: none;
        }

        aside.other_fees {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        aside.other_fees span {
            font-weight: bold;
        }

        aside.all_parks,
        aside.all_hotels,
        .preview {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            max-height: 80vh;
            background: #fff;
            border-radius: 15px;
            overflow-y: auto;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            padding: 25px;
            display: none;
            z-index: 1000;
        }

        .preview {
            max-width: 80vw;
            width: auto;
        }

        aside.all_parks h2,
        aside.all_hotels h2,
        .preview h2 {
            color: #008080;
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 15px;
        }

        .parkList,
        .hotelList {
            padding: 10px;
        }

        .indiviualPark,
        .indiviualHotel {
            border-bottom: 1px solid #ddd;
            padding: 12px 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .indiviualPark:last-child,
        .indiviualHotel:last-child {
            border-bottom: none;
        }

        .indiviualPark:hover,
        .indiviualHotel:hover {
            background: #e0f7f7;
            transform: scale(1.01);
        }

        button.hideParks,
        button.hideHotels,
        button.closePreview {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            background: none;
            color: #999;
            border: none;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        button.hideParks:hover,
        button.hideHotels:hover,
        button.closePreview:hover {
            color: #333;
        }

        .preview-content {
            padding: 15px;
            background-color: #e0f7f7;
            border-radius: 8px;
        }

        .preview-content p {
            margin-bottom: 10px;
        }

        .total,
        .invoice_amount {
            background-color: lightgray;
        }
    </style>
</head>

<body onload="initial_load()">
    <main class="all_tables">
        <section class="input_tables">
            <h2>Enter Your Trip Details</h2>
            <table class="parks">
                <thead>
                    <tr>
                        <th>Park</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Hotel</th>
                        <th>Car Hire In USD Per Person Per Day</th>
                        <th>Extra Fee In USD Per Person</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-id="1">
                        <td class="double"><input type="text" class="park" name="park" disabled required><button class="openParks" onclick="openparks(this.closest('tr').dataset.id, this)">Select Park</button></td>
                        <td><input type="date" class="start_date" name="start_date" required></td>
                        <td><input type="date" class="end_date" name="end_date" required></td>
                        <td class="double"><input type="text" class="hotel" name="hotel" disabled required><button class="openHotels" onclick="openhotels(this.closest('tr').dataset.id, true)">Select Hotel</button></td>
                        <td><input type="number" class="car_hire" min=0 name="car_hire" required></td>
                        <td><input type="number" class="extras" step='0.01' min=0 name="extras" required></td>
                        <td><button class="remove-row" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                </tbody>
            </table>
            <button class="add-row" onclick="addRow()">Add Row</button>
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
                        <td><input type="number" name="ea_citizen_adult" class="table-input" id="EA-Adult" min=0></td>
                        <td><input type="number" name="ea_citizen_child" class="table-input" id="EA-Child" min=0></td>
                        <td><input type="number" name="ea_citizen_infant" class="table-input" id="EA-Infant" min=0></td>
                    </tr>
                    <tr>
                        <td>Non EA citizens</td>
                        <td><input type="number" name="non_ea_citizen_adult" class="table-input" id="Non-EA-Adult" min=0></td>
                        <td><input type="number" name="non_ea_citizen_child" class="table-input" id="Non-EA-Child" min=0></td>
                        <td><input type="number" name="non_ea_citizen_infant" class="table-input" id="Non-EA-Infant" min=0></td>
                    </tr>
                    <tr>
                        <td>TZ residents</td>
                        <td><input type="number" name="tz_resident_adult" class="table-input" id="TZ-Adult" min=0></td>
                        <td><input type="number" name="tz_resident_child" class="table-input" id="TZ-Child" min=0></td>
                        <td><input type="number" name="tz_resident_infant" class="table-input" id="TZ-Infant" min=0></td>
                    </tr>
                </tbody>
            </table>
            <aside class="other_fees">
                <span>Flight In USD Per Person:</span>
                <input type="number" step="0.01" min=0 class="flight" name="flight">
                <span>Total Itinerary Cost:</span>
                <input type="number" step="0.01" min=0 class="total" name="total">
                <span>Profit %:</span>
                <input type="number" step="0.01" min=0 class="profit" name="profit">
                <span>Discount %:</span>
                <input type="number" step="0.01" min=0 class="discount" name="discount">
                <span>Invoice amount:</span>
                <input type="number" step="0.01" min=0 class="invoice_amount" name="invoice_amount">
            </aside>
            <button onclick="openInNewTab()">Show Preview</button>
        </section>
        <section class="preview">
            <button class="closePreview" onclick="openPreview(false)">❌</button>
            <h2>Trip Cost Preview</h2>
            <div class="preview-content">
                <p>This section will display a summary of the calculated costs.</p>
            </div>
        </section>
    </main>

    <aside class="all_parks" style="display: none;">
        <button class="hideParks close" onclick="openparks(this, false)">❌</button>
        <h2>Parks</h2>
        <input type="text" class="search-bar" oninput="searchParks(event)" placeholder="Search parks...">
        <div class="parkList">
        </div>
    </aside>

    <aside class="all_hotels" style="display: none;">
        <button class="hideHotels close" onclick="openhotels(this, false)">❌</button>
        <h2>Hotels</h2>
        <input type="text" class="search-bar hotels" oninput="searchHotels(event.target.value)" placeholder="Search hotels...">
        <div class="hotelList">
        </div>
    </aside>

    <script>
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('change', () => {
                postData();
            })
        });

        const initial_load = async () => {
            const response = await fetch('get_parks.php?for=hotelpage');
            const data = await response.json();
            const parksList = document.querySelector('.parkList');
            const hotelList = document.querySelector('.hotelList');

            data.parks.forEach((park) => {
                let div = document.createElement('div');
                div.classList.add('indiviualPark');
                div.textContent = park.name;
                div.dataset.id = park.id;
                div.addEventListener('click', (event) => selectPark(event));
                parksList.appendChild(div);
            });

            data.hotels.forEach((hotel) => {
                let div = document.createElement('div');
                div.classList.add('indiviualHotel');
                div.textContent = hotel.hotel;
                div.dataset.id = hotel.id;
                div.dataset.parkId = hotel.park_id;
                div.addEventListener('click', (event) => selectHotel(event));
                hotelList.appendChild(div);
            });
        };
        let results = {};
        const postData = async () => {
            const people = {};
            const rows = document.querySelectorAll('.people tbody tr');
            rows.forEach(row => {
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    const inputValue = Number(input.value);
                    if (!isNaN(inputValue) && inputValue > 0) {
                        people[input.name] = inputValue;
                    }
                });
            });
            const flight = Number(document.querySelector('.flight').value || 0);
            const total = Number(document.querySelector('.total').value || 0);
            const profit = Number(document.querySelector('.profit').value || 0);
            const discount = Number(document.querySelector('.discount').value || 0);
            const invoice_amount = Number(document.querySelector('.invoice_amount').value || 0);

            const parks = [];
            const parksTable = document.querySelector('.parks');
            const parkRows = parksTable.querySelectorAll('tbody tr');
            parkRows.forEach(row => {
                const startDate = new Date(row.querySelector('input[name="start_date"]').value || '');
                const endDate = new Date(row.querySelector('input[name="end_date"]').value || startDate);
                const days = (endDate - startDate) / (1000 * 60 * 60 * 24);

                const park = {
                    park: Number(row.querySelector('input[name="park"]').dataset.id || 0),
                    park_name: row.querySelector('input[name="park"]').value || '',
                    start_date: row.querySelector('input[name="start_date"]').value || '',
                    end_date: row.querySelector('input[name="end_date"]').value || '',
                    hotel: Number(row.querySelector('input[name="hotel"]').dataset.id || 0),
                    hotel_name: row.querySelector('input[name="hotel"]').value || '',
                    days: days,
                    car_hire: Number(row.querySelector('input[name="car_hire"]').value || 0),
                    extras: Number(row.querySelector('input[name="extras"]').value || 0),
                };
                parks.push(park);
            });

            const data = {
                people,
                flight,
                total,
                profit,
                discount,
                invoice_amount,
                parks
            };
            // console.log(data);
            const response = await fetch('get_cost.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((result) => {
                    // console.table(result.used_hcf_rates)
                    document.querySelector('.total').value = result.total;
                    document.querySelector('.profit').value = Number(result.profit);
                    document.querySelector('.discount').value = Number(result.discount);
                    document.querySelector('.invoice_amount').value = Number(result.invoice_amount);
                    results = result;
                })
                .catch((e) => {
                    console.error('Error fetching data:', e);
                });
        };

        const openparks = (id, show) => {
            let all_parks = document.querySelector('.all_parks');
            let all_hotels = document.querySelector('.all_hotels');
            let previewSection = document.querySelector('.preview');

            if (show) {
                all_parks.style.display = 'block';
                all_hotels.style.display = 'none';
                previewSection.style.display = 'none';

                all_parks.dataset.id = id;
                delete all_hotels.dataset.id;
            } else {
                all_parks.style.display = 'none';
                delete all_parks.dataset.id;
                delete all_hotels.dataset.id;
            }
        };

        const openhotels = (id, show) => {
            let all_hotels = document.querySelector('.all_hotels');
            let all_parks = document.querySelector('.all_parks');
            let previewSection = document.querySelector('.preview');
            let hotelSearchBar = document.querySelector('.search-bar.hotels');

            if (show) {
                all_hotels.style.display = 'block';
                all_parks.style.display = 'none';
                previewSection.style.display = 'none';

                all_hotels.dataset.id = id;
                delete all_parks.dataset.id;
            } else {
                all_hotels.style.display = 'none';
                delete all_hotels.dataset.id;
                delete all_parks.dataset.id;
            }
        };

        const openPreview = (show) => {
            let previewSection = document.querySelector('.preview');
            let all_parks = document.querySelector('.all_parks');
            let all_hotels = document.querySelector('.all_hotels');

            if (show) {
                previewSection.style.display = 'block';
                all_parks.style.display = 'none';
                all_hotels.style.display = 'none';
            } else {
                previewSection.style.display = 'none';
            }
        };

        const selectPark = (event) => {
            let all_parks = document.querySelector('.all_parks');
            let parkInputField = document.querySelector(`.parks tr[data-id="${all_parks.dataset.id}"] .park`);
            let selectedRow = document.querySelector(`.parks tr[data-id="${all_parks.dataset.id}"]`);
            let hotelSearchBar = document.querySelector('.search-bar.hotels');

            parkInputField.value = event.target.textContent;
            parkInputField.dataset.id = event.target.dataset.id;
            hotelSearchBar.dataset.id = parkInputField.dataset.id;
            delete all_parks.dataset.id;

            searchHotels('');
            openparks(false);
            postData();
        };

        const selectHotel = (event) => {
            let all_hotels = document.querySelector('.all_hotels');
            let hotelListDiv = document.querySelector('.hotelList');
            let hotelInputField = document.querySelector(`.parks tr[data-id="${all_hotels.dataset.id}"] .hotel`);

            hotelInputField.value = event.target.textContent;
            hotelInputField.dataset.id = event.target.dataset.id;
            delete all_hotels.dataset.id;
            openhotels(false);
            postData();
        };

        const calcInvoiceAmount = () => {
            let profit = document.querySelector('.profit').value || 0;
            let discount = document.querySelector('.discount').value || 0;
            let total = document.querySelector('.total').value || 0;

            let calced = (total * (1 + (profit / 100))) * (1 - (discount / 100));

            document.querySelector('.invoice_amount').value = calced.toFixed(1);
        }

        const addRow = () => {
            const table = document.querySelector('.parks tbody');
            const row = table.rows[0].cloneNode(true);
            row.dataset.id = table.rows.length + 1;

            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
                input.dataset.id = '';
            });

            table.appendChild(row);
        }

        const removeRow = (button) => {
            const row = button.closest('tr');
            const table = row.closest('tbody');
            if (table.rows.length > 1) {
                row.remove();
            } else {
                alert('At least one row must remain!');
            }
        }

        const searchParks = (e) => {
            let searchValue = e.target.value.toLowerCase();
            let parkItems = document.querySelectorAll('.parkList .indiviualPark');

            parkItems.forEach((park) => {
                let parkName = park.textContent.toLowerCase();
                if (parkName.includes(searchValue)) {
                    park.style.display = 'block';
                } else {
                    park.style.display = 'none';
                }
            });
        }

        const searchHotels = (v) => {
            let searchValue = v.toLowerCase();
            let hotelItems = document.querySelectorAll('.hotelList .indiviualHotel');
            let hotelSearchBar = document.querySelector('.search-bar.hotels');

            hotelItems.forEach((hotel) => {
                let hotelName = hotel.textContent.toLowerCase();
                if (hotelName.includes(searchValue) && hotel.dataset.parkId == hotelSearchBar.dataset.id) {
                    hotel.style.display = 'block';
                } else {
                    hotel.style.display = 'none';
                }
            });
        }

        const openInNewTab = () => {
            const queryString = encodeURIComponent(JSON.stringify(results));
            window.open(`preview.php?data=${queryString}`, '_blank');
        }
    </script>
</body>

</html>