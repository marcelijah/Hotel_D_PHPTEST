<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Contactpage.css">
</head>
<body>
    
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <div class="slideshow">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
        <div class="slideshow-text">Contact Us</div>
    </div>

    <div class="kontakt">
        <div class="kontakt-container">
            <div class="kontakt-image">
                <img src="assets/img/Contact_img1.jpg" alt="Willkommen im EA Hotel">
            </div>
            <div class="kontakt-textbox">
                <h2>Contact Us</h2>
                <div class="divider"></div>
                <div class="Daten">    
                    <h2>Reservation Department</h2>
                    <h3>Arian Sadeghian</h3>
                    <p>wi24b056@technikum-wien.at</p>
                    <p>+43 699 10059138</p>

                    <h2>Front Desk</h2>
                    <h3>Elijah-Marcel Manikan</h3>
                    <p>wi24b187@technikum-wien.at</p>
                    <p>+43 660 2234042</p>
                </div>    
            </div>
        </div>
    </div>

    <h1 class="KontaktTitel">Send us a message</h1>
    
    <?php if(isset($_GET['status'])): ?>
        <div class="container text-center mb-4">
            <?php if($_GET['status'] == 'success'): ?>
                <div class="alert alert-success">Message sent successfully! We will get back to you soon.</div>
            <?php elseif($_GET['status'] == 'error'): ?>
                <div class="alert alert-danger">Error sending message. Please try again.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <section class="FormularBereich">
        <form action="forms/contact_send.php" method="post" class="FormularBox" enctype="multipart/form-data">
            <div class="FormFeld">
                <label for="Vorname">First Name</label>
                <input id="Vorname" name="Vorname" type="text" required 
                       value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">

                <label for="Nachname">Surname</label>
                <input id="Nachname" name="Nachname" type="text" required>           

                <label for="email">E-Mail</label>
                <input id="email" name="email" type="email" required>                

                <label for="Nachricht">Message</label>
                <textarea id="Nachricht" name="Nachricht" rows="4" required></textarea>
            </div>
            
            <div class="d-flex align-items-end gap-3 mt-3">
                <div class="flex-grow-1">
                    <label for="attachment" class="form-label mb-1 fw-bold text-muted" style="font-size: 0.9rem;">Attach File (optional)</label>
                    <input class="form-control" type="file" id="attachment" name="attachment">
                </div>
                
                <button id="Button" type="submit" class="btn" style="height: 38px; margin-top: 0; min-width: 100px;">Send</button>
            </div>

        </form>

    </section>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>     

</body>
</html>