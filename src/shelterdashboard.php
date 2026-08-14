<?php
session_start();

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: index.php");
    exit();
}
include 'conn.php';

    if (!isset($_SESSION['shelter_id'])) {
        header("Location: login.php");
        exit();
    }

    $Shelter_id = $_SESSION['shelter_id'];
    $Shelter_Name = $_SESSION['name'];

    $animal_sql = "SELECT * FROM Animal WHERE Shelter_id = '$Shelter_id'";
    $animal_result = mysqli_query($conn, $animal_sql);
    $animal_count = mysqli_num_rows($animal_result);

    $available_sql = "SELECT * FROM Animal 
                    WHERE Shelter_id = '$Shelter_id'
                    AND Adoption_Status = 'Available'";
    $available_result = mysqli_query($conn, $available_sql);
    $available_count = mysqli_num_rows($available_result);

    $request_sql = "SELECT Adoption_Request.*
                    FROM Adoption_Request
                    JOIN Animal
                    ON Adoption_Request.Animal_id = Animal.Animal_id
                    WHERE Animal.Shelter_id = '$Shelter_id'
                    AND Adoption_Request.Status = 'Pending'";

    $request_result = mysqli_query($conn, $request_sql);
    $request_count = mysqli_num_rows($request_result);

    $total_request_sql = "SELECT Adoption_Request.*
                        FROM Adoption_Request
                        JOIN Animal
                        ON Adoption_Request.Animal_id = Animal.Animal_id
                        WHERE Animal.Shelter_id = '$Shelter_id'";

    $total_request_result = mysqli_query($conn, $total_request_sql);
    $total_request_count = mysqli_num_rows($total_request_result);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shelter Dashboard - KumaCare</title>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:Poppins,sans-serif;
    }

    body{
        background:#f5f7f5;
        color:#333;
    }

    .sidebar{
        width:240px;
        height:100vh;
        background:#2E7D32;
        position:fixed;
        left:0;
        top:0;
        padding:30px 20px;
        color:white;
    }

    .sidebar h2{
        text-align:center;
        margin-bottom:40px;
        font-size:25px;
    }

    .sidebar a{
        display:block;
        color:white;
        text-decoration:none;
        padding:15px;
        margin:8px 0;
        border-radius:8px;
        font-size:16px;
    }

    .sidebar a:hover,
    .sidebar a.active{
        background:#1f5d25;
    }

    .sidebar i{
        width:25px;
    }
    
    button{
        width:100%;
        padding:10px;
        color:#2E7D32;
        background-color:white;
        border: 1px solid #1f5d25;
        border-radius:8px;
        cursor:pointer;
        font-size:16px;
    }

    .main{
        margin-left:240px;
        padding:35px;
    }

    .main h1{
        color:#2E7D32;
        margin-bottom:10px;
    }

    .welcome{
        color:#777;
        font-size:16px;
        margin-bottom:30px;
    }

    .cards{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:20px;
        margin-bottom:40px;
    }

    .card{
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        display:flex;
        align-items:center;
        gap:20px;
    }

    .card-icon{
        width:55px;
        height:55px;
        background:#e8f5e9;
        color:#2E7D32;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
    }

    .card h2{
        color:#2E7D32;
        font-size:28px;
    }

    .card p{
        color:#777;
        font-size:14px;
    }

    .section-title{
        margin-bottom:20px;
        color:#333;
    }

    .actions{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:20px;
        margin-bottom:40px;
    }

    .action{
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
    }

    .action h3{
        color:#2E7D32;
        margin-bottom:8px;
    }

    .action p{
        color:#777;
        margin-bottom:15px;
    }

    .action a{
        display:inline-block;
        background:#2E7D32;
        color:white;
        padding:10px 18px;
        border-radius:7px;
        text-decoration:none;
    }

    .action a:hover{
        background:#1f5d25;
    }

    .table-container{
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        overflow-x:auto;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:15px;
    }

    th,td{
        padding:14px;
        border-bottom:1px solid #eee;
        text-align:center;
    }

    th{
        background:#2E7D32;
        color:white;
    }

    .status{
        padding:6px 12px;
        border-radius:20px;
        background:#fff3cd;
        color:#856404;
    }

    .review{
        background:#2E7D32;
        color:white;
        padding:7px 12px;
        border-radius:6px;
        text-decoration:none;
    }

    @media(max-width:1000px){
        .cards{
            grid-template-columns:repeat(2,1fr);
        }
    }

    @media(max-width:700px){

        .sidebar{
            width:70px;
            padding:20px 10px;
        }

        .sidebar h2{
            font-size:0;
        }

        .sidebar h2:after{
            content:"KC";
            font-size:20px;
        }

        .sidebar a span{
            display:none;
        }

        .main{
            margin-left:70px;
            padding:20px;
        }

        .cards{
            grid-template-columns:1fr;
        }

        .actions{
            grid-template-columns:1fr;
        }

    }

    </style>
