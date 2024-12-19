<?php
session_start();

// Zrušíme session
session_destroy();

// Přesměrování na přihlašovací stránku
header('Location: login.php');
exit;
