<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = json_decode($_POST['data'], true);
    $people_data = $post_data['people'];
    $extras = $post_data['extras'];
    $total = 0;


    $data = array(
        'people' => $people_data,
        'extras' => $extras,
        'total' => $total,
    );

    echo json_encode($data);
    exit;
}