<?php
session_start();

$name = $_SESSION['name'] ?? '';
$fc = explode(" ", trim($name));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header>
        <div id="logo">
            <img src="ku.png" alt="logo">
        </div>
        <div id="nav">
            <nav>
            <a href="index.php" class="<?= ($currentPage == 'home') ? 'active' : ''; ?>">Home</a>
            <a href="about.php" class="<?= ($currentPage == 'about') ? 'active' : ''; ?>">About</a>
            <a href="rescue.php" class="<?= ($currentPage == 'rescue') ? 'active' : ''; ?>">Rescue</a>
            <a href="adoption.php" class="<?= ($currentPage == 'adoption') ? 'active' : ''; ?>">Adoption</a>
            <a href="" class="<?= ($currentPage == 'animal')? 'active': '';?>">Animal</a>
            <a href="" class="<?= ($currentPage == 'services')? 'active': '';?>">Services</a>
            <a href="contact.php" class="<?= ($currentPage == 'contact')? 'active': '';?>">Contact</a>
        </nav>
        </div>
        <a href="login.php"
        style="display:<?php echo isset($_SESSION['login']) ? 'none' : 'inline-block'; ?>">
        <button>Login</button>
        </a>

        <a href="userdashboard.php"
        style="display:<?php echo isset($_SESSION['login']) ? 'inline-block' : 'none'; ?>">
        <button><?php echo htmlspecialchars($fc[0]); ?></button>
        </a>
    </header>
</body>
</html>