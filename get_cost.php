<?php

//COSTING LOGIC: 
//=============
//
// Parameters:
// 1. PF : Park conservation fees - changes according to type of person (citizen or not) and age. Calculated per day per person.
// 2. HC : Hotel concession fees - changes according to type of person (citizen or not) and age. Calculated per day per person.
// 3. AC : Accommodation - i.e hotel charges. Calculated per day for the whole group.
// 4. CH : Car hire - changes by season. Calculated per day per person.
// 5. DU : Duration - number of days (end date minus start date)
// 6. EX : Extras - one blanket amount applicable over all pax and days
// 7. FL : Flights - one blanket amount applicable over all pax and days
// 8. TX : Tax - 18% and applied on PF and HC
//
// total_cost = (((PF*1.18)+(HC*1.18)+CH)*DU) + AC + EX + FL
// For each person data, get its rate based on lookup from db, multiply by tax rate...and then add for each person

function add_visitor_park_fees($visitor_type, $visitor_type_db, $initial_amount, $parks_data, $day) {
       
        global $total_park_conservation_fees;
        global $begin;
        global $end;
        if ($visitor_type>0)
        {            
            #loop thru array
            foreach($parks_data as $row) {
                $row_start_date = new DateTime($row['start_date']);
                $start_year = $begin->format('Y');
                $current_month = $begin->format('m');
                $start_month = $row_start_date->format('m');
                $start_day = $row_start_date->format('d');
                $row_end_date = new DateTime($row['end_date']);
                $end_year = $end->format('Y');
                $end_month = $row_end_date->format('m');
                $end_day = $row_end_date->format('d');
                $mode = "";    
                if ($start_month > $end_month){
                    $mode = "PEAK";
                    if ($current_month>=$start_month){                     
                        $end_year = $end_year + 1;                     
                    }
                    else{
                        $start_year = $start_year - 1;
                    }
                    $start_date = new DateTime($start_year."-".$start_month."-".$start_day);
                    $end_date = new DateTime($end_year."-".$end_month."-".$end_day);
                }
                else{
                     $mode = "OFF-PEAK";
                     $start_date = new DateTime($start_year."-".$start_month."-".$start_day);
                     $end_date = new DateTime($end_year."-".$end_month."-".$end_day);
                }
                if (($row['visitor_type']==$visitor_type_db) && ($day>=$start_date) && ($day<=$end_date))
                {
                    //echo $mode;
                    $rate = $row['rate'];
                    $total_park_conservation_fees = $total_park_conservation_fees + ($rate * $visitor_type); 
                    $initial_amount = $initial_amount + ($rate * $visitor_type);
                }
            }    
        }
        return $initial_amount;
}

function add_visitor_concession_fees($visitor_type, $visitor_type_db, $initial_amount, $parks_data, $day) {
        global $total_hotel_concession_fees;
        global $begin;
        global $end;
        if ($visitor_type>0)
        {            
            #loop thru array
            foreach($parks_data as $row) {
                $row_start_date = new DateTime($row['start_date']);
                $start_year = $begin->format('Y');
                $current_month = $begin->format('m');
                $start_month = $row_start_date->format('m');
                $start_day = $row_start_date->format('d');
                $row_end_date = new DateTime($row['end_date']);
                $end_year = $end->format('Y');
                $end_month = $row_end_date->format('m');
                $end_day = $row_end_date->format('d');
                $mode = "";    
                if ($start_month > $end_month){
                    $mode = "PEAK";
                    if ($current_month>=$start_month){                     
                        $end_year = $end_year + 1;                     
                    }
                    else{
                        $start_year = $start_year - 1;
                    }
                    $start_date = new DateTime($start_year."-".$start_month."-".$start_day);
                    $end_date = new DateTime($end_year."-".$end_month."-".$end_day);
                }
                else{
                     $mode = "OFF-PEAK";
                     $start_date = new DateTime($start_year."-".$start_month."-".$start_day);
                     $end_date = new DateTime($end_year."-".$end_month."-".$end_day);
                }
                if (($row['visitor_type']==$visitor_type_db) && ($day>=$start_date) && ($day<=$end_date))
                {
                    echo "AAJEJAAJE";
                    $rate = $row['rate'];
                    $total_hotel_concession_fees = $total_hotel_concession_fees + ($rate * $visitor_type); 
                    $initial_amount = $initial_amount + ($rate * $visitor_type);
                }
            }    
        }
        return $initial_amount;
}

