<?php
session_start();
require_once 'database.php';

// Check Login
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: Loginpage.php");
    exit;
}

// ID holen
$booking_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Buchungsdaten laden (Sicherstellen, dass sie dem User gehört)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    die("Booking not found or access denied.");
}

// Für das min-Datum im Kalender
$heute = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Roomsavailabilitypage.css"> </head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <main class="flex-grow-1 container my-5">
        <h1 class="text-center mb-4" style="color: rgb(1, 65, 91);">Edit Your Booking #<?php echo $booking_id; ?></h1>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div class="Buchung mx-auto" style="max-width: 600px;">
            <form action="forms/user_update_booking.php" method="POST" class="Buchung-form">
                
                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">

                <div class="d-flex flex-column mb-3">
                    <label for="Zimmer">Room Type</label>
                    <select name="Zimmer" id="Zimmer" class="form-select">
                        <option value="Single room" <?php if($booking['room_type'] == 'Single room') echo 'selected'; ?>>Single Room (75€)</option>
                        <option value="Double room" <?php if($booking['room_type'] == 'Double room') echo 'selected'; ?>>Double Room (120€)</option>
                    </select>
                </div>

                <div class="d-flex flex-column mb-3">
                    <label for="Personen">Guests</label>
                    <input type="number" name="Personen" id="Personen" min="1" max="2" required value="<?php echo $booking['guests']; ?>">
                </div>

                <div class="Datum">
                    <label for="Check-in">Check-in</label>
                    <input id="Check-in" name="Check-in" type="date" required 
                           min="<?php echo $heute; ?>" 
                           value="<?php echo $booking['check_in']; ?>">
                    
                    <label for="Check-out">Check-out</label>
                    <input id="Check-out" name="Check-out" type="date" required 
                           min="<?php echo $heute; ?>" 
                           value="<?php echo $booking['check_out']; ?>">
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="Mybookingspage.php" class="btn btn-secondary w-50">Cancel</a>
                    <button type="submit" class="btn w-50" style="background-color: rgb(1, 65, 91); color: white;">Update Booking</button>
                </div>
            </form>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>