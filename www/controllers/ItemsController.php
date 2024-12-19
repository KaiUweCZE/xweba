<?php
require_once 'controllers/Controller.php';

class ItemsController extends Controller {
    public function index() {
        return $this->render('items');
    }
}
