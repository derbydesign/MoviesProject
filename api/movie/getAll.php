<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../models/tables/movie.php';

$database = new DB();
$db = $database->getConnection();

$model = new Movie($db);


$stmt = $model->getAll();
$num = $stmt->rowCount();

if ($num > 0) {

    $stmt_arr = array();
    $stmt_arr['rows'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $request_item = array(
            'id' => $id,
            'title' => $title,
            'pc_id' => $pc_id,
            'revenue' => number_format($revenue, 2, '.', ',')
        );

        array_push($stmt_arr['rows'], $request_item);
    }

    http_response_code(200);

    echo json_encode($stmt_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No movies found.")
    );
}
