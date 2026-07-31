<?php
    include 'conn.php';
    if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = $_POST['role'];

    if($password != $cpassword){
        echo "<script>alert('Passwords do not match');</script>";
        exit();
    }

    $check = mysqli_query($conn,"SELECT * FROM Users WHERE Email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already exists');</script>";
    }else{
        $sql = "INSERT INTO Users(Name,Email,Phone,Password,Role)
        VALUES('$name','$email','$phone','$password','$role')";

        if(mysqli_query($conn,$sql)){
            echo "<script>
            alert('Registration Successful');
            window.location='login.php';
            </script>";
        }else{
             echo "<script>alert('Registration Failed');</script>";
        }
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Register.css">
</head>
<body>
    <div id="main">
        <div id="left">
            <img src="dog.jpeg" alt="">
        </div>
        <div id="right">
        <form method="post" name="registerForm" onsubmit="return validateForm();">
            <h1>Create an <b>Account</b></h1>
            <p>Join KumaCare and help animals.</p>
            <label for="Name">Full Name</label><br>
            <input type="text" name="name" id=""><br>
            <label for="Email">Email Address</label><br>
            <input type="email" name="email" id=""><br>
            <label for="Phone">Phone Number</label><br>
            <input type="text" name="phone" id=""><br>
            <label for="Password">Password</label><br>
            <input type="password" name="password" id=""><br>
            <label for="Cpassword">Confirm Password</label><br>
            <input type="password" name="cpassword" id=""><br>
            <label for="Role">I am a..</label><br>
            <select name="role" id="">
            <option value="" selected disabled>Choose a role</option>
                <option value="Adopter/Rescuer">Adopter/Rescuer</option>
                <option value="Shelter">Shelter</option>
            </select><br>
            <input type="checkbox" name="terms" id="term">I agree with the Terms & Conditions <br>
            <button name="submit">Register</button>
            <p id="login">Already have an account? <a href="login.php">Login Here</a></p>
        </form>
        </div>
    </div>
    
    <script>
        function validateForm() {

        let name = document.forms["registerForm"]["name"].value.trim();
        let email = document.forms["registerForm"]["email"].value.trim();
        let phone = document.forms["registerForm"]["phone"].value.trim();
        let password = document.forms["registerForm"]["password"].value;
        let cpassword = document.forms["registerForm"]["cpassword"].value;
        let role = document.forms["registerForm"]["role"].value;
        let terms = document.forms["registerForm"]["terms"].checked;

        if(name == ""){
            alert("Please enter your full name.");
            return false;
        }

        let namePattern = /^[A-Za-z ]+$/;
        if(!namePattern.test(name)){
            alert("Name should contain only letters.");
            return false;
        }

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailPattern.test(email)){
            alert("Please enter a valid email.");
            return false;
        }

        let phonePattern = /^[0-9]{10}$/;
        if(!phonePattern.test(phone)){
            alert("Phone number must contain 10 digits.");
            return false;
        }

        if(password.length < 8){
            alert("Password must be at least 8 characters.");
            return false;
        }

        if(password != cpassword){
            alert("Passwords do not match.");
            return false;
        }

        if(role == ""){
            alert("Please choose a role.");
            return false;
        }

        if(!terms){
            alert("Please accept the Terms & Conditions.");
            return false;
        }

        return true;
        }
    </script>
</body>
</html>