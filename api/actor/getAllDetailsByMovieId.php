<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../models/queries/actorRequestItem.php';

if (isset($_GET['movie_id'])) {
    $database = new DB();
    $db = $database->getConnection();

    $model = new ActorRequestItem($db);


    $stmt = $model->getAllDetailsByMovieId($_GET['movie_id']);
    $num = $stmt->rowCount();

    if ($num > 0) {

        $stmt_arr = array();
        $stmt_arr['rows'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $request_item = array(
                'actor_id' => $actor_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'movie_revenue' => number_format($movie_revenue, 2, '.', ','),
                'base_salary' => number_format($actor_base_salary, 2, '.', ','),
                'revenue_percentage' => $revenue_share,
                'revenue_share' => number_format(($movie_revenue * $revenue_share), 2, '.', ','),
                'total_earnings' => number_format(($movie_revenue * $revenue_share) + $actor_base_salary, 2, '.', ',')
            );

            array_push($stmt_arr['rows'], $request_item);
        }

        http_response_code(200);

        echo json_encode($stmt_arr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No actors found.")
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array("message" => "Must provide movie_id.")
    );
}
