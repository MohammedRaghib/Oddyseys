<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Special Fees</title>
</head>

<body onload="initial_load()">
    <input type="text" class="park" name="park" disabled required><button class="openParks" onclick="openparks(true)">Select Park</button>
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
    </script>
</body>

</html>