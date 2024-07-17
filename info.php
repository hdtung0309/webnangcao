<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=laravel_school_db", "root", "");
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
