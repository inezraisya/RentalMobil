<?php
session_start();
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "19027_psas");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data yang dikirim dari form
$id_mobil = $_POST['id_mobil'];
$ktp = $_POST['ktp'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$tanggal_booking = $_POST['tanggal_booking'];
$lama_sewa = $_POST['lama_sewa'];

// Ambil harga sewa mobil dari database
$sql_mobil = "SELECT harga_sewa FROM mobil WHERE id = ?";
$stmt = $conn->prepare($sql_mobil);
$stmt->bind_param("i", $id_mobil);
$stmt->execute();
$result = $stmt->get_result();
$mobil = $result->fetch_assoc();
$harga_sewa = $mobil['harga_sewa'];

// Tutup result sebelum menjalankan query lain
$result->free();

// Hitung total harga
$total_harga = $harga_sewa * $lama_sewa;

// Query untuk memasukkan data booking
$sql_booking = "INSERT INTO booking (id_mobil, ktp, nama, alamat, telepon, tanggal_booking, lama_sewa, total_harga, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($sql_booking);
$stmt->bind_param("isssssis", $id_mobil, $ktp, $nama, $alamat, $telepon, $tanggal_booking, $lama_sewa, $total_harga);

// Eksekusi query dan arahkan ke halaman transaksi setelah sukses
if ($stmt->execute()) {
    header("Location: transaksi.php?booking_id=" . $stmt->insert_id);
    exit();
} else {
    echo "Booking gagal: " . $stmt->error;
}
?>
