<?php
$currentPage = "adoption";
include "header.php";
include 'conn.php';

$sql = "SELECT Animal.*, Breed.Breed_Name
        FROM Animal
        JOIN Breed
        ON Animal.Breed_id = Breed.Breed_id
        WHERE Animal.Adoption_Status = 'Available'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Adopt an Animal - KumaCare</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            outline: none;
            font-family: Poppins, sans-serif;
        }
        
        html{
            font-size: 62.5%;

        }
        body {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            background: #fff7f5;
            color: #333;
        }

        .page-header {
            margin-top: 10rem;
            text-align: center;
            padding: 3rem 2rem;
            font-size: 62.5%;
        }

        .page-header h1 {
            font-size: 4rem;
            color: #2E7D32;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.7rem;
            color: #666;
        }


        .filter-container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto 4rem;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);

            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-container input,
        .filter-container select {
            padding: 1.2rem 1.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1.5rem;
            min-width: 180px;
        }

        .filter-container button {
            padding: 10px;
            background: #2E7D32;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.5rem;
            cursor: pointer;
            width:100px;
            height:auto;
        }

        .filter-container button:hover {
            background: #1f5d25;
        }

        .animal-section {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto 6rem;

            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2.5rem;
        }

        .animal-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s ease;
            text-align: left;
        }

        .animal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .animal-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .animal-info {
            padding: 1.8rem;
        }

        .animal-info h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.8rem;
        }

        .animal-info p {
            font-size: 1.4rem;
            color: #777;
            margin-bottom: 0.5rem;
        }

        .status {
            display: inline-block;
            margin: 1rem 0;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: #e8f5e9;
            color: #2E7D32;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .adopt-btn {
            display: block;
            width: 100%;
            padding: 1.2rem;
            background: #2E7D32;
            color: white;
            border-radius: 8px;
            text-align: center;
            font-size: 1.5rem;
            transition: 0.3s;
        }

        .adopt-btn:hover {
            background: #1f5d25;
        }

        .adopt-btn i {
            margin-right: 6px;
        }

        .no-animals {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem;
            background: white;
            border-radius: 15px;
            font-size: 1.7rem;
            color: #777;
        }

        @media(max-width: 1000px) {
            .animal-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {


            .page-header h1 {
                font-size: 3rem;
            }

            .animal-section {
                grid-template-columns: 1fr;
            }

            .filter-container {
                width: 90%;
            }

            .filter-container input,
            .filter-container select,
            .filter-container button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <section class="page-header">

        <h1>Find Your New Best Friend</h1>

        <p>
            Give an animal a loving home and make a difference in their life.
        </p>

    </section>

    <div class="filter-container">

        <input type="text"
            placeholder="Search animal...">

        <select>
            <option>All Breeds</option>
            <option>Golden Retriever</option>
            <option>Japanese Splitz</option>
            <option>Pug</option>
        </select>

        <select>
            <option>All Genders</option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <button>
            <i class="fa-solid fa-magnifying-glass"></i>
            Search
        </button>

    </div>

    <div class="animal-section">

    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($animal = mysqli_fetch_assoc($result)) {

    ?>

    <div class="animal-card">

    <img
        src="photo/<?php echo htmlspecialchars($animal['Image']); ?>"
        alt="<?php echo htmlspecialchars($animal['Name']); ?>"
        class="animal-image"
    >

    <div class="animal-info">

        <h2>
            <?php echo htmlspecialchars($animal['Name']); ?>
        </h2>

        <p>
            <i class="fa-solid fa-paw"></i>
            <?php echo htmlspecialchars($animal['Breed_Name']); ?>
        </p>

        <p>
            <i class="fa-solid fa-calendar"></i>
            DOB: <?php echo htmlspecialchars($animal['DOB']); ?>
        </p>

        <p>
            <i class="fa-solid fa-venus-mars"></i>
            <?php echo htmlspecialchars($animal['Gender']); ?>
        </p>

        <span class="status">
            <?php echo htmlspecialchars($animal['Adoption_Status']); ?>
        </span>

        <a
            href="animal_details.php?ID=<?php echo $animal['Animal_id']; ?>"
            class="adopt-btn"
        >
            <i class="fa-solid fa-heart"></i>
            View & Adopt
        </a>

    </div>

    </div>

        </div>

    <?php

        }

    } else {

    ?>

        <div class="no-animals">

            <i class="fa-solid fa-paw"
            style="font-size:4rem;color:#2E7D32;">
            </i>

            <p>No animals are currently available for adoption.</p>

        </div>

    <?php

    }

    ?>

    </div>



</body>
</html>