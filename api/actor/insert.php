<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../models/tables/actor.php';
include_once '../../settings.php';

$database = new DB();
$db = $database->getConnection();

$model = new Actor($db);
$curl_request = new CurlRequest();

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->movie_id) &&
    !empty($data->character_name) &&
    !empty($data->base_salary) &&
    !empty($data->revenue_share)
) {
    $model->first_name = $data->first_name;
    $model->last_name = $data->last_name;

    if ($model->insert()) {
        $data_array = array(
            "movie_id" => $data->movie_id,
            "actor_id" => $db->lastInsertId(),
            "character_name" => $data->character_name,
            "base_salary" => $data->base_salary,
            "revenue_share" => $data->revenue_share
        );

        $attach_movie = $curl_request->callAPI('POST', SERVER_ROOT . '/MoviesProject/api/movieActor/insert.php', json_encode($data_array));
        $attach_movie_response = json_decode($attach_movie);

        http_response_code(201);
        echo json_encode(array("message" => "Actor was added."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to add actor."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to add actor. Data is incomplete."));
}
