<?php
session_start();

$userName = $_SESSION["name"] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Movie Search</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="navbar">

    <div class="logo">
        🎬 <span>Movie<span class="accent">Search</span></span>
    </div>

    <div class="nav-right">

        <?php if ($userName): ?>

            <span class="welcome">
                Hi, <?= htmlspecialchars($userName) ?>
            </span>

        <?php else: ?>

            <a href="login.php" class="login-link">
                Login
            </a>

        <?php endif; ?>

    </div>

</header>


<main class="hero">

    <div class="hero-content">

        <div class="badge">
            🎥 YOUR MOVIE DISCOVERY PLATFORM
        </div>

        <h1>
            Find Your Next
            <span>Favorite Movie</span>
        </h1>

        <p class="subtitle">
            Search thousands of movies and discover ratings,
            genres, actors, directors and more.
        </p>


        <form id="searchForm" class="search-box">

            <input
                type="text"
                id="movieInput"
                name="movie"
                placeholder="Search for a movie..."
                autocomplete="off"
                required
            >

            <button type="submit">
                🔍 Search
            </button>

        </form>

    </div>

</main>


<section class="results-section">

    <div id="result">

        <div class="empty-state">

            <div class="empty-icon">🎬</div>

            <h2>Search for a movie</h2>

            <p>
                Enter a movie name above to see its details.
            </p>

        </div>

    </div>

</section>


<footer>

    <p>
        © <?= date("Y") ?> MovieSearch
    </p>

</footer>


<script src="script.js"></script>

</body>
</html>
