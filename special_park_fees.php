<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Special Fees</title>
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

        .allFields {
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .parkSection {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus {
            border-color: #008080;
            box-shadow: 0px 0px 8px rgba(0, 128, 128, 0.3);
            outline: none;
        }

        button {
            background: linear-gradient(to right, #008080, #00b3b3);
            color: white;
            border: none;
            padding: 10px 20px;
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

        aside.all_parks {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            max-height: 80vh;
            background: #fff;
            border-radius: 15px;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: none;
            z-index: 1000;
        }

        .all_parks h2 {
            color: #008080;
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 15px;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .parkList {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .indiviualPark {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .indiviualPark:hover {
            background: #e0f7f7;
            transform: scale(1.01);
        }

        .hideParks {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
        }

        .hideParks:hover {
            color: #333;
        }
    </style>
</head>

<body onload="initial_load()">
    <form class="allFields" onsubmit="addFees(event)">
        <div class="parkSection">
            <input type="text" class="park" name="park_id" placeholder="Selected Park" disabled required>
            <button class="openParks" onclick="openparks(true)" type="button">Select Park</button>
        </div>
        <input type="text" class="fees_name" name="fees_name" placeholder="Fees Name" required>
        <input type="number" class="rate" step='0.01' min=0 name="rate" placeholder="Rate" required>
        <button type="submit">Add Fee</button>
    </form>
    <aside class="all_parks" style="display: none;">
        <button class="hideParks close" onclick="openparks(false)">❌</button>
        <h2>Parks</h2>
        <input type="text" class="search-bar" oninput="searchParks(event)" placeholder="Search parks...">
        <div class="parkList">
        </div>
    </aside>
    <script>
        const initial_load = async () => {
            const response = await fetch('get_parks.php?for=hotelpage');
            const data = await response.json();
            const parksList = document.querySelector('.parkList');

            data.parks.forEach((park) => {
                let div = document.createElement('div');
                div.classList.add('indiviualPark');
                div.textContent = park.name;
                div.dataset.id = park.id;
                div.addEventListener('click', (event) => selectPark(event));
                parksList.appendChild(div);
            });
        };

        const openparks = (show) => {
            let all_parks = document.querySelector('.all_parks');

            if (show) {
                all_parks.style.display = 'block';
            } else {
                all_parks.style.display = 'none';
            }
        };

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

        const selectPark = (event) => {
            let all_parks = document.querySelector('.all_parks');
            let parkInputField = document.querySelector(`.park`);

            parkInputField.value = event.target.textContent;
            parkInputField.dataset.id = event.target.dataset.id;
            openparks(false);
        };

        const addFees = async (event) => {
            event.preventDefault();
            const formData = {
                park_id: document.querySelector('.park').dataset.id,
                fees_name: document.querySelector('.fees_name').value,
                rate: document.querySelector('.rate').value
            };
            console.log(formData);
            const response = await fetch('posting_data.php?action=add_fee', {
                method: 'POST',
                body: JSON.stringify(formData)
            })
            .then(
                alert('special fees added successfully!')
            )
            .catch(error => {
                alert('Failed to add special fees.')
                console.error('Error:', error);
            });
        };
    </script>
</body>

</html>