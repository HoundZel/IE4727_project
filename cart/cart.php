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

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

// Initialize variables for pre-filling the form
$address = $unit = $postalcode = $date = $time = $quantity = $total = '';
$selected_dishes = [];

// If order_id is provided, fetch the order details
if ($order_id) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $address = $order['address'];
        $unit = $order['unit'];
        $postalcode = $order['postalcode'];
        $date = $order['date'];
        $time = $order['time'];
        $quantity = $order['quantity'];
        $total = $order['total'];
        $selected_dishes = explode(',', $order['dishlist']);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals - Cart</title>
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

    #price-details {
        margin-top: 20px;
        padding: 10px;
        border-radius: 5px;
        background-color: #f9f9f9;
        width: 50%;
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
            <form id='dish-form' action="submit_order.php" method="post">
        <?php
            if (isset($_GET['product_id'])) {
                $product_id = htmlspecialchars($_GET['product_id']);

                // Fetch the category of the product from the menu table
                $stmt = $conn->prepare("SELECT category,price FROM menu WHERE name = ?");
                $stmt->bind_param("s", $product_id);
                $stmt->execute();
                $stmt->bind_result($category, $price);
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
                        echo "<table>";

                        $current_course = "";
                        while ($row = $result->fetch_assoc()) {
                            if ($category !== "bento" && $current_course !== $row['course']) {
                                $current_course = $row['course'];
                                echo "<tr><th colspan='2'><u>" . htmlspecialchars(ucwords($current_course)) . "</u></th></tr>";
                            }
                            $dish_name = ucwords($row['name']);
                            $checked = in_array($row['name'], $selected_dishes) ? 'checked' : '';
                            if ($category === "bento") {
                                echo "<tr><td><input type='checkbox' class='hidden-checkbox' name='selected_dishes[]' value='" . htmlspecialchars($row['name']) . "' checked></td><td>" . htmlspecialchars($dish_name) . "</td></tr>";
                            } else {
                                echo "<tr><td><input type='checkbox' class='course-checkbox' name='selected_dishes[" . htmlspecialchars($current_course) . "]' value='" . htmlspecialchars($row['name']) . "' data-course='" . htmlspecialchars($current_course) . "' $checked></td><td>" . htmlspecialchars($dish_name) . "</td></tr>";
                            }
                        }
                        echo "</table>";
                        echo "<br>";

                        // Pre-fill the form fields
                        echo "<label for='address'>Address:</label>";
                        echo "<input type='text' id='address' name='address' value='" . htmlspecialchars($address) . "' required><br><br>";

                        echo "<label for='unit_number'>Unit Number:</label>";
                        echo "<input type='text' id='unit_number' name='unit_number' value='" . htmlspecialchars($unit) . "' required><br><br>";

                        echo "<label for='postal_code'>Postal Code:</label>";
                        echo "<input type='text' id='postal_code' name='postal_code' value='" . htmlspecialchars($postalcode) . "' required><br><br>";

                        echo "<label for='date'>Date:</label>";
                        echo "<input type='date' id='date' name='date' min='" . date('Y-m-d', strtotime('+1 day')) . "' required><br><br>";

                        echo "<label for='time'>Time:</label>";
                        echo "<input type='time' id='time' name='time' required><br><br>";

                        echo "<label for='quantity'>Quantity:</label>";
                        echo "<input type='number' id='quantity' name='quantity' value='". 1 ."' min='". 1 ."' required><br><br>";
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
            ?>
            <div id="price-details">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td id="subtotal">$0.00</td>
                    </tr>
                    <tr>
                        <td>GST (9%):</td>
                        <td id="gst">$0.00</td>
                    </tr>
                    <tr>
                        <td>Delivery Fee:</td>
                        <td>$20.00</td>
                    </tr>
                    <tr style="border-top: 1px solid gray;">
                        <td>Grand Total:</td>
                        <td id="grand-total">$20.00</td>
                    </tr>
                </table>
            </div>
            <br>
            <input type="hidden" id="total" name="total">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">
            <input type='submit' value='Submit'>
            </form>
        <br><br><br><br>
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
        document.addEventListener('DOMContentLoaded', function() {
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

            const quantityInput = document.getElementById('quantity');
                const price = <?php echo $price; ?>;
                const deliveryFee = 20.00;

                function updatePriceDetails() {
                    const quantity = parseInt(quantityInput.value);
                    const subtotal = quantity * price;
                    const gst = subtotal * 0.09;
                    const grandTotal = subtotal + gst + deliveryFee;

                    document.getElementById('subtotal').innerText = `$${subtotal.toFixed(2)}`;
                    document.getElementById('gst').innerText = `$${gst.toFixed(2)}`;
                    document.getElementById('grand-total').innerText = `$${grandTotal.toFixed(2)}`;
                    document.getElementById('total').value = grandTotal.toFixed(2);
                }

                quantityInput.addEventListener('input', updatePriceDetails);
                updatePriceDetails(); // Initial call to set the values
        });
    </script>
</body>
</html>


