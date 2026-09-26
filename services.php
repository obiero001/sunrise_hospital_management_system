<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Sunrise Community Hospital</title>
    <!-- Corrected CSS folder path -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Sunrise Community Hospital</h1>
        </div>
        <nav>
            <ul>
                <!-- Corrected link targets and active states -->
                <li><a href="index.html">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="appointment.php">Appointment</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Our Hospital Departments & Services</h2>
        
        <div class="grid-container">
            <div class="card">
                <h3>General Medicine</h3>
                <p>Comprehensive primary care, outpatient consultation, routine health monitoring, and management of chronic diseases.</p>
            </div>
            <div class="card">
                <h3>Pediatrics</h3>
                <p>Specialized medical care and developmental tracking dedicated to infants, children, and adolescents.</p>
            </div>
            <div class="card">
                <h3>Obstetrics & Gynecology</h3>
                <p>Maternal healthcare, reproductive medical evaluation, prenatal care, and modern delivery care options.</p>
            </div>
            <div class="card">
                <h3>Dental Care</h3>
                <p>Preventive oral examinations, restorative procedures, oral surgery, and cosmetic dentistry.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sunrise Community Hospital. All rights reserved.</p>
    </footer>
</body>
</html>