<?php

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
        park INTEGER NOT NULL, -- Changed from hotel_id to park
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
*/

# parameters

// $start_date_str = "2025-01-01";
// $end_date_str = "2025-01-05";

$start_date_str = "2025-07-15"; // Within July-September
$end_date_str = "2025-07-20";  // Within July-September

$people = array(
    "non_ea_citizen_adult" => 2,
    "non_ea_citizen_child" => 2
);
$extras = array(
    "balooning" => 200
);
$hotel_id = 109; // Momella Wildlife Lodge ID from park_hotels table
$car_hire_per_day = 50; // Assuming a per day rate
$park_id = 14; // Serengeti Park ID from parks table


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

function get_cost_by_park($start_date_str, $end_date_str, $people, $extras, $hotel_id, $car_hire_per_day, $park_id)
{
    try {
        $pdo = new PDO("sqlite:./travel.db");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    $start = new DateTime($start_date_str);
    $end = new DateTime($end_date_str);
    $days = $start->diff($end)->days + 1;
    $nights = $days - 1;

    $total_park_cost = 0;
    $total_hotel_cost = 0;
    $total_concession_cost = 0;
    $total_car_hire_cost = $car_hire_per_day * array_sum($people) * $days;
    $total_extras_cost = array_sum($extras);
    $cost_by_person_category = array_fill_keys(array_keys($people), 0);
    $concession_cost_by_person_category = array_fill_keys(array_keys($people), 0);
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
                hcf.rate AS hcf_rate
            FROM
                park_conservation_fees pcf
            LEFT JOIN
                hotel_rates hr ON hr.hotel = :hotel_id
            LEFT JOIN
                hotel_concession_fees hcf ON hcf.park_id = :park_id AND hcf.park_id = :park_id
            WHERE
                pcf.park_id = :park_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':park_id' => $park_id, ':hotel_id' => $hotel_id]);
    $rates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    # Calculate costs per day
    $current_date = clone $start;
    for ($i = 0; $i < $days; $i++) {
        $current_month_day = $current_date->format("m-d");

        # 1. Conservancy Fees
        foreach ($rates as $rate_data) {
            if (isset($rate_data['pcf_visitor_type']) && isset($people[$rate_data['pcf_visitor_type']])) {
                if (isDateInRange(
                    (new DateTime($rate_data['pcf_start_date']))->format("m-d"),
                    (new DateTime($rate_data['pcf_end_date']))->format("m-d"),
                    $current_month_day
                )) {
                    $cost_by_person_category[$rate_data['pcf_visitor_type']] += ($rate_data['pcf_rate'] * $people[$rate_data['pcf_visitor_type']]);
                    $total_park_cost += ($rate_data['pcf_rate'] * $people[$rate_data['pcf_visitor_type']]);
                }
            }
        }
        $current_date->modify('+1 day');
    }

    # 2. Hotel Cost (per night)
    foreach ($rates as $rate_data) {
        if (isset($rate_data['hotel_rate'])) {
            if (isDateInRange(
                (new DateTime($rate_data['hr_start_date']))->format("m-d"),
                (new DateTime($rate_data['hr_end_date']))->format("m-d"),
                $start->format("m-d") // Assuming hotel rate applies from the start date
            )) {
                $hotel_cost_per_night = $rate_data['hotel_rate'] * array_sum($people);
                $total_hotel_cost = $hotel_cost_per_night * $nights;
                break; // Assuming only one matching hotel rate
            }
        }
    }

    # 3. Hotel Concession (per night)
    $current_night = clone $start;
    for ($i = 0; $i < $nights; $i++) {
        $current_month_day_night = $current_night->format("m-d");
        foreach ($rates as $rate_data) {
            if (isset($rate_data['hcf_visitor_type']) && isset($people[$rate_data['hcf_visitor_type']])) {
                if (isDateInRange(
                    (new DateTime($rate_data['hcf_start_date']))->format("m-d"),
                    (new DateTime($rate_data['hcf_end_date']))->format("m-d"),
                    $current_month_day_night
                )) {
                    $concession_cost_by_person_category[$rate_data['hcf_visitor_type']] += ($rate_data['hcf_rate'] * $people[$rate_data['hcf_visitor_type']]);
                    $total_concession_cost += ($rate_data['hcf_rate'] * $people[$rate_data['hcf_visitor_type']]);
                }
            }
        }
        $current_night->modify('+1 day');
    }

    $total_cost = $total_park_cost + $total_hotel_cost + $total_concession_cost + $total_car_hire_cost + $total_extras_cost;

    return array(
        'park_id' => $park_id,
        'hotel_id' => $hotel_id,
        'start_date' => $start_date_str,
        'end_date' => $end_date_str,
        'people_breakdown' => $people,
        'extras_breakdown' => $extras,
        'conservancy_fees' => array(
            'total' => $total_park_cost,
            'by_person_type' => $cost_by_person_category
        ),
        'hotel_cost' => array(
            'total' => $total_hotel_cost,
            'per_night_per_person' => $hotel_cost_per_night / array_sum($people)
        ),
        'concession_fees' => array(
            'total' => $total_concession_cost,
            'by_person_type' => $concession_cost_by_person_category
        ),
        'car_hire_cost' => $total_car_hire_cost,
        'extras_cost' => $total_extras_cost,
        'total_cost' => $total_cost
    );
}

# Example Usage:
$result = get_cost_by_park($start_date_str, $end_date_str, $people, $extras, $hotel_id, $car_hire_per_day, $park_id);

echo "<pre>";
print_r($result);
echo "</pre>";
