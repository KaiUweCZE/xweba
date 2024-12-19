<?php
require_once 'controllers/Controller.php';

class ErrorController extends Controller {
    public function index() {
        return $this->render('error');
    }
}
