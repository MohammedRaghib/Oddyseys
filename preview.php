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
            max-width: 1000px;
        }

        .breakdown {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .parkContainer {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            text-align: left;
        }

        .parkContainer h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #008080;
        }

        .parkContainer span {
            display: block;
            font-size: 0.9em;
            margin-bottom: 8px;
            color: #555;
        }

        .sub_total_people {
            margin-top: 20px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .sub_total_people .note {
            display: block;
            margin-bottom: 10px;
            font-size: 1em;
            color: #777;
        }

        .sub_total_people div {
            margin-bottom: 8px;
            font-weight: 500;
        }

        .subtotal{
            font-weight: bold;
            font-size: 30px;
        }

        .overall_total {
            display: block;
            margin-top: 20px;
            font-size: 1.1em;
            font-weight: 600;
            text-align: center;
        }

        .overall_total input[type="number"] {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            border: none;
            background: #e8e8e8;
            border-radius: 5px;
            padding: 8px 12px;
            width: auto;
            display: inline-block;
            text-align: center;
        }

        .special_fees {
            border-top: 1px solid black;
            padding: 5px;
        }

        .other_info {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .other_info input {
            background-color: rgba(244, 244, 244, 0.85);
        }
    </style>
</head>

<body>
    <main class="wrapper">
        <section class="breakdown">

        </section>

        <section class="sub_total_people">
            <span class="note">This is the total cost for each visitor type (without taxes)</span>
        </section>

        <section class="other_info">
            <span class="flight">Flight = <input type="number" name="flight" id="flight" disabled></span>
            <span class="profit">Profit = <input type="number" name="profit" id="profit" disabled></span>
            <span class="discount">Discount = <input type="number" name="discount" id="discount" disabled></span>
            <span class="invoice_amount">Invoice amount = <input type="number" name="invoice_amount" id="invoice_amount" disabled></span>
        </section>

        <span class="overall_total">TOTAL ITINERNARY COST (ALL TAXES INCLUDED) = <input type="number" name="total" id="total" disabled></span>

    </main>
    <script>
        /* JSON data format gotten from index.php
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
        const Formatted_people = {
            'ea_citizen_adult': 'EA Adult',
            'ea_citizen_child': 'EA Child',
            'ea_citizen_infant': 'EA Infant',
            'non_ea_citizen_adult': 'Non-EA Adult',
            'non_ea_citizen_child': 'Non-EA Child',
            'non_ea_citizen_infant': 'Non-EA Infant',
            'tz_resident_adult': 'TZ Adult',
            'tz_resident_child': 'TZ Child',
            'tz_resident_infant': 'TZ Infant',
        };

        const calculateSum = (obj) => Object.values(obj).reduce((sum, num) => sum + num, 0);

        let mainFragment = document.createDocumentFragment();

        Object.entries(data.parks).forEach(([key, value]) => {
            if (key !== 'total_cost') {
                let container = document.createElement('div');
                let park_name = document.createElement('h2');
                let hotel_name = document.createElement('h2');

                park_name.textContent = `${value.park_name} from ${value.start_date} to ${value.end_date}`;
                hotel_name.textContent = `${value.hotel_name}`;
                container.appendChild(park_name);
                container.appendChild(hotel_name);
                container.classList.add('parkContainer');

                let fragment = document.createDocumentFragment();

                Object.entries(value.people_breakdown).forEach(([key2, value2]) => {
                    let total_people = calculateSum(value.people_breakdown);
                    let wrapper_div = document.createElement('div');
                    let title = document.createElement('h2');
                    let conservancy_fees = document.createElement('span');
                    let hotel_cost = document.createElement('span');
                    let concession_fees = document.createElement('span');
                    let car_hire = document.createElement('span');
                    let extras_cost = document.createElement('span');

                    let subtotal = document.createElement('span');
                    subtotal.classList.add('subtotal');
                    let fees = {
                        conservancy_fees: value.conservancy_fees?.by_person_type[key2] || 0,
                        hotel_cost: value.hotel_cost?.per_night_per_person * value2 || 0,
                        concession_fees: value.concession_fees?.by_person_type[key2] || 0,
                        car_hire: (value.car_hire_cost / total_people) * value2 || 0,
                        extras_cost: (value.extras_cost / total_people) * value2 || 0
                    }

                    title.textContent = `${Formatted_people[key2]}`;
                    conservancy_fees.textContent = `Conservancy Fees: ${fees.conservancy_fees}`;
                    hotel_cost.textContent = `Hotel Cost: ${fees.hotel_cost}`;
                    concession_fees.textContent = `Concession Fees: ${fees.concession_fees}`;
                    car_hire.textContent = `Car Hire: ${fees.car_hire}`;
                    extras_cost.textContent = `Extra Fee: ${fees.extras_cost}`;
                    subtotal.textContent = `Subtotal: ${calculateSum(fees)}`;

                    wrapper_div.appendChild(title);
                    wrapper_div.appendChild(conservancy_fees);
                    wrapper_div.appendChild(hotel_cost);
                    wrapper_div.appendChild(concession_fees);
                    wrapper_div.appendChild(car_hire);
                    wrapper_div.appendChild(extras_cost);
                    wrapper_div.appendChild(subtotal);

                    fragment.appendChild(wrapper_div);
                });

                let special_fees = document.createElement('span');
                let total_conservancy_fees = document.createElement('span');
                let total_concession_fees = document.createElement('span');
                special_fees.classList.add('special_fees');
                total_conservancy_fees.classList.add('total_conservancy_fees');
                total_concession_fees.classList.add('total_concession_fees');

                total_conservancy_fees.textContent = `Total Conservancy Fees (18% Tax included) = ${value.conservancy_fees?.total}`;
                total_concession_fees.textContent = `Total Concession Fees (18% Tax included) = ${value.concession_fees?.total}`;
                special_fees.textContent = `Special Fees =  ${value.special_fees?.total > 0 ? value.special_fees?.name + ' : ' + value.special_fees?.total : 'No special fees applied' }`;

                container.appendChild(fragment);

                container.appendChild(special_fees);
                container.appendChild(total_conservancy_fees);
                container.appendChild(total_concession_fees);

                mainFragment.appendChild(container);
            }
        });

        document.querySelector('.breakdown').appendChild(mainFragment);

        if (data.total_cost_by_visitor_category) {
            Object.entries(data.total_cost_by_visitor_category).forEach(([key, value]) => {
                const div = document.createElement('div');
                div.textContent = `Cost For ${Formatted_people[key]}: ${value}`;
                document.querySelector('.sub_total_people').appendChild(div);
            });
        }

        document.querySelector('#flight').value = data.flight || 0;
        document.querySelector('#total').value = data.total || 0;
        document.querySelector('#profit').value = data.profit || 0;
        document.querySelector('#discount').value = data.discount || 0;
        document.querySelector('#invoice_amount').value = data.invoice_amount || 0;
    </script>
</body>

</html>