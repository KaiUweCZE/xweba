<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';

class DashboardController extends Controller {
    private $userModel;
    private $db;

    public function __construct() {
        $this->userModel = new User();
        $this->db = new PDO("mysql:host=db;dbname=mojedatabaze", "uzivatel", "heslo");
    }

    public function index() {
        // Získat posledních 10 přihlášení s daty uživatelů
        $query = "
            SELECT u.firstname, u.lastname, u.email, u.role, l.login_time
            FROM user_logins l
            JOIN users u ON l.user_id = u.id
            ORDER BY l.login_time DESC
            LIMIT 10
        ";
        
        $stmt = $this->db->query($query);
        $logins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data = [
            'logins' => $logins
        ];
        
        $_SESSION['view_data'] = $data;
        return $this->render('dashboard');
    }
}