<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19027_psas");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses konfirmasi pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_booking = $_POST['id_booking'];
    $no_rekening = $_POST['no_rekening'];
    $atas_nama = $_POST['atas_nama'];
    $nominal = $_POST['nominal'];
    $tanggal_transfer = $_POST['tanggal_transfer'];

    // Update status pembayaran menjadi "Sudah Dibayar"
    $sql_update = "UPDATE booking SET status_pembayaran = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id_booking);
    $stmt->execute();

    // Insert ke tabel konfirmasi_transaksi
    $sql_insert = "INSERT INTO konfirmasi_transaksi (id_booking, no_rekening, atas_nama, nominal, tanggal_transfer, status)
                   VALUES (?, ?, ?, ?, ?, 'pending')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issds", $id_booking, $no_rekening, $atas_nama, $nominal, $tanggal_transfer);
    $stmt_insert->execute();

    header("Location: transaksi_detail.php?id_booking=" . $id_booking);
    exit;
}
?>
