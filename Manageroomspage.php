<?php
session_start();
// Wir binden die Datenbank ein, falls wir später die Zimmeranzahl direkt anzeigen wollen
require_once 'database.php'; 

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
    <title>Manage Rooms - EA Hotel Admin</title>
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
        <h2 class="text-center mb-4">Manage Rooms</h2>
        <p class="text-center">Here you can add new rooms or edit existing ones.</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm text-center p-4">
                    <h5>Add New Room</h5>
                    <p class="text-muted small">Create a new room type in the database.</p>
                    <a href="#" class="btn-admin mt-3">Add Room</a>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm text-center p-4">
                    <h5>Edit Existing Rooms</h5>
                    <p class="text-muted small">Change prices or descriptions.</p>
                    <a href="#" class="btn-admin mt-3">Edit Rooms</a>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>