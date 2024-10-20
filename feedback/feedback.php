<!-- this is the feedback page -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get form input values
    $email = $_POST['email'];
    $topic = $_POST['topic'];
    $feedback = $_POST['feedback_input'];

    // Insert data into the feedback table
    $stmt = $conn->prepare("INSERT INTO feedback (email, topic, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $topic, $feedback);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!');</script>";
        // Optionally, redirect to another page
        // header("Location: success.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals - Feedback</title>
   <link rel="icon" href="../media/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="../styles.css">
</head>

<style>
.content{
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

.feedback{
    display: flex;
    flex-direction: column;
    padding: 20px;
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
        height:60vh;
    }
    .container div{
        width: 50%;
        height: 100%;
    }
    .login{
        border-right: 2px solid gray;
    }
}

form input{
    border: 2px solid #000;
    margin-bottom: 15px;
    padding: 5px;
    border-radius: 5px;
}

form input:valid {
    border-color: green;
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
           <a href="../index.php" class="logo">Professionals Catering</a>

           <nav class="nav">
                <ul class="nav_list">
                    <li class="nav_item">
                        <a href="../menu/menu.php" class="nav_link">Menu</a>
                    </li>
                    <li class="nav_item">
                        <a href="../order/order.php" class="nav_link">Order</a>
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
                            <a href="#head" class="nav_link">Login</a>
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
        <div class="container">
            <div class="feedback">
                <form action="feedback.php" method="post" onsubmit="return validateForm()">
                    <input type="hidden" name="form_type" value="feedback">
                    <br>
                    <br>
                    <u><b>Feedback</b></u>
                    <br>
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Please enter your email" required><br><br>

                    <label for="topic">Topic:</label>
                    <input type="text" id="topic" name="topic" placeholder="Please enter your topic" required><br><br>
                    
                    <label>Feedback: <textarea name="feedback_input" id="feedback_input" rows="4" cols="40" required placeholder="Enter your feedback here"></textarea></label>
                                    
                    <input type="submit" value="Submit">
                    <br>
                    <br>
                </form>
                
            </div>
            
        </div>
   </div>

   <footer class="footer">
       <div class="footer_content">
           <div class="footer_section">
               <h4><a href="../feedback/feedback.php">Contact Us</a></h4>
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
   <script>
       
        function validateForm() {
            // Add your form validation logic here
            document.getElementById("myForm").onsubmit = function(event) {
    
            // Validate Email
            var email = document.getElementById("email").value;
            var emailRegex = /^[\w.-]+@[A-Za-z\d.-]+\.[A-Za-z]{2,3}$/;
            var emailRegex1 = /^[\w.-]+@[A-Za-z\d.-]+\.[A-Za-z]{2,3}(\.[A-Za-z]{2,3}){1,3}$/; // Email format
            if (emailRegex.test(email)) {
        
            }
            else if(emailRegex1.test(email)) {
        
            }
            else{
                alert("Please enter a valid email address.");
                event.preventDefault();
            return;
            }

    
            };
            return true;
        }
    </script>
</body>
</html>


