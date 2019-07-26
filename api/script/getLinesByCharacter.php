<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db.php';
include_once '../models/lines.php';

if (isset($_GET['movie_id']) &&
    isset($_GET['actor_id'])) {
    $database = new DB();
    $db = $database->getConnection();

    $model = new Lines($db);


    $stmt = $model->getLinesByCharacter($_GET['movie_id'], $_GET['actor_id']);
    $num = $stmt->rowCount();

    if ($num > 0) {

        $stmt_arr = array();
        $stmt_arr['rows'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $file_lines = file('../../assets/script' . $movie_id . '.txt', FILE_IGNORE_NEW_LINES);

            $lines = preg_grep('/^'. strtoupper($character_name) .'/', $file_lines);
            $references = preg_grep('/'. ucwords($character_name) .'/', $file_lines);

            $total_lines = 0;
            $total_words = 0;
            $total_references = 0;

            foreach ($lines as $line) {
                $colon_pos = strpos($line, ':');

                if ($colon_pos !== false) {
                    $word_count = str_word_count(substr($line, $colon_pos));
                    $total_words += $word_count;
                }

                $total_lines++;
            }

            foreach ($references as $reference) {
                $total_references++;
            }

            $request_item = array(
                'actor_id' => $actor_id,
                'actor_first_name' => $first_name,
                'actor_last_name' => $last_name,
                'movie_id' => $movie_id,
                'character_name' => $character_name,
                'movie_title' => $movie_title,
                'total_lines' => $total_lines,
                'total_words' => $total_words,
                'total_references' => $total_references
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
        array("message" => "Must provide movie_id & actor_id.")
    );
}
