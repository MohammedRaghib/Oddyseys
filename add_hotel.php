<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Hotels</title>
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

        .add_hotel_form {
            display: flex;
            flex-direction: column;
            justify-content: left;
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

        .small-btn {
            width: 20%;
            margin: 15px;
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

        .parkOption {
            display: none;
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

        .changeHotel {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <main class="adding">
        <h1>Park Hotels</h1>
        <form class="add_hotel_form" name="add_hotel_form" onsubmit="handleSubmit(event)">
            <div class="changeHotel">
                <span>Current editing hotel: <b id="currentHotel"></b></span>
                <div class="changeHotel-btns">
                    <button class="openForm" onclick="openhotels(true)" type="button">Load Existing Hotel</button>
                    <button class="clearForm" onclick="change()" type="button">Clear Form</button>
                </div>
            </div>
            <input type="text" name="ID" id="hotel_ID" style="display: none;" class="input">

            <label for="hotel_hotel">Name</label>
            <input type="text" name="hotel" id="hotel_hotel" class="input" required>


            <label for="hotel_country">Country</label>
            <select name="country" class="select" id="hotel_country" onchange="filter(event.target.value)">
                <option value="">-SELECT COUNTRY-</option>
                <option value="kenya">Kenya</option>
                <option value="tanzania">Tanzania</option>
            </select>

            <label for="hotel_park" style="display: none;">Park</label>
            <select name="park" class="parkSelect select" id="hotel_park" style="display: none;" required>
                <option value="">-SELECT PARK-</option>
            </select>

            <table id="dynamic-entries" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Season</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="entry">
                        <td><select name="season[]" id="hotel_season" class="select" required>
                                <option value="">-SELECT SEASON-</option>
                                <option value="Low">Low season (01/04 - 31/05)</option>
                                <option value="Mid">Mid season (01/11 - 14/12)</option>
                                <option value="High1">High season (01/01 - 31/03)</option>
                                <option value="High2">High season (01/06 - 31/10)</option>
                                <option value="High3">High season (15/12 - 31/12)</option>
                            </select></td>
                        <td><input type="number" step="0.01" name="rate[]" id="hotel_rate" class="input" required></td>
                        <td><button type="button" onclick="removeEntry(this)" class="remove-entry">Remove</button></td>
                    </tr>
                </tbody>
            </table>
            <div class="Actionbuttons">
                <button type="button" onclick="addEntry()" class="small-btn">Add Row</button>
                <button type="submit" class="small-btn">Submit</button>
            </div>
        </form>
    </main>

    <aside class="ListOfHotels">
        <h2>All Hotels</h2>
        <button onclick="openhotels(false)" class="cancel-btn">❌</button>
        <input type="text" class="search-bar" id='search-bar' oninput="searchHotels(event)" placeholder="Search hotels">
        <div class="HotelList">
        </div>
    </aside>
    <script>
        let all_parks = {};

        const intial_load = document.addEventListener('DOMContentLoaded', function() {
            let parksSelects = document.querySelectorAll('.parkSelect');
            let hotelSelect = document.querySelector('.HotelList');

            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_parks.php?for=hotelpage', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.status >= 200 && this.status < 400) {
                    const response = JSON.parse(xhr.responseText);

                    all_parks = response.parks;

                    response.parks.forEach((park) => {
                        parksSelects.forEach((select) => {
                            let option = document.createElement('option');
                            option.value = park.id;
                            option.classList.add('parkOption');
                            option.classList.add(park.country);
                            option.textContent = park.name;
                            select.appendChild(option);
                        });
                    });
                    response.hotels.forEach((hotel) => {
                        let hotelList = document.querySelector('.HotelList');
                        let div = document.createElement('div');
                        div.innerHTML = `
                        <div onclick='updateForm(event, ${hotel.id})'>
                            <span class='hotel_name'>${hotel.hotel || 'No hotel found'}</span>
                        </div>`
                        div.classList.add('indiviualHotel');
                        div.classList.add(`hotel${hotel.id}`);
                        hotelList.appendChild(div);
                    });

                } else {
                    parksSelects.innerHTML = '<option value="">Error loading parks.</option>';
                    hotelSelect.innerHTML = '<p>Error loading hotels.</p>';
                }
            };
            xhr.onerror = function() {
                console.error('Error bish')
                parksSelects.forEach((select) => {
                    select.innerHTML = '<option value="">Error loading parks.</option>';
                });
                hotelSelect.innerHTML = '<p>Error loading hotels.</p>';
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

        function getSeasonFromRange(startDate, endDate) {
            const formattedStartDate = `2000-${startDate.slice(5)}`;
            const formattedEndDate = `2000-${endDate.slice(5)}`;

            const seasons = [{
                    season: 'Low',
                    start: '2000-04-01',
                    end: '2000-05-31'
                },
                {
                    season: 'Mid',
                    start: '2000-11-01',
                    end: '2000-12-14'
                },
                {
                    season: 'High1',
                    start: '2000-01-01',
                    end: '2000-03-31'
                },
                {
                    season: 'High2',
                    start: '2000-06-01',
                    end: '2000-10-31'
                },
                {
                    season: 'High3',
                    start: '2000-12-15',
                    end: '2000-12-31'
                }
            ];

            for (const s of seasons) {
                if (formattedStartDate === s.start && formattedEndDate === s.end) {
                    return s.season;
                }
            }

            return '';
        }

        let editing = false;
        const change = () => {
            let countrySelect = document.getElementById('hotel_country');
            let parkSelect = document.getElementById('hotel_park');
            let tbody = document.querySelector('#dynamic-entries tbody');
            let countryLabel = document.getElementById('hotel_country').previousElementSibling;
            let parkLabel = document.getElementById('hotel_park').previousElementSibling;

            let options = document.querySelectorAll('.parkOption');
            options.forEach((option) => {
                option.style.display = 'block';
            });

            parkLabel.style.display = 'none';
            parkSelect.style.display = 'none';

            countryLabel.style.display = 'block';
            countrySelect.style.display = 'block';

            tbody.innerHTML = `
                    <tr class="entry">
                        <td><select name="season[]" id="hotel_season" class="select" required>
                                <option value="">-SELECT SEASON-</option>
                                <option value="Low">Low season (01/04 - 31/05)</option>
                                <option value="Mid">Mid season (01/11 - 14/12)</option>
                                <option value="High1">High season (01/01 - 31/03)</option>
                                <option value="High2">High season (01/06 - 31/10)</option>
                                <option value="High3">High season (15/12 - 31/12)</option>
                            </select></td>
                        <td><input type="number" step="0.01" name="rate[]" id="hotel_rate" class="input" required></td>
                        <td><button type="button" onclick="removeEntry(this)" class="remove-entry">Remove</button></td>
                    </tr>`
            const form = document.querySelector('.add_hotel_form');
            form.reset();
            editing = false;
            let id_field = document.getElementById('hotel_ID');
            let current = document.getElementById('currentHotel');
            current.textContent = '';
            id_field.removeAttribute('required');
        };

        const filter = (selected) => {
            let parkSelect = document.querySelector('.parkSelect');
            let parkLabel = document.querySelector('.parkSelect').previousElementSibling;
            let countrySelect = document.getElementById('hotel_country');

            if (selected) {
                parkSelect.value = '';
                let Alloptions = document.querySelectorAll(`.parkOption`);
                Alloptions.forEach((option) => {
                    option.style.display = 'none';
                });
                let options = document.querySelectorAll(`.${selected}`);
                options.forEach((option) => {
                    option.style.display = 'block';
                });
                parkLabel.style.display = 'inline-block';
                parkSelect.style.display = 'block';
            } else {
                parkSelect.style.display = 'none';
                parkLabel.style.display = 'none';
                parkSelect.value = '';
                let options = document.querySelectorAll(`.parkOption`);
                options.forEach((option) => {
                    option.style.display = 'none';
                });
            }
        };

        function addEntry() {
            const entry = document.querySelector('.entry');
            const newEntry = entry.cloneNode(true);
            const inputs = newEntry.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.value = '';
                delete input.dataset.id;
            });
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
        };

        const openhotels = (show) => {
            let List = document.querySelector('.ListOfHotels');
            if (show) {
                List.style.display = 'block';
            } else {
                List.style.display = 'none';
            }
        };

        const updateForm = async (e, id) => {
            let list = document.querySelector('.ListOfHotels');
            let options = document.querySelectorAll('.parkOption');
            options.forEach((option) => {
                option.style.display = 'block';
            });

            let xhr = new XMLHttpRequest();

            xhr.open('GET', `get_parks.php?for=hotel_info&id=${id}`, true);

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status <= 400) {
                    const response = JSON.parse(xhr.responseText);
                    const hotelInfo = response.hotel_info;

                    const form = document.querySelector('.add_hotel_form');
                    document.getElementById('hotel_ID').value = id;
                    document.getElementById('hotel_hotel').value = document.querySelector(`.hotel${id} .hotel_name`).textContent || '';
                    const parkSelect = document.getElementById('hotel_park');
                    const parklabel = document.getElementById('hotel_park').previousElementSibling;
                    parkSelect.value = hotelInfo.parkID;
                    parkSelect.style.display = 'block';
                    parklabel.style.display = 'block';

                    const countrySelect = document.getElementById('hotel_country');
                    const countryLabel = document.getElementById('hotel_country').previousElementSibling;
                    countrySelect.removeAttribute('required');
                    countrySelect.style.display = 'none';
                    countryLabel.style.display = 'none';

                    const tbody = document.querySelector('#dynamic-entries tbody');
                    tbody.innerHTML = '';

                    hotelInfo.ranges.forEach((range) => {
                        const season = range.start_date && range.end_date ?
                            getSeasonFromRange(range.start_date, range.end_date) :
                            '';
                        const newRow = `
                            <tr class="entry">
                                <td>
                                    <select name="season[]" class="select" data-id='${range.id}' required>
                                        <option value="">-SELECT SEASON-</option>
                                        <option value="Low" ${season === 'Low' ? 'selected' : ''}>Low season (01/04 - 31/05)</option>
                                        <option value="Mid" ${season === 'Mid' ? 'selected' : ''}>Mid season (01/11 - 14/12)</option>
                                        <option value="High1" ${season === 'High1' ? 'selected' : ''}>High season (01/01 - 31/03)</option>
                                        <option value="High2" ${season === 'High2' ? 'selected' : ''}>High season (01/06 - 31/10)</option>
                                        <option value="High3" ${season === 'High3' ? 'selected' : ''}>High season (15/12 - 31/12)</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="rate[]" value="${range.rate}" class="input" required>
                                </td>
                                <td>
                                    <button type="button" onclick="removeEntry(this)" class="remove-entry">Remove</button>
                                </td>
                            </tr>`;
                        document.querySelector('#dynamic-entries tbody').innerHTML += newRow;
                    });

                    const current = document.getElementById('currentHotel');
                    current.textContent = document.querySelector(`.hotel${id} .hotel_name`).textContent || '';
                    list.style.display = 'none';

                    const idField = document.getElementById('hotel_ID');
                    idField.setAttribute('required', '');

                    editing = true;
                } else {
                    console.error(JSON.parse(xhr.responseText).message || '');
                    alert('Failed to fetch hotel details.');
                }
            };

            xhr.onerror = function() {
                console.error(JSON.parse(xhr.responseText).message);
                alert('Failed to fetch hotel details.');
            };

            xhr.send();
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
            if (editing) {
                updateHotel(e);
                return;
            }

            try {
                const form = document.querySelector('.add_hotel_form');
                const formData = new FormData(form);

                const hotel = {
                    name: formData.get('hotel'),
                    park: formData.get('park'),
                };

                const seasons = [];
                const seasonRows = document.querySelectorAll('#dynamic-entries tbody .entry');
                seasonRows.forEach((row) => {
                    const seasonSelect = row.querySelector('select[name="season[]"]');
                    const rateInput = row.querySelector('input[name="rate[]"]');
                    const season = seasonSelect.value;
                    const rate = rateInput.value;

                    const {
                        start,
                        end
                    } = getSeasonDateRange(season);

                    const seasonObject = {
                        season: season,
                        start_date: start,
                        end_date: end,
                        rate: rate,
                    };

                    seasons.push(seasonObject);
                });

                const payload = {
                    hotel: hotel,
                    seasons: seasons,
                    action: 'add_hotel',
                };

                console.log(payload);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'posting_data.php?action=add_hotel', true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Server Response:', response.message);
                        alert('Hotel added successfully!');
                        change();
                    } else {
                        alert('Failed to add hotel.');
                    }
                };

                xhr.onerror = function() {
                    alert('An error occurred while adding the hotel.');
                };

                xhr.send(JSON.stringify(payload));
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to add hotel.');
            } finally {
                editing = false;
            }
        };

        const updateHotel = async (e) => {
            e.preventDefault();

            try {
                const form = document.querySelector('.add_hotel_form');
                const formData = new FormData(form);

                const hotel = {
                    ID: formData.get('ID'),
                    name: formData.get('hotel'),
                    park: formData.get('park'),
                };

                const seasons = [];
                const seasonRows = document.querySelectorAll('#dynamic-entries tbody .entry');
                seasonRows.forEach((row) => {
                    const seasonSelect = row.querySelector('select[name="season[]"]');
                    const rateInput = row.querySelector('input[name="rate[]"]');
                    const season = seasonSelect.value;
                    const rate = rateInput.value;

                    const {
                        start,
                        end
                    } = getSeasonDateRange(season);

                    const seasonObject = {
                        season: season,
                        start_date: start,
                        end_date: end,
                        rate: rate,
                        id: seasonSelect.dataset.id || null,
                    };

                    seasons.push(seasonObject);
                });

                const payload = {
                    hotel: hotel,
                    seasons: seasons,
                    action: 'update_hotel',
                };

                console.log(payload);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'posting_data.php?action=update_hotel', true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Server Response:', response.message);
                        alert('Hotel updated successfully!');
                        change(); // Reset the form
                    } else {
                        alert('Failed to update hotel.');
                    }
                };

                xhr.onerror = function() {
                    alert('An error occurred while updating the hotel.');
                };

                xhr.send(JSON.stringify(payload));
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update hotel.');
            }
            editing = false;
        };
    </script>
</body>

</html>