<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', '19027_psas');

// Periksa koneksi
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Cek apakah ada ID mobil yang dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID mobil tidak ditemukan.');
}

// Ambil ID mobil
$id = intval($_GET['id']);

// Ambil data mobil berdasarkan ID
$sql = "SELECT * FROM mobil WHERE id = $id";
$result = $conn->query($sql);

// Jika data mobil tidak ditemukan
if ($result->num_rows == 0) {
    die('Mobil tidak ditemukan.');
}

$row = $result->fetch_assoc();

// Proses update data mobil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mobil = $_POST['nama_mobil'];
    $harga_sewa = $_POST['harga_sewa'];
    $no_plat = $_POST['no_plat'];
    $merk = $_POST['merk'];
    $status = $_POST['status'];
    $gambar = $row['gambar']; // Default gambar lama

    // Periksa jika ada file gambar yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        $file_name = $_FILES['gambar']['name'];
        $file_tmp = $_FILES['gambar']['tmp_name'];

        // Validasi ekstensi file
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_extensions)) {
            // Upload file baru dan update nama file
            $gambar = uniqid() . '.' . $file_ext;
            move_uploaded_file($file_tmp, "img/$gambar");
        } else {
            echo '<script>alert("Ekstensi file tidak valid! Hanya PNG, JPG, JPEG, GIF yang diperbolehkan.");</script>';
        }
    }

    // Update data mobil ke database
    $sql = "UPDATE mobil SET 
                nama = '$nama_mobil', 
                harga_sewa = $harga_sewa, 
                no_plat = '$no_plat', 
                merk = '$merk', 
                status = '$status', 
                gambar = '$gambar' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Data mobil berhasil diperbarui!"); window.location="daftarmobil.php";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui data mobil.");</script>';
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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Edit Mobil</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
					<li class="breadcrumb-item"><a href="daftarmobil.php">Daftar Mobil</a></li>
                    <li class="breadcrumb-item active text-primary">Edit Mobil</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

    <!-- form edit -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Data Mobil</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_mobil" class="form-label fw-bold">Nama Mobil:</label>
                <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga_sewa" class="form-label fw-bold">Harga Sewa:</label>
                <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" value="<?php echo $row['harga_sewa']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_plat" class="form-label fw-bold">Nomor Plat:</label>
                <input type="text" class="form-control" id="no_plat" name="no_plat" value="<?php echo $row['no_plat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="merk" class="form-label fw-bold">Merk Mobil:</label>
                <input type="text" class="form-control" id="merk" name="merk" value="<?php echo $row['merk']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status Mobil:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="tersedia" <?php echo $row['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                    <option value="disewa" <?php echo $row['status'] == 'disewa' ? 'selected' : ''; ?>>Disewa</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label fw-bold">Foto Mobil:</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                <p class="form-text">Ekstensi yang diperbolehkan: .png, .jpg, .jpeg, .gif</p>
                <img src="img/<?php echo $row['gambar']; ?>" alt="Gambar Mobil" class="img-fluid mt-2" width="200">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="daftarmobil.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
