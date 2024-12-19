<?php
require_once 'controllers/Controller.php';

class DashboardController extends Controller {
    public function index() {
        return $this->render('dashboard');
    }
}
