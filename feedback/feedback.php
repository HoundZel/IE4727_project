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
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "professionals";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];

    // Get the user's email from the database
    $email_query = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $email_query->bind_param("s", $username);
    $email_query->execute();
    $email_result = $email_query->get_result();

    if ($email_result->num_rows > 0) {
    $row = $email_result->fetch_assoc();
    $user_email = $row['email'];
    $email_query->close();
    } else {
    $email_query->close();
    echo "Error: Unable to retrieve email for the user.";
    exit();
    }

    // Get the user's contact number from the database
    $contact_query = $conn->prepare("SELECT contact FROM users WHERE username = ?");
    $contact_query->bind_param("s", $username);
    $contact_query->execute();
    $contact_result = $contact_query->get_result();

    if ($contact_result->num_rows > 0) {
    $row = $contact_result->fetch_assoc();
    $user_contact = $row['contact'];
    $contact_query->close();
    } else {
    $contact_query->close();
    echo "Error: Unable to retrieve contact for the user.";
    exit();
    }

    // Get form input values
    $contact=$user_contact;
    $email = $user_email;
    $topic = $_POST['topic'];
    $feedback = $_POST['feedback_input'];

    // Insert data into the feedback table
    $stmt = $conn->prepare("INSERT INTO feedback (username, contact, email, topic, feedback) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $username, $contact, $email, $topic, $feedback);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!');</script>";
        
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
        padding-left:170px;
        width: 90%;
        height: 100%;
    }

    form textarea{
    width: 130vh;
    height:30vh;
    }

}

form select{
    border: 2px solid #000;
    margin-bottom: 15px;
    padding: 5px;
    border-radius: 5px;
}

form textarea{
    border: 2px solid #000;
    margin-bottom: 15px;
    padding: 5px;
    border-radius: 5px;
}

form select:valid {
    border-color: green;
  }

form textarea:valid {
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
                <form action="feedback.php" method="post">
                    <input type="hidden" name="form_type" value="feedback">
                    <br>
                    <br>
                    <h2><u><b>Feedback</b></u></h2>
                    <br>
                    <br>

                    <label for="topic">Topic:</label>
                    <select size="1" name="topic" required>
                    <option value="" disabled selected> Please select your topic </option>
                    <option value="queries"> Queries  </option>
                    <option value="feedback"> Feedback  </option>
                    <option value="quotation"> Quotation </option>
                    
                    

                    <label><textarea name="feedback_input" id="feedback_input" rows="20" cols="40" required placeholder="Enter your feedback here"></textarea></label>
                                    
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
   
</body>
</html>






