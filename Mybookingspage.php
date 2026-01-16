<?php
session_start();
require_once 'database.php';

// Prüfen ob eingeloggt
if (!isset($_SESSION['loggedin'])) {
    header("Location: Loginpage.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Buchungen holen
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <div class="slideshow" style="height: 300px; overflow: hidden; position: relative;">
         <div class="slideshow-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgb(1, 65, 91); font-size: 3rem; font-weight: bold;">My Bookings</div>
    </div>

     <main class="container py-5 flex-fill">
        <h2 class="text-center mb-4">Your Booking Overview</h2>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success text-center">Booking successful! We look forward to your visit.</div>
        <?php endif; ?>
        
        <?php if(isset($_GET['updated'])): ?>
            <div class="alert alert-success text-center">Your booking has been updated successfully!</div>
        <?php endif; ?>

        <?php if(isset($_GET['deleted'])): ?>
            <div class="alert alert-warning text-center">Booking cancelled successfully.</div>
        <?php endif; ?>

        <div class="card shadow-sm p-4">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Details</th> <th>Dates</th>
                                <th>Price</th>
                                <th style="width: 30%;">Status & Messages</th> <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['booking_id']; ?></td>
                                    
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['room_type']); ?></strong><br>
                                        <small class="text-muted"><?php echo $row['guests']; ?> Guest(s)</small>
                                    </td>
                                    
                                    <td>
                                        <?php echo date("d.m.y", strtotime($row['check_in'])); ?> <br>
                                        <i class="bi bi-arrow-down small"></i> <br>
                                        <?php echo date("d.m.y", strtotime($row['check_out'])); ?>
                                    </td>
                                    
                                    <td class="fw-bold"><?php echo $row['total_price']; ?> €</td>
                                    
                                    <td>
                                        <span class="badge bg-success mb-2">Confirmed</span>
                                        
                                        <?php if (!empty($row['admin_message'])): ?>
                                            <div class="alert alert-info p-2 mb-0 small border-primary">
                                                <i class="bi bi-chat-quote-fill text-primary"></i> 
                                                <strong>Message from Hotel:</strong><br>
                                                <?php echo nl2br(htmlspecialchars($row['admin_message'])); ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="EditBooking.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <form action="forms/user_cancel_booking.php" method="POST" onsubmit="return confirm('Do you really want to cancel this booking?');">
                                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                    <i class="bi bi-trash"></i> Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </td>

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