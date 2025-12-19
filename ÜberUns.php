        <?php session_start(); ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <title>About us - EA Hotel</title>
            <link rel="stylesheet" href="assets/css/ÜberUns.css">
        </head>
        <body>

            <div class="container-fluid px-0">
                
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


        <div class="slideshow">
            <div class="slide s1"></div>
            <div class="slide s2"></div>
            <div class="slide s3"></div>
            <div class="slideshow-text">Über Uns</div>
        </div>

        <div class="container Überuns-container my-5">
            <h2>Über EA Hotel</h2>
            <div class="Überuns-textbox">
                <p>Direkt am azurblauen Mittelmeer, nur wenige Schritte vom traumhaften Sandstrand von Larnaca entfernt, liegt das EA Hotel – ein Rückzugsort, der die natürliche Schönheit Zyperns mit modernem Komfort und mediterraner Gelassenheit vereint. Inmitten einer lebendigen Umgebung, geprägt von zypriotischer Gastfreundschaft und internationalem Flair, verbindet unser Hotel Ruhe, Eleganz und Nähe zu den kulturellen Schätzen der Insel, wie der berühmten Promenade Finikoudes und der historischen Lazarus-Kirche.</p>
                <p>Unser Anspruch ist es, jeden Gast auf eine persönliche, aufrichtige und einzigartige Weise zu begeistern, seine Wünsche zu verstehen und ihnen mit Transparenz, Professionalität und Herzlichkeit zu begegnen.</p>
                <p>Unsere tägliche Aufgabe besteht darin, den Unterschied spürbar zu machen – durch kontinuierliche Verbesserungen, sorgfältige Aufmerksamkeit zum Detail und maßgeschneiderte Leistungen, die Ihren Aufenthalt unvergesslich gestalten. Wir möchten Ihnen helfen, das Bewusstsein für Ihre Zeit, Ihre Erholung und Ihren eigenen Rhythmus wiederzufinden, indem wir Ihnen eine Atmosphäre bieten, die Ruhe, Inspiration und Wohlbefinden harmonisch vereint.</p>
                <p>Im EA Hotel streben wir danach, stets die höchsten Qualitätsstandards zu erfüllen und gleichzeitig die warme, authentische Seele Zyperns in jeder Erfahrung erlebbar zu machen.</p>
            </div>
        </div>

        <div class="container EA-Team-container my-5">
            <div class="row align-items-center mb-5 EA-Team1">
                <div class="col-md-6 team-textbox">
                    <h2>Das EA Team</h2>
                    <div class="divider"></div>
                    <p>Im EA Hotel in Larnaca, Zypern, ist Arian ein zentraler Bestandteil unseres Teams. Mit viel Engagement und Leidenschaft sorgt er dafür, dass jeder Gast sich vom ersten Moment an willkommen und gut betreut fühlt.</p>
                    <p>Arian achtet auf jedes Detail – von der herzlichen Begrüßung bis zu individuellen Wünschen während des Aufenthalts – und stellt sicher, dass Ihr Besuch zu einem unvergesslichen Erlebnis wird.</p>
                    <p>Durch seine Erfahrung und sein Organisationstalent schafft er es, den Ablauf im Hotel reibungslos zu gestalten, damit sich unsere Gäste vollkommen entspannen können. Sein Ziel ist es, jedem Aufenthalt eine persönliche Note zu verleihen, die in Erinnerung bleibt.</p>
                </div>
                <div class="col-md-6 team-image">
                    <img src="assets/img/Kontakt_Bild1.jpg" alt="Cooles Instafoto von Arian" class="img-fluid">
                </div>
            </div>

            <div class="row align-items-center mb-5 EA-Team2">
                <div class="col-md-6 team-image">
                    <img src="assets/img/Kontakt_Bild1.jpg" alt="Cooles Instafoto von Elijah" class="img-fluid">
                </div>
                <div class="col-md-6 team-textbox">
                    <p>Elijah ist das Herzstück unseres Teams im EA Hotel in Larnaca. Mit seiner positiven Ausstrahlung und seinem Engagement trägt er dazu bei, dass unsere Gäste jeden Moment ihres Aufenthalts genießen können.</p>
                    <p>Er arbeitet täglich daran, unseren Gästen einzigartige Erlebnisse zu bieten, die sowohl entspannend als auch inspirierend sind. Dabei legt er besonderen Wert darauf, jeden Wunsch aufmerksam wahrzunehmen und individuelle Lösungen zu finden.</p>
                    <p>Seine Leidenschaft für exzellenten Service und sein Blick für kleine, aber wichtige Details machen jeden Aufenthalt zu etwas Besonderem. Elijahs Ziel ist es, dass jeder Gast nicht nur zufrieden, sondern begeistert und voller schöner Erinnerungen abreist.</p>
                </div>
            </div>
        </div>

        <div class="container Lage-container my-5">
            <div class="row Lage-content align-items-center">
                <div class="col-md-6 Lage-textbox">
                    <h2>Lage</h2>
                    <div class="divider"></div>
                    <p>Direkt an der Küste von Larnaca, mit Blick auf das glitzernde Mittelmeer, bietet das EA Hotel den perfekten Rückzugsort für Gäste, die Erholung, Komfort und zypriotische Lebensart miteinander verbinden möchten. „Nur wenige Schritte trennen Sie von den goldenen Sandstränden, und auch die lebendige Promenade mit Cafés, Boutiquen und kulturellen Sehenswürdigkeiten ist bequem erreichbar.</p>
                    <p>Unsere Umgebung vereint Ruhe und Aktivität: Sie können entspannt am Meer spazieren, die historischen Stätten der Stadt erkunden oder die authentische Gastfreundschaft Zyperns in den nahegelegenen Restaurants und Märkten erleben. Das EA Hotel ist somit ideal für alle, die sowohl Entspannung als auch kulturelle Eindrücke suchen.</p>
                    <p>Wir legen großen Wert darauf, dass jeder Aufenthalt bei uns unvergesslich wird. Mit Liebe zum Detail, professionellem Service und einer Atmosphäre, die mediterrane Gelassenheit mit modernem Komfort vereint, schaffen wir einen Ort, an dem Sie neue Energie tanken und besondere Momente genießen können.</p>
                </div>
                <div class="col-md-6 Lage-image">
                    <img src="assets/img/Lage_Bild1.jpg" alt="Foto von der Lage" class="img-fluid">
                </div>
            </div>
        </div>

        <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Zypern</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>
    </footer>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
