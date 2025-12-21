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

    <?php require_once __DIR__ . '/includes/header.php'; ?>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <!-- Slideshow -->
    <div class="slideshow">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
        <div class="slideshow-text">Booking Overview</div>
    </div>

     <main class="container py-5">
        <h2 class="text-center mb-4">Booking Overview</h2>
        <p class="text-center">Here you can view, edit or cancel all bookings.</p>

        <div class="card shadow-sm p-4 buchung-box">
            <h5 class="text-center mb-3">All Bookings</h5>
        </div>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
