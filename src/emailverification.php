<?php
include 'conn.php';

if (isset($_GET['token'])) {

    $token = $_GET['token'];

    $sql = "SELECT * FROM Users
            WHERE verification_token = '$token'
            AND is_verified = 0";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $update = "UPDATE Users
                   SET is_verified = 1,
                       verification_token = NULL
                   WHERE verification_token = '$token'";

        if (mysqli_query($conn, $update)) {
            echo "Email verified successfully!";
            echo "<br><a href='login.php'>Login Now</a>";
        }

    } else {
        echo "Invalid or expired verification link.";
    }

} else {
    echo "Verification token is missing.";
}
?>