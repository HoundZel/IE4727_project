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
    .hidden-checkbox {
        display: none;
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
                        <a href="#" class="nav_link">Order</a>
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
        <div class="container">
        <?php
            if (isset($_GET['product_id'])) {
                $product_id = htmlspecialchars($_GET['product_id']);

                // Fetch the category of the product from the menu table
                $stmt = $conn->prepare("SELECT category FROM menu WHERE name = ?");
                $stmt->bind_param("s", $product_id);
                $stmt->execute();
                $stmt->bind_result($category);
                $stmt->fetch();
                $stmt->close();

                if ($category) {
                    echo "<h1>$product_id</h1>";
                    echo "<br>";

                    // Fetch all names from the dish table with the retrieved category
                    $stmt = $conn->prepare("SELECT name, course FROM dish WHERE category = ?");
                    $stmt->bind_param("s", $category);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<form>";
                        echo "<table>";

                        $current_course = "";
                        while ($row = $result->fetch_assoc()) {
                            if ($category !== "bento" && $current_course !== $row['course']) {
                                $current_course = $row['course'];
                                echo "<tr><th colspan='2'><u>" . htmlspecialchars(ucwords($current_course)) . "</u></th></tr>";
                            }
                            $dish_name = ucwords($row['name']);
                            if ($category === "bento") {
                                echo "<tr><td><input type='checkbox' class='hidden-checkbox' name='selected_dishes[]' value='" . htmlspecialchars($row['name']) . "' checked></td><td>" . htmlspecialchars($dish_name) . "</td></tr>";
                            } else {
                                echo "<tr><td><input type='checkbox' name='selected_dishes[]' value='" . htmlspecialchars($row['name']) . "'></td><td>" . htmlspecialchars($dish_name) . "</td></tr>";
                            }
                        }

                        echo "</table>";
                        echo "<br>";
                        echo "<input type='submit' value='Submit'>";
                        echo "</form>";
                    } else {
                        echo "<p>No dishes found in this category.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<h1>Product not found</h1>";
                }
            } else {
                echo "<h1>No product selected</h1>";
            }

            $conn->close();
            ?>
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
   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.course-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const course = this.getAttribute('data-course');
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this && cb.getAttribute('data-course') === course) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>