function safe_divide($numerator, $denominator){
    if ($denominator==0){
       return 0; 
    }
    return $numerator/$denominator;
}

$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con=mysqli_connect("localhost","angeligh_huss","husszain$2024","angeligh_new");
    $post_data = json_decode($_POST['data'], true);
    //PF    
    $people_data = $post_data['people'];
    $park_name = $post_data['park_name'];
    $EA_Adult = $people_data['EA_Adult'];
    $EA_Child = $people_data['EA_Child'];
    $EA_Infant = $people_data['EA_Infant'];
    $Non_EA_Adult = $people_data['Non_EA_Adult'];
    $Non_EA_Child = $people_data['Non_EA_Child'];
    $Non_EA_Infant = $people_data['Non_EA_Infant'];
    $TZ_Adult = $people_data['TZ_Adult'];
    $TZ_Child = $people_data['TZ_Child'];
    $TZ_Infant = $people_data['TZ_Infant'];
    $begin = new DateTime($post_data['date_range']['start_date']);
    $end = new DateTime($post_data['date_range']['end_date']);


    $EA_Adult_total_cost_parks = 0;
    $EA_Child_total_cost_parks = 0;
    $EA_Infant_total_cost_parks = 0;
    $Non_EA_Adult_total_cost_parks = 0;
    $Non_EA_Child_total_cost_parks = 0;
    $Non_EA_Infant_total_cost_parks = 0;
    $TZ_Adult_total_cost_parks = 0;
    $TZ_Child_total_cost_parks = 0;
    $TZ_Infant_total_cost_parks = 0;
    $EA_Adult_total_cost_concession = 0;
    $EA_Child_total_cost_concession = 0;
    $EA_Infant_total_cost_concession = 0;
    $Non_EA_Adult_total_cost_concession = 0;
    $Non_EA_Child_total_cost_concession = 0;
    $Non_EA_Infan_total_cost_concession = 0;
    $TZ_Adult_total_cost_concession = 0;
    $TZ_Child_total_cost_concession = 0;
    $TZ_Infant_total_cost_concession = 0;

    $get_parks_query = "SELECT * FROM park_conservation_fees WHERE name='".$park_name."'";
    $parks_data = [];
    if ($result = mysqli_query($con,$get_parks_query)) {
        while ($row = $result->fetch_assoc()) {
            array_push($parks_data, $row);
        }
    }
    #echo '<pre>';
    #print_r($parks_data);
    #echo '</pre>'; 
    #$begin = new DateTime( "2015-07-03" );
    #$end = new DateTime( "2015-07-09" );
    $total_park_conservation_fees = 0;
    $number_of_days = 0;    
    for($i = $begin; $i <= $end; $i->modify('+1 day')){  
        $number_of_days = $number_of_days + 1;      
        #check parks data
        $EA_Adult_total_cost_parks = add_visitor_park_fees($EA_Adult, 'ea_citizen_adult', $EA_Adult_total_cost_parks, $parks_data, $i);
        $EA_Child_total_cost_parks = add_visitor_park_fees($EA_Child, 'ea_citizen_child', $EA_Child_total_cost_parks, $parks_data, $i);
        $EA_Infant_total_cost_parks = add_visitor_park_fees($EA_Infant, 'ea_citizen_infant', $EA_Infant_total_cost_parks, $parks_data, $i);
        $Non_EA_Adult_total_cost_parks = add_visitor_park_fees($Non_EA_Adult, 'non_ea_citizen_adult', $Non_EA_Adult_total_cost_parks, $parks_data, $i);
        $Non_EA_Child_total_cost_parks = add_visitor_park_fees($Non_EA_Child, 'non_ea_citizen_child', $Non_EA_Child_total_cost_parks, $parks_data, $i);
        $Non_EA_Infant_total_cost_parks = add_visitor_park_fees($Non_EA_Infant, 'non_ea_citizen_infant', $Non_EA_Infant_total_cost_parks, $parks_data, $i);
        $TZ_Adult_total_cost_parks = add_visitor_park_fees($TZ_Adult, 'tz_resident_adult', $TZ_Adult_total_cost_parks, $parks_data, $i);
        $TZ_Child_total_cost_parks = add_visitor_park_fees($TZ_Child, 'tz_resident_child', $TZ_Child_total_cost_parks, $parks_data, $i);
        $TZ_Infant_total_cost_parks = add_visitor_park_fees($TZ_Infant, 'tz_resident_infant', $TZ_Infant_total_cost_parks, $parks_data, $i);
    }
    // hotel concession fees
    $get_parks_query = "SELECT * FROM park_hotel_concession_fees WHERE name='".$park_name."'";
    #echo $get_parks_query;
    $parks_data = [];
    if ($result = mysqli_query($con,$get_parks_query)) {
        while ($row = $result->fetch_assoc()) {
            array_push($parks_data, $row);
        }
    }
    #echo '<pre>';
    #print_r($parks_data);
    #echo '</pre>';
    $total_hotel_concession_fees = 0;
    $begin = new DateTime($post_data['date_range']['start_date']);
    $end = new DateTime($post_data['date_range']['end_date']);
    for($j = $begin; $j <= $end; $j->modify('+1 day')){  
        $EA_Adult_total_cost_concession = add_visitor_concession_fees($EA_Adult, 'ea_citizen_adult', $EA_Adult_total_cost_concession, $parks_data, $j);
        $EA_Child_total_cost_concession = add_visitor_concession_fees($EA_Child, 'ea_citizen_child', $EA_Child_total_cost_concession, $parks_data, $j);
        $EA_Infant_total_cost_concession = add_visitor_concession_fees($EA_Infant, 'ea_citizen_infant', $EA_Infant_total_cost_concession, $parks_data, $j);
        $Non_EA_Adult_total_cost_concession = add_visitor_concession_fees($Non_EA_Adult, 'non_ea_citizen_adult', $Non_EA_Adult_total_cost_concession, $parks_data, $j);
        $Non_EA_Child_total_cost_concession = add_visitor_concession_fees($Non_EA_Child, 'non_ea_citizen_child', $Non_EA_Child_total_cost_concession, $parks_data, $j);
        $Non_EA_Infan_total_cost_concession = add_visitor_concession_fees($Non_EA_Infant, 'non_ea_citizen_infant', $Non_EA_Infan_total_cost_concession, $parks_data, $j);
        $TZ_Adult_total_cost_concession = add_visitor_concession_fees($TZ_Adult, 'tz_resident_adult', $TZ_Adult_total_cost_concession, $parks_data, $j);
        $TZ_Child_total_cost_concession = add_visitor_concession_fees($TZ_Child, 'tz_resident_child', $TZ_Child_total_cost_concession, $parks_data, $j);
        $TZ_Infant_total_cost_concession = add_visitor_concession_fees($TZ_Infant, 'tz_resident_infant', $TZ_Infant_total_cost_concession, $parks_data, $j);
    }


    //Add tax of 0.18 to park fees
    $total_park_conservation_fees = $total_park_conservation_fees * 1.18;
    //Add tax of 0.18 to hotel concession fees
    $total_hotel_concession_fees = $total_hotel_concession_fees * 1.18;

    $car_hire_per_day = $post_data['car_hire_cost_per_day'];
    $car_hire = $car_hire_per_day * $number_of_days;    

    $hotel_cost_per_day = $post_data['hotel_cost_per_day'];
    $hotel_cost = $hotel_cost_per_day * $number_of_days;


    $flight = $post_data['flight'];
    $extras = $post_data['extras'];
    //COSTING LOGIC: 
