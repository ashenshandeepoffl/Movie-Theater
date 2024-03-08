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
    <link rel="stylesheet" href="DisplayMovies.css">
</head>

<body>
    <div class="header">
        <div class="container-nav">
            <!-- <div class="logo"><a href="#">Logo</a></div> -->
            <div class="nav">
                <a href="main.php">Home</a>
                <a href="DisplayMovies.php">Movies</a>
                <a href="userProfile.php">Profile</a>
                <a href="Logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2>Ongoing Movies | 2024</h2>
        <div class="card-container">
            <?php foreach ($movies as $movie) : ?>
                <div class="card">
                    <img src="<?php echo $movie['posterImage']; ?>" alt="Poster Image">
                    <div class="card-content">
                        <h3><?php echo $movie['movieName']; ?></h3>
                        <p><?php echo $movie['smallDescription']; ?></p>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <a href="booking_page.php?movie_id=<?php echo $movie['id']; ?>">Book Now</a>
                        <?php else : ?>
                            <p>Login to book</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>


<?php
$conn->close();
?>