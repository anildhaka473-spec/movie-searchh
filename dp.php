<?php

$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASSWORD") ?: "";
$database = getenv("DB_NAME") ?: "movies";
$port = (int) (getenv("DB_PORT") ?: 3306);

$conn = @mysqli_connect(
    $host,
    $user,
    $password,
    $database,
    $port
);

if ($conn) {
    mysqli_set_charset($conn, "utf8mb4");
}

?>
