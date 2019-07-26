<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../models/queries/productionCompanyRequestItem.php';

$database = new DB();
$db = $database->getConnection();

$model = new ProductionCompanyRequestItem($db);


$stmt = $model->getAllDetails();
$num = $stmt->rowCount();

if ($num > 0) {

    $stmt_arr = array();
    $stmt_arr['rows'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $request_item = array(
            'pc_id' => $pc_id,
            'pc_name' => $pc_name,
            'total_revenue' => number_format($total_pc_revenue, 2, '.', ','),
            'total_salary_expenses' => number_format($total_salary_expenses, 2, '.', ','),
            'total_revenue_share_expenses' => number_format($total_revenue_share_expenses, 2, '.', ','),
            'total_expenses' => number_format($total_salary_expenses + $total_revenue_share_expenses, 2, '.', ','),
            'total_profit' => number_format($total_pc_revenue - ($total_salary_expenses + $total_revenue_share_expenses), 2, '.', ',')
        );

        array_push($stmt_arr['rows'], $request_item);
    }

    http_response_code(200);

    echo json_encode($stmt_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No production companies found.")
    );
}
