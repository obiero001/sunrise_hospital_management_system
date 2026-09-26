<?php
// appointment.php - Back-End Processing & Form Render
require_once 'connect_db.php';

$success_message = '';
$error_message = '';

// Form variable initialization for value persistence
$patient_name     = '';
$national_id      = '';
$gender           = '';
$phone_number     = '';
$email_address    = '';
$department       = '';
$appointment_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Task 4: Receive Appointment details
    $patient_name     = trim($_POST['patient_name'] ?? '');
    $national_id      = trim($_POST['national_id'] ?? '');
    $gender           = trim($_POST['gender'] ?? '');
    $phone_number     = trim($_POST['phone_number'] ?? '');
    $email_address    = trim($_POST['email_address'] ?? '');
    $department       = trim($_POST['department'] ?? '');
    $appointment_date = trim($_POST['appointment_date'] ?? '');

    // Task 4: Server-Side Validation
    if (empty($patient_name) || empty($national_id) || empty($gender) || 
        empty($phone_number) || empty($email_address) || empty($department) || empty($appointment_date)) {
        $error_message = 'All fields are required.';
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address format.';
    } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
        $error_message = 'Appointment date cannot be in the past.';
    } else {
        // Task 5: Database Insertion
        try {
            $sql = "INSERT INTO appointments (patient_name, national_id, gender, phone_number, email_address, department, appointment_date) 
                    VALUES (:patient_name, :national_id, :gender, :phone_number, :email_address, :department, :appointment_date)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':patient_name'     => $patient_name,
                ':national_id'      => $national_id,
                ':gender'           => $gender,
                ':phone_number'     => $phone_number,
                ':email_address'    => $email_address,
                ':department'       => $department,
                ':appointment_date' => $appointment_date,
            ]);

            $success_message = "Appointment booked successfully! Your appointment ID is: #" . $pdo->lastInsertId();
            
            // Clear fields after successful insertion
            $patient_name = $national_id = $gender = $phone_number = $email_address = $department = $appointment_date = '';
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Sunrise Community Hospital</title>
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
                <li><a href="index.html">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="appointment.php" class="active">Book Appointment</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Book an Appointment</h2>
            <br>

            <?php if (!empty($success_message)): ?>
                <div class="alert-success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <!-- Task 2: Patient Appointment Booking Form -->
            <form id="appointmentForm" action="appointment.php" method="POST" novalidate>
                <div class="form-group">
                    <label for="patient_name">Patient Name:</label>
                    <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($patient_name); ?>" required>
                    <span class="error-msg" id="nameError"></span>
                </div>

                <div class="form-group">
                    <label for="national_id">National ID Number:</label>
                    <input type="text" id="national_id" name="national_id" value="<?php echo htmlspecialchars($national_id); ?>" required>
                    <span class="error-msg" id="idError"></span>
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($gender === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <span class="error-msg" id="genderError"></span>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="0712345678" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                    <span class="error-msg" id="phoneError"></span>
                </div>

                <div class="form-group">
                    <label for="email_address">Email Address:</label>
                    <input type="email" id="email_address" name="email_address" value="<?php echo htmlspecialchars($email_address); ?>" required>
                    <span class="error-msg" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">-- Select Department --</option>
                        <option value="General Medicine" <?php echo ($department === 'General Medicine') ? 'selected' : ''; ?>>General Medicine</option>
                        <option value="Pediatrics" <?php echo ($department === 'Pediatrics') ? 'selected' : ''; ?>>Pediatrics</option>
                        <option value="Obstetrics & Gynecology" <?php echo ($department === 'Obstetrics & Gynecology') ? 'selected' : ''; ?>>Obstetrics & Gynecology</option>
                        <option value="Dental Care" <?php echo ($department === 'Dental Care') ? 'selected' : ''; ?>>Dental Care</option>
                    </select>
                    <span class="error-msg" id="deptError"></span>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="date" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>" required>
                    <span class="error-msg" id="dateError"></span>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <!-- Submit and Reset Buttons -->
                    <button type="submit" class="btn" style="flex: 1;">Submit</button>
                    <button type="reset" class="btn btn-reset" style="flex: 1;">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sunrise Community Hospital. All rights reserved.</p>
    </footer>

    <!-- Updated JavaScript path to match folder structure -->
    <script src="validation.js"></script>
</body>
</html>