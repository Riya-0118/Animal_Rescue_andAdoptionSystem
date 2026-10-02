<?php
session_start();
include "conn.php";

if (!isset($_SESSION['shelter_id'])) {
    header("Location: login.php");
    exit();
}

$shelter_id = (int) $_SESSION['shelter_id'];
$name = $_SESSION['name'] ?? "Shelter";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adoption_id = (int) ($_POST['adoption_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    if ($adoption_id > 0 && in_array($status, ['Approved', 'Rejected'], true)) {
        $status = mysqli_real_escape_string($conn, $status);

        $update = "UPDATE Adoption_Request ar
                   JOIN Animal a ON ar.Animal_id = a.Animal_id
                   SET ar.Status = '$status'
                   WHERE ar.Adoption_id = $adoption_id
                   AND a.Shelter_id = $shelter_id
                   AND ar.Status = 'Pending'";

        mysqli_query($conn, $update);
    }

    header("Location: adoption_requests.php");
    exit();
}

$sql = "SELECT
            ar.Adoption_id,
            ar.User_id,
            ar.Animal_id,
            ar.Request_Date,
            ar.Status,
            u.Name AS adopter_name,
            u.Email AS adopter_email,
            a.Name AS animal_name
        FROM Adoption_Request ar
        JOIN Users u ON ar.User_id = u.User_id
        JOIN Animal a ON ar.Animal_id = a.Animal_id
        WHERE a.Shelter_id = $shelter_id
        ORDER BY ar.Request_Date DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Requests | KumaCare</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f9f5;
            color: #333;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #2e7d32;
            color: white;
            padding: 25px 15px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 13px;
            margin-bottom: 8px;
            border-radius: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1b5e20;
        }

        .main {
            margin-left: 230px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .header h1 {
            color: #2e7d32;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #00000012;
        }

        .card h2 {
            margin-bottom: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #e8f5e9;
            color: #2e7d32;
        }

        tr:hover {
            background: #f9fdf9;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 15px;
            font-size: 13px;
        }

        .Pending {
            background: #fff3cd;
            color: #856404;
        }

        .Approved {
            background: #d4edda;
            color: #155724;
        }

        .Rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        button {
            padding: 7px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .approve {
            background: #2e7d32;
        }

        .reject {
            background: #dc3545;
        }

        button:hover {
            opacity: 0.8;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 65px;
                padding: 15px 5px;
            }

            .sidebar h2 {
                font-size: 11px;
            }

            .sidebar a {
                font-size: 11px;
                padding: 10px 5px;
                text-align: center;
            }

            .main {
                margin-left: 65px;
                padding: 15px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>KumaCare</h2>

        <a href="shelterdashboard.php">Dashboard</a>
        <a href="shelter_animals.php">My Animals</a>
        <a href="adoption_requests.php" class="active">Adoption Requests</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">

        <div class="header">
            <h1>Adoption Requests</h1>
            <p>Welcome, <?php echo htmlspecialchars($name); ?></p>
        </div>

        <div class="card">
            <h2>All Adoption Requests</h2>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Adoption ID</th>
                            <th>Adopter</th>
                            <th>Email</th>
                            <th>Animal</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>

                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>
                                        <?php echo (int) $row['Adoption_id']; ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['adopter_name'] ?? ''); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['adopter_email'] ?? ''); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['animal_name'] ?? ''); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['Request_Date'] ?? ''); ?>
                                    </td>

                                    <td>
                                        <span class="status <?php echo htmlspecialchars($row['Status'] ?? 'Pending'); ?>">
                                            <?php echo htmlspecialchars($row['Status'] ?? 'Pending'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if ($row['Status'] === 'Pending'): ?>
                                            <form method="POST" class="actions">
                                                <input
                                                    type="hidden"
                                                    name="adoption_id"
                                                    value="<?php echo (int) $row['Adoption_id']; ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    name="status"
                                                    value="Approved"
                                                    class="approve"
                                                >
                                                    Approve
                                                </button>

                                                <button
                                                    type="submit"
                                                    name="status"
                                                    value="Rejected"
                                                    class="reject"
                                                >
                                                    Reject
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span>Completed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty">
                                    No adoption requests found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>