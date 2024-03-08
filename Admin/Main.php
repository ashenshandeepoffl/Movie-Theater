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
        .movie-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px;
            display: inline-block;
            width: 200px;
        }

        .movie-card img {
            width: 100%;
            height: auto;
        }

        .movie-details {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1><?php echo $welcomeMessage; ?> to Admin Dashboard</h1>
    </div>

    <div id="menu">
        <a href="Main.php">Home</a> | <a href="Users.php">Users</a> | <a href="Booking.php">Booking</a> | | <a href="ManageMovies.php">Movies</a> | <a href="../Customer/Logout.php">Logout</a>
    </div>

    <div id="content">
        
    <?php
    $host = "localhost";
    $username = "root";
    $password = "As+s01galaxysa";
    $database = "Movie";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        function getOngoingMovies($conn) {
        $sqlOngoingMovies = "SELECT id, movieName, posterImage FROM movies";
        $resultOngoingMovies = $conn->query($sqlOngoingMovies);

        if ($resultOngoingMovies->num_rows > 0) {
            while ($rowMovie = $resultOngoingMovies->fetch_assoc()) {
                echo "<div class='movie-card'>";
                echo "<img src='" . $rowMovie['posterImage'] . "' alt='" . $rowMovie['movieName'] . "'/>";
                echo "<div class='movie-details'>";
                echo "<h3>" . $rowMovie['movieName'] . "</h3>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No ongoing movies available.";
        }
    }

    // Call the function to display ongoing movies
    echo "<section>";
    echo "<h2>Ongoing Movies</h2>";
    getOngoingMovies($conn);
    echo "</section>";

    // FILL Update Movie Form
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selectMovie"])) {
        // ... (Your existing code for filling update form)
    }

    // UPDATE Movie
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
        // ... (Your existing code for updating the movie)

        // After the update, call the function to display updated ongoing movies
        echo "<section>";
        echo "<h2>Ongoing Movies</h2>";
        getOngoingMovies($conn);
        echo "</section>";
    }
    ?>
</body>

</html>
