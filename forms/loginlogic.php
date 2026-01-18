<?php
session_start();

// Datenbankverbindung einbinden
require_once __DIR__ . "/../database.php";

// 1. Eingaben holen und säubern (Leerzeichen entfernen)
$email = trim($_POST['email'] ?? '');
$passwort = $_POST['Passwort'] ?? '';

// 2. Validierung: Sind die Felder ausgefüllt?
if ($email === '' || $passwort === '') {
    $_SESSION['login_error'] = "Bitte E-Mail und Passwort eingeben.";
    header("Location: ../Loginpage.php");
    exit;
}

// 3. SQL-Abfrage vorbereiten
// Wir holen ID, Passwort-Hash, Admin-Status und Vornamen (für die Begrüßung)
$stmt = $conn->prepare("SELECT `ID`, `Password`, `isAdmin`, `First Name` FROM `users` WHERE `E-Mail` = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// 4. Prüfen: Wurde ein User gefunden?
if (!$user) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

// 5. Prüfen: Stimmt das Passwort? (Vergleich Eingabe mit Hash in DB)
if (!password_verify($passwort, $user['Password'])) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

// --- Login erfolgreich! ---

// Session Variablen setzen
$_SESSION['loggedin']  = true;                 // Flag für eingeloggten Zustand
$_SESSION['user_id']   = (int)$user['ID'];
$_SESSION['user_name'] = $user['First Name'];
$_SESSION['is_admin']  = (int)$user['isAdmin'];

// 6. Weiterleitung je nach Rolle (Admin oder User)
if ($_SESSION['is_admin'] === 1) {
    header("Location: ../Adminpage.php");
} else {
    header("Location: ../Homepage.php");
}
exit;
?>