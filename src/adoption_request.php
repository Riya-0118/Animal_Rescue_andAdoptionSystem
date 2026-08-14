<?php
    session_start();
    include "conn.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $UserID = $_SESSION['user_id'];

    $AnimalID = isset($_GET['Animal_id'])
        ? intval($_GET['Animal_id'])
        : 0;

    if ($AnimalID <= 0) {
        die("Invalid animal.");
    }

    $sql = "SELECT Animal.*, Breed.Breed_Name
            FROM Animal
            JOIN Breed
            ON Animal.Breed_id = Breed.Breed_id
            WHERE Animal.Animal_id = $AnimalID";

    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("Animal not found.");
    }

    $animal = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {

        $RequestDate = date("Y-m-d");

        $sql = "INSERT INTO Adoption_Request
                (User_id, Animal_id, Request_date, Status)
                VALUES
                ('$UserID', '$AnimalID', '$RequestDate', 'Pending')";

        if (mysqli_query($conn, $sql)) {

            echo "<script>
                    alert('Adoption request submitted successfully!');
                    window.location='adoption.php';
                </script>";

            exit();

        } else {

            echo "Error: " . mysqli_error($conn);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Adoption Request - KumaCare</title>

    <style>

        body {
            margin: 0;
            background: #fff7f5;
            font-family: Poppins, sans-serif;
        }

        .request-container {
            width: 70%;
            margin: 130px auto 50px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 5px 5px 30px 0px #2e7d324a;
        }

        h1 {
            text-align: center;
            color: #2E7D32;
            margin-bottom: 30px;
        }

        .animal-info {
            display: flex;
            gap: 30px;
            align-items: center;
            padding: 20px;
            background: #f8faf8;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .animal-info img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
        }

        .animal-info h2 {
            color: #2E7D32;
        }

        .animal-info p {
            color: #666;
            font-size: 16px;
        }

        label {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px;
            margin: 8px 0 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
            background: #f5f5f5;
        }

        button {
            display: block;
            width: 70%;
            margin: 10px auto;
            padding: 14px;
            background: #2E7D32;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1f5d25;
        }

        .message {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2E7D32;
            font-weight: 600;
        }

    </style>
</head>

<body>

<div class="request-container">

    <h1>Adoption Request</h1>

    <div class="animal-info">

        <img
            src="photo/<?php echo htmlspecialchars($animal['Image']); ?>"
            alt="Animal">

        <div>

            <h2>
                <?php echo htmlspecialchars($animal['Name']); ?>
            </h2>

            <p>
                <strong>Breed:</strong>
                <?php echo htmlspecialchars($animal['Breed_Name']); ?>
            </p>

            <p>
                <strong>Gender:</strong>
                <?php echo htmlspecialchars($animal['Gender']); ?>
            </p>

            <p>
                <strong>Date of Birth:</strong>
                <?php echo htmlspecialchars($animal['DOB']); ?>
            </p>

        </div>

    </div>

    <form method="post">

        <label>User Name</label>
        <input type="text">

        <label>Email</label>
        <input type="email">

        <button type="submit" name="submit">
            Submit Adoption Request
        </button>

    </form>

</div>

</body>
</html>