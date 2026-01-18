<?php
session_start();
// Datenbankverbindung einbinden
require_once '../database.php'; 

// --- KONFIGURATION UPLOAD-ORDNER ---
// Wir definieren den Pfad, wo Anhänge gespeichert werden sollen.
// __DIR__ verweist auf den aktuellen Ordner (forms), also gehen wir eins hoch (..) und dann in 'uploads'.
$uploadDir = __DIR__ . '/../uploads/';

// Prüfen, ob der Ordner existiert. Falls nicht, erstellen wir ihn.
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // 0777 gibt Schreibrechte
}

// --- FORMULAR VERARBEITUNG ---
// Prüfen, ob die Seite via POST (durch das Formular) aufgerufen wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Daten aus dem Formular holen und säubern
    // trim() entfernt Leerzeichen am Anfang und Ende
    $vorname = trim($_POST['Vorname']);
    $nachname = trim($_POST['Nachname']);
    $fullName = $vorname . ' ' . $nachname; // Zusammensetzen des vollen Namens
    $email = trim($_POST['email']);
    $nachricht = trim($_POST['Nachricht']);

    $attachmentPath = null; // Standardwert: Kein Anhang vorhanden

    // 2. Datei-Upload Logik
    // Prüfen: Wurde eine Datei gesendet UND gab es keinen Fehler?
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        
        $fileName = basename($_FILES['attachment']['name']); // Original-Dateiname
        
        // Einzigartigen Namen generieren: aktueller Zeitstempel + Originalname
        // Verhindert, dass gleichnamige Dateien überschrieben werden
        $targetFile = time() . "_" . $fileName; 
        $targetPathFull = $uploadDir . $targetFile;
        
        // Versuchen, die Datei vom temporären Ordner in unseren Zielordner zu verschieben
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPathFull)) {
            // Wenn das Verschieben geklappt hat, merken wir uns den Dateinamen für die Datenbank
            $attachmentPath = $targetFile;
        }
    }

    // 3. Nachricht in die Datenbank speichern
    // Wir nutzen Prepared Statements gegen SQL-Injections
    $stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text, attachment_path) VALUES (?, ?, ?, ?)");
    
    // "ssss" bedeutet: 4 Strings (Name, Email, Nachricht, Pfad)
    $stmt->bind_param("ssss", $fullName, $email, $nachricht, $attachmentPath);

    if ($stmt->execute()) {
        // Erfolgreich gespeichert -> Weiterleitung zur Kontaktseite mit Erfolgsmeldung
        header("Location: ../Contactpage.php?status=success");
        exit;
    } else {
        // Datenbankfehler -> Weiterleitung mit Fehlermeldung
        header("Location: ../Contactpage.php?status=error");
        exit;
    }

} else {
    // Falls jemand die Datei direkt aufruft (ohne Formular), zurückschicken
    header("Location: ../Contactpage.php");
    exit;
}
?>