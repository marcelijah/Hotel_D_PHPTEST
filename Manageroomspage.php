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
    <title>Manage Rooms - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
    </head>
    <body>

    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel Admin</h1>
        <div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">
            Welcome, <?php echo htmlspecialchars($adminUser['vorname']); ?>!
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
        <h2 class="text-center mb-4">Manage Rooms</h2>
        <p class="text-center">Here you can add new rooms or edit existing ones.</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm text-center p-4">
                    <h5>Add New Room</h5>
                    <a href="#" class="btn-admin mt-3">Add Room</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm text-center p-4">
                    <h5>Edit Existing Rooms</h5>
                    <a href="#" class="btn-admin mt-3">Edit Rooms</a>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
