<?php 
session_start(); 
require_once 'database.php'; 

$error_message = '';
$heute = date('Y-m-d'); 

// ZENTRALE KONFIGURATION: Mapping von Namen zu Kapazitäten
// Das macht die if-else-Ketten unten überflüssig
$capacityMap = [
    'Single' => 1,
    'Double' => 2,
    'Triple' => 3,
    'Quadruple' => 4,
    'Suite' => 5,
    'Family' => 5
];

// Hilfsfunktion um Kapazität zu finden
function getCapacity($name, $map) {
    foreach ($map as $key => $cap) {
        if (stripos($name, $key) !== false) return $cap;
    }
    return 2; // Standard-Fallback
}

// 1. ZIMMERTYPEN LADEN
$sqlTypes = "SELECT * FROM room_types ORDER BY price ASC";
$resultTypes = $conn->query($sqlTypes);

$roomTypes = [];
$maxGuestsGlobal = 1;

if ($resultTypes) {
    while($row = $resultTypes->fetch_assoc()) {
        $roomTypes[] = $row;
        // Automatische Kapazität ermitteln
        $pCap = getCapacity($row['name'], $capacityMap);
        if ($pCap > $maxGuestsGlobal) {
            $maxGuestsGlobal = $pCap;
        }
    }
}

// 2. FORMULAR VERARBEITUNG
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verfügbarkeit'])) {
    
    $zimmerName = $_POST['Zimmer'] ?? '';
    $checkin = $_POST['Check-in'] ?? '';
    $checkout = $_POST['Check-out'] ?? '';
    $personen = (int)($_POST['Personen'] ?? 0); 

    $_SESSION['temp_inputs'] = $_POST;

    // Validierung
    if (empty($zimmerName)) {
        $error_message = "Please select a room type.";
    }
    elseif ($checkin < $heute) {
        $error_message = "Error: You cannot book dates in the past. Please start from today ($heute).";
    }
    elseif ($checkout <= $checkin) {
        $error_message = "Error: Check-out date must be after Check-in date.";
    }
    else {
        // Kapazität prüfen mit neuer Funktion
        $max_allowed_guests = getCapacity($zimmerName, $capacityMap);

        if ($personen > $max_allowed_guests) {
            $error_message = "Error: The <strong>$zimmerName</strong> is only designed for a maximum of <strong>$max_allowed_guests guest(s)</strong>.";
        } 
        else {
            // Bestand prüfen (DB Logic bleibt gleich)
            $stmtMax = $conn->prepare("SELECT capacity FROM room_types WHERE name = ?");
            $stmtMax->bind_param("s", $zimmerName);
            $stmtMax->execute();
            $resMax = $stmtMax->get_result();
            $rowMax = $resMax->fetch_assoc();
            $stmtMax->close();

            if ($rowMax) {
                $total_rooms_in_stock = $rowMax['capacity']; 
                
                $sqlCount = "SELECT COUNT(*) as active_bookings FROM bookings 
                             WHERE room_type = ? 
                             AND check_in < ? 
                             AND check_out > ?";
                
                $stmtCount = $conn->prepare($sqlCount);
                $stmtCount->bind_param("sss", $zimmerName, $checkout, $checkin);
                $stmtCount->execute();
                $current_active = $stmtCount->get_result()->fetch_assoc()['active_bookings'];
                $stmtCount->close();

                if ($current_active >= $total_rooms_in_stock) {
                    $error_message = "Sorry! All <strong>$zimmerName</strong>s are fully booked for these dates (0 left of $total_rooms_in_stock).";
                } else {
                    $_SESSION['temp_booking'] = $_POST;
                    header("Location: Bookingdetailspage.php");
                    exit;
                }
            } else {
                 $error_message = "Error: Selected room type not found in database.";
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
        <link rel="stylesheet" href="assets/css/Roomsavailabilitypage.css">
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
                        
                        <?php foreach ($roomTypes as $room): ?>
                            <?php 
                                // Bild-Logik
                                $imgSrc = (stripos($room['name'], 'Single') !== false) ? 'assets/img/Room_img1.jpg' : 'assets/img/Room_img2.jpg';
                                
                                // Text-Logik (Fallback)
                                $description = !empty($room['description']) ? $room['description'] : "Enjoy a comfortable stay in our exclusive rooms.";
                                
                                if (empty($room['description'])) {
                                    if (stripos($room['name'], 'Single') !== false) {
                                        $description = "Experience ultimate comfort in our exclusive single rooms, perfectly designed for solo travelers.";
                                    } elseif (stripos($room['name'], 'Double') !== false) {
                                        $description = "Relax in our spacious exclusive double rooms, offering a luxurious king-sized bed.";
                                    } elseif (stripos($room['name'], 'Triple') !== false) {
                                        $description = "Spacious triple room providing comfort for small groups or families with three beds.";
                                    } elseif (stripos($room['name'], 'Quadruple') !== false) {
                                        $description = "Large quadruple room with ample space, perfect for families of four looking for a relaxing stay.";
                                    }
                                }

                                $isChecked = (isset($_POST['Zimmer']) && $_POST['Zimmer'] == $room['name']) ? 'checked' : '';
                            ?>
                            
                            <div class="col-12 col-md-6 text-center">
                                <div class="zimmer-text mb-2">
                                    <p class="fw-bold mb-1" style="font-size: 1.2rem;"><?php echo htmlspecialchars($room['name']); ?></p>
                                    <p class="mb-1 text-muted small"><?php echo htmlspecialchars($description); ?></p>
                                    <p class="zimmer-preis">Price: <?php echo number_format($room['price'], 0); ?>€ / night</p>
                                </div>
                                
                                <input type="radio" class="btn-check" 
                                       name="Zimmer" 
                                       id="room_<?php echo $room['id']; ?>" 
                                       value="<?php echo htmlspecialchars($room['name']); ?>" 
                                       autocomplete="off" 
                                       <?php echo $isChecked; ?>>
                                
                                <label for="room_<?php echo $room['id']; ?>" class="zimmer-label btn p-0 w-100">
                                    <img src="<?php echo $imgSrc; ?>" class="img-fluid rounded shadow zimmer-img" alt="<?php echo htmlspecialchars($room['name']); ?>">
                                </label>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

                <div>
                    <label for="Personen">Guests</label>
                    <input type="number" name="Personen" id="Personen" min="1" 
                           max="<?php echo $maxGuestsGlobal; ?>" 
                           required 
                           value="<?php echo $_POST['Personen'] ?? ''; ?>" 
                           placeholder="Max. <?php echo $maxGuestsGlobal; ?> guests">
                    <small class="text-muted">Maximum allowed guests based on available rooms: <?php echo $maxGuestsGlobal; ?></small>
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