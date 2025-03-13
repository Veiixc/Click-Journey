<?php
include 'database.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Read from CSV
$file = fopen('../data/users.csv', 'r');
while (($data = fgetcsv($file)) !== FALSE) {
    echo "login: " . $data[0] . " - Name: " . $data[3] . " - Role: " . $data[2] . "<br>";
}
fclose($file);
?>
