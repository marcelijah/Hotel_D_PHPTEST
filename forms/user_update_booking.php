<?php
session_start();
require_once '../database.php';

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: ../Loginpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    $user_id = $_SESSION['user_id'];
    
    $room_type = $_POST['Zimmer'];
    $check_in = $_POST['Check-in'];
    $check_out = $_POST['Check-out'];
    $guests = (int)$_POST['Personen'];
    $today = date('Y-m-d');

    // 1. Validierung
    if ($check_in < $today) {
        header("Location: ../EditBooking.php?id=$booking_id&error=Date cannot be in the past");
        exit;
    }
    if ($check_out <= $check_in) {
        header("Location: ../EditBooking.php?id=$booking_id&error=Check-out must be after Check-in");
        exit;
    }

    // 2. Gehört die Buchung dem User?
    $stmtCheck = $conn->prepare("SELECT booking_id FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmtCheck->bind_param("ii", $booking_id, $user_id);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows === 0) {
        die("Unauthorized access.");
    }
    $stmtCheck->close();

    // 3. Preis pro Nacht holen
    $stmtPrice = $conn->prepare("SELECT price, capacity FROM room_types WHERE name = ?");
    $stmtPrice->bind_param("s", $room_type);
    $stmtPrice->execute();
    $roomData = $stmtPrice->get_result()->fetch_assoc();
    $stmtPrice->close();

    if (!$roomData) die("Room type not found");

    $pricePerNight = $roomData['price'];
    $maxCapacity = $roomData['capacity'];

    // 4. Verfügbarkeit prüfen (WICHTIG: Eigene Buchung ausschließen!)
    // Wir zählen alle Buchungen für diesen Raumtyp im Zeitraum, ABER ignorieren unsere eigene booking_id
    $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                 WHERE room_type = ? 
                 AND check_in < ? 
                 AND check_out > ?
                 AND booking_id != ?"; // <--- Das ist der Trick!
    
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param("sssi", $room_type, $check_out, $check_in, $booking_id);
    $stmtCount->execute();
    $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
    $stmtCount->close();

    if ($current_active >= $maxCapacity) {
        header("Location: ../EditBooking.php?id=$booking_id&error=Sorry, no availability for these dates!");
        exit;
    }

    // 5. Neuen Preis berechnen
    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $tage = $date2->diff($date1)->days;
    $new_total_price = $tage * $pricePerNight;

    // 6. Update in der Datenbank
    $stmtUpdate = $conn->prepare("UPDATE bookings SET room_type=?, check_in=?, check_out=?, guests=?, total_price=? WHERE booking_id=? AND user_id=?");
    $stmtUpdate->bind_param("sssidii", $room_type, $check_in, $check_out, $guests, $new_total_price, $booking_id, $user_id);

    if ($stmtUpdate->execute()) {
        header("Location: ../Mybookingspage.php?updated=1");
        exit;
    } else {
        echo "Database Error: " . $conn->error;
    }
}
?>