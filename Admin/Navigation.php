<?php
session_start();

if (isset($_SESSION['username'])) {
    $welcomeMessage = "Welcome, " . $_SESSION['username'];
} else {
    $welcomeMessage = "Welcome";
}

if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../../../Signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Main.css">
</head>

<body>
    <div class="header">
        <h1><?php echo $welcomeMessage; ?> to Admin Dashboard</h1>
    </div>

    <div class="navigation">
        <a href="Main.php">Home</a> |
        <a href="Users.php">Users</a> |
        <a href="Booking.php">Booking</a> |
        <a href="ManageMovies.php">Movies</a> |
        <a href="Messages.php">Messages</a> |
        <a href="../Customer/Logout.php">Logout</a>
    </div>
</body>

</html>