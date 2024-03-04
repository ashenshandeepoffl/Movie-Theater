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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        iframe {
            max-width: 100%;
            height: auto;
        }

        a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }

        p {
            color: #555;
        }
    </style>
</head>
<body>
    <div>
        <h2>Ongoing Movies | March 2024</h2>
        <table>
            <tr>
                <th>Movie Name</th>
                <th>About The Movie</th>
                <th>Release Date</th>
                <th>Duration (HH:MM)</th>
                <th>Poster Image</th>
                <th>Trailer</th>
                <th>Action</th>
            </tr>
            <?php foreach ($movies as $movie) : ?>
                <tr>
                    <td><?php echo $movie['movieName']; ?></td>
                    <td><?php echo $movie['smallDescription']; ?></td>
                    <td><?php echo $movie['releaseDate']; ?></td>
                    <td><?php echo $movie['duration']; ?></td>
                    <td><img src="<?php echo $movie['posterImage']; ?>" alt="Poster Image"></td>
                    <td>
                        <iframe src="<?php echo $movie['trailerEmbedCode']; ?>" frameborder="0" allowfullscreen></iframe>
                    </td>
                    <td>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <a href="booking_page.php?movie_id=<?php echo $movie['id']; ?>">Book Now</a>
                        <?php else : ?>
                            <a href="Signup.php">Login to book</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
