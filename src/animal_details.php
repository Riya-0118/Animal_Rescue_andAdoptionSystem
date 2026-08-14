<?php
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    include 'conn.php';

    $ID = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

    $sql = "SELECT Animal.*, Breed.Breed_Name
            FROM Animal
            JOIN Breed
            ON Animal.Breed_id = Breed.Breed_id
            WHERE Animal.Animal_id = $ID";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $animal = mysqli_fetch_assoc($result);

        $image = $animal['Image'];
        $name = $animal['Name'];
        $breed = $animal['Breed_Name'];
        $gender = $animal['Gender'];
        $dob = $animal['DOB'];
        $status = $animal['Adoption_Status'];
        
    } else {

        echo "Animal not found";
        exit;

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($name); ?> - KumaCare</title>
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Poppins, sans-serif;
    }

    body {
        background: #fff7f5;
        color: #333;
    }

    .container {
        width: 80%;
        max-width: 1000px;
        margin: 120px auto;
        background: white;
        padding: 40px;
        border-radius: 18px;
        box-shadow: 5px 5px 30px 0px #2e7d324a;
        display: flex;
        gap: 50px;
        align-items: center;
        margin-top: 150px;
    }

    .animal-image {
        width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 15px;
    }

    .info {
        flex: 1;
    }

    .info h1 {
        font-size: 36px;
        color: #2E7D32;
        margin-bottom: 10px;
    }

    .info p {
        font-size: 17px;
        margin: 15px 0;
        color: #555;
    }

    .info i {
        color: #2E7D32;
        width: 25px;
    }

    .status {
        display: inline-block;
        margin: 15px 0;
        padding: 8px 18px;
        background: #e8f5e9;
        color: #2E7D32;
        border-radius: 20px;
        font-weight: 600;
    }

    .adopt-btn {
        display: block;
        width: 100%;
        padding: 14px;
        margin-top: 20px;

        background: #2E7D32;
        color: white;

        text-align: center;
        text-decoration: none;

        border-radius: 8px;
        font-size: 17px;

        transition: 0.3s;
    }

    .adopt-btn:hover {
        background: #1f5d25;
    }

    .back {
        display: inline-block;
        margin-top: 20px;
        color: #2E7D32;
        text-decoration: none;
        font-size: 15px;
    }

    @media(max-width: 800px) {

        .container {
            width: 90%;
            flex-direction: column;
            margin: 80px auto;
        }

        .animal-image {
            width: 100%;
            height: 350px;
        }

    }

</style>

</head>

<body>

    <div class="container">

        <img
            src="photo/<?php echo htmlspecialchars($image); ?>"
            alt="<?php echo htmlspecialchars($name); ?>"
            class="animal-image"
        >

        <div class="info">

            <h1>
                <?php echo htmlspecialchars($name); ?>
            </h1>

            <p>
                <i class="fa-solid fa-paw"></i>
                <strong>Breed:</strong>
                <?php echo htmlspecialchars($breed); ?>
            </p>

            <p>
                <i class="fa-solid fa-venus-mars"></i>
                <strong>Gender:</strong>
                <?php echo htmlspecialchars($gender); ?>
            </p>

            <p>
                <i class="fa-solid fa-calendar-days"></i>
                <strong>Date of Birth:</strong>
                <?php echo htmlspecialchars($dob); ?>
            </p>

            <span class="status">
                <?php echo htmlspecialchars($status); ?>
            </span>

            <?php if ($status == "Available") { ?>

                <a
                    href="adoption_request.php?Animal_id=<?php echo $animal['Animal_id']; ?>"
                    class="adopt-btn"
                >
                    Apply for Adoption
                </a>

            <?php } ?>

            <a href="adoption.php" class="back">
                ← Back to Adoption
            </a>

        </div>

    </div>

</body>
</html>