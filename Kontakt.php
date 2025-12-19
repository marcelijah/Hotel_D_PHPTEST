<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Contact us - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Kontakt.css">
</head>
<body>

    <!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

        <?php if(isset($_SESSION['loggedin'])): 
            $user = $_SESSION['users'][$_SESSION['loggedin']];
        ?>
            <span class="welcome-bar position-absolute top-0 end-0 me-3 mt-2">
                Willkommen, <?php echo htmlspecialchars($user['vorname']); ?>!
            </span>
        <?php endif; ?>
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
        <div class="slideshow-text">Kontakt</div>
    </div>

    <!-- Kontakt-Bereich -->
    <div class="kontakt">
        <div class="kontakt-container">
            <div class="kontakt-image">
                <img src="assets/img/Kontakt_Bild1.jpg" alt="Willkommen im EA Hotel">
            </div>
            <div class="kontakt-textbox">
                <h2>Kontaktiere uns</h2>
                <div class="divider"></div>
                <div class="Daten">    
                    <h2>Reservierungsabteilung</h2>
                    <h3>Arian Sadeghian</h3>
                    <p>wi24b056@technikum-wien.at</p>
                    <p>+4369910059138</p>

                    <h2>Empfangsbereich</h2>
                    <h3>Elijah-Marcel Manikan</h3>
                    <p>wi24b187@technikum-wien.at</p>
                    <p>+436602234042</p>
                </div>    
            </div>
        </div>
    </div>

    <h1 class="KontaktTitel">Senden Sie uns eine Nachricht</h1>

    <section class="FormularBereich">
        <form action="kontakt_send.php" method="post" class="FormularBox">
            <div class="FormFeld">
                <label for="Vorname">Vorname</label>
                <input id="Vorname" name="Vorname" type="text" required>

                <label for="Nachname">Nachname</label>
                <input id="Nachname" name="Nachname" type="text" required>           

                <label for="email">E-Mail</label>
                <input id="email" name="email" type="email" required>                

                <label for="Nachricht">Nachricht</label>
                <textarea id="Nachricht" name="Nachricht" rows="4" required></textarea>
            </div>
            <button id="Button" type="submit">Senden</button>
        </form>

    </section>

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
