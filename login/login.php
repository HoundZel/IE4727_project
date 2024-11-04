<!-- this is the login page -->
<?php
session_start();
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

    // Check which form was submitted
    $form_type = $_POST['form_type'];

    if ($form_type == 'login') {
        // Login form was submitted
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Authenticate user
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User authenticated
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
        } else {
            // Authentication failed
            echo "<script>alert('Invalid username or password'); window.location.href = 'login.php';</script>";
        }
    } elseif ($form_type == 'signup') {
        // Signup form was submitted
        $username = $_POST['username'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check for existing username, contact, or email
        $check_stmt = $conn->prepare("SELECT username, contact, email FROM users WHERE username=? OR contact=? OR email=?");
        $check_stmt->bind_param("sss", $username, $contact, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Found duplicates
            echo "<script>alert('Username, Contact Number, or Email already exists. Please use different credentials.'); window.location.href = 'login.php';</script>";
        } else {
            // Insert new user
            $insert_stmt = $conn->prepare("INSERT INTO users (username, contact, email, password) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $username, $contact, $email, $password); 
            if ($insert_stmt->execute()) {
                $_SESSION['username'] = $username; // Log the user in
                echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.'); window.location.href = 'login.php';</script>";
            }
        }
        $check_stmt->close();
        $insert_stmt->close();

    } elseif ($form_type == 'change') {
        // Change password form was submitted
        $username = $_POST['username'];
        $new_password = $_POST['password'];
    
        // Check if the username exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Username exists, update the password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_password, $username);
            if ($stmt->execute()) {
                echo "<script>alert('Password changed successfully!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Password change failed. Please try again.'); window.location.href = 'login.php';</script>";
            }
        } else {
            // Username does not exist
            echo "<script>alert('Username does not exist'); window.location.href = 'login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals - Login</title>
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

.login{
    display: flex;
    flex-direction: column;
    padding: 20px;
}
#change-password-form {
    display: none;
}
.forgot-password {
    color: blue;
    cursor: pointer;
    text-decoration: underline;
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
            <div class="login">
                <form action="login.php" method="post" onsubmit="return validateForm()">
                    <input type="hidden" name="form_type" value="login">
                    <br>
                    <br>
                    <u><b>Login</b></u>
                    <br>
                    <br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Yuji1" pattern="[A-Za-z0-9_]+" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="******" required><br><br>

                    <input type="submit" value="Login">
                    <br>
                    <br>
                </form>
                <a class="forgot-password" onclick="showChangePasswordForm()">Forgot your password?</a>
                <form id="change-password-form" action="login.php" method="post" onsubmit="return validateForm3()">
                    <input type="hidden" name="form_type" value="change">
                    <br>
                    <br>
                    <u><b>Change Password</b></u>
                    <br>
                    <br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Yuji1" pattern="[A-Za-z0-9_]+" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="change_password" name="password" placeholder="******" required><br><br>
                    
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_change_password" name="confirm_password" placeholder="******" required><br><br>

                    <input type="submit" value="Change">
                    <br>
                    <br>
                </form>
            </div>
            <div class="signup">
                <form action="login.php" method="post" onsubmit="return validateForm2()">
                    <input type="hidden" name="form_type" value="signup">
                    <br>
                    <br>
                    <u><b>Sign Up</b></u>
                    <br>
                    <br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Yuji1" pattern="[A-Za-z0-9_]+" required><br><br>

                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" placeholder="8123 4567" pattern="[0-9\s]+" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="yujiitadori@gmail.com" required><br><br>

                    <label for="signup_password">Password:</label>
                    <input type="password" id="signup_password" name="password" placeholder="******" required><br><br>

                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="******" required><br><br>
                    
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
        function showChangePasswordForm() {
            const form = document.getElementById('change-password-form');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        function validateForm() {

            return true;
        }
            
        function validateForm2() {
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

            // Validate Password Match
            var init = document.getElementById("signup_password").value;
            var sec = document.getElementById("confirm_password").value;

            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;

            if (!passwordRegex.test(init)) {
                alert("Password must be at least 12 characters long, include at least one lowercase letter, one uppercase letter, one number, and one special character.");
                event.preventDefault();
                return false;
            }

            if (init !== sec) {
                alert("The two passwords you entered are not the same.");
                event.preventDefault();
                return false;
            }

            return true;
        }

        function validateForm3() {
            

            // Validate Password Match
            var init = document.getElementById("change_password").value;
            var sec = document.getElementById("confirm_change_password").value;

            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;

            if (!passwordRegex.test(init)) {
                alert("Password must be at least 12 characters long, include at least one lowercase letter, one uppercase letter, one number, and one special character.");
                event.preventDefault();
                return false;
            }

            if (init !== sec) {
                alert("The two passwords you entered are not the same.");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>




