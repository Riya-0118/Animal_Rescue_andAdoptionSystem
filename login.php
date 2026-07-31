<?php
session_start();
$conn = mysqli_connect("localhost","root","","project");

if(isset($_POST['login'])){
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $sql = "SELECT * FROM Users WHERE Email='$Email' AND Password='$Password'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $row['UserID'];   
        $_SESSION['name'] = $row['Name'];       
        $_SESSION['email'] = $row['Email'];
        echo "<script>
        alert('Login Successful');
        window.location='index.php';
        </script>";
        exit();
    } else {
        echo "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div id="main">
        <div id="left">
            <img src="a.jpeg" alt="">
        </div>
    <div id="right">
    <h1><img src="kuma.png" alt="logo" id="logo"></h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Welcome Back!</h2>
        <p>Login to continue</p> 
        <label for="Email">Email Address</label> 
        <input type="email" name="email" placeholder="Enter your email">
        <br>
        <label for="Password">Password</label><br>
        <input type="password" name="password" placeholder="Enter your password"><br>
        <input type="checkbox" name="remember" id="check">Remember me <br>
        <button name="login" id="login">Login</button>
        <p id="register">Don't have an account? <a href="Register.php">Register here</a></p>
    </form>
    </div></div>
</body>
</html>