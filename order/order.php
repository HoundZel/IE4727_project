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

// Retrieve orders for the logged-in user
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE username = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    // Fetch the image name from the menu table
    $itemname = $row['itemname'];
    $img_stmt = $conn->prepare("SELECT imgname FROM menu WHERE name = ?");
    $img_stmt->bind_param("s", $itemname);
    $img_stmt->execute();
    $img_result = $img_stmt->get_result();
    $img_row = $img_result->fetch_assoc();
    $imgname = $img_row['imgname'];

    $row['imgname'] = $imgname;
    $orders[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals - Orders</title>
   <link rel="icon" href="../media/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="../styles.css">
</head>

<style>
    .content{
        min-height: 90vh;
    }

    .container {
        display: flex;
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
    .left {
            width: 15%;
            padding-right: 10px;
    }
    .right {
        width: 85%;
        padding-left: 20px;
    }
    table {
           width: 100%;
           border-collapse: collapse;
           border: none;
       }
    th, td {
        padding: 10px 0 10px 0;
        text-align: left;
        vertical-align: top;
    }
    img{
        border-radius: 20px;
        border: 1px solid black;
    }
    ol.s {
        list-style-type: inherit;
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
        <h1>Orders</h1>
        <?php foreach ($orders as $order): ?>
            <div class="container">
                <div class="left">
                    <img src="../media/menu/<?php echo htmlspecialchars($order['imgname']); ?>.jpg" alt="<?php echo htmlspecialchars($order['itemname']); ?>" style="width: 100%;">
                </div>
                <div class="right">
                    <table>
                        <tr>
                            <th colspan="2" style="text-align: center;"><b><u><?php echo htmlspecialchars($order['itemname']); ?></u></b></th>
                        </tr>
                        <tr>
                            <th>Dish List:</th>
                            <td>
                                <ol class="s">
                                    <?php foreach (explode(',', $order['dishlist']) as $dish): ?>
                                        <li><?php echo htmlspecialchars($dish); ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                        </tr>
                        <tr>
                            <th> </th>
                            <td><?php echo htmlspecialchars($order['unit']); ?></td>
                        </tr>
                        <tr>
                            <th> </th>
                            <td>Singapore <?php echo htmlspecialchars($order['postalcode']); ?></td>
                        </tr>
                        <tr>
                            <th>Date and Time:</th>
                            <td><?php echo htmlspecialchars($order['date'] . ' , ' . $order['time']); ?></td>
                        </tr>
                        <tr>
                            <th>Quantity:</th>
                            <td><?php echo htmlspecialchars($order['quantity']); ?> pax</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>$<?php echo htmlspecialchars($order['total']); ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php
                                $orderDateTime = new DateTime($order['date'] . ' ' . $order['time']. ':00');
                                $currentDateTime = new DateTime();
                                if ($orderDateTime > $currentDateTime) {
                                    echo "Paid";
                                    
                                } else {
                                    echo "Delivered";
                                    echo ' (<a href="../feedback/feedback.php" style="color: blue;">Your Feedback</a>)';
                                }
                                ?>
                                <br>
                                <br>
                                <a href="../cart/cart.php?product_id=<?php echo urlencode($order['itemname']); ?>" style="color: green;">(Reorder)</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
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
</body>
</html>
