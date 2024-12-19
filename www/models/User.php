<?php
class User {
    private $currentUser;

    public function setCurrentUser($username) {
        $this->currentUser = $username;
    }

    public function getCurrentUser() {
        return $this->currentUser;
    }
}
