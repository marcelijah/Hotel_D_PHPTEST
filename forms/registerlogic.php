<?php
session_start();
require_once __DIR__ . "/../database.php";

// Daten aus dem HTML-Formular
$vorname = $_POST['Vorname'] ?? '';
$nachname = $_POST['Nachname'] ?? '';
$email = $_POST['email'] ?? '';
$passwortRaw = $_POST['Passwort'] ?? '';

// 1. Validierung
if(empty($vorname) || empty($nachname) || empty($email) || empty($passwortRaw)) {
    $_SESSION['register_error'] = "Bitte alle Felder ausfüllen!";
    header("Location: ../Registrationpage.php");
    exit;
}

try {
    // 2. Prüfen, ob E-Mail existiert
    // ACHTUNG: Spaltenname ist `E-Mail` (mit Bindestrich), daher in Backticks `...`
    $checkStmt = $conn->prepare("SELECT ID FROM users WHERE `E-Mail` = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['register_error'] = "Diese E-Mail ist bereits registriert!";
        header("Location: ../Registrationpage.php");
        exit;
    }
    $checkStmt->close();

    // 3. User speichern
    $passwortHash = password_hash($passwortRaw, PASSWORD_DEFAULT);
    $isAdmin = 0; // Standard-User ist kein Admin

    // Hier mappen wir deine exakten Tabellen-Spalten:
    // `First Name`, `Surname`, `E-Mail`, `Password`, `isAdmin`
    $sql = "INSERT INTO users (`First Name`, `Surname`, `E-Mail`, `Password`, `isAdmin`) VALUES (?, ?, ?, ?, ?)";
    
    $insertStmt = $conn->prepare($sql);
    // "ssssi" steht für: String, String, String, String, Integer
    $insertStmt->bind_param("ssssi", $vorname, $nachname, $email, $passwortHash, $isAdmin);
    
    if ($insertStmt->execute()) {
        // Login-Session setzen
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_name'] = $vorname; // Oder $nachname, je nach Wunsch
        
        header("Location: ../Homepage.php");
        exit;
    } else {
        throw new Exception("Speichern fehlgeschlagen.");
    }

} catch (Exception $e) {
    $_SESSION['register_error'] = "Fehler: " . $e->getMessage();
    header("Location: ../Registrationpage.php");
    exit;
}
?>