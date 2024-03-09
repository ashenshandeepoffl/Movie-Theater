<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Connect to the database (replace these values with your actual database information)
  $host = "localhost";
  $username = "root";
  $password = "As+s01galaxysa";
  $database = "Movie";

  // Create a database connection
  $conn = new mysqli($host, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve form data
  $fullName = $_POST['name']; // Updated to match the input name in HTML
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Insert data into the database
  $sql = "INSERT INTO contacts (full_name, email, message) VALUES ('$fullName', '$email', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="ContactUs.css" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <span class="big-circle"></span>
    <img src="img/shape.png" class="square" alt="" />
    <div class="form">
      <div class="contact-info">
        <h3 class="title">Let's get in touch</h3>
        <p class="text">
          Hello
        </p>

        <div class="info">
          <div class="information">
            <i class="fas fa-map-marker-alt"></i> &nbsp &nbsp

            <p>Colombo 06</p>
          </div>
          <div class="information">
            <i class="fas fa-envelope"></i> &nbsp &nbsp
            <p>email@email.com</p>
          </div>
          <div class="information">
            <i class="fas fa-phone"></i>&nbsp&nbsp
            <p>0113038215</p>
          </div>
        </div>

        <div class="social-media">
          <p>Connect with us</p>
          <div class="social-icons">
            <a href="#">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="contact-form">
        <span class="circle one"></span>
        <span class="circle two"></span>

        <form action="" method="post" autocomplete="off">
          <h3 class="title">Contact us</h3>
          <div class="input-container">
            <input type="text" name="name" class="input" />
            <label for="">Full Name</label>
            <span>Full Name</span>
          </div>
          <div class="input-container">
            <input type="email" name="email" class="input" />
            <label for="">Email</label>
            <span>Email</span>
          </div>
          <div class="input-container textarea">
            <textarea name="message" class="input"></textarea>
            <label for="">Type your Message...</label>
            <span>Type your Message...</span>
          </div>
          <input type="submit" value="Send" class="btn" />
        </form>

      </div>
    </div>
  </div>

  <script>
    const inputs = document.querySelectorAll(".input");

    function focusFunc() {
      let parent = this.parentNode;
      parent.classList.add("focus");
    }

    function blurFunc() {
      let parent = this.parentNode;
      if (this.value == "") {
        parent.classList.remove("focus");
      }
    }

    inputs.forEach((input) => {
      input.addEventListener("focus", focusFunc);
      input.addEventListener("blur", blurFunc);
    });
  </script>
</body>

</html>