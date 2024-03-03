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

// UPDATE Movie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $movieId = sanitizeInput($_POST["updateMovieId"]);
    $movieName = sanitizeInput($_POST["updateMovieName"]);
    $smallDescription = sanitizeInput($_POST["updateSmallDescription"]);
    $longDescription = sanitizeInput($_POST["updateLongDescription"]);
    $releaseDate = sanitizeInput($_POST["updateReleaseDate"]);
    $duration = sanitizeInput($_POST["updateDuration"]);
    $posterImage = sanitizeInput($_POST["updatePosterImage"]);
    $trailerEmbedCode = sanitizeInput($_POST["updateTrailerEmbedCode"]);

    $sqlUpdate = "UPDATE movies SET 
                  movieName = '$movieName', 
                  smallDescription = '$smallDescription', 
                  longDescription = '$longDescription', 
                  releaseDate = '$releaseDate', 
                  duration = '$duration', 
                  posterImage = '$posterImage', 
                  trailerEmbedCode = '$trailerEmbedCode' 
                  WHERE id = '$movieId'";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Movie updated successfully!";
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
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
</head>
<body>
    <h2>Create Movie</h2>
    <form action="#" method="post">
        <label for="movieName">Movie Name:</label>
        <input type="text" name="movieName" required>
        <label for="smallDescription">Small Description:</label>
        <textarea name="smallDescription" required></textarea>
        <label for="longDescription">Long Description:</label>
        <textarea name="longDescription" required></textarea>
        <label for="releaseDate">Release Date:</label>
        <input type="date" name="releaseDate" required>
        <label for="duration">Duration:</label>
        <input type="text" name="duration" required>
        <label for="posterImage">Poster Image:</label>
        <input type="text" name="posterImage" required>
        <label for="trailerEmbedCode">Trailer Embed Code:</label>
        <textarea name="trailerEmbedCode" required></textarea>
        <input type="submit" name="create" value="Create Movie">
    </form>

    <h2>Update Movie</h2>
    <form action="#" method="post">
        <label for="updateMovieId">Movie ID to Update:</label>
        <input type="text" name="updateMovieId" required>
        <label for="movieName">Movie Name:</label>
        <input type="text" name="movieName" required>
        <label for="smallDescription">Small Description:</label>
        <textarea name="smallDescription" required></textarea>
        <label for="longDescription">Long Description:</label>
        <textarea name="longDescription" required></textarea>
        <label for="releaseDate">Release Date:</label>
        <input type="date" name="releaseDate" required>
        <label for="duration">Duration:</label>
        <input type="text" name="duration" required>
        <label for="posterImage">Poster Image:</label>
        <input type="text" name="posterImage" required>
        <label for="trailerEmbedCode">Trailer Embed Code:</label>
        <textarea name="trailerEmbedCode" required></textarea>
        <input type="submit" name="update" value="Update Movie">
    </form>

    <h2>Delete Movie</h2>
    <form action="#" method="post">
        <label for="deleteMovieId">Movie ID to Delete:</label>
        <input type="text" name="deleteMovieId" required>
        <input type="submit" name="delete" value="Delete Movie">
    </form>
</body>
</html>

<?php
$conn->close();
?>
