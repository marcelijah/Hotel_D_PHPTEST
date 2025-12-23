<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Homepage - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Homepage.css">
</head>
<body>

    <?php require_once __DIR__ . '/includes/header.php'; ?>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <!-- SlideshowTest -->
    <div class="slideshow">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
        <div class="slideshow-text">EA Hotel</div>
    </div>

    <!-- Intro Abschnitt -->
    <section class="intro py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Bild -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="assets/img/Homepage_img4.jpg" alt="Willkommen im EA Hotel" class="img-fluid rounded shadow">
                </div>
                <!-- Text -->
                <div class="col-lg-6">
                    <div class="intro-textbox p-4 p-lg-5 border rounded shadow-sm">
                        <h2>Welcome</h2>
                        <div class="divider mb-3"></div>
                        <p>Experience a grand establishment in a typical Mediterranean style with 67 comfortable rooms.</p>
                        <p>Since its opening, EA Hotel has dedicated itself to making your stay an unforgettable experience.</p>
                        <p>Enjoy moments of relaxation and well-being on the coast of Larnaca, with a dreamy location right by the sea and just a few steps from the vibrant heart of the city.</p>
                        <p>Indulge in precious moments and be enchanted by the countless pleasures and experiences that only EA Hotel can offer.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
