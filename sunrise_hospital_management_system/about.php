<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sunrise Community Hospital</title>
    <!-- Updated CSS folder path -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Sunrise Community Hospital</h1>
        </div>
        <nav>
            <ul>
                <!-- Fixed link target and active classes -->
                <li><a href="index.html">Home</a></li>
                <li><a href="about.php" class="active">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="appointment.php">Book Appointment</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>About Sunrise Community Hospital</h2>
        <p style="margin-top: 1rem;">Founded to deliver compassion and clinical excellence, Sunrise Community Hospital offers comprehensive preventive, curative, and emergency medical services. Our healthcare delivery system is built upon community integrity, accessibility, and high quality standards.</p>
        
        <div class="grid-container">
            <div class="card">
                <h3>Our Vision</h3>
                <p>To be the leading regional community hospital delivering trusted, accessible, and affordable healthcare for all individuals and families.</p>
            </div>
            <div class="card">
                <h3>Our Mission</h3>
                <p>To improve community wellness through patient-centered clinical services, active public health education, and innovative healthcare management systems.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sunrise Community Hospital. All rights reserved.</p>
    </footer>
</body>
</html>