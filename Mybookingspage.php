<?php
session_start();
require_once 'database.php';

// Prüfen ob eingeloggt
if (!isset($_SESSION['loggedin'])) {
    header("Location: Loginpage.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Buchungen für diesen User holen
$sql = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>My Bookings - EA Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Homepage.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <div class="slideshow" style="height: 300px; overflow: hidden; position: relative;">
         <div class="slideshow-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 2rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">My Bookings</div>
    </div>

     <main class="container py-5 flex-fill">
        <h2 class="text-center mb-4">Your Booking Overview</h2>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success text-center">Booking successful! We look forward to your visit.</div>
        <?php endif; ?>

        <div class="card shadow-sm p-4">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Booking ID</th>
                                <th>Room</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Guests</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['booking_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                                    <td><?php echo date("d.m.Y", strtotime($row['check_in'])); ?></td>
                                    <td><?php echo date("d.m.Y", strtotime($row['check_out'])); ?></td>
                                    <td><?php echo $row['guests']; ?></td>
                                    <td class="fw-bold"><?php echo $row['total_price']; ?> €</td>
                                    <td><span class="badge bg-success">Confirmed</span></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <h4>No bookings found.</h4>
                    <p>You haven't booked any rooms yet.</p>
                    <a href="Roomsavailabilitypage.php" class="btn btn-primary" style="background-color: rgb(1, 65, 91);">Book a Room now</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>