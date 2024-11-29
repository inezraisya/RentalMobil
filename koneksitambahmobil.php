<?php
include 'koneksi.php';

// Ambil data dari form
$nama_mobil = $_POST['nama_mobil'];
$harga_sewa = $_POST['harga_sewa'];
$no_plat = $_POST['no_plat'];
$merk = $_POST['merk'];
$deskripsi = $_POST['deskripsi'];
$status = $_POST['status']; // Status mobil (tersedia atau disewa)

// Proses upload gambar
$rand = rand();
$ekstensi = array('png', 'jpg', 'jpeg', 'gif');
$filename = $_FILES['gambar']['name'];
$ukuran = $_FILES['gambar']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

// Cek ekstensi file gambar
if (!in_array($ext, $ekstensi)) {
    header("Location: tambah_mobil.php?alert=gagal_ekstensi");
} else {
    // Cek ukuran file gambar (maksimum 1 MB)
    if ($ukuran < 1044070) {
        $xx = $rand . '_' . $filename;
        // Pindahkan file gambar ke folder img/
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'img/' . $xx);

        // Query untuk memasukkan data mobil ke database
        $query = "INSERT INTO mobil (nama, harga_sewa, no_plat, merk, deskripsi, status, gambar)
                  VALUES ('$nama_mobil', '$harga_sewa', '$no_plat', '$merk', '$deskripsi', '$status', '$xx')";

        // Eksekusi query
        if (mysqli_query($conn, $query)) {
            header("Location: daftar_mobil.php?alert=berhasil");
        } else {
            header("Location: tambah_mobil.php?alert=gagal_insert");
        }
    } else {
        header("Location: tambah_mobil.php?alert=gagal_ukuran");
    }
}
?>
