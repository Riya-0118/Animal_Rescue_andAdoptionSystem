<?php

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();

        header("Location: index.php");
        exit();
    }

    include "conn.php";
    $User_id = $_SESSION['user_id'];
    $User_Name = $_SESSION['name'];

    $sql_total = "SELECT COUNT(*) AS total
                FROM Adoption_Request
                WHERE User_id = '$User_id'";

    $result_total = mysqli_query($conn, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);

    $total_requests = $row_total['total'];

    $sql_pending = "SELECT COUNT(*) AS total
                    FROM Adoption_Request
                    WHERE User_id = '$User_id'
                    AND Status = 'Pending'";

    $result_pending = mysqli_query($conn, $sql_pending);
    $row_pending = mysqli_fetch_assoc($result_pending);

    $pending_requests = $row_pending['total'];


    $sql_approved = "SELECT COUNT(*) AS total
                    FROM Adoption_Request
                    WHERE User_id = '$User_id'
                    AND Status = 'Approved'";

    $result_approved = mysqli_query($conn, $sql_approved);
    $row_approved = mysqli_fetch_assoc($result_approved);

    $approved_requests = $row_approved['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard - KumaCare</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: Poppins, sans-serif;
        }

        body {
            background: #fff7f5;
            color: #333;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);

            position: fixed;
            left: 0;
            top: 0;
        }

        .profile {
            text-align: center;
            padding-bottom: 25px;
            border-bottom: 1px solid #ddd;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            margin: auto;

            border-radius: 50%;

            background: #e8f5e9;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #2E7D32;
            font-size: 35px;
        }

        .profile h3 {
            margin-top: 12px;
            font-size: 18px;
        }

        .profile p {
            color: #777;
            margin-top: 5px;
            font-size: 13px;
        }

        .menu {
            margin-top: 25px;
        }

        .menu a {
            display: block;

            padding: 13px 15px;
            margin-bottom: 8px;

            color: #555;

            border-radius: 8px;

            font-size: 15px;
        }

        .menu a i {
            width: 25px;
            color: #2E7D32;
        }

        .menu a:hover,
        .menu a.active {
            background: #e8f5e9;
            color: #2E7D32;
        }

        .menu hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        #content {
            margin-left: 260px;

            padding: 45px;

            width: calc(100% - 260px);
        }

        #content h1 {
            color: #2E7D32;
            margin-bottom: 8px;
            font-size: 32px;
        }

        .welcome {
            color: #777;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .cards {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 35px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .card i {
            font-size: 28px;
            color: #2E7D32;
        }

        .card h2 {
            font-size: 30px;

            margin-top: 12px;

            color: #2E7D32;
        }

        .card p {
            color: #777;
            font-size: 14px;
        }

        .quick-actions {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 20px;

            margin-bottom: 35px;
        }

        .action {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .action h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .action h2 i {
            color: #2E7D32;
        }

        .action p {
            color: #777;

            margin-bottom: 18px;

            line-height: 1.6;
        }

        .action a {
            display: inline-block;

            background: #2E7D32;

            color: white;

            padding: 10px 20px;

            border-radius: 7px;
        }

        .action a:hover {
            background: #1f5d25;
        }

        .recent {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .recent h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;

            border-bottom: 1px solid #eee;

            text-align: left;
        }

        th {
            color: #2E7D32;
        }

        .pending {
            color: #d88a00;
            font-weight: bold;
        }

        .approved {
            color: #2E7D32;
            font-weight: bold;
        }

        .rejected {
            color: #d32f2f;
            font-weight: bold;
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

        .logout-btn i {
            width: 25px;
            color: #2E7D32;
        }

        .logout-btn:hover {
            color: #2E7D32;
            background: #e8f5e9;
            border-radius: 8px;
        }

        @media(max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            #content {
                margin-left: 210px;

                width: calc(100% - 210px);

                padding: 25px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width: 600px) {

            .sidebar {
                position: relative;

                width: 100%;

                min-height: auto;
            }

            .dashboard {
                display: block;
            }

            #content {
                margin-left: 0;

                width: 100%;

                padding: 25px;
            }

            .recent {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }
        }

    </style>

</head>

<body>


<div class="dashboard">

    <div class="sidebar">

        <div class="profile">

            <div class="profile-image">

                <i class="fa-solid fa-user"></i>

            </div>

            <h3>
                <?php echo htmlspecialchars($User_Name); ?>
            </h3>

            <p>
                <i class="fa-solid fa-user"></i>
                Adopter / Rescuer
            </p>

        </div>


        <div class="menu">


            <a href="userdashboard.php" class="active">

                <i class="fa-solid fa-table-columns"></i>

                Dashboard

            </a>


            <a href="adoption.php">

                <i class="fa-solid fa-paw"></i>

                Find Animals

            </a>


            <a href="myadoption.php">

                <i class="fa-solid fa-heart"></i>

                My Adoption Requests

            </a>


            <a href="myrescue.php">

                <i class="fa-solid fa-truck-medical"></i>

                My Rescue Requests

            </a>


            <a href="profile.php">

                <i class="fa-solid fa-user"></i>

                My Profile

            </a>


            <a href="settings.php">

                <i class="fa-solid fa-gear"></i>

                Settings

            </a>


            <hr>


            <form method="POST">

                <button
                    type="submit"
                    name="logout"
                    class="logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        </div>

    </div>

    <div id="content">
        <h1>
            Welcome back,
            <?php echo htmlspecialchars($User_Name); ?>! 👋

        </h1>


        <p class="welcome">

            Find an animal, manage your adoption requests, and help make a difference.

        </p>

        <div class="cards">


            <div class="card">

                <i class="fa-solid fa-heart"></i>

                <h2>
                    <?php echo $total_requests; ?>
                </h2>

                <p>
                    Total Adoption Requests
                </p>

            </div>


            <div class="card">

                <i class="fa-solid fa-clock"></i>

                <h2>
                    <?php echo $pending_requests; ?>
                </h2>

                <p>
                    Pending Requests
                </p>

            </div>


            <div class="card">

                <i class="fa-solid fa-circle-check"></i>

                <h2>
                    <?php echo $approved_requests; ?>
                </h2>

                <p>
                    Approved Adoptions
                </p>

            </div>


        </div>

        <div class="quick-actions">


            <div class="action">

                <h2>

                    <i class="fa-solid fa-paw"></i>

                    Find an Animal

                </h2>

                <p>

                    Browse animals currently available for adoption
                    and find your new best friend.

                </p>

                <a href="adoption.php">

                    Browse Animals

                </a>

            </div>


            <div class="action">

                <h2>

                    <i class="fa-solid fa-heart"></i>

                    My Adoption Requests

                </h2>

                <p>

                    View the status of your submitted adoption requests.

                </p>

                <a href="myadoption.php">

                    View Requests

                </a>

            </div>


        </div>

        <div class="recent">

            <h2>
                Recent Adoption Requests
            </h2>


            <table>

                <tr>

                    <th>ID</th>

                    <th>Animal</th>

                    <th>Date</th>

                    <th>Status</th>

                </tr>


                <?php

                $recent_sql = "SELECT
                                    ar.Adoption_id,
                                    ar.Request_date,
                                    ar.Status,
                                    a.Name AS Animal_Name

                               FROM Adoption_Request ar

                               JOIN Animal a
                               ON ar.Animal_id = a.Animal_id

                               WHERE ar.User_id = '$User_id'

                               ORDER BY ar.Adoption_id DESC

                               LIMIT 5";


                $recent_result = mysqli_query($conn, $recent_sql);


                if ($recent_result && mysqli_num_rows($recent_result) > 0) {

                    while ($row = mysqli_fetch_assoc($recent_result)) {

                ?>

                        <tr>

                            <td>
                                <?php echo $row['Adoption_id']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['Animal_Name']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['Request_date']); ?>
                            </td>

                            <td class="<?php echo strtolower($row['Status']); ?>">

                                <?php echo htmlspecialchars($row['Status']); ?>

                            </td>

                        </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="4">

                            You have not submitted any adoption requests yet.

                        </td>

                    </tr>

                <?php

                }

                ?>

            </table>
        </div>

    </div>
</div>
</body>

</html>