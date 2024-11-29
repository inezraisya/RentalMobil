<?php
if (isset($_GET['id_konfirmasi'])) {
    $id_konfirmasi = $_GET['id_konfirmasi'];

    // Update status konfirmasi pembayaran
    $sql_update = "UPDATE konfirmasi_transaksi SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id_konfirmasi);
    $stmt->execute();

    // Update status pembayaran di tabel booking
    $sql_update_booking = "UPDATE booking SET status_pembayaran = 1 WHERE id = (SELECT id_booking FROM konfirmasi_transaksi WHERE id = ?)";
    $stmt_booking = $conn->prepare($sql_update_booking);
    $stmt_booking->bind_param("i", $id_konfirmasi);
    $stmt_booking->execute();

    header("Location: transaksi.php");
    exit;
}
?>
