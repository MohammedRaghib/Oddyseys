<?php
/* Fees:
    1. Park fee - varies with visitor type and date
    2. Concession fee - varies visitor type and date. Is also per night
    3. Hotel fee - varies with date. Is also per night
    4. Car hire - days * rate
    5. Special fees - check for each park if there is one and add
    6. Extras - right now it is one amount just need to add to total, may need to be changed
    7. Flight - one amount just need to add to total
*/
/* All fees to check or calculate for each park:
    Ea adult - park fee
    Ea child - park fee
    Ea infant - park fee
    Non ea adult - park fee
    Non ea child - park fee
    Non ea infant - park fee
    TZ adult - park fee
    TZ child - park fee
    TZ infant - park fee
    Ea adult - concession fee
    Ea child - concession fee
    Ea infant - concession fee
    Non ea adult - concession fee
    Non ea child - concession fee
    Non ea infant - concession fee
    TZ adult - concession fee
    TZ child - concession fee
    TZ infant - concession fee
    total people * hotel fee
    total days * car hire
    special fees (if any)
*/
/* Tables (In sqlite format): 
    CREATE TABLE parks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        country TEXT CHECK(country IN ('kenya', 'tanzania')) NOT NULL
    );

    CREATE TABLE park_conservation_fees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        park_id INTEGER NOT NULL,
        visitor_type TEXT NOT NULL,
        start_date TEXT NOT NULL,
        end_date TEXT NOT NULL,
        currency TEXT CHECK(currency IN ('USD', 'KES', 'TZS')) NOT NULL,
        rate REAL NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );

    CREATE TABLE hotel_concession_fees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        park_id INTEGER NOT NULL,
        visitor_type TEXT NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        currency TEXT NOT NULL CHECK(currency IN ('USD', 'KES', 'TZS')),
        rate REAL NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );

    CREATE TABLE park_hotels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hotel TEXT NOT NULL,
        park_id INTEGER NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );

    CREATE TABLE hotel_rates (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hotel INTEGER NOT NULL,
        start_date TEXT NOT NULL,
        end_date TEXT NOT NULL,
        rate REAL NOT NULL,
        FOREIGN KEY (hotel) REFERENCES park_hotels(id) ON DELETE CASCADE
    );

    CREATE TABLE park_special_fees (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        park_id INTEGER NOT NULL,
        fees_name TEXT NOT NULL,
        rate REAL NOT NULL,
        FOREIGN KEY (park_id) REFERENCES parks(id) ON DELETE CASCADE
    );
*/
/* Posting data to server in the format: {
    people: [
        {
            EA-Adult: number,
            EA-Child: number,
            EA-Infant: number,
            Non-EA-Adult: number,
            Non-EA-Child: number,
            Non-EA-Infant: number,
            TZ-Adult: number,
            TZ-Child: number,
            TZ-Infant: number,
        }
    ],
    flight: number,
    total: number,
    profit: number,
    discount: number,
    invoice_amount: number,
    parks: [
        {
            park: number,
            start_date: string,
            end_date: string,
            hotel: number,
            hotel_rate: number,
            days: number,
            car_hire: number,
            extras: number,
        }
    ]
} */

$dbPath = './travel.db';

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $host = 'localhost';
// $dbName = 'angeligh_new'; 
// $user = 'angeligh_huss'; 
// $pass = 'husszain$2024';

// $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $user, $pass);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$people = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $data = json_decode(file_get_contents('php://input'), true);

    $people = $data['people'];
    $flight = $data['flight'];
    $profit = $data['profit'];
    $discount = $data['discount'];
    $parks = $data['parks'];


    $total_cost_by_visitor_category = array_fill_keys(array_keys($people), 0);

    $output = [];
    foreach ($parks as $park) {
        $output[] = get_cost_by_park($park['start_date'], $park['end_date'], $people, $park['extras'], $park['hotel'], $park['car_hire'], $park['park'], $park['hotel_name'], $park['park_name']);
    }

    $everything_total = 0;
    $people_count = array_sum($people);

    foreach ($total_cost_by_visitor_category as $key => $value) {
        $total_cost_by_visitor_category[$key] += $flight;
    }
    $flight = $flight * $people_count;
    $everything_total += $flight;

    foreach ($output as $item) {
        $everything_total += $item['total_cost'];
    }

    $output['total_cost'] = $everything_total;
    $invoice_amount = $everything_total * (1 + ($profit / 100));
    $invoice_amount = (1 - ($discount / 100)) * $invoice_amount;

    $final_output = [
        'parks' => $output,
        'flight' => $flight,
        'total' => $output['total_cost'],
        'profit' => $profit,
        'discount' => $discount,
        'invoice_amount' => $invoice_amount,
        'total_cost_by_visitor_category' => $total_cost_by_visitor_category,
    ];

    // Redirect to the preview page
    echo json_encode($final_output);
}

