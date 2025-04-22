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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .wrapper {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .breakdown {
            margin-bottom: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .note {
            display: block;
            color: #777;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .breakdown div {
            background-color: #e0f7f7;
            color: #008080;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 5px;
            font-weight: bold;
        }

        .breakdown div:last-child {
            margin-bottom: 0;
        }

        .overall_total {
            display: block;
            margin-top: 25px;
            font-size: 1.1em;
            font-weight: 600;
            color: #008080;
        }

        .overall_total input[type="number"] {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            border: none;
            background: lightgray;
            border-radius: 5px;
            padding: 8px 12px;
            width: auto;
            display: inline-block;
            text-align: center;
        }
    </style>

</head>

<body>
    <main class="wrapper">
        <section class="breakdown">
            <span class="note">This is the total cost for each visitor type</span>
        </section>
        <span class="overall_total">TOTAL = <input type="number" name="total" id="total" disabled></span>
    </main>
    <script>
        /*
            parks: {
                0: {
                    park_id: 14,
                    park_name: "Serengeti National Park",
                    hotel_id: 628,
                    hotel_name: "Serengeti River Camp",
                    start_date: "2025-05-17",
                    end_date: "2025-05-18",
                    people_breakdown: {
                        non_ea_citizen_adult: 2,
                        non_ea_citizen_child: 2
                    },
                    conservancy_fees: {
                        total: 360,
                        by_person_type: {
                            non_ea_citizen_adult: 280,
                            non_ea_citizen_child: 80
                        }
                    },
                    hotel_cost: {
                        total: 200,
                        per_night_per_person: 50
                    },
                    concession_fees: {
                        total: 140,
                        by_person_type: {
                            non_ea_citizen_adult: 120,
                            non_ea_citizen_child: 20
                        }
                    },
                    special_fees: {
                        total: 200,
                        name: "",
                        per_day_per_person: 50
                    },
                    car_hire_cost: 400,
                    extras_cost: 600,
                    total_cost: 1900,
                    total_cost_by_visitor_category: {
                        non_ea_citizen_adult: 550,
                        non_ea_citizen_child: 400
                    }
                }
            },
            total_cost: 5900,
            flight: 4000,
            total: 5900,
            profit: 10,
            discount: 5,
            invoice_amount: 6165.5,
            total_cost_by_visitor_category: {
                non_ea_citizen_adult: 1550,
                non_ea_citizen_child: 1400
            }
        */
        const urlParams = new URLSearchParams(window.location.search);
        const data = JSON.parse(decodeURIComponent(urlParams.get("data")));

        console.log(data);

        if (data.total_cost_by_visitor_category) {
            Object.entries(data.total_cost_by_visitor_category).forEach(([key, value]) => {
                const div = document.createElement('div');
                div.textContent = `${key}: ${value}`;
                document.querySelector('.breakdown').appendChild(div);
            });
        }

        document.querySelector('#total').value = data.total || 0;
    </script>
</body>

</html>