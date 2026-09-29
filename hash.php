<?php

$hash = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = $_POST["password"] ?? "";

    if ($password !== "") {
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Hash Generator</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #08090d;
            color: white;
            padding: 40px;
        }

        input {
            padding: 12px;
            width: 300px;
            background: #151720;
            color: white;
            border: 1px solid #333;
            border-radius: 8px;
        }

        button {
            padding: 12px 20px;
            margin-left: 5px;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
        }

        .hash {
            margin-top: 20px;
            padding: 15px;
            background: #151720;
            border-radius: 8px;
            word-break: break-all;
        }

    </style>

</head>

<body>

    <h2>Password Hash Generator</h2>

    <form method="POST">

        <input
            type="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button type="submit">
            Generate
        </button>

    </form>


    <?php if ($hash !== ""): ?>

        <h3>Password Hash:</h3>

        <div class="hash">
            <?= htmlspecialchars($hash, ENT_QUOTES, "UTF-8") ?>
        </div>

    <?php endif; ?>

</body>

</html>
