<?php
session_start();

$welcomeMessage = isset($_SESSION['username']) ? "Welcome, " . $_SESSION['username'] : "Welcome";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            text-align: center;
        }

        .welcome-message {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .nav-links {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <p><?php echo $welcomeMessage; ?></p>
        </div>
        
        <div class="nav-links">
            <a href="DisplayMovies.php">Display Movies</a>
            <a href="userProfile.php">Profile</a>
            <a href="Logout.php">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
