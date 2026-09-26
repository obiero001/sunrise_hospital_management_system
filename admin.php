<?php
// admin.php - Manage Appointments
require_once 'connect_db.php'; 

$message = '';

// Delete record functionality (Converted to POST for security)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = (int)($_POST['id'] ?? 0);
    if ($delete_id > 0) {
        try {
            // Checks for 'id' primary key column (or 'appointment_id')
            $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id OR appointment_id = :id");
            $stmt->execute([':id' => $delete_id]);
            $message = "Appointment record #{$delete_id} deleted successfully.";
        } catch (PDOException $e) {
            $message = "Error deleting record: " . $e->getMessage();
        }
    }
}

// Search functionality
$search = trim($_GET['search'] ?? '');
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM appointments 
                           WHERE patient_name LIKE :s 
                           OR national_id LIKE :s 
                           OR department LIKE :s 
                           ORDER BY appointment_date DESC");
    $stmt->execute([':s' => "%{$search}%"]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointment Records Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Sunrise Community Hospital</h1>
        </div>
        <nav>
            <ul>
                <!-- Corrected link targets and active class states -->
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="appointment.php">Book Appointment</a></li>
                <li><a href="admin.php" class="active">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Appointment Records Management</h2>
        
        <?php if (!empty($message)): ?>
            <div class="alert-success" style="margin-top: 1rem;"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Search Form -->
        <form action="admin.php" method="GET" style="margin-top: 1.5rem; display: flex; gap: 0.5rem; max-width: 500px;">
            <input type="text" name="search" placeholder="Search by name, ID, or department..." value="<?php echo htmlspecialchars($search); ?>" style="flex: 1; padding: 0.5rem; border-radius: 4px; border: 1px solid #333; background: #2a2a2a; color: #fff;">
            <button type="submit" class="btn">Search</button>
            <?php if (!empty($search)): ?>
                <a href="admin.php" class="btn btn-reset">Clear</a>
            <?php endif; ?>
        </form>

        <!-- Task 6: View Appointment Records Table -->
        <div class="table-responsive" style="margin-top: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>National ID</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments) && count($appointments) > 0): ?>
                        <?php foreach ($appointments as $row): ?>
                            <?php 
                                // Normalize primary key identifier
                                $record_id = $row['id'] ?? $row['appointment_id'] ?? 0; 
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($record_id); ?></td>
                                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['national_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['email_address']); ?></td>
                                <td><?php echo htmlspecialchars($row['department']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td>
                                    <!-- Secure POST Delete Action -->
                                    <form action="admin.php<?php echo !empty($search) ? '?search='.urlencode($search) : ''; ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($record_id); ?>">
                                        <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.85rem; cursor: pointer;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">No appointment records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sunrise Community Hospital. All rights reserved.</p>
    </footer>
</body>
</html>