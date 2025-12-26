<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Registrationpage.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

    <nav class="Leiste navbar navbar-expand-md navbar-dark">
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
                    <li class="nav-item"><a class="nav-link" href="Loginpage.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="Registrationpage.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
        <div class="container my-5">
            <h1 class="RegistrierenTitel text-center">Register</h1>
            <h3 class="Registrieren text-center mb-4">Register yourself</h3>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <!-- Fehlermeldung -->
                    <?php
                    if(isset($_SESSION['register_error'])) {
                        echo '<div class="alert alert-danger text-center mb-3">'.$_SESSION['register_error'].'</div>';
                        unset($_SESSION['register_error']);
                    }
                    ?>

                    <form action="forms/registerlogic.php" method="post" class="FormularioBox">
                        <div class="mb-3">
                            <label for="Vorname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="Vorname" name="Vorname" required>
                        </div>
                        <div class="mb-3">
                            <label for="Nachname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="Nachname" name="Nachname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="Passwort" class="form-label">Password</label>
                            <input type="password" class="form-control" id="Passwort" name="Passwort" required>
                        </div>
                        <button type="submit" class="btn w-100" id="Button">Register</button>
                    </form>

                    <div class="KeinAccount mt-3 text-center">
                        <a href="Loginpage.php">You already have an account?</a>
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
