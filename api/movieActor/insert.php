<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../models/tables/movieActor.php';

$database = new DB();
$db = $database->getConnection();

$model = new MovieActor($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->movie_id) &&
    !empty($data->actor_id) &&
    !empty($data->base_salary) &&
    !empty($data->revenue_share)
) {
    $model->movie_id = $data->movie_id;
    $model->actor_id = $data->actor_id;
    $model->base_salary = number_format($data->base_salary, '2', '.', '');
    $model->revenue_share = number_format($data->revenue_share / 100, 2, '.', '');

    if ($model->insert()) {
        http_response_code(201);
        echo json_encode(array("message" => "Movie was attached."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to attach movie."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to attach actor. Data is incomplete."));
}