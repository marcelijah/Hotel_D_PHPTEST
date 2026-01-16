<?php
session_start();
require_once 'database.php';

// Nur Admin
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

$booking_id = $_GET['booking_id'] ?? 0;

// Gastdaten zur Buchung laden
// Wir nutzen Backticks für `E-Mail`, `First Name`
$sql = "SELECT b.*, u.`First Name`, u.Surname, u.`E-Mail` 
        FROM bookings b 
        JOIN users u ON b.user_id = u.ID 
        WHERE b.booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) die("Booking not found.");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Contact Guest - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-primary">Contact Guest regarding Booking #<?php echo $booking_id; ?></h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="alert alert-info">
                            <strong>Recipient:</strong> <?php echo htmlspecialchars($booking['First Name'] . " " . $booking['Surname']); ?> <br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($booking['E-Mail']); ?>
                        </div>

                        <form action="forms/admin_send_mail.php" method="POST">
                            <input type="hidden" name="guest_email" value="<?php echo htmlspecialchars($booking['E-Mail']); ?>">
                            <input type="hidden" name="booking_ref" value="<?php echo $booking_id; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Subject</label>
                                <input type="text" name="subject" class="form-control" value="Regarding your reservation #<?php echo $booking_id; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Message</label>
                                <textarea name="message" class="form-control" rows="6" required placeholder="Dear Guest..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="Checkbookingspage.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Send Email</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>