<?php
class User {
    private $currentUser;
    private $users = [];

    public function __construct() {
        // Načteme uživatele ze session (dočasné řešení místo databáze)
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [
                ['id' => 1, 'username' => 'admin', 'email' => 'admin@example.com', 'role' => 'Administrator'],
                ['id' => 2, 'username' => 'user', 'email' => 'user@example.com', 'role' => 'User']
            ];
        }
        $this->users = $_SESSION['users'];
    }

    public function setCurrentUser($username) {
        $this->currentUser = $username;
    }

    public function getCurrentUser() {
        return $this->currentUser;
    }

    public function getAllUsers() {
        return $this->users;
    }

    public function addUser($username, $email, $role) {
        $id = count($this->users) + 1;
        $user = [
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'role' => $role
        ];
        $this->users[] = $user;
        $_SESSION['users'] = $this->users;
        return $user;
    }

    public function updateUser($id, $username, $email, $role) {
        foreach ($this->users as $key => $user) {
            if ($user['id'] == $id) {
                $this->users[$key] = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'role' => $role
                ];
                $_SESSION['users'] = $this->users;
                return true;
            }
        }
        return false;
    }

    public function deleteUser($id) {
        foreach ($this->users as $key => $user) {
            if ($user['id'] == $id) {
                unset($this->users[$key]);
                $this->users = array_values($this->users); // Reindexuje pole
                $_SESSION['users'] = $this->users;
                return true;
            }
        }
        return false;
    }

    public function getUserById($id) {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
}
