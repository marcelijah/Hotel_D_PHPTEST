<?php
session_start();
require 'users.php'; // nur laden, nicht überschreiben!

$email = $_POST['email'] ?? '';
$passwort = $_POST['Passwort'] ?? '';

$found = false;
foreach($_SESSION['users'] as $key => $user) {
    if ($user['email'] === $email && $user['passwort'] === $passwort) {
        $_SESSION['loggedin'] = $key;
        $_SESSION['role'] = $user['role']; // Rolle speichern
        $found = true;
        break;
    }
}

if ($found) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin.php"); // Admin weiterleiten
    } else {
        header("Location: ../Homepage.php"); // Normalen User weiterleiten
    }
    exit;
} else {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Anmelden.php");
    exit;
}

?>