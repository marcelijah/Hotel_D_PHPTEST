<?php
session_start();
require_once 'database.php';

// 1. Sicherheits-Check: Ist User eingeloggt UND Admin?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

// 2. Buchungen aus der Datenbank holen
// WICHTIG: Wir nutzen Backticks (`), da deine Spaltennamen Leerzeichen/Bindestriche haben (First Name, E-Mail)
$sql = "SELECT 
            b.booking_id, b.room_type, b.check_in, b.check_out, b.guests, b.total_price, b.booking_date,
            u.`First Name` as vorname, 
            u.Surname as nachname, 
            u.`E-Mail` as email
        FROM bookings b
        JOIN users u ON b.user_id = u.ID
        ORDER BY b.booking_date DESC"; // Neueste Buchungen zuerst

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Bookings - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel Admin</h1>
        <div class="welcome-bar position-absolute top-0 end-0 me-3 mt-3">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
        </div>
    </header>

    <nav class="Leiste navbar navbar-expand-md navbar-dark sticky-top">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="Adminpage.php">Admin Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="forms/logoutlogic.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-5">
        <h2 class="text-center mb-4">Check Bookings</h2>
        <p class="text-center text-muted">Overview of all reservations in the system.</p>

        <?php if(isset($_GET['deleted'])): ?>
            <div class="alert alert-success text-center mx-auto" style="max-width: 600px;">
                Booking cancelled successfully. Capacity has been restored.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm p-4 buchung-box">
            
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Guest Info</th>
                                <th>Room Type</th>
                                <th>Check-In / Out</th>
                                <th>Guests</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold">#<?php echo $row['booking_id']; ?></td>
                                    
                                    <td class="text-start">
                                        <strong><?php echo htmlspecialchars($row['vorname'] . " " . $row['nachname']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary" style="background-color: rgb(1, 65, 91) !important;">
                                            <?php echo htmlspecialchars($row['room_type']); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php echo date('d.m.Y', strtotime($row['check_in'])); ?> <br>
                                        <i class="bi bi-arrow-down-short"></i> <br>
                                        <?php echo date('d.m.Y', strtotime($row['check_out'])); ?>
                                    </td>

                                    <td><?php echo $row['guests']; ?></td>

                                    <td class="fw-bold text-success">
                                        <?php echo number_format($row['total_price'], 2); ?> €
                                    </td>

                                    <td>
                                        <form action="forms/delete_booking.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Cancel Booking">
                                                <i class="bi bi-trash3-fill"></i> Cancel
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4 class="text-muted">No bookings found yet.</h4>
                    <p>Wait for customers to reserve rooms.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>