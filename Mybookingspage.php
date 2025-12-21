<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>My Bookings - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Homepage.css">
</head>
<body>

    <!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

        <?php
        if (isset($_SESSION['loggedin'])) {
            $user = $_SESSION['users'][$_SESSION['loggedin']];

            echo '<div class="welcome-bar position-absolute top-0 end-0 me-3 mt-2">'
            . 'Willkommen, ' . htmlspecialchars($user['vorname']) . '!'
            . '</div>';
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
                    <li class="nav-item"><a class="nav-link" href="Zimmer&Verfügbarkeit.php">Zimmer & Verfügbarkeit</a></li>
                    <li class="nav-item"><a class="nav-link" href="Kontakt.php">Kontakt</a></li>
                    <li class="nav-item"><a class="nav-link" href="ÜberUns.php">Über Uns</a></li>

                    <?php
                    if (!isset($_SESSION['loggedin'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="Anmelden.php">Anmelden</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Registrierung.php">Registrieren</a></li>';
                    }

                    if (isset($_SESSION['loggedin'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="MeineBuchungen.php">Meine Buchungen</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Slideshow -->
    <div class="slideshow">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
        <div class="slideshow-text">Buchungsübersicht</div>
    </div>

     <main class="container py-5">
        <h2 class="text-center mb-4">Buchungsübersicht </h2>
        <p class="text-center">Hier können alle Buchungen eingesehen, bearbeitet oder storniert werden.</p>

        <div class="card shadow-sm p-4 buchung-box">
            <h5 class="text-center mb-3">Alle Buchungen</h5>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Zypern</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
