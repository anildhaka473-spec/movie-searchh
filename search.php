<?php

header(
    "Content-Type: text/html; charset=UTF-8"
);


if (!isset($_GET["movie"])) {

    showError(
        "Search required",
        "Please enter a movie name."
    );

    exit;
}


$movie = trim($_GET["movie"]);


if ($movie === "") {

    showError(
        "Search required",
        "Please enter a movie name."
    );

    exit;
}


if (mb_strlen($movie) > 100) {

    showError(
        "Invalid search",
        "Movie name is too long."
    );

    exit;
}


$apiKey = getenv("OMDB_API_KEY");


if (!$apiKey) {

    showError(
        "API key missing",
        "OMDb API key has not been configured on the server."
    );

    exit;
}


$url =
    "https://www.omdbapi.com/" .
    "?apikey=" . urlencode($apiKey) .
    "&t=" . urlencode($movie) .
    "&plot=full";


$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "timeout" => 10,
        "ignore_errors" => true
    ]
]);


$response = @file_get_contents(
    $url,
    false,
    $context
);


if ($response === false) {

    showError(
        "Service unavailable",
        "Unable to connect to the movie service."
    );

    exit;
}


$data = json_decode(
    $response,
    true
);


if (
    !is_array($data) ||
    ($data["Response"] ?? "False") !== "True"
) {

    showError(
        "Movie not found",
        "No movie was found for \"" .
        htmlspecialchars(
            $movie,
            ENT_QUOTES,
            "UTF-8"
        ) .
        "\"."
    );

    exit;
}


function cleanValue($value)
{
    if (
        !isset($value) ||
        $value === "" ||
        $value === "N/A"
    ) {
        return "Not available";
    }

    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        "UTF-8"
    );
}


function showError($title, $message)
{
    ?>

    <div class="error-card">

        <div class="empty-icon">
            🎬
        </div>

        <h2>
            <?= htmlspecialchars(
                $title,
                ENT_QUOTES,
                "UTF-8"
            ) ?>
        </h2>

        <p>
            <?= $message ?>
        </p>

    </div>

    <?php
}


$title = cleanValue(
    $data["Title"] ?? null
);

$year = cleanValue(
    $data["Year"] ?? null
);

$genre = cleanValue(
    $data["Genre"] ?? null
);

$director = cleanValue(
    $data["Director"] ?? null
);

$actors = cleanValue(
    $data["Actors"] ?? null
);

$plot = cleanValue(
    $data["Plot"] ?? null
);

$runtime = cleanValue(
    $data["Runtime"] ?? null
);

$language = cleanValue(
    $data["Language"] ?? null
);

$country = cleanValue(
    $data["Country"] ?? null
);

$rating = cleanValue(
    $data["imdbRating"] ?? null
);

$votes = cleanValue(
    $data["imdbVotes"] ?? null
);

$released = cleanValue(
    $data["Released"] ?? null
);


$poster = $data["Poster"] ?? "";


if (
    !$poster ||
    $poster === "N/A"
) {

    $poster =
        "https://via.placeholder.com/400x600" .
        "?text=No+Poster";
}


$poster = htmlspecialchars(
    $poster,
    ENT_QUOTES,
    "UTF-8"
);

?>


<div class="movie-card">


    <div class="movie-poster">

        <img
            src="<?= $poster ?>"
            alt="<?= $title ?> poster"
            loading="lazy"
            onerror="this.src='https://via.placeholder.com/400x600?text=No+Poster'"
        >

    </div>


    <div class="movie-info">

        <span class="movie-label">
            MOVIE
        </span>


        <h2>
            <?= $title ?>
        </h2>


        <div class="movie-meta">

            <span>
                <?= $year ?>
            </span>

            <span>•</span>

            <span>
                <?= $runtime ?>
            </span>

            <span>•</span>

            <span>
                <?= $genre ?>
            </span>

        </div>


        <?php if ($rating !== "Not available"): ?>

            <div class="rating">

                <span class="star">
                    ★
                </span>

                <strong>
                    <?= $rating ?>
                </strong>

                <span>
                    / 10
                </span>

                <?php if ($votes !== "Not available"): ?>

                    <small>
                        <?= $votes ?> votes
                    </small>

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <div class="details-grid">


            <div class="detail">

                <span>
                    Director
                </span>

                <strong>
                    <?= $director ?>
                </strong>

            </div>


            <div class="detail">

                <span>
                    Released
                </span>

                <strong>
                    <?= $released ?>
                </strong>

            </div>


            <div class="detail">

                <span>
                    Language
                </span>

                <strong>
                    <?= $language ?>
                </strong>

            </div>


            <div class="detail">

                <span>
                    Country
                </span>

                <strong>
                    <?= $country ?>
                </strong>

            </div>


        </div>


        <div class="plot">

            <h3>
                Story
            </h3>

            <p>
                <?= $plot ?>
            </p>

        </div>


        <div class="cast">

            <h3>
                Cast
            </h3>

            <p>
                <?= $actors ?>
            </p>

        </div>


    </div>

</div>
