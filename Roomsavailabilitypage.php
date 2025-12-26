<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Reservation - EA Hotel</title>
        <link rel="stylesheet" href="assets/css/RoomsAvailabilitypage.css">

    </head>
    <body>
        
    <?php require_once __DIR__ . '/includes/header.php'; ?>

   <?php require_once __DIR__ . '/includes/nav.php'; ?>


        <main class="flex-grow-1">
        <h1 class="TitelBuchen">Book A Room in EA Hotel</h1>
        <h2 class="TitelGebenSie ">Enter your data and book your stay in Larnaca.</h2>

        <section class="Buchung">
            
            <form action="Bookingdetailspage.php" method="Post" class="Buchung-form">

                <div class="container mt-4">
                <div class="row justify-content-center g-4 zimmer-auswahl-bilder">

                    <div class="col-12 col-md-6 text-center">
                      <div class="zimmer-text mb-2">
                            <p>Cozy single room with modern amenities and free Wi-Fi.</p>
                            <p class="zimmer-preis">Price: 75€ / night</p>
                        </div>
                        <input type="radio" class="btn-check" name="Zimmer" id="Single room" value="Single room" autocomplete="off">
                        <label for="Single room" class="zimmer-label btn p-0 w-100">
                            <img src="assets/img/Room_img1.jpg" class="img-fluid rounded shadow zimmer-img" alt="Single room">
                            <div class="fw-bold mt-2">Single Room</div>
                        </label>
                    </div>

                    <div class="col-12 col-md-6 text-center">
                        <div class="zimmer-text mb-2">
                            <p>Spacious double room with balcony, ideal for couples or friends.</p>
                            <p class="zimmer-preis">Price: 120€ / night</p>
                        </div>
                        <input type="radio" class="btn-check" name="Zimmer" id="Double room" value="Double room" autocomplete="off">
                        <label for="Double room" class="zimmer-label btn p-0 w-100">
                            <img src="assets/img/Room_img2.jpg" class="img-fluid rounded shadow zimmer-img" alt="Double room">
                            <div class="fw-bold mt-2">Double Room</div>
                        </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="Personen">Guests</label>
                    <input type="number" name="Personen" id = "Personen" min="1" max="2" required>
                </div>

                <div class="Datum">
                    <label for="Check-in">Check-in</label>
                    <input id="Check-in" name="Check-in" type="date" value required>
                    <label for="Check-out">Check-out</label>
                    <input id="Check-out" name="Check-out" type="date" value required>
                </div>

                <button type="submit" class="submit-button" name="verfügbarkeit">Check Availability</button>
            </form>
        </section>
        </main>

        

        <!-- Footer -->
        <?php require_once __DIR__ . '/includes/footer.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>         
    </body>
</html>    