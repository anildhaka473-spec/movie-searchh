<?php

header("Content-Type: text/html; charset=UTF-8");


if (!isset($_GET["movie"])) {

    echo '
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h2>Enter a movie name</h2>
            <p>Search for a movie to see its details.</p>
        </div>
    ';

    exit;
}


$movie = trim($_GET["movie"]);


if ($movie === "") {

    echo '
        <div class="empty-state">
            <div class="empty-icon">⚠️</div>
            <h2>Movie name is required</h2>
        </div>
    ';

    exit;
}


$apiKey = getenv("OMDB_API_KEY");


if (!$apiKey) {

    echo '
        <div class="error-card">
            <h2>API Configuration Error</h2>
            <p>OMDb API key is not configured on the server.</p>
        </div>
    ';

    exit;
}


$url =
    "https://www.omdbapi.com/?apikey="
    . urlencode($apiKey)
    . "&t="
    . urlencode($movie)
    . "&plot=full";


$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "timeout" => 10
    ]
]);


$response = @file_get_contents($url, false, $context);


if ($response === false) {

    echo '
        <div class="error-card">
            <h2>Unable to reach movie service</h2>
            <p>Please try again in a moment.</p>
        </div>
    ';

    exit;
}


$data = json_decode($response, true);


if (
    !$data ||
    !isset($data["Response"]) ||
    $data["Response"] !== "True"
) {

    echo '
        <div class="empty-state">

            <div class="empty-icon">🎬</div>

            <h2>Movie not found</h2>

            <p>
                We could not find a movie matching
                <strong>'
                . htmlspecialchars($movie, ENT_QUOTES, "UTF-8")
                . '</strong>.
            </p>

        </div>
    ';

    exit;
}


function clean($value)
{
    if (!$value || $value === "N/A") {
        return "Not available";
    }

    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        "UTF-8"
    );
}


$title = clean($data["Title"] ?? "");
$year = clean($data["Year"] ?? "");
$genre = clean($data["Genre"] ?? "");
$director = clean($data["Director"] ?? "");
$actors = clean($data["Actors"] ?? "");
$plot = clean($data["Plot"] ?? "");
$runtime = clean($data["Runtime"] ?? "");
$language = clean($data["Language"] ?? "");
$country = clean($data["Country"] ?? "");
$rating = clean($data["imdbRating"] ?? "");
$votes = clean($data["imdbVotes"] ?? "");
$released = clean($data["Released"] ?? "");
$poster = $data["Poster"] ?? "";


if (
    empty($poster) ||
    $poster === "N/A"
) {

    $poster = "https://via.placeholder.com/400x600?text=No+Poster";
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
        >

    </div>


    <div class="movie-info">

        <div class="movie-heading">

            <span class="movie-label">
                MOVIE
            </span>

            <h2><?= $title ?></h2>

            <div class="movie-meta">

                <span><?= $year ?></span>

                <span>•</span>

                <span><?= $runtime ?></span>

                <span>•</span>

                <span><?= $genre ?></span>

            </div>

        </div>


        <?php if ($rating !== "Not available"): ?>

            <div class="rating">

                <span class="star">★</span>

                <strong><?= $rating ?></strong>

                <span>/ 10</span>

                <?php if ($votes !== "Not available"): ?>

                    <small>
                        <?= $votes ?> votes
                    </small>

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <div class="details-grid">

            <div class="detail">

                <span>Director</span>

                <strong><?= $director ?></strong>

            </div>


            <div class="detail">

                <span>Released</span>

                <strong><?= $released ?></strong>

            </div>


            <div class="detail">

                <span>Language</span>

                <strong><?= $language ?></strong>

            </div>


            <div class="detail">

                <span>Country</span>

                <strong><?= $country ?></strong>

            </div>

        </div>


        <div class="plot">

            <h3>Story</h3>

            <p><?= $plot ?></p>

        </div>


        <div class="cast">

            <h3>Cast</h3>

            <p><?= $actors ?></p>

        </div>

    </div>

</div>
