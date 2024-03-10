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
  <title>Document</title>
  <link rel="stylesheet" href="Movies.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>

  <?php
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  function getOngoingMovies($conn)
  {
    $sqlOngoingMovies = "SELECT id, movieName, posterImage, smallDescription, duration FROM movies";
    $resultOngoingMovies = $conn->query($sqlOngoingMovies);

    if ($resultOngoingMovies->num_rows > 0) {
      while ($rowMovie = $resultOngoingMovies->fetch_assoc()) {
        echo "<div class='movie-card'>";
        echo "<img src='" . $rowMovie['posterImage'] . "' alt='" . $rowMovie['movieName'] . "'/>";
        echo "<div class='movie-details'>";
        echo "<a class='popup-btn'>" . $rowMovie['movieName'] . "</a>";
        echo "</div>";

        echo "<div class='popup-view'>";
        echo "<div class='popup-card'>";
        echo "<a><i class='fas fa-times close-btn'></i></a>";
        echo "<div class='product-img'>";
        echo "<img src='" . $rowMovie['posterImage'] . "' alt='" . $rowMovie['movieName'] . "'/>";
        echo "</div>";

        echo "<div class='info'>";
        echo "<h3>" . $rowMovie['movieName'] . "</h3>";
        echo "<p>" . $rowMovie['smallDescription'] . "<p>";
        echo "<span class='price'>" . $rowMovie['duration'] . " Mins" . "</span>";
        echo "<div>";
        if (isset($_SESSION['user_id'])) {
          echo "<a href='Signup.php' class='add-cart-btn' >Book Now</a>";
        } else {
          echo "<a href='Signup.php' class='add-cart-btn'>Login to book</a>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
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
<script type="text/javascript">
  var popupViews = document.querySelectorAll('.popup-view');
  var popupBtns = document.querySelectorAll('.popup-btn');
  var closeBtns = document.querySelectorAll('.close-btn');
  //javascript for quick view button
  var popup = function(popupClick) {
    popupViews[popupClick].classList.add('active');
  }
  popupBtns.forEach((popupBtn, i) => {
    popupBtn.addEventListener("click", () => {
      popup(i);
    });
  });
  //javascript for close button
  closeBtns.forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
      popupViews.forEach((popupView) => {
        popupView.classList.remove('active');
      });
    });
  });
</script>

</html>