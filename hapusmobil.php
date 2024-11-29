<?php
// Menghubungkan ke database
require 'koneksi.php';

// Cek apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus mobil berdasarkan ID
    $query = "DELETE FROM mobil WHERE id = ?";

    // Menyiapkan statement dan melakukan bind parameter
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id); // 'i' untuk integer (id)

        // Menjalankan query
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman daftar mobil
            header("Location: daftarmobil.php");
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: " . $stmt->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Jika gagal mempersiapkan query
        echo "Error: " . $conn->error;
    }
} else {
    // Jika ID tidak ada, redirect ke halaman daftar mobil
    header("Location: daftarmobil.php");
    exit;
}

// Menutup koneksi database
$conn->close();
?>