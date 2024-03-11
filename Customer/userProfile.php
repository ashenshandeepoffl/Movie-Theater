<?php

include 'dbConnection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Signup.php");
    exit();
}

function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

$userId = $_SESSION['user_id'];

// Handle account update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_account"])) {
    // Retrieve the input values
    $newUsername = sanitizeInput($_POST["new_username"]);
    $newEmail = sanitizeInput($_POST["new_email"]);
    $oldPassword = $_POST["old_password"]; // Added for password verification

    // Check if the old password matches the stored password
    $sqlCheckPassword = "SELECT password FROM users WHERE id = '$userId'";
    $resultCheckPassword = $conn->query($sqlCheckPassword);

    if ($resultCheckPassword->num_rows > 0) {
        $row = $resultCheckPassword->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the old password
        if (password_verify($oldPassword, $storedPassword)) {
            // Password verification successful, proceed with the update
            $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

            $sqlUpdate = "UPDATE users 
                          SET username = '$newUsername', email = '$newEmail', password = '$newPassword' 
                          WHERE id = '$userId'";

            if ($conn->query($sqlUpdate) === TRUE) {
                echo "Account updated successfully!";
                $_SESSION['username'] = $newUsername;
                $_SESSION['email'] = $newEmail;
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
            }
        } else {
            echo '<script>alert("Old password verification failed!");</script>';
        }
    } else {
        echo '<script>alert("Error checking old password!");</script>';
    }
}

// Retrieve current user details
$sqlSelectUser = "SELECT * FROM users WHERE id = '$userId'";
$resultUser = $conn->query($sqlSelectUser);

if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
} else {
    echo '<script>alert("User not found!");</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link rel="stylesheet" href="userProfile.css">
</head>

<body>

    <div class="form-modal">

        <div class="form-toggle">
            <button id="login-toggle" onclick="toggleLogin()">Profile</button>
            <button id="signup-toggle" onclick="toggleSignup()">Edit Profile</button>
        </div>

        <div id="login-form">
            <form>
                <input type="text" placeholder="<?php echo $user['username']; ?>" disabled />
                <input type="text" placeholder="<?php echo $user['email']; ?>" disabled />
            </form>
        </div>

        <div id="signup-form">
            <form>
                <input type="text" name="new_username" value="<?php echo $user['username']; ?>" required>
                <input type="email" name="new_email" value="<?php echo $user['email']; ?>" required>
                <input type="password" name="old_password" required placeholder="Old Password">
                <input type="password" name="new_password" required placeholder="New password">
                <input type="submit" name="update_account" value="Update Account" class="btn signup">
            </form>
        </div>

    </div>

</body>
<script>
    function toggleSignup() {
        document.getElementById("login-toggle").style.backgroundColor = "#fff";
        document.getElementById("login-toggle").style.color = "#222";
        document.getElementById("signup-toggle").style.backgroundColor = "#F86F03";
        document.getElementById("signup-toggle").style.color = "#fff";
        document.getElementById("login-form").style.display = "none";
        document.getElementById("signup-form").style.display = "block";
    }

    function toggleLogin() {
        document.getElementById("login-toggle").style.backgroundColor = "#F86F03";
        document.getElementById("login-toggle").style.color = "#fff";
        document.getElementById("signup-toggle").style.backgroundColor = "#fff";
        document.getElementById("signup-toggle").style.color = "#222";
        document.getElementById("signup-form").style.display = "none";
        document.getElementById("login-form").style.display = "block";
    }
</script>

</html>

<?php
$conn->close();
?>