<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = json_decode($_POST['data'], true);
    $people_data = $post_data['people'];
    $extras = $post_data['extras'];
    $total = 0;

    $data = array(
        'conservation' => array(
            'ea' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
            'non_ea' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
            'tz' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
        ),
        'consession' => array(
            'ea' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
            'non_ea' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
            'tz' => array(
                'adult' => array(
                    'count' => 5,
                    'per' => 20,
                    'total' => 100,
                ),
                'child' => array(
                    'count' => 3,
                    'per' => 10,
                    'total' => 30,
                ),
                'infant' => array(
                    'count' => 2,
                    'per' => 0,
                    'total' => 0,
                ),
            ),
        ),
        'hotel' => array(
            'count' => 4,
            'per' => 100,
            'total' => 400,
        ),
        'car_hire' => 50,
        'flight' => 200,
        'extras' => 75,
        'total' => 855,
    );

    echo json_encode($data);
    exit;
}
