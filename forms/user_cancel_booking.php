<?php
session_start();
// Datenbankverbindung einbinden
require_once '../database.php';

// --- SICHERHEITS-CHECK: LOGIN ---
// Prüfen, ob der User überhaupt eingeloggt ist.
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    // Falls nicht, zur Login-Seite schicken
    header("Location: ../Loginpage.php");
    exit;
}

// --- STORNIERUNGS-LOGIK ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Daten holen
    $booking_id = (int)$_POST['booking_id'];
    $user_id = $_SESSION['user_id'];

    // --- SICHERHEITS-CHECK: EIGENTUM ---
    // WICHTIG: Wir prüfen, ob die Buchung (booking_id) auch wirklich 
    // dem aktuell eingeloggten User (user_id) gehört!
    // Der SQL-Befehl löscht NUR, wenn beide IDs in einer Zeile übereinstimmen.
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);

    // Ausführen und prüfen
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Erfolgreich gelöscht (affected_rows > 0 bedeutet, es wurde tatsächlich eine Zeile entfernt)
        header("Location: ../Mybookingspage.php?deleted=1");
        exit;
    } else {
        // Fehlerfall:
        // Entweder DB-Fehler oder (wahrscheinlicher) die Buchung gehörte nicht dem User 
        // oder existierte gar nicht mehr.
        die("Error: Could not cancel booking. Unauthorized or ID not found.");
    }
}
?>