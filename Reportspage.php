<?php
session_start();
require_once 'database.php'; 

// 1. Sicherheits-Check: Ist User eingeloggt UND Admin?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

// --- LOGIK FÜR BERICHTE ---

// 1. Gesamteinnahmen (Total Revenue)
$sqlRevenue = "SELECT SUM(total_price) as total_revenue FROM bookings";
$resRevenue = $conn->query($sqlRevenue);
$totalRevenue = $resRevenue->fetch_assoc()['total_revenue'] ?? 0;

// 2. Anzahl aller Buchungen (Total Bookings)
$sqlCount = "SELECT COUNT(*) as total_bookings FROM bookings";
$resCount = $conn->query($sqlCount);
$totalBookings = $resCount->fetch_assoc()['total_bookings'] ?? 0;

// 3. Aktive Buchungen heute (Gäste im Haus)
$heute = date('Y-m-d');
$sqlActive = "SELECT COUNT(*) as active_now FROM bookings WHERE check_in <= '$heute' AND check_out > '$heute'";
$resActive = $conn->query($sqlActive);
$activeNow = $resActive->fetch_assoc()['active_now'] ?? 0;

// 4. Statistik nach Zimmertyp (Welcher Raum läuft am besten?)
$sqlRooms = "SELECT room_type, COUNT(*) as count, SUM(total_price) as revenue 
             FROM bookings 
             GROUP BY room_type 
             ORDER BY revenue DESC";
$resRooms = $conn->query($sqlRooms);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Stats - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Kleines extra Styling für die Dashboard-Karten */
        .stat-card {
            border-left: 5px solid rgb(1, 65, 91);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 2.5rem;
            color: rgb(1, 65, 91);
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <header class="container-fluid p-0 position-relative">
        <?php require_once __DIR__ . '/includes/header.php'; ?>
    </header>

    <?php require_once __DIR__ . '/includes/adminnav.php'; ?>

    <main class="container py-5">
        <h2 class="text-center mb-4">Occupancy & Reports</h2>
        <p class="text-center text-muted mb-5">Key metrics and performance overview of EA Hotel.</p>

        <div class="row g-4 mb-5">
            
            <div class="col-md-4">
                <div class="card stat-card shadow-sm h-100 py-3">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold">Total Revenue</h6>
                            <h2 class="mb-0 fw-bold text-success"><?php echo number_format($totalRevenue, 2); ?> €</h2>
                        </div>
                        <div class="icon-box">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm h-100 py-3">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold">Total Bookings</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $totalBookings; ?></h2>
                        </div>
                        <div class="icon-box">
                            <i class="bi bi-bookmark-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm h-100 py-3">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold">Active Today</h6>
                            <h2 class="mb-0 fw-bold text-primary"><?php echo $activeNow; ?></h2>
                            <small class="text-muted">Rooms occupied currently</small>
                        </div>
                        <div class="icon-box">
                            <i class="bi bi-house-door-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-secondary"><i class="bi bi-bar-chart-fill me-2"></i>Performance by Room Type</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Room Type</th>
                                <th class="text-center">Bookings Count</th>
                                <th class="text-end">Total Revenue Generated</th>
                                <th class="text-end">Avg. Price per Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resRooms->num_rows > 0): ?>
                                <?php while($row = $resRooms->fetch_assoc()): ?>
                                    <?php 
                                        $avg = $row['count'] > 0 ? $row['revenue'] / $row['count'] : 0; 
                                    ?>
                                    <tr>
                                        <td class="fw-bold text-primary"><?php echo htmlspecialchars($row['room_type']); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill"><?php echo $row['count']; ?></span>
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            <?php echo number_format($row['revenue'], 2); ?> €
                                        </td>
                                        <td class="text-end text-muted">
                                            ~ <?php echo number_format($avg, 2); ?> €
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">No booking data available yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="Adminpage.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>