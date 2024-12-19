<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $username = $_SESSION['username'] ?? 'Unknown';
        $this->userModel->setCurrentUser($username);
        return $this->render('users');
    }
}
