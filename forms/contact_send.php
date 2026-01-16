<?php
session_start();
require_once '../database.php'; // Verbindung zur DB holen

// Upload-Ordner sicherstellen
$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Daten säubern
    $vorname = trim($_POST['Vorname']);
    $nachname = trim($_POST['Nachname']);
    $fullName = $vorname . ' ' . $nachname;
    $email = trim($_POST['email']);
    $nachricht = trim($_POST['Nachricht']);

    $attachmentPath = null; // Standard: Kein Anhang

    // 2. File Upload Logik
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['attachment']['name']);
        // Einzigartigen Namen generieren, damit nichts überschrieben wird
        $targetFile = time() . "_" . $fileName; 
        $targetPathFull = $uploadDir . $targetFile;
        
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPathFull)) {
            // Wir speichern nur den Dateinamen (oder relativen Pfad) in der DB
            $attachmentPath = $targetFile;
        }
    }

    // 3. In die Datenbank speichern (statt E-Mail senden)
    $stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text, attachment_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $nachricht, $attachmentPath);

    if ($stmt->execute()) {
        // Erfolg
        header("Location: ../Contactpage.php?status=success");
        exit;
    } else {
        // DB Fehler
        header("Location: ../Contactpage.php?status=error");
        exit;
    }

} else {
    header("Location: ../Contactpage.php");
    exit;
}
?>