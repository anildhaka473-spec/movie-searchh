<?php

$password = "12345";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Password Hash</h2>";
echo "<p>" . htmlspecialchars($hashedPassword) . "</p>";

?>
