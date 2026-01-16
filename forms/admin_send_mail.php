<?php
session_start();
require_once '../database.php'; // DB Verbindung nötig

// Nur Admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['guest_email'];
    $subject = $_POST['subject'];
    $body = $_POST['message'];
    $booking_ref = (int)$_POST['booking_ref'];

    // 1. In die Datenbank speichern
    // Wir kombinieren Betreff und Nachricht, damit der User alles sieht
    $fullMessage = "$subject:\n$body";
    
    $stmt = $conn->prepare("UPDATE bookings SET admin_message = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $fullMessage, $booking_ref);
    $stmt->execute();

    // 2. Simulation: Loggen in email_log.txt (Weiterhin gut zur Kontrolle)
    $logEntry = "--- ADMIN MESSAGE TO USER (Saved in DB) ---\n";
    $logEntry .= "To: $to\n";
    $logEntry .= "Ref: Booking #$booking_ref\n";
    $logEntry .= "Message:\n$fullMessage\n\n";

    file_put_contents(__DIR__ . '/../email_log.txt', $logEntry, FILE_APPEND);

    // Zurück mit Erfolg
    echo "<script>
            alert('Message sent and visible to user!');
            window.location.href='../Checkbookingspage.php';
          </script>";
    exit;
}
?>