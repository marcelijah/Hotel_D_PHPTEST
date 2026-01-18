<?php
session_start();
// Datenbankverbindung einbinden
require_once '../database.php';

// --- SICHERHEITS-CHECK ---
// 1. Prüfen, ob der User eingeloggt ist
// 2. Prüfen, ob das Admin-Flag (is_admin) gesetzt und gleich 1 ist
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    // Falls nicht berechtigt: Zurück zur Startseite werfen
    header("Location: ../Homepage.php");
    exit;
}

// --- LÖSCHVORGANG ---
// Wir verarbeiten nur POST-Anfragen (Sicherer als GET für Löschaktionen)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Die ID der zu löschenden Buchung sicher als Integer holen
    $booking_id = (int)$_POST['booking_id'];

    // SQL-Befehl vorbereiten: Lösche Eintrag aus der Tabelle 'bookings'
    // Hinweis: Durch das Löschen wird die Kapazität des Zimmers für diesen Zeitraum 
    // automatisch wieder verfügbar (da die Verfügbarkeitsprüfung live zählt).
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);

    // Ausführen und prüfen, ob es geklappt hat
    if ($stmt->execute()) {
        // Erfolgreich -> Zurück zur Übersicht mit Erfolgsmeldung (?deleted=1)
        header("Location: ../Checkbookingspage.php?deleted=1");
        exit;
    } else {
        // Fehlerfall: Fehlermeldung ausgeben
        echo "Error: " . $conn->error;
    }
}
?>