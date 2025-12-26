<?php
session_start();
require_once '../database.php';

// 1. Nur eingeloggte User dürfen buchen
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: ../Loginpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Daten aus dem Formular (Bookingdetailspage.php) empfangen
    $room_type = $_POST['zimmer'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $guests = (int)$_POST['personen'];
    $total_price = (float)$_POST['gesamtpreis'];

    // ---------------------------------------------------------
    // SICHERHEITS-CHECK (Der Türsteher)
    // Wir prüfen ein letztes Mal, ob INZWISCHEN jemand schneller war.
    // ---------------------------------------------------------

    // A: Kapazität holen
    $stmtMax = $conn->prepare("SELECT capacity FROM room_types WHERE name = ?");
    $stmtMax->bind_param("s", $room_type);
    $stmtMax->execute();
    $resMax = $stmtMax->get_result();
    $rowMax = $resMax->fetch_assoc();
    $stmtMax->close();

    if (!$rowMax) { die("Fehler: Zimmertyp existiert nicht."); }
    $max_capacity = $rowMax['capacity'];

    // B: Aktuelle Buchungen zählen
    $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                 WHERE room_type = ? 
                 AND check_in < ? 
                 AND check_out > ?";
    
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param("sss", $room_type, $check_out, $check_in);
    $stmtCount->execute();
    $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
    $stmtCount->close();

    // C: Wenn jetzt voll ist -> Ab zur Fehlerseite
    if ($current_active >= $max_capacity) {
        // Hier leiten wir auf die schöne BookingErrorPage weiter, 
        // weil das ein seltener "Unfall" ist (jemand war schneller).
        header("Location: ../BookingErrorPage.php");
        exit;
    }

    // ---------------------------------------------------------
    // ALLES OK -> SPEICHERN
    // ---------------------------------------------------------
    
    $stmtInsert = $conn->prepare("INSERT INTO bookings (user_id, room_type, check_in, check_out, guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("isssid", $user_id, $room_type, $check_in, $check_out, $guests, $total_price);

    if ($stmtInsert->execute()) {
        // Erfolg! Session bereinigen und zu MyBookings
        unset($_SESSION['temp_booking']); // Temporäre Daten löschen
        header("Location: ../MyBookingspage.php?success=1");
        exit;
    } else {
        echo "Datenbankfehler: " . $conn->error;
    }
}
?>