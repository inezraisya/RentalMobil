<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = '19027_psas';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Koneksi database gagal: ' . $conn->connect_error);
}
?>
