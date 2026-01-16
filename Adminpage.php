<?php
session_start();

// 1. Sicherheits-Check: Ist der User eingeloggt UND ist er Admin?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

$adminName = $_SESSION['user_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <header class="container-fluid p-0 position-relative">
        <?php require_once __DIR__ . '/includes/header.php'; ?>
    </header>

    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="Adminpage.php">Admin Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="forms/logoutlogic.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="slideshow">
        <div class="slide s1" style="background-image: url('assets/img/Homepage_img1.jpg');"></div>
        <div class="slide s2" style="background-image: url('assets/img/Homepage_img2.jpg');"></div>
        <div class="slide s3" style="background-image: url('assets/img/Homepage_img3.jpg');"></div>
        <div class="slideshow-text">Admin Dashboard</div>
    </div>

    <main class="container py-5">
        
        <h2 class="text-center mb-5">Management Dashboard for <?php echo htmlspecialchars($adminName); ?></h2>

        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="mb-3 text-primary fs-1"><i class="bi bi-houses-fill"></i></div>
                        <h5 class="card-title">Manage Rooms</h5>
                        <p class="card-text">Add new rooms, edit prices or capacities.</p>
                        <a href="Manageroomspage.php" class="btn-admin mt-auto">Manage Rooms</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="mb-3 text-success fs-1"><i class="bi bi-calendar-check-fill"></i></div>
                        <h5 class="card-title">Check Bookings</h5>
                        <p class="card-text">View all reservations and cancel bookings.</p>
                        <a href="Checkbookingspage.php" class="btn-admin mt-auto">Check Bookings</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="mb-3 text-warning fs-1"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <h5 class="card-title">Occupancy & Reports</h5>
                        <p class="card-text">View revenue stats and current occupancy.</p>
                        <a href="Reportspage.php" class="btn-admin mt-auto">View Reports</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card admin-card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="mb-3 text-info fs-1"><i class="bi bi-envelope-paper-fill"></i></div>
                        <h5 class="card-title">Guest Inquiries</h5>
                        <p class="card-text">Read messages and view file attachments.</p>
                        <a href="AdminMessages.php" class="btn-admin mt-auto">Inbox</a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>