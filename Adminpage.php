<?php
session_start();
require 'forms/users.php';

// Prüfen, ob eingeloggt und admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: Homepage.php");
    exit;
}

$adminUser = $_SESSION['users'][$_SESSION['loggedin']];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
</head>
<body>

    <!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel Admin</h1>
        <div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">
            Welcome, <?php echo htmlspecialchars($adminUser['vorname']); ?>!
        </div>
    </header>

    <!-- Navigation -->
    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="forms/logoutlogic.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slideshow-Bereich -->
    <div class="slideshow">
        <div class="slide s1" style="background-image: url('assets/img/Homepage_img1.jpg');"></div>
        <div class="slide s2" style="background-image: url('assets/img/Homepage_img2.jpg');"></div>
        <div class="slide s3" style="background-image: url('assets/img/Homepage_img3.jpg');"></div>
        <div class="slideshow-text">Admin Dashboard</div>
    </div>

    <!-- Admin Inhalte -->
    <main class="container py-5">
        <h2 class="text-center mb-5">Management</h2>

        <div class="row g-4">
            <!-- Zimmer verwalten -->
            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Manage Rooms</h5>
                        <p class="card-text">Add new rooms or edit existing ones.</p>
                        <a href="Manageroomspage.php" class="btn-admin">Manage Rooms</a>
                    </div>
                </div>
            </div>

            

            <!-- Buchungen prüfen -->
            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Check Bookings</h5>
                        <p class="card-text">View, edit, or cancel all bookings.</p>
                        <a href="Checkbookingspage.php" class="btn-admin">Check Bookings</a>
                    </div>
                </div>
            </div>

            <!-- Auslastung / Berichte -->
            <div class="col-md-12">
                <div class="card admin-card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Occupancy & Reports</h5>
                        <p class="card-text">Overview of occupied rooms and occupancy.</p>
                        <a href="Reportspage.php" class="btn-admin">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
