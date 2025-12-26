<?php
session_start();
require_once 'database.php';

// 1. Sicherheits-Check: Ist User eingeloggt UND Admin?
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: Homepage.php");
    exit;
}

$msg = "";

// --- LOGIK: NEUES ZIMMER HINZUFÜGEN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $newName = trim($_POST['new_name']);
    $newPrice = (float)$_POST['new_price'];
    $newCapacity = (int)$_POST['new_capacity'];

    if (!empty($newName) && $newPrice > 0 && $newCapacity > 0) {
        // Prüfen ob Name schon existiert
        $check = $conn->prepare("SELECT id FROM room_types WHERE name = ?");
        $check->bind_param("s", $newName);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>Error: A room with this name already exists!</div>";
        } else {
            // Einfügen
            $stmt = $conn->prepare("INSERT INTO room_types (name, price, capacity) VALUES (?, ?, ?)");
            $stmt->bind_param("sdi", $newName, $newPrice, $newCapacity);
            if ($stmt->execute()) {
                $msg = "<div class='alert alert-success'>New room type added successfully!</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Database Error: " . $conn->error . "</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please fill in all fields correctly.</div>";
    }
}

// --- LOGIK: ZIMMER UPDATEN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_room'])) {
    $id = (int)$_POST['room_id'];
    $price = (float)$_POST['price'];
    $capacity = (int)$_POST['capacity'];

    $stmt = $conn->prepare("UPDATE room_types SET price=?, capacity=? WHERE id=?");
    $stmt->bind_param("dii", $price, $capacity, $id);
    if($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Room updated successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error updating room.</div>";
    }
}

// --- LOGIK: ZIMMER LÖSCHEN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_room'])) {
    $id = (int)$_POST['room_id'];
    // Achtung: Das löscht den Zimmertyp. Alte Buchungen bleiben erhalten, 
    // aber referenzieren dann evtl. einen nicht mehr existierenden Typ, 
    // falls du keine Foreign Key Constraints hast.
    $stmt = $conn->prepare("DELETE FROM room_types WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Room type deleted.</div>";
    }
}

// --- DATEN LADEN: Alle Zimmer holen ---
$result = $conn->query("SELECT * FROM room_types ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Manage Rooms - EA Hotel Admin</title>
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
        <h2 class="text-center mb-4">Manage Rooms</h2>
        
        <?php echo $msg; ?>

        <div class="row g-4">
            
            <div class="col-12">
                <div class="card shadow-sm p-4 border-top border-3" style="border-color: rgb(1, 65, 91) !important;">
                    <h5 class="mb-3"><i class="bi bi-plus-circle-fill"></i> Add New Room Type</h5>
                    <form method="POST" action="" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Room Name (e.g. "Suite")</label>
                            <input type="text" name="new_name" class="form-control" required placeholder="Name">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price per Night (€)</label>
                            <input type="number" step="0.01" name="new_price" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Total Capacity</label>
                            <input type="number" name="new_capacity" class="form-control" required placeholder="10">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="add_room" class="btn btn-success w-100">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm p-4">
                    <h5 class="mb-3">Existing Rooms</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Room Name</th>
                                    <th>Price (€)</th>
                                    <th>Capacity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <form method="POST" action="">
                                                <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
                                                
                                                <td><?php echo $row['id']; ?></td>
                                                
                                                <td>
                                                    <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                                                </td>
                                                
                                                <td>
                                                    <input type="number" step="0.01" name="price" class="form-control form-control-sm" style="width: 100px;" value="<?php echo $row['price']; ?>">
                                                </td>
                                                
                                                <td>
                                                    <input type="number" name="capacity" class="form-control form-control-sm" style="width: 80px;" value="<?php echo $row['capacity']; ?>">
                                                </td>
                                                
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="submit" name="update_room" class="btn btn-sm btn-primary" title="Save Changes">
                                                            <i class="bi bi-floppy"></i> Save
                                                        </button>
                                                        
                                                        <button type="submit" name="delete_room" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure? This will remove the room type from the database.');" title="Delete Room">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center">No rooms found. Add one above!</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>