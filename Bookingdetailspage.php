<?php
session_start();
require_once 'database.php'; // Verbindung zur Datenbank herstellen

// --- SICHERHEITS-CHECK ---
// Wir prüfen, ob temporäre Buchungsdaten in der Session vorhanden sind.
// Diese werden normalerweise auf der 'Roomsavailabilitypage.php' gesetzt.
// Falls nicht (z.B. bei Direktaufruf der URL), schicken wir den User zurück.
if (!isset($_SESSION['temp_booking'])) {
    header("Location: Roomsavailabilitypage.php");
    exit;
}

// --- DATEN ÜBERNEHMEN ---
// Daten aus der Session holen (mit Fallback-Werten, falls etwas fehlt)
$data = $_SESSION['temp_booking'];
$zimmerName = $data['Zimmer'] ?? '';
$personen   = (int)($data['Personen'] ?? 0);
$checkin    = $data['Check-in'] ?? '';
$checkout   = $data['Check-out'] ?? '';

// Variablen für die Anzeige initialisieren
$meldung = '';
$showButton = false;
$gesamtpreis = 0;

// --- PREISBERECHNUNG ---
if ($zimmerName && $personen && $checkin && $checkout) {
    
    // 1. Preis des gewählten Zimmertyps aus der DB holen
    $stmt = $conn->prepare("SELECT price FROM room_types WHERE name = ?");
    $stmt->bind_param("s", $zimmerName);
    $stmt->execute();
    $roomData = $stmt->get_result()->fetch_assoc();
    
    if ($roomData) {
        $preisProNacht = $roomData['price'];
        
        // 2. Anzahl der Nächte berechnen
        $date1 = new DateTime($checkin);
        $date2 = new DateTime($checkout);
        $tage = $date2->diff($date1)->days;

        // 3. Validieren: Abreise muss nach Anreise liegen
        if ($date2 > $date1 && $tage > 0) {
            
            // Gesamtpreis berechnen
            $gesamtpreis = $preisProNacht * $tage;
            $showButton = true; // Buchungs-Button freischalten

            // Zusammenfassung für den User erstellen
            $meldung = "Your selected Room: <strong>$zimmerName</strong><br>
                        Number of Persons: <strong>$personen</strong><br>
                        Check In: <strong>$checkin</strong><br>
                        Check Out: <strong>$checkout</strong><br>
                        Nights: <strong>$tage</strong><br>
                        Total Price: <strong>" . number_format($gesamtpreis, 2) . " €</strong>";
        } else {
            // Fehlerfall: Ungültiges Datum
             $meldung = "<span class='text-danger'>Error: Check-out date must be after Check-in date!</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Preview - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Roomsavailabilitypage.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="container-fluid p-0 position-relative">
        <?php require_once __DIR__ . '/includes/header.php'; ?>
    </header>

    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <main class="flex-fill">
        <div class="container my-5">
            <h1 class="text-center mb-4">Booking Preview</h1>

            <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px; border-top: 5px solid rgb(1, 65, 91);">
                
                <div class="text-center mb-4 fs-5">
                    <?php echo $meldung; ?>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="Roomsavailabilitypage.php" class="btn btn-secondary">Back</a>

                    <?php if ($showButton): ?>
                        
                        <?php if (isset($_SESSION['loggedin'])): ?>
                            
                            <form action="forms/book_room.php" method="POST">
                                <input type="hidden" name="zimmer" value="<?php echo htmlspecialchars($zimmerName); ?>">
                                <input type="hidden" name="personen" value="<?php echo htmlspecialchars($personen); ?>">
                                <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
                                <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
                                <input type="hidden" name="gesamtpreis" value="<?php echo htmlspecialchars($gesamtpreis); ?>">
                                
                                <button type="submit" class="btn btn-primary" style="background-color: rgb(1, 65, 91); border:none;">Confirm Booking</button>
                            </form>

                        <?php else: ?>
                            <a href="Loginpage.php" class="btn btn-warning">Login to Book</a>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>