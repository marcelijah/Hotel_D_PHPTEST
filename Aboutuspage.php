        <?php session_start(); ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <title>About Us - EA Hotel</title>
            <link rel="stylesheet" href="assets/css/Aboutuspage.css">
        </head>
        <body>
                
        <?php require_once __DIR__ . '/includes/header.php'; ?>

        <?php require_once __DIR__ . '/includes/nav.php'; ?>


        <div class="slideshow">
            <div class="slide s1"></div>
            <div class="slide s2"></div>
            <div class="slide s3"></div>
            <div class="slideshow-text">About Us</div>
        </div>

        <div class="container Überuns-container my-5">
            <h2>About EA Hotel</h2>
            <div class="Überuns-textbox">
                <p>Situated directly on the azure Mediterranean, just a few steps from the stunning sandy beach of Larnaca, the EA Hotel is a retreat that combines the natural beauty of Cyprus with modern comfort and Mediterranean serenity. Surrounded by a vibrant environment characterized by Cypriot hospitality and international flair, our hotel blends tranquility and elegance with proximity to the island's cultural treasures, such as the famous Finikoudes promenade and the historic Church of Saint Lazarus.</p>
                <p>Our goal is to delight every guest in a personal, sincere, and unique way, understanding their wishes and meeting them with transparency, professionalism, and warmth.</p>
                <p>Our daily mission is to make a tangible difference—through continuous improvement, careful attention to detail, and tailored services designed to make your stay unforgettable. We want to help you rediscover a sense of your own time, relaxation, and rhythm by offering an atmosphere that harmoniously combines peace, inspiration, and well-being.</p>
                <p>At the EA Hotel, we strive to consistently meet the highest quality standards while bringing the warm, authentic soul of Cyprus to life in every experience.</p>
            </div>
        </div>

        <div class="container EA-Team-container my-5">
            <div class="row align-items-center mb-5 EA-Team1">
                <div class="col-md-6 team-textbox">
                    <h2>The EA Team</h2>
                    <div class="divider"></div>
                   <p>At the EA Hotel in Larnaca, Cyprus, Arian is a key member of our team. With great dedication and passion, he ensures that every guest feels welcome and well cared for from the very first moment.</p>
                    <p>Arian pays attention to every detail—from the warm welcome to individual requests during your stay—ensuring that your visit becomes an unforgettable experience.</p>
                    <p>Thanks to his experience and organizational skills, he ensures that hotel operations run smoothly, allowing our guests to relax completely. His goal is to add a personal touch to every stay that leaves a lasting impression.</p>
                </div>
                <div class="col-md-6 team-image">
                    <img src="assets/img/Contact_img1.jpg" alt="Cooles Instafoto von Arian" class="img-fluid">
                </div>
            </div>

            <div class="row align-items-center mb-5 EA-Team2">
                <div class="col-md-6 team-image">
                    <img src="assets/img/Contact_img1.jpg" alt="Cooles Instafoto von Elijah" class="img-fluid">
                </div>
                <div class="col-md-6 team-textbox">
                   <p>Elijah is the heart of our team at the EA Hotel in Larnaca. With his positive energy and dedication, he ensures that our guests enjoy every moment of their stay.</p>
                    <p>He works daily to provide our guests with unique experiences that are both relaxing and inspiring. He pays special attention to every request, always striving to find individual solutions.</p>
                    <p>His passion for excellent service and his eye for small but significant details make every stay special. Elijah's goal is for every guest to leave not just satisfied, but delighted and filled with beautiful memories.</p>
                </div>
            </div>
        </div>

        <div class="container Lage-container my-5">
            <div class="row Lage-content align-items-center">
                <div class="col-md-6 Lage-textbox">
                    <h2>Location</h2>
                <div class="divider"></div>
                    <p>Located directly on the coast of Larnaca, overlooking the glittering Mediterranean Sea, the EA Hotel offers the perfect retreat for guests seeking to combine relaxation, comfort, and the Cypriot lifestyle. You are just steps away from golden sandy beaches, and the vibrant promenade with its cafés, boutiques, and cultural sights is within easy reach.</p>
                    <p>Our surroundings offer a perfect blend of tranquility and activity: enjoy a relaxing stroll by the sea, explore the city's historical sites, or experience authentic Cypriot hospitality in the nearby restaurants and markets. The EA Hotel is the ideal destination for those seeking both relaxation and cultural experiences.</p>
                    <p>We are dedicated to making every stay with us unforgettable. With attention to detail, professional service, and an atmosphere that blends Mediterranean serenity with modern comfort, we create a sanctuary where you can recharge and cherish special moments.</p>
                </div>
                <div class="col-md-6 Lage-image">
                    <img src="assets/img/Location_img1.jpg" alt="Foto von der Lage" class="img-fluid">
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once __DIR__ . '/includes/footer.php'; ?>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
