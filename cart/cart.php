<!-- this is the cart page -->
<?php

// Database connection
$servername = "localhost"; // Change if different
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "professionals";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals</title>
   <link rel="icon" href="media/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="../styles.css">
</head>
<body>
   <header class="header">
       <div class="header_content">
           <a href="../index.html" class="logo">Professionals Catering</a>

           <nav class="nav">
               <ul class="nav_list">
                   <li class="nav_item">
                       <a href="../menu/menu.php" class="nav_link">Menu</a>
                   </li>
                   <li class="nav_item">
                       <a href="#" class="nav_link">Order</a>
                   </li>
                   <li class="nav_item">
                       <a href="../login/login.php" class="nav_link">Login</a>
                   </li>
               </ul>
           </nav>

           <div class="hamburger">
               <div class="bar"></div>
               <div class="bar"></div>
               <div class="bar"></div>
           </div>
       </div>
   </header>

   <div id="head"></div>   
   <div class="content">

   </div>

   <footer class="footer">
       <div class="footer_content">
           <div class="footer_section">
               <h4>Contact Us</h4>
               <p>Email: info@professionalscatering.com</p>
               <p>Phone: (123) 456-7890</p>
               <p>Address: 123 Catering Lane, Food City, FC 12345</p>
           </div>
           <br>
       </div>
       <div class="footer_bottom">
           <p>&copy; 2024 Professionals Catering. All rights reserved.</p>
       </div>
   </footer>

   <script src="../script.js"></script>
</body>
</html>


