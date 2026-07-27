<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="rescue.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <?php 
    include 'header.html';
    ?>
    <div id="main">
        <h1>Rescue a Life. Be a Hero.</h1>
        <p>Found an animal in need? Send us a rescue request and</p>
        <p>our team will reach out as soon as possible.</p>
    </div>
    <div id="request">
        <div id="form">
            <form method="post" enctype="multipart/form-data">
            <h2>Send a Rescue Request</h2>
            <label for="Name">Full Name</label><br>
            <input type="text" name="name" id="" placeholder="Enter your full name" required><br>
            <label for="Phone">Phone Number</label><br>
            <input type="text" name="phone" id="" placeholder="Enter your phone number" required><br>
            <label for="Email">Email Address</label><br>
            <input type="email" name="email" placeholder="Enter your email address" required><br>
            <label for="Location">Location</label><br>
            <input type="text" name="location" id="" required><br>
            <label for="Description">Description</label><br>
            <textarea name="description" id=""></textarea><br>
            <label for="photo">Upload Photo/ Video</label><br>
            <input type="file" name="photo[]" id="file"
            accept="image/png, image/jpeg, image/jpg, video/mp4"
            multiple><br>
            <button name="submit" id="submit">Submit Rescue Request</button><br>
            <span class="message">
                <?php
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
            </span>
            </form>
        </div>
        <div>
            <div id="next">
                <h3>What Happens Next?</h3>
                <p><i class="fa-solid fa-phone"></i>We Receive Your Request</p>
                <p><i class="fa-solid fa-location-dot"></i>Verfication & Assignment</p>
                <p><i class="fa-regular fa-truck"></i>Rescue in Progress</p>
                <p><i class="fa-solid fa-heart"></i>Care & Rehabilitation</p>
            </div>
            <div id="note">
            <h3>Important Notes</h3>
                <p><i class="fa-regular fa-circle-check"></i>Please provide the exact address.</p>
                <p><i class="fa-regular fa-circle-check"></i>Add clear photos or videos if possible.</p>
                <p><i class="fa-regular fa-circle-check"></i>Do not try to rescue the animal on your own if it's unsafe.</p>
                <p><i class="fa-regular fa-circle-check"></i>Out team will contact you for more details if needed.</p>
                <div id="call">
                <p><i class="fa-solid fa-phone"></i>
                Emergency? <br>
                Call us directly <br>
                at +977 9844620080</p>
            </div>
        </div>
    </div>

    <?php
        include 'conn.php';

        if (isset($_POST['submit'])) {

            $Name = $_POST['name'];
            $Phone = $_POST['phone'];
            $Email = $_POST['email'];
            $Location = $_POST['location'];
            $Description = $_POST['description'];

            $photos = [];

            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'][0])) {

                $count = count($_FILES['photo']['name']);

                for ($i = 0; $i < $count; $i++) {

                    $photoName = $_FILES['photo']['name'][$i];
                    $tempName = $_FILES['photo']['tmp_name'][$i];

                    $folder = __DIR__ . "/photo/" . $photoName;

                    if (move_uploaded_file($tempName, $folder)) {
                        $photos[] = $photoName;
                    }
                }
            }

            $Photo = json_encode($photos);

            $sql = "INSERT INTO Rescue
                    (Name, Phone, Email, Location, Description, Image)
                    VALUES
                    ('$Name', '$Phone', '$Email', '$Location', '$Description', '$Photo')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $message = "Request submitted successfully!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    ?>
</body>
</html>