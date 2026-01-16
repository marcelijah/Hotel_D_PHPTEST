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
    
    // Daten aus dem Formular
    $room_type = $_POST['zimmer'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $guests = (int)$_POST['personen'];
    $total_price = (float)$_POST['gesamtpreis'];

    // --- KAPAZITÄTS-CHECK (Wiederholung zur Sicherheit) ---
    $stmtMax = $conn->prepare("SELECT capacity FROM room_types WHERE name = ?");
    $stmtMax->bind_param("s", $room_type);
    $stmtMax->execute();
    $resMax = $stmtMax->get_result();
    $rowMax = $resMax->fetch_assoc();
    $stmtMax->close();

    if (!$rowMax) { die("Fehler: Zimmertyp existiert nicht."); }
    $max_capacity = $rowMax['capacity'];

    $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                 WHERE room_type = ? 
                 AND check_in < ? 
                 AND check_out > ?";
    
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param("sss", $room_type, $check_out, $check_in);
    $stmtCount->execute();
    $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
    $stmtCount->close();

    if ($current_active >= $max_capacity) {
        header("Location: ../BookingErrorPage.php");
        exit;
    }

    // --- BUCHUNG SPEICHERN ---
    $stmtInsert = $conn->prepare("INSERT INTO bookings (user_id, room_type, check_in, check_out, guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("isssid", $user_id, $room_type, $check_in, $check_out, $guests, $total_price);

    if ($stmtInsert->execute()) {
        $booking_id = $conn->insert_id; // Die ID der neuen Buchung

        // --- USER STORY 1: EMAIL BESTÄTIGUNG SENDEN ---
        
        // 1. E-Mail Adresse des Users holen
        // (Achtung: Spaltenname ist `E-Mail` mit Bindestrich)
        $stmtUser = $conn->prepare("SELECT `E-Mail`, `First Name`, `Surname` FROM users WHERE ID = ?");
        $stmtUser->bind_param("i", $user_id);
        $stmtUser->execute();
        $userData = $stmtUser->get_result()->fetch_assoc();
        $stmtUser->close();

        if ($userData) {
            $to = $userData['E-Mail'];
            $name = $userData['First Name'] . " " . $userData['Surname'];
            $subject = "Booking Confirmation - Booking #$booking_id";
            
            $message = "Dear $name,\n\n";
            $message .= "Thank you for your reservation at EA Hotel!\n";
            $message .= "Here are your details:\n\n";
            $message .= "Booking ID: #$booking_id\n";
            $message .= "Room: $room_type\n";
            $message .= "Check-In: $check_in\n";
            $message .= "Check-Out: $check_out\n";
            $message .= "Guests: $guests\n";
            $message .= "Total Price: " . number_format($total_price, 2) . " €\n\n";
            $message .= "We look forward to welcoming you!\n";
            $message .= "Your EA Hotel Team";

            // Simulation: In Log-Datei schreiben statt mail()
            $logEntry = "--- EMAIL SENT (Booking Confirmation) ---\n";
            $logEntry .= "To: $to\n";
            $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
            $logEntry .= "Subject: $subject\n";
            $logEntry .= "Body:\n$message\n\n";
            
            file_put_contents(__DIR__ . '/../../email_log.txt', $logEntry, FILE_APPEND);
        }

        // Session bereinigen und weiterleiten
        unset($_SESSION['temp_booking']); 
        header("Location: ../MyBookingspage.php?success=1");
        exit;
    } else {
        echo "Datenbankfehler: " . $conn->error;
    }
}
?>