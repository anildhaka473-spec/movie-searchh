<?php

$conn = null;

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$port = (int) (getenv("DB_PORT") ?: 3306);

if ($host && $user && $database) {

    mysqli_report(MYSQLI_REPORT_OFF);

    $conn = @mysqli_connect(
        $host,
        $user,
        $password ?: "",
        $database,
        $port
    );

    if ($conn) {
        mysqli_set_charset($conn, "utf8mb4");
    }
}

?>
