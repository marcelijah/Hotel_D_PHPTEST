<?php
session_start();
require_once '../database.php';

// Nur eingeloggte User
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: ../Loginpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    $user_id = $_SESSION['user_id'];

    // SICHERHEIT: Prüfen, ob die Buchung wirklich diesem User gehört!
    // Wir löschen nur, wenn user_id und booking_id übereinstimmen.
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Erfolgreich gelöscht
        header("Location: ../Mybookingspage.php?deleted=1");
        exit;
    } else {
        // Entweder DB Fehler oder Buchung gehörte nicht dem User
        die("Error: Could not cancel booking. Unauthorized or ID not found.");
    }
}
?>