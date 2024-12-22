<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (isset($_SESSION['user_id'])) {
            $this->userModel->setCurrentUser($_SESSION['user_id']);
            error_log("Setting current user from session: " . $_SESSION['user_id']);
        }
    }

    public function index() {
        error_log("Session data: " . print_r($_SESSION, true));
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $message = $_SESSION['message'] ?? ''; 
        unset($_SESSION['message']); 

        // Zpracování POST požadavků
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['action'])) {
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

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
                    if (!$isAjax) {
                        $_SESSION['message'] = $message; // Uložíme message do session
                        header('Location: index.php?page=users');
                        exit;
                    }
                
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
                    error_log('Deleting user: ' . $_POST['id']);
                    $this->userModel->deleteUser($_POST['id']);
                    $message = 'Uživatel byl úspěšně smazán.';
                    if (!$isAjax) {
                        header('Location: index.php?page=users');
                        exit;
                    }
                    break;
            }
        }

        $currentUser = $this->userModel->getCurrentUser();
        error_log("Current user from model: " . print_r($currentUser, true));

        // Data pro view
        $data = [
            'users' => $this->userModel->getAllUsers(),
            'message' => $message,
            'currentUser' => $this->userModel->getCurrentUser()
        ];
        error_log("Data for view: " . print_r($data, true));

        // Předáme data do view
        $_SESSION['view_data'] = $data;
        return $this->render('users');
    }
}


/*
<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (isset($_SESSION['user_id'])) {
            $this->userModel->setCurrentUser($_SESSION['user_id']);
            error_log("Setting current user from session: " . $_SESSION['user_id']);
        }
    }

    public function index() {
        error_log("Session data: " . print_r($_SESSION, true));
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $message = '';

        // Zpracování POST požadavků
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['action'])) {
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                     strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
            
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
                    if (!$isAjax) {
                        header('Location: index.php?page=users');
                        exit;
                    }
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
                    if (!$isAjax) {
                        header('Location: index.php?page=users');
                        exit;
                    }
                    break;

                case 'delete':
                    error_log('Deleting user: ' . $_POST['id']);
                    $this->userModel->deleteUser($_POST['id']);
                    $message = 'Uživatel byl úspěšně smazán.';
                    if (!$isAjax) {
                        header('Location: index.php?page=users');
                        exit;
                    }
                    break;
            }
        }

        $currentUser = $this->userModel->getCurrentUser();
        error_log("Current user from model: " . print_r($currentUser, true));

        // Data pro view
        $data = [
            'users' => $this->userModel->getAllUsers(),
            'message' => $message,
            'currentUser' => $currentUser
        ];
        error_log("Data for view: " . print_r($data, true));

        // Předáme data do view
        $_SESSION['view_data'] = $data;
        return $this->render('users');
    }
}

*/