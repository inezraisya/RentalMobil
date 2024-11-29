<?php
session_name('rental_session');
session_start();
include 'koneksi.php';
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "19027_psas");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil id_booking dari URL
$booking_id = isset($_GET['id_booking']) ? $_GET['id_booking'] : '';

// Ambil data booking berdasarkan booking_id
$sql_booking = "SELECT b.*, m.nama AS nama_mobil, m.harga_sewa FROM booking b
                JOIN mobil m ON b.id_mobil = m.id
                WHERE b.id = ?";
$stmt = $conn->prepare($sql_booking);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

// Pastikan booking ditemukan
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    $total_harga = $booking['harga_sewa'] * $booking['lama_sewa'];
} else {
    echo "<p>Transaksi tidak ditemukan.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>SewaAja</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


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
                            <a href="SewaAja@gmail.com" class="text-muted me-0"><i class="fas fa-envelope text-primary me-2"></i>SewaAja@gmail.com</a>
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
                        <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i></i>SewaAja</h1>
                        <!-- <img src="img/logo.png" alt="Logo"> -->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Beranda</a>
                        <a href="daftarmobil.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftarmobil.php' ? 'active' : ''; ?>">Daftar Mobil</a>
                        <a href="kontak.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : ''; ?>">Kontak Kami</a>
                    </div>
                       
                </nav>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Konfirmasi Pembayaran</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active text-primary">Daftar Mobil</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->



<div class="container mt-5">
    <h2 class="text-center">Konfirmasi Pembayaran</h2>
    
    <!-- Pilihan Pembayaran  -->
    <div class="mt-4">
        <h4>Metode Pembayaran:</h4>
        <p>Transfer ke rekening berikut:</p>
        <ul>
            <li><strong>Bank BRI</strong>: 190234456</li>
            <li><strong>Atas Nama:</strong> SewaAja</li>
        </ul>
        <p>Setelah melakukan pembayaran, harap lakukan konfirmasi melalui tombol di bawah.</p>
    </div>

    <!-- Form Konfirmasi Pembayaran -->
    <form action="proses_konfirmasi.php" method="POST">
        <input type="hidden" name="id_booking" value="<?php echo $booking['id']; ?>">
        
        <div class="mb-3">
            <label for="kode_booking">Kode Booking:</label>
            <input type="text" name="kode_booking" value="<?php echo $booking['id']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="no_rekening">No Rekening:</label>
            <input type="text" name="no_rekening" required>
        </div>
        <div class="mb-3">
            <label for="atas_nama">Atas Nama:</label>
            <input type="text" name="atas_nama" required>
        </div>
        <div class="mb-3">
            <label for="nominal">Nominal:</label>
            <input type="text" name="nominal" value="<?php echo number_format($total_harga, 0, ',', '.'); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tanggal_transfer">Tanggal Transfer:</label>
            <input type="date" name="tanggal_transfer" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Kirim Konfirmasi</button>
    </form>
</div>




                                <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <div class="footer-item">
                                <h4 class="text-white mb-4">Tentang Kami</h4>
                                <p class="mb-3">Di SewaAja menyediakan rental mobil berkualitas dengan harga terjangkau, memastikan perjalanan Anda nyaman dan aman.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Quick Links</h4>
                            <a href="daftarmobil.php"><i class="fas fa-angle-right me-2"></i> Daftar Mobil</a>
                            <a href="kontak.php"><i class="fas fa-angle-right me-2"></i> Kontak Kami</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Jam Kerja</h4>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Senin - Jumat:</h6>
                                <p class="text-white mb-0">09.00 hingga 19.00</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Sabtu:</h6>
                                <p class="text-white mb-0">10.00 hingga 17.00</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Libur:</h6>
                                <p class="text-white mb-0">Hari Minggu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Kontak Kami</h4>
                            <a href="#"><i class="fa fa-map-marker-alt me-2"></i> Yogyakarta</a>
                            <a href="mailto:info@example.com"><i class="fas fa-envelope me-2"></i> SewaAja@gmail.com</a>
                            <a href="tel:+012 345 67890"><i class="fas fa-phone me-2"></i>+01276286593</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>

<style>
    /* Styling untuk Form Konfirmasi Pembayaran */
form {
    background-color: #fff;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px; /* Membuat sudut lebih melengkung */
    max-width: 600px;
    margin: 20px auto; /* Membuat form berada di tengah halaman */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Efek bayangan ringan */
}

/* Styling untuk Label Form */
form label {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

/* Styling untuk Input Form */
form input[type="text"],
form input[type="date"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px; /* Memberikan border rounded */
    font-size: 1rem;
    transition: border-color 0.3s ease; /* Efek transisi pada border */
}

form input[type="text"]:focus,
form input[type="date"]:focus {
    border-color: #007bff; /* Border berubah saat fokus */
    outline: none; /* Menghilangkan outline default */
}

/* Styling untuk Button Kirim Konfirmasi */
form button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    font-size: 1.1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease; /* Efek transisi saat hover */
}

form button[type="submit"]:hover {
    background-color: #0056b3; /* Warna tombol berubah saat hover */
}

/* Styling untuk Form Input yang Bersifat Readonly */
form input[readonly] {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
}

/* Styling untuk Margin bawah pada setiap elemen input */
.mb-3 {
    margin-bottom: 20px;
}

/* Styling untuk Heading dalam Form */
form h4 {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #333;
    text-align: center; /* Membuat heading lebih menarik dan terpusat */
}

/* Styling untuk Teks di Metode Pembayaran */
.mt-4 p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
    text-align: left; /* Menjaga teks agar rata kiri */
}

/* Styling untuk Kotak Form dengan lebih banyak fokus */
form .form-group {
    padding: 15px;
    background-color: #f9f9f9; /* Memberikan latar belakang yang lebih terang */
    border-radius: 6px;
    margin-bottom: 15px;
}

</style>