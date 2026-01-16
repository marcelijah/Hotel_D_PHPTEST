<?php
session_start();
require_once 'database.php';

// Nur Admin darf Nachrichten lesen
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

// Nachrichten abrufen (neueste zuerst)
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Guest Messages - EA Hotel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Adminpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <header class="container-fluid p-0 position-relative">
        <h1 class="EA-Hotel text-center text-md-start ps-md-5">EA Hotel</h1>
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
        <h2 class="text-center mb-4">Guest Messages & Inquiries</h2>

        <div class="card shadow-sm p-4">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td style="white-space:nowrap;"><?php echo date("d.m.Y H:i", strtotime($row['created_at'])); ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['sender_name']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($row['sender_email']); ?>"><?php echo htmlspecialchars($row['sender_email']); ?></a></td>
                                    
                                    <td><?php echo nl2br(htmlspecialchars($row['message_text'])); ?></td>
                                    
                                    <td>
                                        <?php if (!empty($row['attachment_path'])): ?>
                                            <a href="uploads/<?php echo htmlspecialchars($row['attachment_path']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-paperclip"></i> View File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4 class="text-muted">No messages yet.</h4>
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