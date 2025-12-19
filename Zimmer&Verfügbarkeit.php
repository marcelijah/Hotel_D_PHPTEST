<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Reservation - EA Hotel</title>
        <link rel="stylesheet" href="assets/css/Zimmer&Verfügbarkeit.css">

    </head>
    <body>
        
    <!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>
        
        <?php 
        if(isset($_SESSION['loggedin'])) {
            $user = $_SESSION['users'][$_SESSION['loggedin']];
        
            echo '<div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">'
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


        <main class="flex-grow-1">
        <h1 class="TitelBuchen">Buchen Sie im EA Hotel</h1>
        <h2 class="TitelGebenSie ">Geben Sie Daten ein und buchen Sie Ihren Traumaufenthalt in Larnaca.</h2>

        <section class="Buchung">
            
            <form action="Buchung.php" method="Post" class="Buchung-form">

                <div class="container mt-4">
                <div class="row justify-content-center g-4 zimmer-auswahl-bilder">

                    <div class="col-12 col-md-6 text-center">
                        <div class="zimmer-text mb-2">
                            <p>Gemütliches Einzelzimmer mit modernem Komfort und kostenfreiem WLAN.</p>
                            <p class="zimmer-preis">Preis: 75€ / Nacht</p>
                        </div>
                        <input type="radio" class="btn-check" name="Zimmer" id="einzelzimmer" value="Einzelzimmer" autocomplete="off">
                        <label for="einzelzimmer" class="zimmer-label btn p-0 w-100">
                            <img src="assets/img/Zimmer_Bild1.jpg" class="img-fluid rounded shadow zimmer-img" alt="Einzelzimmer">
                            <div class="fw-bold mt-2">Einzelzimmer</div>
                        </label>
                    </div>

                    <div class="col-12 col-md-6 text-center">
                        <div class="zimmer-text mb-2">
                            <p>Geräumiges Doppelzimmer mit Balkon, ideal für Paare oder Freunde.</p>
                            <p class="zimmer-preis">Preis: 120€ / Nacht</p>
                        </div>
                        <input type="radio" class="btn-check" name="Zimmer" id="doppelzimmer" value="Doppelzimmer" autocomplete="off">
                        <label for="doppelzimmer" class="zimmer-label btn p-0 w-100">
                            <img src="assets/img/Zimmer_Bild2.jpg" class="img-fluid rounded shadow zimmer-img" alt="Doppelzimmer">
                            <div class="fw-bold mt-2">Doppelzimmer</div>
                        </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="Personen">Personen</label>
                    <input type="number" name="Personen" id = "Personen" min="1" max="2" required>
                </div>

                <div class="Datum">
                    <label for="Check-in">Check-in</label>
                    <input id="Check-in" name="Check-in" type="date" value required>
                    <label for="Check-out">Check-out</label>
                    <input id="Check-out" name="Check-out" type="date" value required>
                </div>
                
                <button type="submit" class="submit-button" name="verfügbarkeit">Verfügbarkeit prüfen</button>
            </form>
        </section>
        </main>

        


        <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Zypern</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>

    </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>         
    </body>
</html>    