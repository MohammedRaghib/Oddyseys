<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Special Fees</title>
</head>

<body onload="initial_load()">
    <aside class="all_parks" style="display: none;">
        <button class="hideParks close" onclick="openparks(this, false)">❌</button>
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

        const openparks = (id, show) => {
            let all_parks = document.querySelector('.all_parks');
            let previewSection = document.querySelector('.preview');

            if (show) {
                all_parks.style.display = 'block';
                previewSection.style.display = 'none';

                all_parks.dataset.id = id;
            } else {
                all_parks.style.display = 'none';
                delete all_parks.dataset.id;
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
    </script>
</body>

</html>