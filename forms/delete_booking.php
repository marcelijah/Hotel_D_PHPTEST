<?php
session_start();
require_once '../database.php';

// Nur Admin darf löschen
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: ../Homepage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];

    // Buchung löschen (Kapazität wird dadurch automatisch frei)
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        header("Location: ../Checkbookingspage.php?deleted=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>