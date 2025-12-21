<?php
session_start();

$meldung = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zimmer = $_POST['Zimmer'] ?? '';
    $personen = (int)($_POST['Personen'] ?? 0);
    $checkin = $_POST['Check-in'] ?? '';
    $checkout = $_POST['Check-out'] ?? '';

    $preise = ['Einzelzimmer' => 75, 'Doppelzimmer' => 120];

    if ($zimmer && $personen && $checkin && $checkout) {
        $tage = (new DateTime($checkout))->diff(new DateTime($checkin))->days;

        if ($tage > 0) {
            $gesamtpreis = $preise[$zimmer] * $tage;
            $meldung = "Ihr gewähltes Zimmer: <strong>$zimmer</strong><br>
                        Anzahl der Personen: <strong>$personen</strong><br>
                        Check In: <strong>$checkin</strong><br>
                        Check Out: <strong>$checkout</strong><br>
                        Nächte: <strong>$tage</strong><br>
                        Gesamtpreis: <strong>$gesamtpreis €</strong><br>
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

    <!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

        <?php 
        if(isset($_SESSION['loggedin'])) {
            $user = $_SESSION['users'][$_SESSION['loggedin']];
            echo '<span class="welcome-bar position-absolute top-0 end-0 me-3 mt-2">'
                . 'Welcome, ' . htmlspecialchars($user['vorname']) . '!'
                . '</span>';
        }
        ?>
    </header>

    <!-- Navigation -->
    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="Homepage.php">Homepage</a></li>
                    <li class="nav-item"><a class="nav-link" href="Roomsavailabilitypage.php">Rooms & Availability</a></li>
                    <li class="nav-item"><a class="nav-link" href="Contactpage.php">Contact us</a></li>
                    <li class="nav-item"><a class="nav-link" href="Aboutuspage.php">About us</a></li>
                    <?php
                    if (!isset($_SESSION['loggedin'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="Loginpage.php">Login</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Registrationpage.php">Registration</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="Mybookingspage.php">My Bookings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logoutlogic.php">Logout</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

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
    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Cyprus</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
