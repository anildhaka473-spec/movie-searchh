<?php

session_start();

require_once "dp.php";

$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email.";
        $messageType = "error";

    } elseif ($password === "") {

        $message = "Please enter your password.";
        $messageType = "error";

    } elseif (!$conn) {

        $message =
            "Login database is not configured. " .
            "Movie search is still available.";

        $messageType = "error";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, password
             FROM users
             WHERE email = ?
             LIMIT 1"
        );


        if (!$stmt) {

            $message = "Unable to process login.";
            $messageType = "error";

        } else {

            mysqli_stmt_bind_param(
                $stmt,
                "s",
                $email
            );

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);


            if (
                $result &&
                mysqli_num_rows($result) === 1
            ) {

                $user = mysqli_fetch_assoc($result);


                if (
                    isset($user["password"]) &&
                    password_verify(
                        $password,
                        $user["password"]
                    )
                ) {

                    session_regenerate_id(true);

                    $_SESSION["user_id"] =
                        $user["id"];

                    $_SESSION["name"] =
                        $user["name"];

                    header("Location: index.php");

                    exit;

                }

            }


            $message =
                "Incorrect email or password.";

            $messageType = "error";

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login — MovieSearch</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="login-page">

<div class="login-container">

    <div class="login-card">

        <div class="login-logo">
            🎬
        </div>

        <h1>
            Welcome Back
        </h1>

        <p class="login-subtitle">
            Login to MovieSearch
        </p>


        <?php if ($message): ?>

            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            class="login-form"
        >

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter email"
                autocomplete="email"
                required
            >


            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter password"
                autocomplete="current-password"
                required
            >


            <button type="submit">
                Login
            </button>

        </form>


        <a
            href="index.php"
            class="back-home"
        >
            ← Back to Movie Search
        </a>

    </div>

</div>

</body>

</html>
