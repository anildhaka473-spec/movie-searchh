<?php

session_start();

$userName = $_SESSION["name"] ?? null;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Search movies, ratings, genres, actors and more."
    >

    <title>MovieSearch — Discover Movies</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header class="navbar">

    <a href="index.php" class="logo">
        🎬 Movie<span>Search</span>
    </a>

    <div class="nav-right">

        <?php if ($userName): ?>

            <span class="welcome">
                Hi, <?= htmlspecialchars($userName, ENT_QUOTES, "UTF-8") ?>
            </span>

        <?php else: ?>

            <a href="login.php" class="login-link">
                Login
            </a>

        <?php endif; ?>

    </div>

</header>


<main>

    <section class="hero">

        <div class="hero-content">

            <div class="badge">
                🎥 MOVIE DISCOVERY PLATFORM
            </div>

            <h1>
                Find Your Next
                <span>Favorite Movie</span>
            </h1>

            <p class="subtitle">
                Search movies and discover posters, ratings,
                genres, actors, directors and complete details.
            </p>


            <form
                id="searchForm"
                class="search-box"
                autocomplete="off"
            >

                <input
                    type="text"
                    id="movieInput"
                    name="movie"
                    placeholder="Search movie name..."
                    maxlength="100"
                    required
                >

                <button type="submit" id="searchButton">
                    Search
                </button>

            </form>

        </div>

    </section>


    <section class="results-section">

        <div id="result">

            <div class="empty-state">

                <div class="empty-icon">
                    🎬
                </div>

                <h2>
                    Search for a movie
                </h2>

                <p>
                    Enter a movie name above to get started.
                </p>

            </div>

        </div>

    </section>

</main>


<footer>

    <p>
        © <?= date("Y") ?> MovieSearch
    </p>

</footer>


<script src="script.js"></script>

</body>

</html>