</head>

<body>

    <div class="sidebar">
        <h2>
            <i class="fa-solid fa-paw"></i>
            KumaCare
        </h2>
        <a href="shelterdashboard.php" class="active">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="addanimal.php">
            <i class="fa-solid fa-plus"></i>
            <span>Add Animal</span>
        </a>

        <a href="shelter_animals.php">
            <i class="fa-solid fa-paw"></i>
            <span>My Animals</span>
        </a>

        <a href="adoption_requests.php">
            <i class="fa-solid fa-file-circle-check"></i>
            <span>Adoption Requests</span>
        </a>
        <form action="" method="POST">
            <button name="logout">Logout</button>
        </form>
    </div>

    <div class="main">

        <h1>
            Welcome, <?php echo htmlspecialchars($Shelter_Name); ?>!
        </h1>

        <p class="welcome">
            Manage your shelter animals and adoption requests.
        </p>

        <div class="cards">

            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-paw"></i>
                </div>

                <div>
                    <h2><?php echo $animal_count; ?></h2>
                    <p>Total Animals</p>
                </div>

            </div>


            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div>
                    <h2><?php echo $available_count; ?></h2>
                    <p>Available for Adoption</p>
                </div>

            </div>


            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div>
                    <h2><?php echo $request_count; ?></h2>
                    <p>Pending Requests</p>
                </div>

            </div>


            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>

                <div>
                    <h2><?php echo $total_request_count; ?></h2>
                    <p>Total Requests</p>
                </div>

            </div>

        </div>

        <h2 class="section-title">Quick Actions</h2>

        <div class="actions">

            <div class="action">

                <h3>
                    <i class="fa-solid fa-plus"></i>
                    Add New Animal
                </h3>

                <p>
                    Add an animal to your shelter and make it available for adoption.
                </p>

                <a href="addanimal.php">
                    Add Animal
                </a>

            </div>


            <div class="action">

                <h3>
                    <i class="fa-solid fa-file-circle-check"></i>
                    Adoption Requests
                </h3>

                <p>
                    Review and manage adoption applications received for your animals.
                </p>

                <a href="adoption_requests.php">
                    Review Requests
                </a>

            </div>

        </div>

        <div class="table-container">

            <h2>Recent Adoption Requests</h2>

            <table>

                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Animal ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

    <?php

    $recent_sql = "SELECT Adoption_Request.*
                FROM Adoption_Request
                JOIN Animal
                ON Adoption_Request.Animal_id = Animal.Animal_id
                WHERE Animal.Shelter_id = '$Shelter_id'
                ORDER BY Adoption_Request.Adoption_id DESC
                LIMIT 5";

    $recent_result = mysqli_query($conn, $recent_sql);

    if(mysqli_num_rows($recent_result) > 0){

        while($row = mysqli_fetch_assoc($recent_result)){

    ?>
                <tr>
                    <td>
                        <?php echo $row['Adoption_id']; ?>
                    </td>

                    <td>
                        <?php echo $row['User_id']; ?>
                    </td>

                    <td>
                        <?php echo $row['Animal_id']; ?>
                    </td>

                    <td>
                        <?php echo $row['Request_date']; ?>
                    </td>

                    <td>
                        <span class="status">
                            <?php echo $row['Status']; ?>
                        </span>
                    </td>

                    <td>

                        <a
                            href="review_request.php?Adoption_id=<?php echo $row['Adoption_id']; ?>"
                            class="review"
                        >
                            Review
                        </a>

                    </td>

                </tr>

    <?php

        }

    }else{
    ?>
                <tr>
                    <td colspan="6">
                        No adoption requests found.
                    </td>
                </tr>
    <?php
    }
    ?>
            </table>
        </div>
    </div>
</body>
</html>