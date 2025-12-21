<!DOCTYPE html>
<!-- Header -->
    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>

        <?php
        if (isset($_SESSION['loggedin'])) {
            $user = $_SESSION['users'][$_SESSION['loggedin']];

            echo '<div class="welcome-bar position-absolute top-0 end-0 me-3 mt-2">'
            . 'Welcome, ' . htmlspecialchars($user['vorname']) . '!'
            . '</div>';
        }
        ?>
        
    </header>
    </html>