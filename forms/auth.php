<?php
require 'users.php';

// Prüfen, ob Benutzer eingeloggt ist
$isLoggedIn = false;
$loggedInUser = '';

if (isset($_SESSION['email']) && isset($_SESSION['users'][$_SESSION['email']])) {
    $isLoggedIn = true;
    $loggedInUser = $_SESSION['users'][$_SESSION['email']]['vorname'];
}
?>
