<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['logged_in'] = true;
            header('Location: index.php');
            exit;
        }
        return $this->render('login');
    }

    public function logout() {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
