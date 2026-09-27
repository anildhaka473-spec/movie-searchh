<?php

$password = $_GET["password"] ?? "";

if ($password === "") {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
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
        </style>
    </head>

    <body>

        <h2>Password Hash Generator</h2>

        <form method="GET">

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

    </body>
    </html>
    <?php

    exit;
}

echo "<h3>Password Hash:</h3>";

echo "<code>" .
    htmlspecialchars(
        password_hash($password, PASSWORD_DEFAULT),
        ENT_QUOTES,
        "UTF-8"
    )
    . "</code>";

?>
