<!-- this is the login page -->
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

// Start session
session_start();

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

<style>
.content{
    border: 2px solid red;
    min-height: 85vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.container{
    border: 1px solid gray;
    border-radius: 30px;
    background-color: #ffffff;
    display: flex;
    width:80%;
}

.container div{
    display: flex;
    justify-content: center;
    align-items: center;
}

form{
    align-items: left;
    text-align: left;
    font-size: 1.0em;
}

/* Mobile version */
@media (max-width: 768px) {
    .container{
        flex-direction: column;
        height:auto;
    }
    .container div{
        width: 100%;
        height: auto;
    }
    .login{
        border-bottom: 2px solid gray;
    }
}

/* PC version */
@media (min-width: 769px) {
    .container{
        flex-direction: row;
        height:70vh;
    }
    .container div{
        width: 50%;
        height: 100%;
    }
    .login{
        border-right: 2px solid gray;
    }
}

/* New CSS for buttons */
button, input[type="submit"] {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            font-size: 1em; /* Increase font size */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        button:hover, input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        button:focus, input[type="submit"]:focus {
            outline: none; /* Remove outline */
            box-shadow: 0 0 5px #4CAF50; /* Add a green shadow */
        }
</style>

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
                       <a href="#head" class="nav_link">Login</a>
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
        <div class="container">
            <div class="login">
                <form action="login_process.php" method="post">
                    <br>
                    <br>
                    <u><b>Login</b></u>
                    <br>
                    <br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <input type="submit" value="Login">
                    <br>
                    <br>
                </form>
            </div>
            <div class="signup">
                <form action="signup_process.php" method="post">
                    <br>
                    <br>
                    <u><b>Sign Up</b></u>
                    <br>
                    <br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <input type="submit" value="Sign Up">
                    <br>
                    <br>
                </form>
            </div>
        </div>
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


