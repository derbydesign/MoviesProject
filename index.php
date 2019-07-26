<?php

include_once 'settings.php';
$curl_request = new CurlRequest();

// process add actor form if submitted
if (isset($_POST['add_actor'])) {
    $data_array = array(
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "movie_id" => $_POST['movie_id'],
        "character_name" => $_POST['character_name'],
        "base_salary" => $_POST['base_salary'],
        "revenue_share" => $_POST['revenue_share']
    );

    $add_actor = $curl_request->callAPI('POST', SERVER_ROOT . '/MoviesProject/api/actor/insert.php', json_encode($data_array));
    $attach_movie_response = json_decode($add_actor);

    header('Location: /MoviesProject');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        .pc.card {
            border-color: #000000;
        }
    </style>

    <title>Movies Project</title>
</head>
<body>
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4 mb-5">
            <form class="border border-dark rounded p-3" method="post" action="index.php">
                <h2>Add Actor</h2>
                <div class="form-group">
                    <label for="add-first-name">First Name</label>
                    <input type="text" class="form-control" id="add-first-name" name="first_name" required/>
                </div>
                <div class="form-group">
                    <label for="add-last-name">Last Name</label>
                    <input type="text" class="form-control" id="add-last-name" name="last_name" required/>
                </div>
                <div class="form-group">
                    <label for="movie-select">Associated Movie</label>
                    <select class="form-control" id="movie-select" name="movie_id" required>
                        <option selected disabled>-- SELECT A MOVIE --</option>
                        <?php
                        $get_movies = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/movie/getAll.php', false);
                        $movies_response = json_decode($get_movies);

                        foreach ($movies_response->rows as $movie) {
                            echo '<option value="' . $movie->id . '">' . $movie->title . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-character-name">Character Name</label>
                    <input type="text" class="form-control" id="add-character-name" name="character_name"
                           required/>
                </div>
                <div class="form-group">
                    <label for="add-base-salary">Base Salary</label>
                    <input type="number" min="0" step=".01" class="form-control" id="add-base-salary" name="base_salary"
                           required/>
                </div>
                <div class="form-group">
                    <label for="add-revenue-share">Revenue Share %</label>
                    <input type="number" min="0" max="100" class="form-control" id="add-revenue-share"
                           name="revenue_share" required/>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 ml-auto">
                            <input type="submit" class="form-control btn btn-primary" id="submit-form" value="ADD"
                                   name="add_actor">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-4 col-lg-6 col-xl-4 mb-5">
            <div class="card pc">
                <div class="card-body">
                    <h5 class="card-title"><em>Friendly Fire</em></h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Script Analysis
                    </h6>
                    <?php
                    $get_movie_actors = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/actor/getAllDetailsByMovieId.php?movie_id=33', false);
                    $get_movie_actors_response = json_decode($get_movie_actors);

                    foreach ($get_movie_actors_response->rows as $actor) {
                        $total_lines = 0;
                        $total_words = 0;
                        $total_references = 0;

                        $get_lines_details = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/script/getLinesByCharacter.php?movie_id=33&actor_id=' . $actor->actor_id, false);
                        $lines_details_response = json_decode($get_lines_details);

                    foreach ($lines_details_response->rows as $response) {
                        $total_lines = $response->total_lines;
                        $total_words = $response->total_words;
                        $total_references = $response->total_references;
                    }
                        ?>
                        <p class="card-text">
                            <?= htmlentities($actor->first_name) ?> <?= htmlentities($actor->last_name) ?>
                            <small><em>(as <?= htmlentities($actor->character_name) ?>)</em></small>
                        </p>
                        <ul>
                            <li>Total Character Lines: <?= $total_lines ?></li>
                            <li>Total Character Words Spoken: <?= $total_words ?></li>
                            <li>Total Character References: <?= $total_references ?></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $get_pc_details = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/productionCompany/getAllDetails.php', false);
        $pc_details_response = json_decode($get_pc_details);
        foreach ($pc_details_response->rows as $pc) {
            ?>
            <div class="col-12 col-md-6 mb-3">
                <div class="card pc">
                    <div class="card-body">
                        <h4 class="card-title"><?= $pc->pc_name ?></h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Total Revenue: $<?= htmlentities($pc->total_revenue) ?>
                            <br>
                            Total Expenses: $<?= htmlentities($pc->total_expenses) ?>
                            <br>
                            Profit: $<?= htmlentities($pc->total_profit) ?>
                        </h6>
                        <div class="row">
                            <?php
                            $get_movies_by_pc = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/movie/getAllDetailsByPcId.php?pc_id=' . $pc->pc_id, false);
                            $movies_by_pc_response = json_decode($get_movies_by_pc);
                            foreach ($movies_by_pc_response->rows as $movie) {
                                ?>
                                <div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><em><?= htmlentities($movie->title) ?></em></h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                Total Revenue: $<?= htmlentities($movie->revenue) ?>
                                                <br>
                                                Total Expenses: $<?= htmlentities($movie->expenses) ?>
                                                <br>
                                                Profit: $<?= htmlentities($movie->profit) ?>
                                            </h6>
                                            <p class="card-text font-weight-bold">Starring:</p>
                                            <?php
                                            $get_actors = $curl_request->callAPI('GET', SERVER_ROOT . '/MoviesProject/api/actor/getAllDetailsByMovieId.php?movie_id=' . $movie->id, false);
                                            $get_actors_response = json_decode($get_actors);

                                            foreach ($get_actors_response->rows as $actor) {
                                                ?>
                                                <p class="card-text">
                                                    <?= htmlentities($actor->first_name) ?> <?= htmlentities($actor->last_name) ?>
                                                    <small><em>(as <?= htmlentities($actor->character_name) ?>)</em></small>
                                                </p>
                                                <ul>
                                                    <li>Base Salary: $<?= htmlentities($actor->base_salary) ?></li>
                                                    <li>Revenue Share
                                                        (<?= number_format(htmlentities($actor->revenue_percentage) * 100, 0) ?>
                                                        %):
                                                        $<?= htmlentities($actor->revenue_share) ?></li>
                                                    <li>Total Earnings:
                                                        $<?= number_format((float)str_replace(',', '', htmlentities($actor->revenue_share)) + (float)str_replace(',', '', htmlentities($actor->base_salary)), 2, '.', ',') ?></li>
                                                </ul>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>
