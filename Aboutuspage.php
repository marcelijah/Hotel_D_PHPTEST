        <?php session_start(); ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <title>About Us - EA Hotel</title>
            <link rel="stylesheet" href="assets/css/Aboutuspage.css">
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
                    Welcome, <?php echo htmlspecialchars($user['vorname']); ?>!
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
                        <li class="nav-item"><a class="nav-link" href="Roomsavailabilitypage.php">Rooms & Availability</a></li>
                        <li class="nav-item"><a class="nav-link" href="Contactpage.php">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="Aboutuspage.php">About Us</a></li>

                        <?php
                        if (!isset($_SESSION['loggedin'])) {
                            echo '<li class="nav-item"><a class="nav-link" href="Loginpage.php">Login</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Registrationpage.php">Registration</a></li>';
                        }

                        if (isset($_SESSION['loggedin'])) {
                            echo '<li class="nav-item"><a class="nav-link" href="Mybookingspage.php">Meine Buchungen</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logoutlogic.php">Logout</a></li>';
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

        <div class="container Aboutus-container my-5">
            <h2>About EA Hotel</h2>
            <div class="Aboutus-textbox">
                <p>Situated directly on the azure Mediterranean, just a few steps from the stunning sandy beach of Larnaca, the EA Hotel is a retreat that combines the natural beauty of Cyprus with modern comfort and Mediterranean serenity. Surrounded by a vibrant environment characterized by Cypriot hospitality and international flair, our hotel blends tranquility and elegance with proximity to the island's cultural treasures, such as the famous Finikoudes promenade and the historic Church of Saint Lazarus.</p>
                <p>Our goal is to delight every guest in a personal, sincere, and unique way, understanding their wishes and meeting them with transparency, professionalism, and warmth.</p>
                <p>Our daily mission is to make a tangible difference—through continuous improvement, careful attention to detail, and tailored services designed to make your stay unforgettable. We want to help you rediscover a sense of your own time, relaxation, and rhythm by offering an atmosphere that harmoniously combines peace, inspiration, and well-being.</p>
                <p>At the EA Hotel, we strive to consistently meet the highest quality standards while bringing the warm, authentic soul of Cyprus to life in every experience.</p>
            </div>
        </div>

        <div class="container EA-Team-container my-5">
            <div class="row align-items-center mb-5 EA-Team1">
                <div class="col-md-6 team-textbox">
                    <h2>The EA Team</h2>
                    <div class="divider"></div>
                   <p>At the EA Hotel in Larnaca, Cyprus, Arian is a key member of our team. With great dedication and passion, he ensures that every guest feels welcome and well cared for from the very first moment.</p>
                    <p>Arian pays attention to every detail—from the warm welcome to individual requests during your stay—ensuring that your visit becomes an unforgettable experience.</p>
                    <p>Thanks to his experience and organizational skills, he ensures that hotel operations run smoothly, allowing our guests to relax completely. His goal is to add a personal touch to every stay that leaves a lasting impression.</p>
                </div>
                <div class="col-md-6 team-image">
                    <img src="assets/img/Contactimg1.jpg" alt="Cooles Instafoto von Arian" class="img-fluid">
                </div>
            </div>

            <div class="row align-items-center mb-5 EA-Team2">
                <div class="col-md-6 team-image">
                    <img src="assets/img/Contact_img1.jpg" alt="Cooles Instafoto von Elijah" class="img-fluid">
                </div>
                <div class="col-md-6 team-textbox">
                   <p>Elijah is the heart of our team at the EA Hotel in Larnaca. With his positive energy and dedication, he ensures that our guests enjoy every moment of their stay.</p>
                    <p>He works daily to provide our guests with unique experiences that are both relaxing and inspiring. He pays special attention to every request, always striving to find individual solutions.</p>
                    <p>His passion for excellent service and his eye for small but significant details make every stay special. Elijah's goal is for every guest to leave not just satisfied, but delighted and filled with beautiful memories.</p>
                </div>
            </div>
        </div>

        <div class="container Lage-container my-5">
            <div class="row Lage-content align-items-center">
                <div class="col-md-6 Lage-textbox">
                    <h2>Location</h2>
                <div class="divider"></div>
                    <p>Located directly on the coast of Larnaca, overlooking the glittering Mediterranean Sea, the EA Hotel offers the perfect retreat for guests seeking to combine relaxation, comfort, and the Cypriot lifestyle. You are just steps away from golden sandy beaches, and the vibrant promenade with its cafés, boutiques, and cultural sights is within easy reach.</p>
                    <p>Our surroundings offer a perfect blend of tranquility and activity: enjoy a relaxing stroll by the sea, explore the city's historical sites, or experience authentic Cypriot hospitality in the nearby restaurants and markets. The EA Hotel is the ideal destination for those seeking both relaxation and cultural experiences.</p>
                    <p>We are dedicated to making every stay with us unforgettable. With attention to detail, professional service, and an atmosphere that blends Mediterranean serenity with modern comfort, we create a sanctuary where you can recharge and cherish special moments.</p>
                </div>
                <div class="col-md-6 Lage-image">
                    <img src="assets/img/Location_img1.jpg" alt="Foto von der Lage" class="img-fluid">
                </div>
            </div>
        </div>

        <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Cyprus</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>
    </footer>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
