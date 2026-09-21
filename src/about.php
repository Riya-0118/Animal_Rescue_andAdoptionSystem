<?php
$currentPage = "about";
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div id="main">
        <div id="left">
        <h4>ABOUT KUMACARE</h4>
        <pre>Every street animal
    deserves a door that opens.
        </pre>
        <p>KumaCare is an animal rescue and adoption platform that connects animals in need with people who are willing to provide them with a safe and loving home.</p>
        <a href="animals.php">Explore Animals <i class="fa-solid fa-arrow-right-long"></i> </a>
        </div>
        <div id="right">
        <img src="assets/about.jpeg" alt="About Us">
        </div>
    </div>
    <div id="who">
        <div id="right">
            <img src="assets/who.jpeg" alt="Who We Are">  
        </div>
        <div id="left">
            <h4>WHO WE ARE</h4>
            <p>KumaCare is a web based animal rescue and adoption system designed to make the process of rescuing and adopting animals easier, safer and more organized.
                <br>
                Our platform provides a centralized database of animals in need of rescue and adoption, allowing users to easily search for available animals based on their location, breed, age, and other criteria.
            </p>
        </div>
    </div>
    <div id="mission">
        <h4>OUR MISSION</h4>
        <h3>What We Do</h3>
        <div id="rescue">
            <i class="fa-solid fa-paw"></i>
            <h5>Rescue Animals</h5>
            <p>Help users report animals that need rescue and connect with shelters and responsible people.</p>
        </div>
        <div id="home">
            <i class="fa-solid fa-heart"></i>
            <h5>Find Loving Homes</h5>
            <p>Provide a platform for users to find loving homes for animals in need of adoption.</p>
        </div>
        <div id="shelter">
            <i class="fa-solid fa-house"></i>
            <h5>Support Shelters</h5>
            <p>Support animal shelters and rescue organizations by providing them with a platform to showcase their animals and connect with potential adopters.</p>
        </div>
    </div>
    <div id="status">
        <h4>OUR STATUS</h4>
        <div id="rescued">
            <i class="fa-solid fa-paw"></i>
            <h5>Animals Rescued</h5>
            <p>Over 100 animals rescued and counting.</p>
        </div>
        <div id="adopted">
            <i class="fa-solid fa-heart"></i>
            <h5>Animals Adopted</h5>
            <p>Over 80 animals adopted into loving homes.</p>
        </div>
        <div id="user">
            <i class="fa-solid fa-users"></i>
            <h5>Active Users</h5>
            <p>Over 300 active users on our platform.</p>
        </div>
    </div>
</body>
</html>