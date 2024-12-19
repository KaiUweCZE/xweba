<?php
session_start();

// Pokud je uživatel již přihlášen, přesměrujeme ho na index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Zpracování přihlašovacího formuláře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Uložíme uživatelské jméno do session
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['logged_in'] = true;
    
    // Přesměrování na hlavní stránku
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./bootstrap.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Přihlášení</h2>
                        <form method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Uživatelské jméno</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Heslo</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Přihlásit se</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
