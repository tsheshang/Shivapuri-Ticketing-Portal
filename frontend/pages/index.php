<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shivapuri National Park - Ticketing</title>
    <link rel="stylesheet" href="/shivapuri-ticketing/frontend/assets/css/style.css">
</head>
<body>

<header class="navbar">
    <div class="logo">🌲 Shivapuri National Park</div>
    <nav>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="tickets.php">Tickets</a></li>
            <li><a href="about.php">About Park</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php" class="btn-login">Login</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>Explore the Wilderness of Shivapuri</h1>
        <p>Book your entry ticket online — skip the queue, enjoy the trail.</p>
        <a href="tickets.php" class="btn-primary">Book Tickets Now</a>
    </div>
</section>

<section class="info-section">
    <h2>Ticket Categories</h2>
    <div class="ticket-cards">
        <div class="card">
            <h3>Nepali Citizen</h3>
            <p>NPR 100</p>
        </div>
        <div class="card">
            <h3>SAARC National</h3>
            <p>NPR 500</p>
        </div>
        <div class="card">
            <h3>Foreign Tourist</h3>
            <p>NPR 1000</p>
        </div>
    </div>
</section>

<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Shivapuri National Park Ticketing Portal. All rights reserved.</p>
    <p>Nagarjun Municipality, Kathmandu, Nepal</p>
</footer>

</body>
</html>