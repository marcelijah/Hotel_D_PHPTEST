<?php
session_start();
// Datenbankverbindung einbinden
require_once '../database.php';

// --- SICHERHEITS-CHECK: LOGIN ---
// Nur eingeloggte User dürfen hier zugreifen
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: ../Loginpage.php");
    exit;
}

// --- FORMULAR VERARBEITUNG ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Daten aus dem Formular holen
    $booking_id = (int)$_POST['booking_id'];
    $user_id = $_SESSION['user_id'];
    
    $room_type = $_POST['Zimmer'];
    $check_in = $_POST['Check-in'];
    $check_out = $_POST['Check-out'];
    $guests = (int)$_POST['Personen'];
    $today = date('Y-m-d');

    // 1. Validierung der Daten
    if ($check_in < $today) {
        // Fehler: Datum liegt in der Vergangenheit
        header("Location: ../EditBooking.php?id=$booking_id&error=Date cannot be in the past");
        exit;
    }
    if ($check_out <= $check_in) {
        // Fehler: Abreise ist vor oder am gleichen Tag wie Anreise
        header("Location: ../EditBooking.php?id=$booking_id&error=Check-out must be after Check-in");
        exit;
    }

    // 2. Sicherheits-Check: Gehört die Buchung dem User?
    // Verhindert, dass man durch Manipulation der ID fremde Buchungen ändert
    $stmtCheck = $conn->prepare("SELECT booking_id FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmtCheck->bind_param("ii", $booking_id, $user_id);
    $stmtCheck->execute();
    
    if ($stmtCheck->get_result()->num_rows === 0) {
        die("Unauthorized access."); // Abbruch, wenn Buchung nicht gefunden oder falscher User
    }
    $stmtCheck->close();

    // 3. Preis und Kapazität für den gewählten Raumtyp holen
    $stmtPrice = $conn->prepare("SELECT price, capacity FROM room_types WHERE name = ?");
    $stmtPrice->bind_param("s", $room_type);
    $stmtPrice->execute();
    $roomData = $stmtPrice->get_result()->fetch_assoc();
    $stmtPrice->close();

    if (!$roomData) die("Room type not found");

    $pricePerNight = $roomData['price'];
    $maxCapacity = $roomData['capacity'];

    // 4. Verfügbarkeit prüfen
    // Wir schauen, ob im neuen Zeitraum noch Platz ist.
    // TRICK: Wir müssen unsere EIGENE Buchung ($booking_id) bei der Zählung ausschließen (booking_id != ?).
    // Sonst würde das System sagen "Ist schon belegt", obwohl wir selbst der Belegende sind.
    
    $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                 WHERE room_type = ? 
                 AND check_in < ? 
                 AND check_out > ?
                 AND booking_id != ?"; // <--- Schließt die aktuelle Buchung aus
    
    $stmtCount = $conn->prepare($sqlCount);
    // "sssi" = String, String, String, Integer
    $stmtCount->bind_param("sssi", $room_type, $check_out, $check_in, $booking_id);
    $stmtCount->execute();
    $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
    $stmtCount->close();

    // Wenn voll (Kapazität erreicht), Abbruch mit Fehler
    if ($current_active >= $maxCapacity) {
        header("Location: ../EditBooking.php?id=$booking_id&error=Sorry, no availability for these dates!");
        exit;
    }

    // 5. Neuen Gesamtpreis berechnen
    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $tage = $date2->diff($date1)->days; // Differenz in Tagen
    $new_total_price = $tage * $pricePerNight;

    // 6. Update in der Datenbank durchführen
    $stmtUpdate = $conn->prepare("UPDATE bookings SET room_type=?, check_in=?, check_out=?, guests=?, total_price=? WHERE booking_id=? AND user_id=?");
    $stmtUpdate->bind_param("sssidii", $room_type, $check_in, $check_out, $guests, $new_total_price, $booking_id, $user_id);

    if ($stmtUpdate->execute()) {
        // Erfolgreich -> Zurück zur Übersicht
        header("Location: ../Mybookingspage.php?updated=1");
        exit;
    } else {
        echo "Database Error: " . $conn->error;
    }
}
?>