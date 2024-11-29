<?php
// Jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama']; // Pastikan ini sesuai dengan nama input form
    $merk = $_POST['merk'];
    $harga_sewa = $_POST['harga_sewa'];
    $no_plat = $_POST['no_plat'];
    $status = $_POST['status'];

    // Proses unggah gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($gambar);

    // Validasi dan unggah gambar
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        // Koneksi database
        $conn = new mysqli('localhost', 'root', '', '19027_psas');

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk memasukkan data ke database
        $sql = "INSERT INTO mobil (nama, merk, harga_sewa, no_plat, status, gambar) 
                VALUES ('$nama', '$merk', '$harga_sewa', '$no_plat', '$status', '$gambar')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Mobil berhasil ditambahkan!'); window.location.href='daftarmobil.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "<script>alert('Gagal mengunggah gambar.');</script>";
    }
}
?>

<?php
session_name('rental_session');
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil role pengguna
$role = $_SESSION['role'];

// Cek akses untuk admin dan pengunjung
if ($role !== 'admin' && $role !== 'pengunjung') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

   
    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-secondary d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-6 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Yogyakarta</a>
                        <a href="tel:+01234567890" class="text-muted me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01276286593</a>
                        <a href="mailto:example@gmail.com" class="text-muted me-0"><i class="fas fa-envelope text-primary me-2"></i>SewaAja@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end ms-auto">
                    <div class="d-inline-flex align-items-center" style="height: 45px;">
                        <?php if (!isset($_SESSION['username'])): ?>
                            <a href="register.php" class="text-light me-3"><small><i class="fa fa-user me-2"></i>Register</small></a>
                            <a href="login.php" class="text-light me-3"><small><i class="fa fa-sign-in-alt me-2"></i>Login</small></a>
                        <?php else: ?>
                            <span class="text-light me-3"><small><i class="fa fa-user me-2"></i>Hallo, <?php echo htmlspecialchars($_SESSION['username']); ?></small></span>
                            <a href="logout.php" class="text-light me-3"><i class="fas fa-power-off me-2"></i> Log Out</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
                    <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i>SewaAja</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Beranda</a>
                    <a href="about.html" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.html' ? 'active' : ''; ?>">About</a>
                    <a href="service.html" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'service.html' ? 'active' : ''; ?>">Service</a>
                    <a href="daftarmobil.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftarmobil.php' ? 'active' : ''; ?>">Daftar Mobil</a>
                    <a href="contact.html" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.html' ? 'active' : ''; ?>">Contact</a>
                </div>
                <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Booking</a>
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->

	<!-- Header Start -->
	<div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Tambah Mobil</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
					<li class="breadcrumb-item"><a href="daftarmobil.php">Daftar Mobil</a></li>
                    <li class="breadcrumb-item active text-primary">Tambah Mobil</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

    <!-- Form untuk Menambah Mobil -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Mobil Baru</h2>
        <form action="tambahmobil.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Mobil</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Mobil" required>
            </div>
            <div class="mb-3">
                <label for="merk" class="form-label fw-bold">Merk</label>
                <input type="text" class="form-control" id="merk" name="merk" placeholder="Masukkan Nama Merk" required>
            </div>
            <div class="mb-3">
                <label for="harga_sewa" class="form-label fw-bold">Harga Sewa (per hari)</label>
                <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" placeholder="Masukkan Harga" required>
            </div>
            <div class="mb-3">
                <label for="no_plat" class="form-label fw-bold">Nomor Plat</label>
                <input type="text" class="form-control" id="no_plat" name="no_plat" placeholder="Masukkan Nomor Plat" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="disewa">Disewa</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label fw-bold">Unggah Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Mobil</button>
            <a href="daftarmobil.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
