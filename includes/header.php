<!DOCTYPE html>
<header class="container-fluid p-0 position-relative">
    <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

    <?php
    // Prüfen, ob der User eingeloggt ist (true) UND ob ein Name da ist
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_name'])) {
        
        echo '<div class="welcome-bar position-absolute top-0 end-0 me-3 mt-2">'
           . 'Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '!'
           . '</div>';
           
    }
    ?>
    
</header>