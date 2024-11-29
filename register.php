<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; // Ambil role dari input form

    // Validasi role (hanya boleh admin atau pengunjung)
    if ($role !== 'admin' && $role !== 'pengunjung') {
        $error = "Role tidak valid!";
    } else {
        // Query untuk menyimpan data user baru
        $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $query->bind_param('sss', $username, $password, $role);
        if ($query->execute()) {
            header("Location: login.php"); // Arahkan ke halaman login setelah berhasil mendaftar
            exit;
        } else {
            $error = "Gagal mendaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link untuk font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Box untuk form */
        .register-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Membatasi lebar form */
        }

        .register-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .register-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Styling untuk label dengan font bold untuk username, password, dan role */
        .register-container label {
            font-weight: 400; /* Normal untuk label lainnya */
            font-size: 14px;
            text-align: left;
            color: #333;
        }

        .register-container label[for="username"],
        .register-container label[for="password"],
        .register-container label[for="role"] {
            font-weight: 600; /* Bold hanya untuk username, password, dan role */
        }

        /* Styling untuk input dan select dengan font Poppins */
        .register-container input,
        .register-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 400; /* Normal untuk teks dalam input dan select */
        }

        /* Button submit */
        .register-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Hover effect untuk button */
        .register-container button:hover {
            background-color: #0056b3;
        }

        /* Styling error message */
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        /* Styling untuk link */
        .register-container a {
            color: #007bff;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .register-container {
                padding: 20px;
            }

            input, select, button {
                padding: 12px;
                font-size: 16px;
            }
        }

    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username Anda" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye"></i> <!-- Ikon mata dari Font Awesome -->
            </span>
            
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="pengunjung">Pengunjung</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit">Daftar</button>
            <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>

