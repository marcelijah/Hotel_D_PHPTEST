<?php
session_start();
require_once 'database.php'; // Datenbankverbindung (falls wir später Berichte laden)

// 1. Sicherheits-Check: Ist User eingeloggt UND Admin (is_admin === 1)?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

// Das alte Array $adminUser brauchen wir nicht mehr.
// Der Name steht jetzt in $_SESSION['user_name'].
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occupancy & Reports - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
</head>

<body>

    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel Admin</h1>
        <div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
        </div>
    </header>

    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="Adminpage.php">Admin Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="forms/logoutlogic.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-5">
        <h2 class="text-center mb-4">Occupancy & Reports</h2>
        <p class="text-center">Here you can view the occupancy and reports of the hotel.</p>

        <div class="card shadow-sm p-4 text-center berichte-box">
            <h5>View Occupancy</h5>
            <p class="text-muted small">Generate reports about bookings and earnings.</p>
            
            <a href="#" class="btn-admin d-block mx-auto" style="max-width: 200px;">View Reports</a>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>