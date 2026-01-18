<?php
session_start();
// Verbindung zur Datenbank herstellen
require_once '../database.php'; 

// --- SICHERHEITS-CHECK ---
// Prüfen, ob der User eingeloggt ist UND ob er Admin-Rechte hat (is_admin = 1)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    die("Access denied"); // Skript sofort beenden, wenn kein Admin
}

// --- FORMULAR VERARBEITUNG ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Daten aus dem Absende-Formular holen
    $to = $_POST['guest_email'];
    $subject = $_POST['subject'];
    $body = $_POST['message'];
    $booking_ref = (int)$_POST['booking_ref']; // Sicherstellen, dass ID eine Zahl ist

    // 1. Nachricht in der Datenbank speichern
    // Wir kombinieren Betreff und Nachrichtentext, damit der User beides sieht
    $fullMessage = "$subject:\n$body";
    
    // SQL-Befehl vorbereiten: Nachricht in die 'bookings'-Tabelle schreiben
    $stmt = $conn->prepare("UPDATE bookings SET admin_message = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $fullMessage, $booking_ref);
    $stmt->execute();

    // 2. Simulation: E-Mail-Versand loggen
    // Statt eine echte Mail zu senden (was einen Mailserver braucht), schreiben wir in eine Textdatei.
    $logEntry = "--- ADMIN MESSAGE TO USER (Saved in DB) ---\n";
    $logEntry .= "To: $to\n";
    $logEntry .= "Ref: Booking #$booking_ref\n";
    $logEntry .= "Message:\n$fullMessage\n\n";

    // Inhalt an die Datei 'email_log.txt' anhängen (FILE_APPEND)
    file_put_contents(__DIR__ . '/../email_log.txt', $logEntry, FILE_APPEND);

    // 3. Erfolgsmeldung und Weiterleitung
    // Wir nutzen JavaScript für ein Popup und leiten dann zurück zur Buchungsübersicht
    echo "<script>
            alert('Message sent and visible to user!');
            window.location.href='../Checkbookingspage.php';
          </script>";
    exit;
}
?>