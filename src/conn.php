
<?php

$conn = mysqli_connect("db", "root", "Project123", "Project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>