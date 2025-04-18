<?php
session_start();

$previewData = isset($_SESSION['preview_data']) ? $_SESSION['preview_data'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
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

    main.container {
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    .parks_data > div {
        border: 1px solid #eee;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background: #f9f9f9;
    }

    .details h2 {
        margin-top: 0;
        color: #008080;
        margin-bottom: 10px;
    }

    .details p {
        margin-bottom: 8px;
        color: #666;
        font-size: 0.95em;
    }

    .all_total {
        font-size: 1.3em;
        font-weight: 600;
        margin-top: 25px;
        display: block;
        text-align: right;
        color: #333;
    }

    .all_total span {
        color: #00b3b3;
    }

    .fee-category {
        font-weight: bold;
        margin-top: 10px;
    }

    .fee-breakdown-title {
        font-weight: bold;
        font-size: 1em;
        margin-top: 5px;
        color: #555;
        margin-bottom: 8px;
        text-align: left; /* Align title to the left */
    }

    .person-fees {
        display: grid;
        grid-template-columns: auto auto; /* Two columns: Person Type and Total */
        gap: 5px;
        margin-bottom: 10px;
    }

    .person-fees div {
        padding: 8px;
        background-color: #f0f0f0;
        border-radius: 4px;
    }

    .person-fees div:nth-child(odd) {
        font-weight: bold; /* Person Type labels */
        background-color: #e8e8e8;
        text-align: left; /* Align person type to the left */
    }

    .person-fees div:nth-child(even) {
        text-align: right; /* Align fee to the right */
    }
    .fee-breakdown-title{
        grid-column: 1 / -1;
    }
</style>
</head>

<body>
    <main class="container">
        <section class="parks_data">

        </section>
        <section class="one_fees">

        </section>
        <span class="all_total">
           TOTAL = <span></span>
        </span>
    </main>
    <script>
        /* {

            "parks": {
                "0": {
                    "park_id": 20,
                    "hotel_id": 140,
                    "start_date": "",
                   "end_date": "",
                    "people_breakdown": [],
                    "conservancy_fees": {
                        "total": 0,
                        "by_person_type": []
                    },
                    "hotel_cost": {
                        "total": 0,
                        "per_night_per_person": 0
                    },
                    "concession_fees": {
                        "total": 0,
                        "by_person_type": []
                    },
                    "car_hire_cost": 0,
                    "extras_cost": 0,
                    "total_cost": 0
                },
                "total_cost": 0
            },
            "flight": 0,
            "total": 0,
            "profit": 0,
            "discount": 0,
            "invoice_amount": 0
        }   */
        // const data = <?php echo json_encode($previewData); ?>;
        const data = {
            'parks': [{
                    'park_name': 'Serengeti National Park',
                    'hotel_name': 'Serengeti Serena Safari Lodge',
                    'start_date': '2024-07-01',
                    'end_date': '2024-07-05',
                    'conservancy_fees': {
                        'total': 600,
                        'by_person_type': [{
                            'person_type': 'EA-Adult',
                                'total': 200
                            },
                            {
                                'person_type': 'EA-Child',
                                'total': 100
                            },
                            {
                                'person_type': 'Non-EA-Adult',
                                'total': 300
                            }
                        ]
                    },
                    'hotel_cost': {
                        'total': 1000,
                        'per_night_per_person': 100
                    },
                    'concession_fees': {
                        'total': 150,
                        'by_person_type': [{
                                'person_type': 'EA-Adult',
                                'total': 50
                            },
                            {
                                'person_type': 'Non-EA-Adult',
                                'total': 100
                            }
                        ]
                    },
                    'car_hire_cost': 400,
                    'extras_cost': 200,
                    'total_cost': 2350
                },
                {
                    'park_name': 'Masai Mara National Reserve',
                    'hotel_name': 'Keekorok Lodge',
                    'start_date': '2024-07-08',
                    'end_date': '2024-07-12',
                    'conservancy_fees': {
                        'total': 500,
                        'by_person_type': [{
                                'person_type': 'EA-Adult',
                                'total': 150
                            },
                            {
                                'person_type': 'Non-EA-Adult',
                                'total': 350
                            }
                        ]
                    },
                    'hotel_cost': {
                        'total': 900,
                        'per_night_per_person': 90
                    },
                    'concession_fees': {
                        'total': 100,
                        'by_person_type': [{
                                'person_type': 'EA-Adult',
                                'total': 30
                            },
                            {
                                'person_type': 'Non-EA-Adult',
                                'total': 70
                            }
                        ]
                    },
                    'car_hire_cost': 350,
                    'extras_cost': 150,
                    'total_cost': 2000
                }
            ],
            'flight': 500,
            'total': 4850,
            'profit': 1000,
            'discount': 0,
            'invoice_amount': 3850
        };
        console.log(data);
        const main = document.querySelector('.container');
        const parks = document.querySelector('.parks_data');
        const oneFees = document.querySelector('.one_fees');
        let total = document.querySelector('.all_total span');
        total.textContent = data.total;

        if (data && data.parks) {
            if (Array.isArray(data.parks)) {
                data.parks.forEach((park) => {
                    let div = document.createElement('div');
                    div.innerHTML = `
                <div class="details">
                    <h2>${park.park_name}</h2>
                    <p>Hotel: ${park.hotel_name}</p>
                    <p>Start Date: ${park.start_date}</p>
                    <p>End Date: ${park.end_date}</p>
                    <p class="fee-category">Conservancy Fees: ${park.conservancy_fees.total}</p>
                    <div class="person-fees conservancy">
                        <p class="fee-breakdown-title">Conservancy Fee Breakdown</p>
                    </div>
                    <p class="fee-category">Hotel Fees: ${park.hotel_cost.total}</p>
                    <p class="fee-category">Concession Fees: ${park.concession_fees.total}</p>
                    <div class="person-fees concession">
                         <p class="fee-breakdown-title">Concession Fee Breakdown</p>
                    </div>
                    <p>Car Hire Fees: ${park.car_hire_cost}</p>
                    <p>Extras Cost: ${park.extras_cost}</p>
                    <p>Total Cost: ${park.total_cost}</p>
                </div>
            `;

                    let conservancy_fees_div = div.querySelector('.person-fees.conservancy');
                    if (park.conservancy_fees.by_person_type && Array.isArray(park.conservancy_fees.by_person_type)) {
                        let conservancyBreakdownHTML = `<p class="fee-breakdown-title">Conservancy Fee Breakdown</p>`;
                        park.conservancy_fees.by_person_type.forEach((person) => {
                            conservancyBreakdownHTML += `
                                <div>${person.person_type}</div>
                                <div>${person.total}</div>
                            `;
                        });
                        conservancy_fees_div.innerHTML = conservancyBreakdownHTML;
                    }

                    let concession_fees_div = div.querySelector('.person-fees.concession');
                     if (park.concession_fees.by_person_type && Array.isArray(park.concession_fees.by_person_type)) {
                        let concessionBreakdownHTML = `<p class="fee-breakdown-title">Concession Fee Breakdown</p>`;
                        park.concession_fees.by_person_type.forEach((person) => {
                            concessionBreakdownHTML += `
                                <div>${person.person_type}</div>
                                <div>${person.total}</div>
                            `;
                        });
                        concession_fees_div.innerHTML = concessionBreakdownHTML;
                    }
                    parks.appendChild(div);
                });
            } else if (typeof data.parks === 'object' && data.parks !== null) {
                for (const key in data.parks) {
                    if (data.parks.hasOwnProperty(key) && key !== 'total_cost') {
                        const park = data.parks[key];
                        let div = document.createElement('div');
                        div.innerHTML = `
                    <div class="details">
                        <h2>${park.park_name}</h2>
                        <p>Hotel: ${park.hotel_name}</p>
                        <p>Start Date: ${park.start_date}</p>
                        <p>End Date: ${park.end_date}</p>
                        <p class="fee-category">Conservancy Fees: ${park.conservancy_fees.total}</p>
                        <div class="person-fees conservancy">
                            <p class="fee-breakdown-title">Conservancy Fee Breakdown</p>
                        </div>
                        <p class="fee-category">Hotel Fees: ${park.hotel_cost.total}</p>
                        <p class="fee-category">Concession Fees: ${park.concession_fees.total}</p>
                        <div class="person-fees concession">
                            <p class="fee-breakdown-title">Concession Fee Breakdown</p>
                        </div>
                        <p>Car Hire Fees: ${park.car_hire_cost}</p>
                        <p>Extras Cost: ${park.extras_cost}</p>
                        <p>Total Cost: ${park.total_cost}</p>
                    </div>
                `;
                    let conservancy_fees_div = div.querySelector('.person-fees.conservancy');
                    if (park.conservancy_fees.by_person_type && Array.isArray(park.conservancy_fees.by_person_type)) {
                        let conservancyBreakdownHTML = `<p class="fee-breakdown-title">Conservancy Fee Breakdown</p>`;
                        park.conservancy_fees.by_person_type.forEach((person) => {
                            conservancyBreakdownHTML += `
                                <div>${person.person_type}</div>
                                <div>${person.total}</div>
                            `;
                        });
                        conservancy_fees_div.innerHTML = conservancyBreakdownHTML;
                    }

                    let concession_fees_div = div.querySelector('.person-fees.concession');
                     if (park.concession_fees.by_person_type && Array.isArray(park.concession_fees.by_person_type)) {
                        let concessionBreakdownHTML = `<p class="fee-breakdown-title">Concession Fee Breakdown</p>`;
                        park.concession_fees.by_person_type.forEach((person) => {
                            concessionBreakdownHTML += `
                                <div>${person.person_type}</div>
                                <div>${person.total}</div>
                            `;
                        });
                        concession_fees_div.innerHTML = concessionBreakdownHTML;
                    }
                        parks.appendChild(div);
                    }
                }
            }
        }
    </script>
</body>

</html>