//=============
//
// Parameters:
// 1. PF : Park conservation fees - changes according to type of person (citizen or not) and age. Calculated per day per person.
// 2. HC : Hotel concession fees - changes according to type of person (citizen or not) and age. Calculated per day per person.
// 3. AC : Accommodation - i.e hotel charges. Calculated per day for the whole group.
// 4. CH : Car hire - changes by season. Calculated per day per person.
// 5. DU : Duration - number of days (end date minus start date)
// 6. EX : Extras - one blanket amount applicable over all pax and days
// 7. FL : Flights - one blanket amount applicable over all pax and days
// 8. TX : Tax - 18% and applied on PF and HC
//
// total_cost = (((PF*1.18)+(HC*1.18)+CH)*DU) + AC + EX + FL
// For each person data, get its rate based on lookup from db, multiply by tax rate...and then add for each person

$total = $total_park_conservation_fees + $total_hotel_concession_fees + $car_hire + $hotel_cost + $flight + $extras;

#$ddf = x_divide($total_park_conservation_fees, $total_hotel_concession_fees);

$data = array(
    'conservation' => array(
            'ea' => array(
                'adult' => array(
                    'count' => $EA_Adult,
                    'per' => safe_divide($EA_Adult_total_cost_parks,$EA_Adult),
                    'total' => $EA_Adult_total_cost_parks,
                ),
                'child' => array(
                    'count' => $EA_Child,
                    'per' => safe_divide($EA_Child_total_cost_parks,$EA_Child),
                    'total' => $EA_Child_total_cost_parks,
                ),
                'infant' => array(
                    'count' => $EA_Infant,
                    'per' => safe_divide($EA_Infant_total_cost_parks,$EA_Infant),
                    'total' => $EA_Infant_total_cost_parks,
                ),
            ),
            'non_ea' => array(
                'adult' => array(
                    'count' => $Non_EA_Adult,
                    'per' => safe_divide($Non_EA_Adult_total_cost_parks,$Non_EA_Adult),
                    'total' => $Non_EA_Adult_total_cost_parks,
                ),
                'child' => array(
                    'count' => $Non_EA_Child,
                    'per' => safe_divide($Non_EA_Child_total_cost_parks,$Non_EA_Child),
                    'total' => $Non_EA_Child_total_cost_parks,
                ),
                'infant' => array(
                    'count' => $Non_EA_Infant,
                    'per' => safe_divide($Non_EA_Infant_total_cost_parks,$Non_EA_Infant),
                    'total' => $Non_EA_Infant_total_cost_parks,
                ),
            ),
            'tz' => array(
                'adult' => array(
                    'count' => $TZ_Adult,
                    'per' => safe_divide($TZ_Adult_total_cost_parks,$TZ_Adult),
                    'total' => $TZ_Adult_total_cost_parks,
                ),
                'child' => array(
                    'count' => $TZ_Child,
                    'per' => safe_divide($TZ_Child_total_cost_parks,$TZ_Child),
                    'total' => $TZ_Child_total_cost_parks,
                ),
                'infant' => array(
                    'count' => $TZ_Infant,
                    'per' => safe_divide($TZ_Infant_total_cost_parks,$TZ_Infant),
                    'total' => $TZ_Infant_total_cost_parks,
                ),
            ))
        ,
        'consession' => array(
            'ea' => array(
                'adult' => array(
                    'count' => $EA_Adult,
                    'per' => safe_divide($EA_Adult_total_cost_concession,$EA_Adult),
                    'total' => $EA_Adult_total_cost_concession,
                ),
                'child' => array(
                    'count' => $EA_Child,
                    'per' => safe_divide($EA_Child_total_cost_concession,$EA_Child),
                    'total' => $EA_Child_total_cost_concession,
                ),
                'infant' => array(
                    'count' => $EA_Infant,
                    'per' => safe_divide($EA_Infant_total_cost_concession,$EA_Infant),
                    'total' => $EA_Infant_total_cost_concession,
                ),
            ),
            'non_ea' => array(
                'adult' => array(
                    'count' => $Non_EA_Adult,
                    'per' => safe_divide($Non_EA_Adult_total_cost_concession,$Non_EA_Adult),
                    'total' => $Non_EA_Adult_total_cost_concession,
                ),
                'child' => array(
                    'count' => $Non_EA_Child,
                    'per' => safe_divide($Non_EA_Child_total_cost_concession,$Non_EA_Child),
                    'total' => $Non_EA_Child_total_cost_concession,
                ),
                'infant' => array(
                    'count' => $Non_EA_Infant,
                    'per' => safe_divide($Non_EA_Infan_total_cost_concession,$Non_EA_Infant),
                    'total' => $Non_EA_Infan_total_cost_concession,
                ),
            ),
            'tz' => array(
                'adult' => array(
                    'count' => $TZ_Adult,
                    'per' => safe_divide($TZ_Adult_total_cost_concession,$TZ_Adult),
                    'total' => $TZ_Adult_total_cost_concession,
                ),
                'child' => array(
                    'count' => $TZ_Child,
                    'per' => safe_divide($TZ_Child_total_cost_concession,$TZ_Child),
                    'total' => $TZ_Child_total_cost_concession,
                ),
                'infant' => array(
                    'count' => $TZ_Infant,
                    'per' => safe_divide($TZ_Infant_total_cost_concession,$TZ_Infant),
                    'total' => $TZ_Infant_total_cost_concession,
                ),
            ),
        ),
        'hotel' => array(
            'count' => $EA_Adult+$EA_Child+$EA_Infant+$Non_EA_Adult+$Non_EA_Child+$Non_EA_Infant+$TZ_Adult+$TZ_Child+$TZ_Infant,
            'per' => $hotel_cost_per_day,
            'total' => $hotel_cost,
        ),
        'car_hire' => $car_hire,
        'flight' => $flight,
        'extras' => $extras,
        'total' => $total,
    );   


    echo json_encode($data);
    //exit;
}