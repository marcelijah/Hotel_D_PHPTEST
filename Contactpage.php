<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Contactpage.css">
</head>
<body>
    
    <?php require_once __DIR__ . '/includes/header.php'; ?>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>


    <!-- Slideshow -->
    <div class="slideshow">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
        <div class="slideshow-text">Contact Us</div>
    </div>

    <!-- Kontakt-Bereich -->
    <div class="kontakt">
        <div class="kontakt-container">
            <div class="kontakt-image">
                <img src="assets/img/Contact_img1.jpg" alt="Willkommen im EA Hotel">
            </div>
            <div class="kontakt-textbox">
                <h2>Contact Us</h2>
                <div class="divider"></div>
                <div class="Daten">    
                    <h2>Reservation Department</h2>
                    <h3>Arian Sadeghian</h3>
                    <p>wi24b056@technikum-wien.at</p>
                    <p>+43 699 10059138</p>

                    <h2>Front Desk</h2>
                    <h3>Elijah-Marcel Manikan</h3>
                    <p>wi24b187@technikum-wien.at</p>
                    <p>+43 660 2234042</p>
                </div>    
            </div>
        </div>
    </div>

    <h1 class="KontaktTitel">Send us a message</h1>

    <section class="FormularBereich">
        <form action="kontakt_send.php" method="post" class="FormularBox">
            <div class="FormFeld">
                <label for="Vorname">First Name</label>
                <input id="Vorname" name="Vorname" type="text" required>

                <label for="Nachname">Surname</label>
                <input id="Nachname" name="Nachname" type="text" required>           

                <label for="email">E-Mail</label>
                <input id="email" name="email" type="email" required>                

                <label for="Nachricht">Message</label>
                <textarea id="Nachricht" name="Nachricht" rows="4" required></textarea>
            </div>
            <button id="Button" type="submit">Send</button>
        </form>

    </section>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>     

</body>
</html>
