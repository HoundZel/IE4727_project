<!-- this is the order page -->
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
   <link rel="icon" href="../media/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="../styles.css">
</head>

<style>
    .container {
        background-color: white;
        border-radius: 20px;
        border: 1px solid gray;
        margin: 20px 0 20px 0;
        min-width: 350px;
        width: 70vw;
        max-width: 750px;
        padding: 20px; /* Optional: Add padding for better content spacing */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow for better visual appeal */
    }
    table {
           width: 100%;
           border-collapse: collapse;
           border: none;
       }
    th, td {
        padding: 10px 0 10px 0;
        text-align: left;
    }
</style>

<body>
   <header class="header">
       <div class="header_content">
           <a href="../index.php" class="logo">Professionals Catering</a>

           <nav class="nav">
                <ul class="nav_list">
                    <li class="nav_item">
                        <a href="../menu/menu.php" class="nav_link">Menu</a>
                    </li>
                    <li class="nav_item">
                        <a href="#head" class="nav_link">Order</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav_item">
                            <a href="../logout.php" class="nav_link">Logout</a>
                        </li>
                        <li class="nav_item">
                            <span class="nav_link">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                        </li>
                    <?php else: ?>
                        <li class="nav_item">
                            <a href="../login/login.php" class="nav_link">Login</a>
                        </li>
                    <?php endif; ?>
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
        <br><br>
        <div class="container">
            
        </div>
        <br><br><br><br>
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