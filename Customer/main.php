<?php
session_start();

$welcomeMessage = isset($_SESSION['username']) ? "Welcome, " . $_SESSION['username'] : "Welcome";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cineplex</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <section class="showcase">
        <header>
            <h2 class="logo"><?php echo $welcomeMessage; ?></h2>
            <div class="toggle"></div>
        </header>

        <video src="../Images/Intro2.mp4" type='video/mp4' muted loop autoplay></video>
        <div class="overlay"></div>
        <div class="text">
            <h2></h2>

            <!-- <a href="Signup.php">Join</a> -->
        </div>
        <ul class="social">
            <li><a href="#"><img src="https://i.ibb.co/x7P24fL/facebook.png"></a></li>
            <li><a href="https://www.facebook.com/Interfanet"><img src="https://i.ibb.co/Wnxq2Nq/twitter.png"></a></li>
            <li><a href="https://twitter.com/Interfanet"><img src="https://i.ibb.co/ySwtH4B/instagram.png"></a></li>
        </ul>
    </section>
    <div class="menu">
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="DisplayMovies.php">Movies</a></li>
            <li><a href="userProfile.php">Profile</a></li>
            <li><a href="Logout.php">Logout</a></li>
        </ul>
    </div>

    <script>
        const menuToggle = document.querySelector('.toggle');
        const showcase = document.querySelector('.showcase');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            showcase.classList.toggle('active');
        })
    </script>
</body>

</html>