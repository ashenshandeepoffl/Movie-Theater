<?php
session_start();

if (isset($_SESSION['username'])) {
    $welcomeMessage = "Welcome, " . $_SESSION['username'];
} else {
    $welcomeMessage = "Welcome";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <p><?php echo $welcomeMessage; ?></p>
    </div>
    <a href="DisplayMovies.php">Display Movies</a>
    <a href="Logout.php">Logout</a>
</body>
</html>
