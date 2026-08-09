<?php
$currentPage = "contact";
include "header.php";

include 'conn.php';

if (isset($_POST['submit'])) {

    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Subject = $_POST['subject'];
    $Message = $_POST['message'];

    $sql = "INSERT INTO Contact(Name, Email, Subject, Message)
            VALUES('$Name', '$Email', '$Subject', '$Message')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
            alert ('Message sent successfully!');
        </script>";
    } else {
        echo "<script>
            alert ('Message not sent. Please try again.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
        margin: 0;
        background: #f8faf8;
        font-family: Poppins, sans-serif;
        color: #333;
        }

        h1 {
            color: #2E7D32;
            font-size: 42px;
            margin: 40px 0 8px;
            margin-left: 115px;
        }

        p {
            margin-left: 115px;
            color: #666;
            font-size: 17px;
        }

        #main {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            gap: 40px;
            padding-left: 45px;
        }

        #address {
            width: 30%;
            padding: 30px;
            padding-top: 0;
        }

        #address p {
            margin: 12px 0;
            line-height: 24px;
        }

        i {
            color: #2E7D32;
            font-weight: 600;
            font-size: 17px;
            margin-top: 22px;
        }

        #address i {
            color: #2E7D32;
            font-size: 18px;
            margin-right: 10px;
        }

        #address iframe {
            width: 100%;
            height: 280px;
            border: 0;
            border-radius: 12px;
            margin-top: 20px;
        }

        #form {
            width: 50%;
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
        }

        #form label {
            display: inline-block;
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
        }

        #form input {
            width: 100%;
            padding: 13px;
            margin: 5px 0 18px;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
            font-size: 15px;
            font-family: Poppins, sans-serif;
            box-sizing: border-box;
            transition: 0.3s;
        }

        #form textarea {
        width: 100%;
        height: 120px;
        padding: 13px;
        margin: 5px 0 18px;
        border: 1px solid #d9d9d9;
        border-radius: 8px;
        font-size: 15px;
        font-family: Poppins, sans-serif;
        box-sizing: border-box;
        resize: vertical;
        }

        #form input:focus {
            border-color: #2E7D32;
            outline: none;
            box-shadow: 0 0 8px rgba(46, 125, 50, 0.25);
        }

        #form button {
            display: block;
            width: 70%;
            height: 45px;
            margin: 10px auto 0;
            background: #2E7D32;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-family: Poppins, sans-serif;
            cursor: pointer;
            transition: 0.3s;
        }

        #form button:hover {
            background: #1f5d25;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(46, 125, 50, 0.3);
        }

        @media (max-width: 900px) {

            #main {
                flex-direction: column;
                align-items: center;
                padding: 30px 15px;
            }

            #address,
            #form {
                width: 95%;
            }
        }
    </style>
</head>
<body>

    <h1>Get in Touch</h1>
    <p>Have questions or want to get involved?</p>
    <p>We'd love to hear from you.</p>
    <div id="main">
        <div id= "address">
            <p><i class="fa-solid fa-location-dot"></i>Address</p>
            <p>Madhyapur Thimi, Bhaktapur</p>
            <p><i class="fa-solid fa-phone"></i>Phone</p>
            <p>+977 9844620080</p>
            <p><i class="fa-regular fa-envelope"></i>Email</p>
            <p>info@kumacare.org.np</p>
            <p><i class="fa-regular fa-clock"></i>Working Hours</p>
            <p>Sun - Fri: 8:00 AM - 6:00 PM</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29883.62826597599!2d85.37892260000004!3d27.6851649!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1a419f80aa67%3A0x288ab8841508315f!2sMadhyapur%20Thimi!5e1!3m2!1sen!2snp!4v1786282665420!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
        <div id="form">
            <form action="" method="post">
            <label for="Name">Your Name</label><br>
            <input type="text" name="name"><br>
            <label for="Email">Email Address</label><br>
            <input type="email" name="email" id=""><br>
            <label for="Subject">Subject</label><br>
            <input type="text" name="subject" id=""><br>
            <label for="Message">Message</label><br>
            <textarea name="message" id="Message" placeholder="Type your message..."></textarea><br>
            <button type="submit" name="submit">Send Message</button>
        </form>
        </div>
    </div>
</body>
</html>