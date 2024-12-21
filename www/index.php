<?php
session_start();

// Získání aktuální stránky z URL
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Seznam povolených stránek a jejich kontrolerů
$controllers = [
    'dashboard' => 'DashboardController',
    'items' => 'ItemsController',
    'others' => 'OthersController',
    'users' => 'UsersController',
    'login' => 'AuthController',
    'logout' => 'AuthController'
];

// Kontrola přihlášení pro všechny stránky kromě login
if ($page !== 'login' && (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)) {
    header('Location: index.php?page=login');
    exit;
}

// Kontrola, zda stránka existuje
if (!array_key_exists($page, $controllers)) {
    $page = 'error';
}

// Načtení kontroleru
$controllerName = $controllers[$page] ?? 'ErrorController';
require_once "controllers/{$controllerName}.php";

// Vytvoření instance kontroleru a spuštění akce
$controller = new $controllerName();

// Volání správné metody podle stránky
if ($page === 'login') {
    $content = $controller->login();
} elseif ($page === 'logout') {
    $content = $controller->logout();
} else {
    $content = $controller->index();
}

// Pokud jsme na login stránce, zobrazíme jen login template
if ($page === 'login') {
    echo $content;
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Simple Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./bootstrap-icons.css">
    <link rel="stylesheet" href="./custom.css">
</head>

<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
}

.sidebar-sticky {
    height: calc(100vh - 48px);
    overflow-x: hidden;
    overflow-y: auto;
}
</style>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <button class="navbar-toggler d-md-none collapsed m-2 b-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="?page=dashboard">simple administration</a>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="index.php?page=logout">logout</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="?page=dashboard" class="nav-link <?php echo $page === 'dashboard' ? 'active' : 'link-dark'; ?>">
                                <span class="icon">
                                    <i class="bi bi-easel"></i>
                                </span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="?page=items" class="nav-link <?php echo $page === 'items' ? 'active' : 'link-dark'; ?>">
                                <span class="icon">
                                    <i class="bi bi-card-list"></i>
                                </span>
                                Items
                            </a>
                        </li>
                        <li>
                            <a href="?page=others" class="nav-link <?php echo $page === 'others' ? 'active' : 'link-dark'; ?>">
                                <span class="icon">
                                    <i class="bi bi-box"></i>
                                </span>
                                Others
                            </a>
                        </li>
                        <li>
                            <a href="?page=users" class="nav-link <?php echo $page === 'users' ? 'active' : 'link-dark'; ?>">
                                <span class="icon">
                                    <i class="bi bi-person-circle"></i>
                                </span>
                                Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">
                <?php echo $content; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>