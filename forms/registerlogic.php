<?php
session_start();
// Datenbankverbindung einbinden
require_once __DIR__ . "/../database.php";

// --- EINGABEN VERARBEITEN ---
// Daten aus dem HTML-Formular abrufen. Der "Null Coalescing Operator" (??)
// verhindert Fehler, falls ein Feld nicht gesendet wurde (setzt dann leeren String).
$vorname = $_POST['Vorname'] ?? '';
$nachname = $_POST['Nachname'] ?? '';
$email = $_POST['email'] ?? '';
$passwortRaw = $_POST['Passwort'] ?? '';

// 1. Validierung: Sind alle Felder ausgefüllt?
if(empty($vorname) || empty($nachname) || empty($email) || empty($passwortRaw)) {
    // Fehler in Session speichern und zurück zum Formular leiten
    $_SESSION['register_error'] = "Bitte alle Felder ausfüllen!";
    header("Location: ../Registrationpage.php");
    exit;
}

try {
    // 2. Dubletten-Check: Prüfen, ob E-Mail bereits existiert
    // ACHTUNG: Spaltenname ist `E-Mail` (mit Bindestrich), daher in Backticks `...`
    $checkStmt = $conn->prepare("SELECT ID FROM users WHERE `E-Mail` = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    // Wenn mehr als 0 Zeilen gefunden werden, gibt es die Mail schon
    if ($checkStmt->num_rows > 0) {
        $_SESSION['register_error'] = "Diese E-Mail ist bereits registriert!";
        header("Location: ../Registrationpage.php");
        exit;
    }
    $checkStmt->close();

    // 3. User speichern
    // Passwort sicher hashen (niemals Klartext speichern!)
    $passwortHash = password_hash($passwortRaw, PASSWORD_DEFAULT);
    $isAdmin = 0; // Standard-User ist kein Admin

    // SQL-Insert vorbereiten
    // Wir mappen hier auf die Tabellenspalten: `First Name`, `Surname`, `E-Mail`, `Password`, `isAdmin`
    $sql = "INSERT INTO users (`First Name`, `Surname`, `E-Mail`, `Password`, `isAdmin`) VALUES (?, ?, ?, ?, ?)";
    
    $insertStmt = $conn->prepare($sql);
    
    // Parameter binden: "ssssi" steht für String, String, String, String, Integer
    $insertStmt->bind_param("ssssi", $vorname, $nachname, $email, $passwortHash, $isAdmin);
    
    // Ausführen
    if ($insertStmt->execute()) {
        // --- REGISTRIERUNG ERFOLGREICH ---
        
        // User direkt einloggen (Session setzen)
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $conn->insert_id; // Die ID des neuen Users
        $_SESSION['user_name'] = $vorname;       // Für die Begrüßung "Welcome ..."
        
        // Weiterleitung zur Startseite
        header("Location: ../Homepage.php");
        exit;
    } else {
        throw new Exception("Speichern fehlgeschlagen.");
    }

} catch (Exception $e) {
    // Fehler abfangen (z.B. Datenbank-Probleme) und anzeigen
    $_SESSION['register_error'] = "Fehler: " . $e->getMessage();
    header("Location: ../Registrationpage.php");
    exit;
}
?>