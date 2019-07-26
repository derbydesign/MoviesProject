<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../models/queries/movieRequestItem.php';
include_once '../../settings.php';

if (isset($_GET['pc_id'])) {
    $database = new DB();
    $db = $database->getConnection();

    $model = new MovieRequestItem($db);
    $curl_request = new CurlRequest();

    $stmt = $model->getAllDetailsByPcId($_GET['pc_id']);
    $num = $stmt->rowCount();

    if ($num > 0) {

        $stmt_arr = array();
        $stmt_arr['rows'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $total_expenses = 0;

            $get_actors = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/actor/getAllDetailsByMovieId.php?movie_id=' . $movie_id, false);
            $get_actors_response = json_decode($get_actors);

            foreach ($get_actors_response->rows as $actor) {
                $base_salary = (float) str_replace(',', '', $actor->base_salary);
                $revenue_share = $movie_revenue * $actor->revenue_percentage;

                $total_expenses += $base_salary;
                $total_expenses += $revenue_share;
            }

            $request_item = array(
                'id' => $movie_id,
                'title' => $movie_title,
                'pc_id' => $pc_id,
                'pc_name' => $pc_name,
                'revenue' => number_format($movie_revenue, 2, '.', ','),
                'expenses' => number_format($total_expenses, 2, '.', ','),
                'profit' => number_format($movie_revenue - $total_expenses, 2, '.', ',')
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
        array("message" => "Must provide pc_id.")
    );
}
