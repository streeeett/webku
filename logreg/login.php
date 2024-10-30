<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .kotak_login {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .tulisan_login {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
        }

        .form_login {
            margin-bottom: 15px;
        }

        .tombol_login {
            width: 100%;
            margin-top: 10px;
        }

        .alert {
            margin-top: 10px;
        }

        .link {
            margin: 10px;
            text-decoration: none;
            color: #0d6efd;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php 
    if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
        echo "<div class='alert alert-danger text-center'>Username dan Password tidak sesuai!</div>";
    }
    ?>

    <div class="kotak_login">
        <p class="tulisan_login">Silahkan Login</p>

        <form action="../connection/proses_login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control form_login" id="username" name="username" 
                       placeholder="Username .." required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control form_login" id="email" name="email" 
                       placeholder="Email .." required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control form_login" id="password" name="password" 
                       placeholder="Password .." required>
            </div>

            <button type="submit" class="btn btn-primary tombol_login">LOGIN</button>

            <div class="text-center mt-3">
                <a class="link" href="../halaman.php">Kembali</a>
                <a class="link" href="register.php">Register</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
