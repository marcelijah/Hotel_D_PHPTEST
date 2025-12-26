<?php
session_start();

// Datenbankverbindung holen
require_once __DIR__ . "/../database.php";

// Eingaben holen und säubern
$email = trim($_POST['email'] ?? '');
$passwort = $_POST['Passwort'] ?? '';

// Prüfen, ob Felder leer sind
if ($email === '' || $passwort === '') {
    $_SESSION['login_error'] = "Bitte E-Mail und Passwort eingeben.";
    header("Location: ../Loginpage.php");
    exit;
}

// SQL-Abfrage vorbereiten
// WICHTIG: Wir brauchen auch `First Name` für die Begrüßung im Header!
$stmt = $conn->prepare("SELECT `ID`, `Password`, `isAdmin`, `First Name` FROM `users` WHERE `E-Mail` = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// 1. Prüfen: Gibt es den User überhaupt?
if (!$user) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

// 2. Prüfen: Stimmt das Passwort? (Hash Vergleich)
if (!password_verify($passwort, $user['Password'])) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

// --- Login erfolgreich! ---

// Session Variablen setzen (damit der Header funktioniert)
$_SESSION['loggedin'] = true;               // Wichtig für den Header-Check
$_SESSION['user_id'] = (int)$user['ID'];
$_SESSION['user_name'] = $user['First Name']; // Wichtig für "Welcome King Cel"
$_SESSION['is_admin'] = (int)$user['isAdmin'];

// Weiterleitung je nach Rolle
if ($_SESSION['is_admin'] === 1) {
    // Admin kommt auf die Adminseite
    header("Location: ../Adminpage.php");
} else {
    // Normaler User kommt auf die Homepage
    header("Location: ../Homepage.php");
}
exit;