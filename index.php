<?php
// Pastikan sesi unik untuk situs ini
session_name('rental_session');
session_start();
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
                        <a href="kontak.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : ''; ?>">Kontak Kami</a>
                    </div>

                       
                </nav>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "username", "password", "19027_psas");

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mengambil data mobil
        $query = "SELECT id, nama, harga_sewa FROM mobil";
        $result_mobil = $conn->query($query);

        // Cek apakah query berhasil
        if (!$result_mobil) {
            die("Query gagal: " . $conn->error);
        }
        ?>

           <!-- Carousel Start -->
    <div class="header-carousel">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="img/pajero.jpeg" class="img-fluid w-100" alt="First slide"/>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">
                                <div class="col-lg-6 fadeInLeft animated" style="animation-delay: 1s;">
                                    <div class="bg-secondary rounded p-5">
                                        <h4 class="text-white mb-4">Form Booking </h4>
                                        <form action="booking.php" method="POST">
                                            <div class="mb-3">
                                                <label for="nama_pelanggan" class="form-label text-white">Nama Pelanggan:</label>
                                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama Anda" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label text-white">Nomor HP:</label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan Nomor HP Anda">
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_mobil" class="form-label text-white">Pilih Mobil:</label>
                                                <select class="form-select" id="id_mobil" name="id_mobil" required>
                                                    <option value="" selected disabled>Pilih Mobil</option>
                                                    <?php while ($row = $result_mobil->fetch_assoc()): ?>
                                                        <option value="<?php echo $row['id']; ?>">
                                                            <?php echo $row['nama']; ?> - Rp<?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?>/hari
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_booking" class="form-label text-white">Tanggal Booking:</label>
                                                <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="durasi_sewa" class="form-label text-white">Durasi Sewa (hari):</label>
                                                <input type="number" class="form-control" id="durasi_sewa" name="durasi_sewa" placeholder="Masukkan Berapa Hari Anda Menyewa" required>
                                            </div>
                                            <a href="#" class="btn booking-button w-100 py-2 text-center">Booking</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" style="animation-delay: 1s;">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">Jadikan Setiap Langkah Anda Lebih Efisien dengan Kami!</h1>
                                        <p>Rasakan Pengalaman Terbaik di SewaAja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


        <!-- Features Start -->
        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize mb-3">SewaAja <span class="text-primary">Fitur</span></h1>
                    <p class="mb-0">Temukan mobil yang Anda butuhkan dalam hitungan detik. Pilih jenis kendaraan, waktu sewa, dan lokasi, dan kami akan menampilkan pilihan terbaik untuk Anda. Proses pencarian yang simpel, hasil yang maksimal!
                    </p>
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-xl-4">
                        <div class="row gy-4 gx-0">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <span class="fa fa-trophy fa-2x"></span>
                                    </div>
                                    <div class="ms-4">
                                        <h5 class="mb-3">Beragam Pilihan Kendaraan</h5>
                                        <p class="mb-0">Dari city car hingga mobil mewah, SewaAja menyediakan berbagai jenis kendaraan sesuai dengan kebutuhan Anda.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <span class="fa fa-road fa-2x"></span>
                                    </div>
                                    <div class="ms-4">
                                        <h5 class="mb-3">Reservasi Mudah 24/7</h5>
                                        <p class="mb-0"> Booking kapan saja, di mana saja, langsung dari website.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="img/pajeroputih.jpeg" class="img-fluid w-100" style="object-fit: cover;" alt="Img">
                    </div>
                    <div class="col-xl-4">
                        <div class="row gy-4 gx-0">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="feature-item justify-content-end">
                                    <div class="text-end me-4">
                                        <h5 class="mb-3">Mobil Terawat</h5>
                                        <p class="mb-0">Semua kendaraan kami dalam kondisi prima untuk perjalanan Anda.</p>
                                    </div>
                                    <div class="feature-icon">
                                        <span class="fa fa-tag fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="feature-item justify-content-end">
                                    <div class="text-end me-4">
                                        <h5 class="mb-3">Akses Mudah dan Cepat ke Semua Lokasi</h5>
                                        <p class="mb-0">Dengan jaringan lokasi yang luas, Anda bisa menemukan kendaraan kami di berbagai titik strategis, termasuk bandara, stasiun, dan pusat kota, 
                                                        memudahkan Anda untuk memulai perjalanan dengan cepat.</p>
                                    </div>
                                    <div class="feature-icon">
                                        <span class="fa fa-map-pin fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features End -->

        

        <!-- Fact Counter -->
        <div class="container-fluid counter bg-secondary py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-thumbs-up fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">829</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Tanggapan Klien</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-car-alt fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">56</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Jumlah Mobil</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">127</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Pusat Mobil</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="counter-item text-center">
                            <div class="counter-item-icon mx-auto">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div class="counter-counting my-3">
                                <span class="text-white fs-2 fw-bold" data-toggle="counter-up">589</span>
                                <span class="h1 fw-bold text-white">+</span>
                            </div>
                            <h4 class="text-white mb-0">Total Kilometer</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Counter -->


        

        

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

        <!-- style css -->
        <style>
            .form-label {
                text-align: left; /* memastikan label rata kiri */
                display: block;   /* membuat label sebagai block untuk mengambil seluruh lebar */
                margin-bottom: 5px; /* sedikit jarak antara label dan input */
            }
            .booking-button {
    background-color: red; /* Warna kotak default merah */
    color: white; /* Warna teks putih */
    text-decoration: none;
    display: inline-block;
    border: none;
    text-align: center;
    font-weight: bold;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.booking-button:hover {
    background-color: white; /* Latar menjadi putih saat disentuh */
    color: red; /* Teks tetap merah */
}

            </style>
        
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