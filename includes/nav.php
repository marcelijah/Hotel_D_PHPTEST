<!DOCTYPE html>
<html>

    <!-- Navigation -->
    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
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

                    <?php
                    if (!isset($_SESSION['loggedin'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="Loginpage.php">Login</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Registrationpage.php">Register</a></li>';
                    }

                    if (isset($_SESSION['loggedin'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="Mybookingspage.php">My Bookings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="forms/logoutlogic.php">Logout</a></li>';
                    }


                    ?>

                </ul>
            </div>
        </div>
    </nav>
</html>