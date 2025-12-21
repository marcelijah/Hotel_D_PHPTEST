<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Anmelden.css">
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
                    <li class="nav-item"><a class="nav-link" href="Zimmer&Verfügbarkeit.php">Zimmer & Verfügbarkeit</a></li>
                    <li class="nav-item"><a class="nav-link" href="Kontakt.php">Kontakt</a></li>
                    <li class="nav-item"><a class="nav-link" href="ÜberUns.php">Über Uns</a></li>
                    <li class="nav-item"><a class="nav-link" href="Anmelden.php">Anmelden</a></li>
                    <li class="nav-item"><a class="nav-link" href="Registrierung.php">Registrieren</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
        <div class="container my-5">
            <h1 class="AnmeldenTitel text-center">Anmelden</h1>
            <h3 class="Anmelden text-center mb-4">Melden Sie sich an</h3>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <!-- Fehlermeldung -->
                    <?php
                    if(isset($_SESSION['login_error'])) {
                        echo '<div class="alert alert-danger text-center mb-3">'.$_SESSION['login_error'].'</div>';
                        unset($_SESSION['login_error']);
                    }
                    ?>

                    <form action="forms/login.php" method="post" class="FormularioBox">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="Passwort" class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="Passwort" name="Passwort" required>
                        </div>
                        <button type="submit" class="btn w-100" id="Button">Anmelden</button>
                    </form>

                    <div class="KeinAccount mt-3 text-center">
                        <a href="Registrierung.php">Noch keinen Account?</a>
                    </div>
                </div>
            </div>
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
