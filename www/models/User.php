<?php
class User {
    private $db;
    private $currentUser;

    public function __construct() {
        try {
            // Připojení k databázi - používáme název služby 'db' z docker-compose
            $this->db = new PDO(
                "mysql:host=db;dbname=mojedatabaze",
                "uzivatel",
                "heslo"
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log error nebo throw new Exception s lepší zprávou
            throw new Exception("Nepodařilo se připojit k databázi: " . $e->getMessage());
        }
    }
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($email, $firstname, $lastname, $phone = '', $office = '', $description = '', $password = '', $role = 'User') {
        $stmt = $this->db->prepare("INSERT INTO users (email, firstname, lastname, phone, office, description, password, role) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $email, 
            $firstname, 
            $lastname, 
            $phone, 
            $office, 
            $description, 
            $password,
            //password_hash($password, PASSWORD_DEFAULT), // Hashování hesla
            $role
        ]);
    }

    public function updateUser($id, $email, $firstname, $lastname, $phone = '', $office = '', $description = '', $password = null, $role = 'User') {
        // Kontrola oprávnění
        if (!$this->canEditUser($id)) {
            return false;
        }

        if ($password !== null) {
            $sql = "UPDATE users SET email = ?, firstname = ?, lastname = ?, phone = ?, 
                    office = ?, description = ?, password = ?, role = ? WHERE id = ?";
            $params = [$email, $firstname, $lastname, $phone, $office, $description, $password
                     /* password_hash($password, PASSWORD_DEFAULT)*/, $role, $id];
        } else {
            $sql = "UPDATE users SET email = ?, firstname = ?, lastname = ?, phone = ?, 
                    office = ?, description = ?, role = ? WHERE id = ?";
            $params = [$email, $firstname, $lastname, $phone, $office, $description, $role, $id];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteUser($id) {
        // Kontrola oprávnění
        if (!$this->canEditUser($id)) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function canEditUser($userId) {
        if (!$this->currentUser) {
            return false;
        }

        // Získáme aktuálního uživatele
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$this->currentUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Správci mohou editovat všechny
        if ($user['role'] === 'Administrator') {
            return true;
        }

        // Běžní uživatelé mohou editovat pouze sebe
        return $userId == $this->currentUser;
    }

    public function getCurrentUser() {
        error_log("Getting current user, currentUser ID is: " . print_r($this->currentUser, true));
        
        if (!$this->currentUser) {
            error_log("No current user set");
            return null;
        }
        $user = $this->getUserById($this->currentUser);
        error_log("Retrieved user data: " . print_r($user, true));
        return $user;
    }
    
    public function setCurrentUser($userId) {
        error_log("Setting current user ID to: " . $userId);
        $this->currentUser = $userId;
    }
}