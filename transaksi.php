<?php
// Pastikan sesi unik untuk situs ini
session_name('rental_session');
session_start();


// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "19027_psas");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil booking_id dari URL
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';

// Ambil data booking dari database berdasarkan booking_id
$sql_booking = "SELECT  b.*, m.nama AS nama_mobil, m.merk, m.no_plat, m.harga_sewa, b.status_pembayaran
                FROM booking b
                JOIN mobil m ON b.id_mobil = m.id
                WHERE b.id = ?";
$stmt = $conn->prepare($sql_booking);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

// Pastikan booking ditemukan
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    
    // Hitung total harga (harga sewa per hari * lama sewa)
    $total_harga = $booking['harga_sewa'] * $booking['lama_sewa'];
} else {
    echo "<p>Transaksi tidak ditemukan.</p>";
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

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

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
                    <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i></i>SewaAja</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Beranda</a>
                    <a href="daftarmobil.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftarmobil.php' ? 'active' : ''; ?>">Daftar Mobil</a>
                    <a href="transaksi.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>">Transaksi</a>
                    <a href="contact.html" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.html' ? 'active' : ''; ?>">Contact</a>
                </div>

                   
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Transaksi</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="booking.php">Booking</a></li>
                <li class="breadcrumb-item active text-primary">Transaksi</li>
            </ol>    
        </div>
    </div>
    <!-- Header End -->

    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - <?php echo $booking['nama_mobil']; ?></title>
</head>
<body>
<div class="container mt-5">
    <h2>Detail Transaksi</h2>
    
    
    <div class="card">
        <h3>Mobil: <?php echo $booking['nama_mobil']; ?></h3>
        <p>Merk: <?php echo $booking['merk']; ?></p>
        <p>Plat Nomor: <?php echo $booking['no_plat']; ?></p>
        <p>Nama Pemesan: <?php echo $booking['nama']; ?></p>
        <p>Nomor KTP: <?php echo $booking['ktp']; ?></p>
        <p>Alamat: <?php echo $booking['alamat']; ?></p>
        <p>Nomor Telepon: <?php echo $booking['telepon']; ?></p>
        <p>Tanggal Booking: <?php echo $booking['tanggal_booking']; ?></p>
        <p>Lama Sewa: <?php echo $booking['lama_sewa']; ?> hari</p>
        <p>Total Harga: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
        <p>Status Pembayaran: <?php echo ($booking['status_pembayaran'] == 1) ? 'Sudah Dibayar' : 'Belum Dibayar'; ?></p>
    </div>
    
    <?php if ($booking['status_pembayaran'] == 'Sedang Diproses') : ?>
        <div class="mt-4">
            <h4>Metode Pembayaran:</h4>
            <p>Transfer ke rekening berikut:</p>
            <ul>
                <li><strong>Bank BRI</strong>: 190234456</li>
                <li><strong>Atas Nama:</strong> SewaAja</li>
            </ul>
            <p>Setelah melakukan pembayaran, harap lakukan konfirmasi melalui tombol di bawah.</p>
            <a href="konfirmasitransaksi.php?id_booking=<?php echo $booking['id']; ?>" class="btn btn-primary">Konfirmasi Pembayaran</a>
        </div>
    <?php else: ?>
        <p>Transaksi sudah dikonfirmasi dan dibayar.</p>
    <?php endif; ?>
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


    /* Styling untuk Card */
    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        max-width: 800px;
        margin: 0 auto;
        text-align: left; /* Mengubah teks menjadi rata kiri */
    }

    .card h3 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 8px;
    }

    .card ul {
        list-style-type: none;
        padding-left: 0;
    }

    .card ul li {
        font-size: 1rem;
        color: #333;
    }

    .card .btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1rem;
    }

    .card .btn:hover {
        background-color: #0056b3;
    }



    /* Untuk Detail Transaksi dan Metode Pembayaran */
    .detail-transaksi, .payment-method {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-left: 10px;
        margin-right: 10px;
        text-align: left; /* Mengubah teks menjadi rata kiri */
    }

    .detail-transaksi h3, .payment-method h4 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 10px;
    }

    .detail-transaksi p, .payment-method p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 8px;
    }

    .payment-method ul {
        list-style-type: none;
        padding-left: 0;
    }

    .payment-method ul li {
        font-size: 1rem;
        color: #333;
    }

    .payment-method .btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1rem;
    }

    .payment-method .btn:hover {
        background-color: #0056b3;
    }

    /* Styling untuk bagian detail transaksi */
    .detail-transaksi p {
        font-size: 1.2rem;
        color: #444;
    }

    .detail-transaksi .status {
        font-weight: bold;
        color: #ff6f61;
    }

</style>

