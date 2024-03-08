<?php
session_start(); // Start the session

$host = "localhost";
$username = "root";
$password = "As+s01galaxysa";
$database = "Movie";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all movies
$sqlSelect = "SELECT * FROM movies";
$result = $conn->query($sqlSelect);

$movies = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ongoing Movies | March 2024</title>
    <link rel="stylesheet" href="DisplayMovies.css">
</head>
<body>

    <?php
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getOngoingMovies($conn) {
        $sqlOngoingMovies = "SELECT id, movieName, posterImage, smallDescription, duration FROM movies";
        $resultOngoingMovies = $conn->query($sqlOngoingMovies);

        if ($resultOngoingMovies->num_rows > 0) {
            while ($rowMovie = $resultOngoingMovies->fetch_assoc()) {
                echo "<div class='movie-card'>";
                echo "<img src='" . $rowMovie['posterImage'] . "' alt='" . $rowMovie['movieName'] . "'/>";
                echo "<div class='movie-details'>";
                echo "<h3>" . $rowMovie['movieName'] . "</h3>";
                echo "<h3>" . $rowMovie['smallDescription'] . "</h3>";
                echo "<h3>" . $rowMovie['duration'] . "</h3>";
                echo "</div>";
                
                if (isset($_SESSION['user_id'])) {
                    echo "<a href='booking_page.php?movie_id=" . $rowMovie['id'] . "'>Book Now</a>";
                } else {
                    echo "<a href='Signup.php'>Login to book</a>";
                }
                
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

<?php
$conn->close();
?>
