<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sunrise Community Hospital</title>
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
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php" class="active">Contact Us</a></li>
                <li><a href="appointment.php">Book Appointment</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Contact Us</h2>
        <div class="grid-container">
            <div class="card">
                <h3>Hospital Address</h3>
                <p>Sunrise Community Hospital</p>
                <p>Hospital Road, Off Main Highway</p>
                <p>Nairobi, Kenya</p>
                <br>
                <p><strong>Phone:</strong> +254 700 000 000</p>
                <p><strong>Email:</strong> info@sunrisehospital.org</p>
            </div>
            <div class="card">
                <h3>Working Hours</h3>
                <p><strong>Emergency Unit:</strong> 24 Hours / 7 Days</p>
                <p><strong>Outpatient Clinic:</strong> Mon - Fri (8:00 AM - 5:00 PM)</p>
                <p><strong>Visiting Hours:</strong> 12:30 PM - 2:00 PM, 4:30 PM - 6:30 PM</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sunrise Community Hospital. All rights reserved.</p>
    </footer>
</body>
</html>