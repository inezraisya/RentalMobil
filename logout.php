<?php
session_name('rental_session');
session_start();
session_unset(); // Menghapus semua data sesi
session_destroy(); // Menghancurkan sesi
header("Location: login.php"); // Arahkan ke halaman login
exit;
?>
