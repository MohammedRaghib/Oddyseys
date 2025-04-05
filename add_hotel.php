<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hotel</title>
    <!-- <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #4caf50, #81c784);
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .adding {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        form {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background: #4caf50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f1f1f1;
        }

        td input,
        td select {
            width: 80%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        td input:focus,
        td select:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0px 0px 5px rgba(76, 175, 80, 0.5);
        }

        button {
            background: #ff9800;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 5px;
        }

        button:hover {
            background: #e65100;
        }

        .cancel-btn:hover {
            background-color: #b71c1c;
        }

        button:active {
            transform: scale(0.98);
        }

        .add-entry {
            width: 100%;
            background: #4caf50;
            margin-top: 10px;
        }

        .add-entry:hover {
            background: #388e3c;
        }

        .submit-hotel {
            width: 100%;
            background: #00796b;
        }

        .submit-hotel:hover {
            background: #004d40;
        }

        .remove-entry {
            width: auto;
            background: #d32f2f;
        }

        .remove-entry:hover {
            background: #b71c1c;
        }
    </style> -->
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

        main.adding,
        .modifying,
        .ListOfHotels {
            margin: 20px auto;
            max-width: 1100px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #008080;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.9em;
        }

        table th,
        table td {
            padding: 10px;
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
        select,
        .search-bar {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus,
        select:focus,
        .search-bar:focus {
            border-color: #008080;
            box-shadow: 0px 0px 8px rgba(0, 128, 128, 0.3);
            outline: none;
        }

        .search-bar {
            border-radius: 25px;
        }

        aside.ListOfHotels {
            position: fixed;
            top: 10%;
            right: 5%;
            width: 300px;
            height: 80%;
            background: #fff;
            border-radius: 15px;
            overflow-y: auto;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: none;
        }

        aside.ListOfHotels h2 {
            color: #008080;
            font-size: 1.4rem;
        }

        .indiviualHotel {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .indiviualHotel:hover {
            background: #e0f7f7;
            transform: scale(1.02);
        }

        .cancel-btn {
            float: right;
            font-size: 1.2rem;
            background: none;
            color: #999;
            border: none;
            cursor: pointer;
        }

        .cancel-btn:hover {
            color: #333;
        }

        .modifying {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <main class="adding">
        <h1>Season Hotels Rates</h1>
        <form class="add_hotel_form" name="add_hotel_form" onsubmit="handleSubmit(event)">
            <table id="dynamic-entries" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Park</th>
                        <th>Season</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="entry">
                        <td><input type="text" name="hotel[]" id="hotel" required></td>
                        <td><select name="park[]" id="park" class="parkSelect" required>
                                <option value="">-SELECT PARK-</option>
                            </select></td>
                        <td><select name="season[]" id="season" required>
                                <option value="">-SELECT SEASON-</option>
                                <option value="Low">Low season (01/04 - 31/05)</option>
                                <option value="Mid">Mid season (01/11 - 14/12)</option>
                                <option value="High1">High season (01/01 - 31/03)</option>
                                <option value="High2">High season (01/06 - 31/10)</option>
                                <option value="High3">High season (15/12 - 31/12)</option>
                            </select></td>
                        <td><input type="number" step="0.01" name="rate[]" id="rate" required></td>
                        <td><button type="button" onclick="removeEntry(this)" class="remove-entry">Remove</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="addEntry()" class="add-entry">Add Row</button>
            <button type="submit" class="submit-hotel">Submit</button>
        </form>
    </main>
    <form class="modifying" onsubmit="updateHotel(event)">
        <div class="changeHotel">
            <label for="hotels">Current editing hotel: <b id="currentHotel"></b></label>
            <button class="openForm" onclick="openhotels(true)" type="button">Change</button>
        </div>
        <input type="text" name="ID" id="hotel_ID" style="display: none;" required>

        <label for="hotel_hotel">Name</label>
        <input type="text" name="hotel" id="hotel_hotel" required>

        <label for="parkSelect">Park</label>
        <select name="park" class="parkSelect" id="hotel_park" required>
            <option value="">-SELECT PARK-</option>
        </select>

        <label for="hotel_season">Season</label>
        <select name="season" id="hotel_season" required>
            <option value="">-SELECT SEASON-</option>
            <option value="Low">Low season (01/04 - 31/05)</option>
            <option value="Mid">Mid season (01/11 - 14/12)</option>
            <option value="High1">High season (01/01 - 31/03)</option>
            <option value="High2">High season (01/06 - 31/10)</option>
            <option value="High3">High season (15/12 - 31/12)</option>
        </select>

        <label for="hotel_rate">Rate</label>
        <input type="text" id="hotel_rate" name="rate" required>

        <button type="submit">Save Hotel</button>
    </form>
    <aside class="ListOfHotels">
        <h2>All Hotels</h2>
        <button onclick="openhotels(false)" class="cancel-btn">❌</button>
        <input type="text" class="search-bar" oninput="searchHotels(event)" placeholder="Search hotels">
        <div class="HotelList">
        </div>
    </aside>
    <script>
        const intial_load = document.addEventListener('DOMContentLoaded', function() {
            let parksSelects = document.querySelectorAll('.parkSelect');
            let hotelSelect = document.getElementById('hotels');

            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_parks.php?for=hotelpage', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.status >= 200 && this.status < 400) {
                    const response = JSON.parse(xhr.responseText);
                    response.parks.forEach((park) => {
                        parksSelects.forEach((select) => {
                            let option = document.createElement('option');
                            option.value = park;
                            option.textContent = park;
                            select.appendChild(option);
                        });
                    });
                    response.hotels.forEach((hotel) => {
                        let hotelList = document.querySelector('.HotelList');
                        let div = document.createElement('div');
                        div.innerHTML = `
                        <div onclick='updateForm(event, ${hotel.id})'>
                            <span class='hotel_name'>${hotel.hotel || 'No hotel found'}</span>
                            <br>
                            <span class='hotel_start_date'>${hotel?.start_date}</span>
                            <br>
                            <span class='hotel_end_date'>${hotel?.end_date}</span>
                            <br>
                            <span class='hotel_park'>${hotel?.park}</span>
                            <br>
                            <span class='hotel_rate'>${hotel?.rate}</span>
                        </div>`
                        div.classList.add('indiviualHotel');
                        div.classList.add(`hotel${hotel.id}`);
                        hotelList.appendChild(div);
                    });

                } else {
                    parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                    hotelSelect.innerHTML = '<option value="">Error loading hotels.</option>';
                }
            };
            xhr.onerror = function() {
                parksSelect.innerHTML = '<option value="">Error loading parks.</option>';
                hotelSelect.innerHTML = '<option value="">Error loading hotels.</option>';
            };
            xhr.send();
        });

        function getSeasonDateRange(season) {
            switch (season) {
                case 'Low':
                    return {
                        start: '2000-04-01', end: '2000-05-31'
                    };
                case 'Mid':
                    return {
                        start: '2000-11-01', end: '2000-12-14'
                    };
                case 'High1':
                    return {
                        start: '2000-01-01', end: '2000-03-31'
                    };
                case 'High2':
                    return {
                        start: '2000-06-01', end: '2000-10-31'
                    };
                case 'High3':
                    return {
                        start: '2000-12-15', end: '2000-12-31'
                    };
                default:
                    return {
                        start: '', end: ''
                    };
            }
        }

        function addEntry() {
            const entry = document.querySelector('.entry');
            const newEntry = entry.cloneNode(true);
            const inputs = newEntry.querySelectorAll('input, select');
            inputs.forEach(input => input.value = '');
            document.querySelector('#dynamic-entries tbody').appendChild(newEntry);
        }

        function removeEntry(button) {
            const row = button.closest('tr');
            const rows = document.querySelectorAll('#dynamic-entries tbody .entry');
            if (rows.length > 1) {
                row.remove();
            } else {
                alert('At least one row must remain!');
            }
        }

        const openhotels = (show) => {
            let List = document.querySelector('.ListOfHotels');
            if (show) {
                List.style.display = 'block';
            } else {
                List.style.display = 'none';
            }
        }

        const updateForm = (e, id) => {
            let list = document.querySelector('.ListOfHotels');

            let data = {
                ID: id,
                hotel: document.querySelector(`.hotel${id} .hotel_name`).textContent || '',
                park: document.querySelector(`.hotel${id} .hotel_park`).textContent || '',
                start_date: document.querySelector(`.hotel${id} .hotel_start_date`).textContent || '',
                end_date: document.querySelector(`.hotel${id} .hotel_end_date`).textContent || '',
                rate: parseFloat(document.querySelector(`.hotel${id} .hotel_rate`).textContent) || 0,
            };

            const startDate = data.start_date;
            const endDate = data.end_date;
            const seasonSelect = document.getElementById('hotel_season');

            if (startDate === '2000-04-01' && endDate === '2000-05-31') {
                seasonSelect.value = 'Low';
            } else if (startDate === '2000-11-01' && endDate === '2000-12-14') {
                seasonSelect.value = 'Mid';
            } else if (startDate === '2000-01-01' && endDate === '2000-03-31') {
                seasonSelect.value = 'High1';
            } else if (startDate === '2000-06-01' && endDate === '2000-10-31') {
                seasonSelect.value = 'High2';
            } else if (startDate === '2000-12-15' && endDate === '2000-12-31') {
                seasonSelect.value = 'High3';
            }

            Object.keys(data).forEach((field) => {
                let text = data[field];
                if (text && field !== 'start_date' && field !== 'end_date') {
                    let input = document.getElementById(`hotel_${field}`);
                    if (input) {
                        input.value = data[field];
                    }
                }
            });

            let current = document.getElementById('currentHotel');
            current.textContent = data['hotel'];
            list.style.display = 'none';
        };

        const searchHotels = (event) => {
            let searchValue = event.target.value.toLowerCase();
            let hotelItems = document.querySelectorAll('.HotelList .indiviualHotel');

            hotelItems.forEach((hotel) => {
                let hotelName = hotel.querySelector('.hotel_name').textContent.toLowerCase();
                if (hotelName.includes(searchValue)) {
                    hotel.style.display = 'block';
                } else {
                    hotel.style.display = 'none';
                }
            });
        };

        const handleSubmit = async (e) => {
            e.preventDefault();
            try {
                const formData = new FormData(document.querySelector('.add_hotel_form'));
                const seasonElements = document.querySelectorAll('select[name="season[]"]');
                seasonElements.forEach((select, index) => {
                    const season = select.value;
                    const {
                        start,
                        end
                    } = getSeasonDateRange(season);
                    formData.append(`start_date[${index}]`, start);
                    formData.append(`end_date[${index}]`, end);
                });

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'posting_data.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        let response = JSON.parse(xhr.responseText);
                        console.log(response.message);
                        alert('Hotels added successfully');
                    } else {
                        alert('Failed to add hotels');
                    }
                };
                xhr.onerror = function() {
                    alert('Failed to add hotels');
                };
                formData.append("action", "add_hotel");
                xhr.send(new URLSearchParams(formData).toString());
            } catch (error) {
                alert('Failed to add hotels');
                console.error(error);
            }
        };

        const updateHotel = async (e) => {
            e.preventDefault();

            let form = document.querySelector('.modifying');
            let formData = new FormData(form);
            const season = formData.get('season');
            const {
                start,
                end
            } = getSeasonDateRange(season);
            formData.set('start_date', start);
            formData.set('end_date', end);

            try {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'posting_data.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        let response = JSON.parse(xhr.responseText);
                        console.log("Server Response:", response.message);
                        alert('Hotel updated successfully!');
                    } else {
                        alert('Failed to update hotel.');
                    }
                };

                xhr.onerror = function() {
                    alert('An error occurred while updating the hotel.');
                };

                formData.append("action", "update_hotel");
                xhr.send(new URLSearchParams(formData).toString());
            } catch (error) {
                console.error("Error:", error);
                alert('Failed to update hotel.');
            }
        };
    </script>
</body>

</html>