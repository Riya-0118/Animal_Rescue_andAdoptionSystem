<?php
$currentPage = "home";
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <section id="main">
        <div id="text">
            <h1>Every street animal deserves a <br><span>door that opens.</span></h1>
            <p>KumaCare connects rescuers, shelters and adopters in one system— <br>
            from the first rescue call to the day an animal goes home. </p>

        <div class="buttons">
            <a href="Animal.php">
            <button class="primary">Find a Companion</button>
            </a>

            <a href="Rescue.php">
            <button class="secondary">Report a Rescue</button>
            </a>
        </div>
        </div>
    <br>
        <div id="image">
            <img src="land.jpg" alt="Dogs">
        </div>

    </section>

    <section id="donate">

        <div class="donate">
        <i class="fa-solid fa-heart"></i>
        <h2>Feed, Treat & Shelter One More Animal</h2>
        <p>
        Your donation helps partner shelters provide food,
        vaccinations and life-saving medical care.
        </p>
        <button>
        <i class="fa-solid fa-paw"></i>
        Donate Now
        </button>
        </div>
    </section>
</body>
</html>