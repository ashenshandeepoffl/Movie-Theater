<?php
// Start the session to check if the user is logged in
session_start();

if (isset($_SESSION['username'])) {
    $welcomeMessage = "Welcome, " . $_SESSION['username'];
} else {
    $welcomeMessage = "Welcome";
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: login_page.php"); // Redirect to the login page if not logged in or not an admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #header {
            background-color: #333;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        #menu {
            background-color: #444;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        #content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        #logout {
            margin-top: 20px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1><?php echo $welcomeMessage; ?> to Admin Dashboard</h1>
    </div>

    <div id="menu">
        <a href="Main.php">Home</a> | <a href="#">Users</a> | <a href="Booking.php">Booking</a> | <a href="Logout.php">Logout</a>
    </div>

    <div id="content">
        <h2>Recent Movies</h2>
        <table>
            <thead>
                <tr>
                    <th>Movie Name</th>
                    <th>Release Date</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Movie 1</td>
                    <td>2024-03-01</td>
                    <td>2 hours</td>
                </tr>
                <tr>
                    <td>Movie 2</td>
                    <td>2024-03-05</td>
                    <td>1.5 hours</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        <div id="logout">
            <a href="Logout.php">Logout</a>
        </div>
    </div>
</body>

</html>
