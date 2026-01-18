<?php
// Session starten, um auf Login-Daten zuzugreifen
session_start();

// --- SICHERHEITS-CHECK ---
// 1. Ist der User eingeloggt?
// 2. Ist das Admin-Flag gesetzt?
// 3. Ist der Wert des Admin-Flags exakt 1?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    // Falls nein: Sofortige Weiterleitung zur Startseite (Schutz vor unbefugtem Zugriff)
    header("Location: Homepage.php");
    exit;
}

// Name des Admins für die Begrüßung holen (Fallback auf "Admin", falls leer)
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
    
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <?php require_once __DIR__ . '/includes/adminnav.php'; ?>

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