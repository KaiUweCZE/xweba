<?php
require_once 'controllers/Controller.php';

class OthersController extends Controller {
    public function index() {
        return $this->render('others');
    }
}
