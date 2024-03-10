<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Main.css">
</head>

<body>

    <?php
    include 'dbConnection.php';
    include 'Navigation.php';

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