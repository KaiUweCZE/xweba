<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        $error = '';
        error_log("Login attempt started"); // Debug log
    
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            error_log("User already logged in"); // Debug log
            header('Location: index.php');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['username'];
            $password = $_POST['password'];
            
            error_log("Login attempt for email: " . $email); // Debug log
            
            try {
                $users = $this->userModel->getAllUsers();
                error_log("Got users from DB: " . print_r($users, true)); // Debug log všech uživatelů
                
                $found = false;
                foreach ($users as $user) {
                    error_log("Checking user: " . $user['email']); // Debug log
                    error_log("Comparing: " . $user['password'] . " with: " . $password); // Debug log
                    
                    if ($user['email'] === $email && $user['password'] === $password) {
                        error_log("User found and password matches"); // Debug log
                        $found = true;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['logged_in'] = true;
                        
                        $this->userModel->setCurrentUser($user['id']);
                        
                        header('Location: index.php');
                        exit;
                    }
                }
                
                if (!$found) {
                    error_log("User not found or password doesn't match"); // Debug log
                    $error = 'Nesprávné přihlašovací údaje';
                }
            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage()); // Debug log
                $error = 'Chyba při přihlašování: ' . $e->getMessage();
            }
        }
    
        $data = [
            'error' => $error
        ];
        $_SESSION['view_data'] = $data;
        
        return $this->render('login');
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}