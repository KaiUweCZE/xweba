<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $message = '';

        // Zpracování POST požadavků
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['action'])) {
            switch ($action) {
                case 'add':
                    $this->userModel->addUser(
                        $_POST['email'],
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['phone'] ?? '',
                        $_POST['office'] ?? '',
                        $_POST['description'] ?? '',
                        $_POST['password'],
                        $_POST['role']
                    );
                    $message = 'Uživatel byl úspěšně přidán.';
                    break;

                case 'edit':
                    $this->userModel->updateUser(
                        $_POST['id'],
                        $_POST['email'],
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['phone'] ?? '',
                        $_POST['office'] ?? '',
                        $_POST['description'] ?? '',
                        !empty($_POST['password']) ? $_POST['password'] : null,
                        $_POST['role']
                    );
                    $message = 'Uživatel byl úspěšně upraven.';
                    break;

                case 'delete':
                    $this->userModel->deleteUser($_POST['id']);
                    $message = 'Uživatel byl úspěšně smazán.';
                    break;
            }
        }

        // Data pro view
        $data = [
            'users' => $this->userModel->getAllUsers(),
            'message' => $message,
            'currentUser' => $this->userModel->getCurrentUser()
        ];

        // Předáme data do view
        $_SESSION['view_data'] = $data;
        return $this->render('users');
    }
}
