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

// Query untuk mengambil data mobil dari database
$query = "SELECT * FROM mobil";
$result = $conn->query($query);
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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Daftar mobil</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active text-primary">Daftar Mobil</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <div class="container-fluid py-5">
             <div class="container">
                 <h2 class="mb-4 text-center">Daftar Mobil</h2>
            </div>
        </div>


            <!-- Tombol Tambah Mobil (Hanya untuk Admin) -->
            <?php if ($role === 'admin'): ?>
                <a href="tambahmobil.php" class="btn btn-primary mb-4 ms-3">Tambah Mobil</a>
            <?php endif; ?>

            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="categories-item p-4">
                                <div class="categories-item-inner">
                                    <!-- Gambar Mobil -->
                                    <div class="categories-img rounded-top">
                                        <img src="img/<?php echo $row['gambar']; ?>" class="img-fluid w-100 rounded-top" alt="<?php echo $row['nama']; ?>">
                                    </div>
                                    <!-- Konten Mobil -->
                                    <div class="categories-content rounded-bottom p-4">
                                        <!-- Nama dan Merk -->
                                        <h4><?php echo $row['nama']; ?></h4>
                                        <p class="text-secondary"><strong>Merk:</strong> <?php echo $row['merk']; ?></p>

                                    <!-- Harga -->
                                    <div class="mb-4 text-start">
                                        <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0 d-flex align-items-center justify-content-start" style="padding-left: 0;">
                                            <?php echo "Rp" . number_format($row['harga_sewa'], 0, ',', '.'); ?> /Hari
                                        </h4>
                                    </div>


                                        <!-- Informasi Tambahan -->
                                        <div class="row text-start mb-4">
                                            <div class="col-12 mb-2">
                                                <i class="fa fa-car text-dark"></i> 
                                                <span class="text-body ms-1">Plat: <?php echo $row['no_plat']; ?></span>
                                            </div>
                                            <div class="col-12">
                                                <i class="fa fa-cogs text-dark"></i> 
                                                <span class="text-body ms-1">Status: <?php echo ucfirst($row['status']); ?></span>
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-between">
                                        <?php if ($role === 'admin'): ?>
                                            <a href="editmobil.php?id=<?php echo $row['id']; ?>" class="btn btn-warning rounded-pill py-2 px-3">Edit</a>
                                            <a href="hapusmobil.php?id=<?php echo $row['id']; ?>" class="btn btn-danger rounded-pill py-2 px-3" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['username'])): ?>
                                            <a href="booking.php?id=<?php echo $row['id']; ?>" 
                                            class="btn rounded-pill py-2 px-3 booking-btn" style="background-color: #ff4d4d; border-color: #ff4d4d; color: #ffffff;">Booking</a>
                                        <?php else: ?>
                                            <p class="text-danger">Silakan login untuk melakukan booking.</p>
                                        <?php endif; ?>
                                       </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada data mobil tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
                    

        


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
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>SewaAja</a></span>
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