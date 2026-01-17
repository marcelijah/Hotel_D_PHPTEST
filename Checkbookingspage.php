<?php
session_start();
require_once 'database.php';

// 1. Sicherheits-Check: Nur Admin darf hier rein
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

// 2. Buchungen abrufen
// Wir verknüpfen (JOIN) die Tabelle 'bookings' mit 'users', 
// damit wir den Namen des Gastes anzeigen können.
$sql = "SELECT b.*, u.`First Name`, u.Surname, u.`E-Mail` 
        FROM bookings b 
        JOIN users u ON b.user_id = u.ID 
        ORDER BY b.booking_date DESC";
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
        <?php require_once __DIR__ . '/includes/header.php'; ?>
    </header>

    <?php require_once __DIR__ . '/includes/adminnav.php'; ?>

    <main class="container py-5">
        <h2 class="text-center mb-4">Manage Bookings</h2>
        
        <?php if(isset($_GET['mailsent'])): ?>
            <div class="alert alert-success text-center">Email sent successfully to the guest!</div>
        <?php endif; ?>

        <div class="card shadow-sm p-4">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Check-In / Out</th>
                                <th>Guests</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['booking_id']; ?></td>
                                    
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['First Name'] . " " . $row['Surname']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['E-Mail']); ?></small>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                                    
                                    <td>
                                        <?php echo date("d.m.Y", strtotime($row['check_in'])); ?> <br>
                                        <i class="bi bi-arrow-down-short text-muted"></i> <br>
                                        <?php echo date("d.m.Y", strtotime($row['check_out'])); ?>
                                    </td>
                                    
                                    <td class="text-center"><?php echo $row['guests']; ?></td>
                                    
                                    <td class="fw-bold text-success">
                                        <?php echo number_format($row['total_price'], 2); ?> €
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="AdminContactGuest.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn btn-outline-primary btn-sm" title="Send Message">
                                                <i class="bi bi-envelope-at-fill"></i> Contact
                                            </a>

                                            <form action="forms/delete_booking.php" method="POST" onsubmit="return confirm('Do you really want to cancel this booking? This cannot be undone.');" style="display:inline;">
                                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Cancel Booking">
                                                    <i class="bi bi-trash3-fill"></i> Cancel
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <?php if(!empty($row['admin_message'])): ?>
                                            <div class="mt-2">
                                                <span class="badge bg-info text-dark" style="font-size: 0.7rem;">
                                                    <i class="bi bi-chat-text"></i> Message sent
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4 class="text-muted">No active bookings found.</h4>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="Adminpage.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>