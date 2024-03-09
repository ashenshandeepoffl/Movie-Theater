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
    <link rel="stylesheet" href="Main.css">
</head>

<body>
    <div class="header">
        <h1><?php echo $welcomeMessage; ?> to Admin Dashboard</h1>
    </div>

    <div class="navigation">
        <a href="Main.php">Home</a> |
        <a href="Users.php">Users</a> |
        <a href="Booking.php">Booking</a> |
        <a href="ManageMovies.php">Movies</a> |
        <a href="Messages.php">Messages</a> |
        <a href="../Customer/Logout.php">Logout</a>
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
        function getOngoingMovies($conn)
        {
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
        echo "<hr>";
        getOngoingMovies($conn);
        echo "</section>";
        ?>
</body>

</html>