<?php
session_start();

$meldung = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zimmer = $_POST['Zimmer'] ?? '';
    $personen = (int)($_POST['Personen'] ?? 0);
    $checkin = $_POST['Check-in'] ?? '';
    $checkout = $_POST['Check-out'] ?? '';

    $preise = ['Single room' => 75, 'Double room' => 120];

    if ($zimmer && $personen && $checkin && $checkout) {
        $tage = (new DateTime($checkout))->diff(new DateTime($checkin))->days;

        if ($tage > 0) {
            $gesamtpreis = $preise[$zimmer] * $tage;
            $meldung = "Your selected Room: <strong>$zimmer</strong><br>
                        Number of Persons: <strong>$personen</strong><br>
                        Check In: <strong>$checkin</strong><br>
                        Check Out: <strong>$checkout</strong><br>
                        Nights: <strong>$tage</strong><br>
                        Total Price: <strong>$gesamtpreis €</strong><br>
                        ";
        } else {
            $meldung = "Check-out muss nach Check-in liegen!";
        }
    } else {
        $meldung = "Bitte alle Felder ausfüllen!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Check Booking Details - EA Hotel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/Roomsavailabilitypage.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once __DIR__ . '/includes/header.php'; ?>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <!-- Main Content -->
    <main class="flex-fill">
        <div class="container my-5">
            <h1 class="text-center mb-4">Booking Preview</h1>

            <?php if($meldung): ?>
                <div class=" text-center"><?php echo $meldung; ?></div>
            <?php endif; ?>

            <div class="text-center mt-3">
                <a href="Roomsavailabilitypage.php" class="btn-buchen" style="color: white; background-color: rgb(1, 65, 91); padding: 12px 24px; border-radius: 5px; display: inline-block; text-decoration: none;">Back to Bookingpage</a>
            </div>

            <div class="text-center mt-3">
                <a href="Roomsavailabilitypage.php" class="btn-buchen" style="color: white; background-color: rgb(1, 65, 91); padding: 12px 24px; border-radius: 5px; display: inline-block; text-decoration: none;">Book</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
