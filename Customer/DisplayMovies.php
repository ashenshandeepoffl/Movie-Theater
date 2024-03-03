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
    <title>All Movies</title>
</head>
<body>
    <h2>All Movies</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Movie Name</th>
            <th>Small Description</th>
            <th>Release Date</th>
            <th>Duration</th>
            <th>Poster Image</th>
            <th>Trailer</th>
            <th>Action</th>
        </tr>
        <?php foreach ($movies as $movie) : ?>
            <tr>
                <td><?php echo $movie['id']; ?></td>
                <td><?php echo $movie['movieName']; ?></td>
                <td><?php echo $movie['smallDescription']; ?></td>
                <td><?php echo $movie['releaseDate']; ?></td>
                <td><?php echo $movie['duration']; ?></td>
                <td><img src="<?php echo $movie['posterImage']; ?>" alt="Poster Image" width="100"></td>
                <td>
                    <iframe width="200" height="150" src="<?php echo $movie['trailerEmbedCode']; ?>" frameborder="0" allowfullscreen></iframe>
                </td>
                <td>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="booking_page.php?movie_id=<?php echo $movie['id']; ?>">Book Now</a>
                    <?php else : ?>
                        <p>Login to book</p>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
