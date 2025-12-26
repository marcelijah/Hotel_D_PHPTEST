<?php 
session_start(); 
require_once 'database.php'; 

$error_message = '';
// WICHTIG: Das heutige Datum definieren wir gleich hier oben, 
// damit wir es im HTML (für das min-Attribut) nutzen können.
$heute = date('Y-m-d'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verfügbarkeit'])) {
    
    $zimmerName = $_POST['Zimmer'] ?? '';
    $checkin = $_POST['Check-in'] ?? '';
    $checkout = $_POST['Check-out'] ?? '';
    $personen = $_POST['Personen'] ?? '';

    $_SESSION['temp_inputs'] = $_POST;

    // --- SICHERHEITS-CHECK (Backend) ---
    // Falls jemand HTML manipuliert, fängt PHP ihn hier ab.
    if ($checkin < $heute) {
        $error_message = "Error: You cannot book dates in the past. Please start from today ($heute).";
    }
    elseif ($checkout <= $checkin) {
        $error_message = "Error: Check-out date must be after Check-in date.";
    }
    else {
        // --- KAPAZITÄTS-CHECK ---
        $stmtMax = $conn->prepare("SELECT capacity FROM room_types WHERE name = ?");
        $stmtMax->bind_param("s", $zimmerName);
        $stmtMax->execute();
        $resMax = $stmtMax->get_result();
        $rowMax = $resMax->fetch_assoc();
        $stmtMax->close();

        if ($rowMax) {
            $max_capacity = $rowMax['capacity'];

            $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                         WHERE room_type = ? 
                         AND check_in < ? 
                         AND check_out > ?";
            
            $stmtCount = $conn->prepare($sqlCount);
            $stmtCount->bind_param("sss", $zimmerName, $checkout, $checkin);
            $stmtCount->execute();
            $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
            $stmtCount->close();

            if ($current_active >= $max_capacity) {
                $error_message = "Sorry! All <strong>$zimmerName</strong>s are fully booked for these dates.";
            } else {
                $_SESSION['temp_booking'] = $_POST;
                header("Location: Bookingdetailspage.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Reservation - EA Hotel</title>
        <link rel="stylesheet" href="assets/css/RoomsAvailabilitypage.css">
    </head>
    <body>
        
    <header class="container-fluid p-0 position-relative">
       <?php require_once __DIR__ . '/includes/header.php'; ?>
    </header>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <main class="flex-grow-1">
        <h1 class="TitelBuchen">Book A Room in EA Hotel</h1>
        <h2 class="TitelGebenSie ">Enter your data and book your stay in Larnaca.</h2>

        <section class="Buchung">
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-warning d-flex align-items-center justify-content-center mb-4 mx-auto" role="alert" style="max-width: 800px; border-left: 5px solid rgb(1, 65, 91);">
                    <i class="bi bi-emoji-frown-fill me-2" style="font-size: 1.5rem; color: rgb(1, 65, 91);"></i>
                    <div style="font-size: 1.1rem; color: #333;">
                        <?php echo $error_message; ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="Post" class="Buchung-form">

                <div class="container mt-4">
                    <div class="row justify-content-center g-4 zimmer-auswahl-bilder">
                        <div class="col-12 col-md-6 text-center">
                          <div class="zimmer-text mb-2">
                                <p>Cozy single room with modern amenities and free Wi-Fi.</p>
                                <p class="zimmer-preis">Price: 75€ / night</p>
                            </div>
                            <input type="radio" class="btn-check" name="Zimmer" id="Single room" value="Single room" autocomplete="off" <?php if(isset($_POST['Zimmer']) && $_POST['Zimmer'] == 'Single room') echo 'checked'; ?>>
                            <label for="Single room" class="zimmer-label btn p-0 w-100">
                                <img src="assets/img/Room_img1.jpg" class="img-fluid rounded shadow zimmer-img" alt="Single room">
                                <div class="fw-bold mt-2">Single Room</div>
                            </label>
                        </div>

                        <div class="col-12 col-md-6 text-center">
                            <div class="zimmer-text mb-2">
                                <p>Spacious double room with balcony, ideal for couples or friends.</p>
                                <p class="zimmer-preis">Price: 120€ / night</p>
                            </div>
                            <input type="radio" class="btn-check" name="Zimmer" id="Double room" value="Double room" autocomplete="off" <?php if(isset($_POST['Zimmer']) && $_POST['Zimmer'] == 'Double room') echo 'checked'; ?>>
                            <label for="Double room" class="zimmer-label btn p-0 w-100">
                                <img src="assets/img/Room_img2.jpg" class="img-fluid rounded shadow zimmer-img" alt="Double room">
                                <div class="fw-bold mt-2">Double Room</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="Personen">Guests</label>
                    <input type="number" name="Personen" id="Personen" min="1" max="2" required value="<?php echo $_POST['Personen'] ?? ''; ?>">
                </div>

                <div class="Datum">
                    <label for="Check-in">Check-in</label>
                    <input id="Check-in" name="Check-in" type="date" required 
                           min="<?php echo $heute; ?>" 
                           value="<?php echo $_POST['Check-in'] ?? ''; ?>">
                    
                    <label for="Check-out">Check-out</label>
                    <input id="Check-out" name="Check-out" type="date" required 
                           min="<?php echo $heute; ?>" 
                           value="<?php echo $_POST['Check-out'] ?? ''; ?>">
                </div>

                <button type="submit" class="submit-button" name="verfügbarkeit">Check Availability</button>
            </form>
        </section>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script> 
    </body>
</html>