/**
 * Checks if a given date is within a range of two dates.
 *
 * This function assumes that the given dates are in the format "mm-dd".
 * It also assumes that the given dates are in the same year, so it
 * "normalizes" the dates by prepending "2000-" to the given dates.
 *
 * If the start date is after the end date, it means that the range
 * crosses the year end, so the function returns true if the check
 * date is either after the start date or before the end date.
 *
 * Otherwise, the function returns true if the check date is within
 * the start and end dates (inclusive).
 *
 * @param string $start_md Start date in the format "mm-dd"
 * @param string $end_md End date in the format "mm-dd"
 * @param string $check_md Date to check in the format "mm-dd"
 * @return bool True if the check date is within the given range, false otherwise
 */
function isDateInRange($start_md, $end_md, $check_md)
{
    $year = "2000";
    $startDate = DateTime::createFromFormat('Y-m-d', "$year-$start_md");
    $endDate = DateTime::createFromFormat('Y-m-d', "$year-$end_md");
    $checkDate = DateTime::createFromFormat('Y-m-d', "$year-$check_md");

    if ($endDate < $startDate) {
        return ($checkDate >= $startDate || $checkDate <= $endDate);
    } else {
        return ($checkDate >= $startDate && $checkDate <= $endDate);
    }
}

/**
 * Calculate the total cost of a trip to a park including park fees, hotel costs, 
 * concession fees, car hire, and extras based on the given parameters.
 *
 * @param string $start_date_str Start date of the trip in 'Y-m-d' format.
 * @param string $end_date_str End date of the trip in 'Y-m-d' format.
 * @param array $people Associative array of people categories and counts (e.g., ['adult' => 2, 'child' => 3]).
 * @param float $extras Associative array of extra costs (e.g., ['balooning' => 200]).
 * @param int $hotel_id ID of the hotel for fetching hotel rates.
 * @param float $car_hire_per_day Cost of car hire per day.
 * @param int $park_id ID of the park for fetching park and concession fees.
 *
 * @return array Associative array containing detailed breakdown of costs:
 *               - 'park_id': ID of the park
 *               - 'hotel_id': ID of the hotel
 *               - 'start_date': Start date of the trip
 *               - 'end_date': End date of the trip
 *               - 'people_breakdown': Breakdown of people by category
 *               - 'extras_breakdown': Breakdown of extra costs
 *               - 'conservancy_fees': Total and per person type park fees
 *               - 'hotel_cost': Total and per person per night hotel fees
 *               - 'concession_fees': Total and per person type concession fees
 *               - 'car_hire_cost': Total car hire cost
 *               - 'extras_cost': Total extra costs
 *               - 'total_cost': Total cost of the trip
 */
