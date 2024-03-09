<?php
$host = "localhost";
$username = "root";
$password = "As+s01galaxysa";
$database = "Movie";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// CREATE Movie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $movieName = sanitizeInput($_POST["movieName"]);
    $smallDescription = sanitizeInput($_POST["smallDescription"]);
    $longDescription = sanitizeInput($_POST["longDescription"]);
    $releaseDate = sanitizeInput($_POST["releaseDate"]);
    $duration = sanitizeInput($_POST["duration"]);
    $posterImage = sanitizeInput($_POST["posterImage"]);
    $trailerEmbedCode = sanitizeInput($_POST["trailerEmbedCode"]);

    $sqlCreate = "INSERT INTO movies (movieName, smallDescription, longDescription, releaseDate, duration, posterImage, trailerEmbedCode) 
                  VALUES ('$movieName', '$smallDescription', '$longDescription', '$releaseDate', '$duration', '$posterImage', '$trailerEmbedCode')";

    if ($conn->query($sqlCreate) === TRUE) {
        echo "Movie created successfully!";
    } else {
        echo "Error: " . $sqlCreate . "<br>" . $conn->error;
    }
}


// DELETE Movie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $movieId = sanitizeInput($_POST["deleteMovieId"]);

    $sqlDelete = "DELETE FROM movies WHERE id = '$movieId'";

    if ($conn->query($sqlDelete) === TRUE) {
        echo "Movie deleted successfully!";
    } else {
        echo "Error: " . $sqlDelete . "<br>" . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie CRUD</title>
    <link rel="stylesheet" href="ManageMovies.css">
</head>

<body>
    <div class="container">
        <header>
            <h2></h2>
        </header>

        <?php
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
            echo "<section>";
            echo "<h2>Ongoing Movies</h2>";
            getOngoingMovies($conn);
            echo "</section>";
        }
        ?>

        <h2>Create Movie</h2>
        <form action="#" method="post">
            <input type="text" name="movieName" required placeholder="Movie Name">
            <textarea name="smallDescription" required placeholder="Small Description"></textarea>
            <textarea name="longDescription" required placeholder="Long Description"></textarea>
            <input type="date" name="releaseDate" required placeholder="Release Date">
            <input type="text" name="duration" required placeholder="Duration (Mins)">
            <input type="text" name="posterImage" required placeholder="Poster Image">
            <textarea name="trailerEmbedCode" required placeholder="Trailer Embed Code"></textarea>
            <input type="submit" name="create" value="Create Movie">
        </form>

        <h2>Search and Update Movie</h2>
        <form action="#" method="post" class="search-update-form">
            <label for="searchMovieName">Search Movie Name</label>
            <input type="text" name="searchMovieName" required class="search-box">
            <input type="submit" name="search" value="Search Movie">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
            $searchMovieName = sanitizeInput($_POST["searchMovieName"]);

            $sqlSearch = "SELECT * FROM movies WHERE movieName LIKE '%$searchMovieName%'";
            $result = $conn->query($sqlSearch);

            if ($result->num_rows > 0) {
                echo "<h2>Search Results</h2>";
                echo "<form action='#' method='post'>";
                echo "<label for='updateMovieId'>Select Movie to Update</label>";
                echo "<select name='updateMovieId'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["movieName"] . "</option>";
                }
                echo "</select>";
                echo "<input type='submit' name='selectMovie' value='Select Movie'>";
                echo "</form>";
            } else {
                echo "No results found.";
            }
        }

        // FILL Update Movie Form
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selectMovie"])) {
            $selectedMovieId = sanitizeInput($_POST["updateMovieId"]);

            $sqlSelect = "SELECT * FROM movies WHERE id = '$selectedMovieId'";
            $selectedMovie = $conn->query($sqlSelect);

            if ($selectedMovie->num_rows > 0) {
                $row = $selectedMovie->fetch_assoc();
                // Fill the update form with the selected movie details
                echo "<h2>Update Movie</h2>";
                echo "<form action='#' method='post'>";
                echo "<label for='updateMovieId'>Movie ID to Update</label>";
                echo "<input type='text' name='updateMovieId' value='" . $row["id"] . "' readonly required>";
                echo "<label for='movieName'>Movie Name</label>";
                echo "<input type='text' name='movieName' value='" . $row["movieName"] . "' required>";
                echo "<label for='smallDescription'>Small Description</label>";
                echo "<textarea name='smallDescription' required>" . $row["smallDescription"] . "</textarea>";
                echo "<label for='longDescription'>Long Description</label>";
                echo "<textarea name='longDescription' required>" . $row["longDescription"] . "</textarea>";
                echo "<label for='releaseDate'>Release Date</label>";
                echo "<input type='date' name='releaseDate' value='" . $row["releaseDate"] . "' required>";
                echo "<label for='duration'>Duration (Mins)</label>";
                echo "<input type='text' name='duration' value='" . $row["duration"] . "' required>";
                echo "<label for='posterImage'>Poster Image</label>";
                echo "<input type='text' name='posterImage' value='" . $row["posterImage"] . "' required>";
                echo "<label for='trailerEmbedCode'>Trailer Embed Code</label>";
                echo "<textarea name='trailerEmbedCode' required>" . $row["trailerEmbedCode"] . "</textarea>";
                echo "<input type='submit' name='update' value='Update Movie'>";
                echo "</form>";
            }
        }

        // UPDATE Movie
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
            $updateMovieId = sanitizeInput($_POST["updateMovieId"]);
            $movieName = sanitizeInput($_POST["movieName"]);
            $smallDescription = sanitizeInput($_POST["smallDescription"]);
            $longDescription = sanitizeInput($_POST["longDescription"]);
            $releaseDate = sanitizeInput($_POST["releaseDate"]);
            $duration = sanitizeInput($_POST["duration"]);
            $posterImage = sanitizeInput($_POST["posterImage"]);
            $trailerEmbedCode = sanitizeInput($_POST["trailerEmbedCode"]);

            $sqlUpdate = "UPDATE movies SET
                    movieName = '$movieName',
                    smallDescription = '$smallDescription',
                    longDescription = '$longDescription',
                    releaseDate = '$releaseDate',
                    duration = '$duration',
                    posterImage = '$posterImage',
                    trailerEmbedCode = '$trailerEmbedCode'
                    WHERE id = '$updateMovieId'";

            if ($conn->query($sqlUpdate) === TRUE) {
                echo "Movie updated successfully!";
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
            }
        }
        ?>


        <h2>Delete Movie</h2>
        <form action="#" method="post" class="delete-form">
            <label for="deleteMovieId">Movie ID to Delete</label>
            <input type="text" name="deleteMovieId" required>
            <input type="submit" name="delete" value="Delete Movie">
        </form>
    </div>
</body>

</html>

<?php
$conn->close();
?>