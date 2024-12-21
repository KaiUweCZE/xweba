<?php
class Controller {
    protected function render($view) {
        ob_start();
        include "views/{$view}.php";
        return ob_get_clean();
    }
}