function get_cost_by_park($start_date_str, $end_date_str, $people, $extras, $hotel_id, $car_hire_per_day, $park_id, $hotel_name, $park_name)
{
    global $pdo;

    $start = new DateTime($start_date_str);
    $end = new DateTime($end_date_str);
    $days = $start->diff($end)->days + 1;
    $nights = $days - 1;

    $total_park_cost = 0;
    $total_hotel_cost = 0;
    $total_concession_cost = 0;
    $total_specialfees_cost = 0;
    $total_car_hire_cost = 0;
    $total_extras_cost = 0;
    $cost_by_person_category = array_fill_keys(array_keys($people), 0);
    $concession_cost_by_person_category = array_fill_keys(array_keys($people), 0);
    global $total_cost_by_visitor_category;

    $hotel_cost_per_night = 0;

    # Fetch rates from the database
    $sql = "SELECT
                pcf.visitor_type AS pcf_visitor_type,
                pcf.start_date AS pcf_start_date,
                pcf.end_date AS pcf_end_date,
                pcf.rate AS pcf_rate,
                hr.rate AS hotel_rate,
                hr.start_date AS hr_start_date,
                hr.end_date AS hr_end_date,
                hcf.visitor_type AS hcf_visitor_type,
                hcf.start_date AS hcf_start_date,
                hcf.end_date AS hcf_end_date,
                hcf.rate AS hcf_rate,
                psf.fees_name AS special_fees_name,
                psf.rate AS special_fees_rate
            FROM
                park_conservation_fees pcf
            LEFT JOIN
                hotel_rates hr ON hr.hotel = :hotel_id
            LEFT JOIN
                hotel_concession_fees hcf ON hcf.park_id = :park_id AND hcf.visitor_type = pcf.visitor_type
            LEFT JOIN
                park_special_fees psf ON psf.park_id = :park_id
            WHERE
                pcf.park_id = :park_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':park_id' => $park_id, ':hotel_id' => $hotel_id]);
    $rates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $elsesql = "SELECT
                    hcf.visitor_type AS hcf_visitor_type,
                    hcf.start_date AS hcf_start_date,
                    hcf.end_date AS hcf_end_date,
                    hcf.rate AS hcf_rate
                FROM
                    hotel_concession_fees hcf 
                WHERE
                    hcf.park_id = :park_id";

    $elsestmt = $pdo->prepare($elsesql);
    $elsestmt->execute([':park_id' => 109]);
    $elserates = $elsestmt->fetchAll(PDO::FETCH_ASSOC);


    $special_fees_name = '';
    $special_fees_rate = 0;

    # Calculate costs per day
    $current_date = clone $start;

    #print_r($rates);
    for ($i = 0; $i < $days; $i++) {
        $current_month_day = $current_date->format("m-d");
        # 1. Conservancy Fees
        $pcf_values = array();
        foreach ($rates as $rate_data) {
            if (isset($rate_data['pcf_visitor_type']) && isset($people[$rate_data['pcf_visitor_type']]) && !isset($pcf_values[$rate_data['pcf_visitor_type']])) {
                if (isDateInRange(
                    (new DateTime($rate_data['pcf_start_date']))->format("m-d"),
                    (new DateTime($rate_data['pcf_end_date']))->format("m-d"),
                    $current_month_day
                )) {
                    $pcf_values[$rate_data['pcf_visitor_type']] = 'yes';
                    #echo $rate_data['pcf_visitor_type'];
                    #echo $total_cost_by_visitor_category[$rate_data['pcf_visitor_type']];
                    $cost_by_person_category[$rate_data['pcf_visitor_type']] += ($rate_data['pcf_rate'] * $people[$rate_data['pcf_visitor_type']]);
                    $total_park_cost += ($rate_data['pcf_rate'] * $people[$rate_data['pcf_visitor_type']]);
                    $total_cost_by_visitor_category[$rate_data['pcf_visitor_type']] += $rate_data['pcf_rate'];
                    #echo $total_cost_by_visitor_category[$rate_data['pcf_visitor_type']];
                }
            }
        }
        $current_date->modify('+1 day');
    }
    #print_r($total_cost_by_visitor_category);

    # 2. Hotel Cost (per night)
    $hc_values = array();
    foreach ($rates as $rate_data) {
        if (isset($rate_data['hotel_rate'])) {
            if (isDateInRange(
                (new DateTime($rate_data['hr_start_date']))->format("m-d"),
                (new DateTime($rate_data['hr_end_date']))->format("m-d"),
                $start->format("m-d") // Assuming hotel rate applies from the start date
            )) {
                $hotel_cost_per_night = $rate_data['hotel_rate'] * array_sum($people);
                $total_hotel_cost = $hotel_cost_per_night * $nights;
                foreach ($total_cost_by_visitor_category as $key => $value) {
                    if (!isset($hc_values[$key])) {
                        $hc_values[$key] = "yes";
                        $total_cost_by_visitor_category[$key] += $rate_data['hotel_rate'] * $nights;
                    }
                }
                break; // Assuming only one matching hotel rate
            }
        }
    }

    #print_r($total_cost_by_visitor_category);

    # 3. Hotel Concession (per night)
    $current_night = clone $start;
    // $valid_hcf_values = array();
    for ($i = 0; $i < $nights; $i++) {
        $current_date = $current_night->format("m-d");
        $processed_types = array();

        foreach ($rates as $rate) {
            $type = $rate['hcf_visitor_type'];
            if (
                isset($rate['hcf_rate']) && $rate['hcf_rate'] > 0 &&
                isset($people[$type]) &&
                !isset($processed_types[$type]) &&
                isDateInRange(
                    date("m-d", strtotime($rate['hcf_start_date'])),
                    date("m-d", strtotime($rate['hcf_end_date'])),
                    $current_date
                )
            ) {
                $cost = $rate['hcf_rate'] * $people[$type];

                if (!isset($concession_cost_by_person_category[$type])) {
                    $concession_cost_by_person_category[$type] = 0;
                }
                if (!isset($total_cost_by_visitor_category[$type])) {
                    $total_cost_by_visitor_category[$type] = 0;
                }

                $concession_cost_by_person_category[$type] += $cost;
                $total_cost_by_visitor_category[$type] += $rate['hcf_rate'];
                $total_concession_cost += $cost;

                $processed_types[$type] = true;
            }
        }

        // fallback loop: only for visitor types not already processed
        foreach ($elserates as $rate) {
            $type = $rate['hcf_visitor_type'];
            if (
                isset($people[$type]) &&
                !isset($processed_types[$type]) &&
                isDateInRange(
                    date("m-d", strtotime($rate['hcf_start_date'])),
                    date("m-d", strtotime($rate['hcf_end_date'])),
                    $current_date
                )
            ) {
                $cost = $rate['hcf_rate'] * $people[$type];

                if (!isset($concession_cost_by_person_category[$type])) {
                    $concession_cost_by_person_category[$type] = 0;
                }
                if (!isset($total_cost_by_visitor_category[$type])) {
                    $total_cost_by_visitor_category[$type] = 0;
                }

                $concession_cost_by_person_category[$type] += $cost;
                $total_cost_by_visitor_category[$type] += $rate['hcf_rate'];
                $total_concession_cost += $cost;
            }
        }

        $current_night->modify('+1 day');
    }


    #print_r($total_cost_by_visitor_category);


    # 4. Park special fees (per day)



    for ($i = 0; $i < $days; $i++) {
        $special_values = array();
        if (isset($rate_data['special_fees_name'])) {
            $total_specialfees_cost += ($rate_data['special_fees_rate'] * array_sum($people));
            foreach ($total_cost_by_visitor_category as $key => $value) {
                if (!isset($special_values[$key])) {
                    $special_values[$key] = 'yes';
                    $total_cost_by_visitor_category[$key] += $rate_data['special_fees_rate'];
                }
            }
        }
    }

    #print_r($total_cost_by_visitor_category);

    #echo "Extras : ";

    # 5. Extras 
    if (isset($extras)) {
        $total_extras_cost += ($extras * array_sum($people));
        foreach ($total_cost_by_visitor_category as $key => $value) {
            $total_cost_by_visitor_category[$key] += $extras;
        }
    }

    #print_r($total_cost_by_visitor_category);

    # 6. Car Hire
    for ($i = 0; $i < $days; $i++) {
        if (isset($car_hire_per_day)) {
            $total_car_hire_cost += ($car_hire_per_day * array_sum($people));
            foreach ($total_cost_by_visitor_category as $key => $value) {
                $total_cost_by_visitor_category[$key] += $car_hire_per_day;
            }
        }
    }

    #print_r($total_cost_by_visitor_category);

    $total_cost = ($total_park_cost * 1.18) + $total_hotel_cost + ($total_concession_cost * 1.18) + $total_car_hire_cost + $total_extras_cost + $total_specialfees_cost;
    $total_people = array_sum($people);
    if ($total_people <= 0) {
        $total_people = 1;
    }

    $itinerary_cost = array(
        'park_id' => $park_id,
        'park_name' => $park_name,
        'hotel_id' => $hotel_id,
        'hotel_name' => $hotel_name,
        'start_date' => $start_date_str,
        'end_date' => $end_date_str,
        'people_breakdown' => $people,
        'conservancy_fees' => array(
            'total' => $total_park_cost * 1.18,
            'by_person_type' => $cost_by_person_category
        ),
        'hotel_cost' => array(
            'total' => $total_hotel_cost,
            'per_night_per_person' => $hotel_cost_per_night / $total_people,
        ),
        'concession_fees' => array(
            'total' => $total_concession_cost * 1.18,
            'by_person_type' => $concession_cost_by_person_category
        ),
        'special_fees' => array(
            'total' => $total_specialfees_cost,
            'name' => $special_fees_name,
            'per_day_per_person' => $total_specialfees_cost / $total_people,
        ),
        // 'used_hcf_rates' => $valid_hcf_values,
        'car_hire_cost' => $total_car_hire_cost,
        'extras_cost' => $total_extras_cost,
        'total_cost' => $total_cost,
        'total_cost_by_visitor_category' => $total_cost_by_visitor_category,
    );

    return $itinerary_cost;
}
