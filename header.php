<?php
session_start();
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
            <img src="kuma.png" alt="logo">
        </div>
        <div id="nav">
            <nav>
            <a href="index.php">Home</a>
            <a href="">Animals</a>
            <a href="">Adopt</a>
            <a href="Rescue.php">Rescue</a>
            <a href="">Services</a>
            <a href="">About Us</a>
            <a href="">Contact</a>
        </nav>
        </div>
        <a href="login.php"
        style="display:<?php echo isset($_SESSION['login']) ? 'none' : 'inline-block'; ?>">
        <button>Login</button>
        </a>

        <a href="userdashboard.php"
        style="display:<?php echo isset($_SESSION['login']) ? 'inline-block' : 'none'; ?>">
        <button><?php echo htmlspecialchars($_SESSION['name']); ?></button>
        </a>
    </header>
</body>
</html>