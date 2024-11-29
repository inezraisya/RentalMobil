<?php
session_name('rental_session');
session_start();
include 'koneksi.php'; // Sambungan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi username dan password
    if ($user && password_verify($password, $user['password'])) {
        // Simpan data pengguna ke dalam sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Arahkan berdasarkan role
        if ($user['role'] == 'admin') {
            header("Location: index.php"); // Sesuaikan dengan halaman admin
        } else if ($user['role'] == 'pengunjung') {
            header("Location: daftarmobil.php");
        }
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .login-container label {
            font-weight: 500;
            font-size: 14px;
            text-align: left;
            color: #333;
        }
        .login-container input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-wrapper input {
            width: 100%;
            padding-right: 40px;
        }
        .password-wrapper .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }
        .login-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container p {
            margin-top: 10px;
            color: #555;
            text-align: center;
        }
        .login-container a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .login-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2> <!-- Tambahkan judul login -->
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Masukkan Username Anda" required>

        <label for="password">Password:</label>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye"></i> <!-- Ikon mata dari Font Awesome -->
            </span>
        </div>
        <button type="submit">Login</button>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash'); // Mengganti ikon menjadi mata tertutup
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye'); // Mengganti ikon menjadi mata terbuka
            }
        }
    </script>
</body>
</html>
