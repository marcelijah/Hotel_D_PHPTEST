<?php
session_start();
require 'forms/users.php';

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
<title>Edit Bookings - EA Hotel Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel Admin</h1>
        <div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">
            Willkommen, <?php echo htmlspecialchars($adminUser['vorname']); ?>!
        </div>
    </header>

    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
    </nav>

    <main class="container py-5">
        <h2 class="text-center mb-4">Buchungen prüfen</h2>
        <p class="text-center">Hier können alle Buchungen eingesehen, bearbeitet oder storniert werden.</p>

        <div class="card shadow-sm p-4 buchung-box">
            <h5 class="text-center mb-3">Alle Buchungen</h5>
            <a href="#" class="btn-admin d-block mx-auto">Buchungen anzeigen</a>
        </div>
    </main>

    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EA Hotel</p>
        <p>123 Finikoudes Avenue, 6023 Larnaca, Zypern</p>
        <p>+4369910059138</p>
        <p>wi24b056@technikum-wien.at</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
