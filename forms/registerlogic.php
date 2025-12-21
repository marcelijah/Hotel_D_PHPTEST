<?php
session_start();

// Beispielhafte User-Daten (da keine Datenbank)
if(!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$vorname = $_POST['Vorname'] ?? '';
$nachname = $_POST['Nachname'] ?? '';
$email = $_POST['email'] ?? '';
$passwort = $_POST['Passwort'] ?? '';

// Prüfen, ob E-Mail bereits existiert
$email_exists = false;
foreach($_SESSION['users'] as $user) {
    if($user['email'] === $email) {
        $email_exists = true;
        break;
    }
}

if($email_exists) {
    $_SESSION['register_error'] = "Diese E-Mail ist bereits registriert!";
    header("Location: ../Registrationpage.php");
    exit;
} else {
    // Neuen User speichern
    $id = 'user' . (count($_SESSION['users']) + 1);
    $_SESSION['users'][$id] = [
        'vorname' => $vorname,
        'nachname' => $nachname,
        'email' => $email,
        'passwort' => $passwort,
        'role' => 'user' // neu hinzugefügt
    ];

    // Direkt einloggen
    $_SESSION['loggedin'] = $id;
    header("Location: ../Homepage.php");
    exit;
}
