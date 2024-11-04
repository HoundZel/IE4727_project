<!-- this is the landing page -->
<?php
session_start();

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

function popular($conn) {
    // Count distinct items in the orders table
    $countQuery = "SELECT COUNT(DISTINCT itemname) AS distinct_count FROM orders";
    $countResult = $conn->query($countQuery);
    $row = $countResult->fetch_assoc();
    $distinctCount = (int)$row['distinct_count'];

    // Define default top items
    $defaults = [
        ['itemname' => 'Super Value', 'imgname' => '../media/curryfish.jpg'],
        ['itemname' => 'Mini Buffet A', 'imgname' => '../media/springroll.jpg'],
        ['itemname' => 'High Tea Set', 'imgname' => '../media/muffin.jpg']
    ];

    if ($distinctCount >= 3) {
        // SQL query to get top items by aggregated quantity if there are 3 or more distinct items
        $sql = "
            SELECT orders.itemname AS itemname, SUM(orders.quantity) AS total_quantity, menu.imgname AS imgname
            FROM orders
            INNER JOIN menu ON orders.itemname = menu.name
            GROUP BY orders.itemname
            ORDER BY total_quantity DESC
            LIMIT 3;";

        $result = $conn->query($sql);
        $topItems = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imgname = htmlspecialchars($row['imgname']);
                if (pathinfo($imgname, PATHINFO_EXTENSION) === '') {
                    $imgname .= '.jpg';
                }
                $topItems[] = [
                    'itemname' => htmlspecialchars($row['itemname']),
                    'imgname' => 'menu/' . $imgname
                ];
            }
        }
    } else {
        // Use default items if there are 2 or fewer distinct items in orders
        $topItems = $defaults;
    }

    // Output HTML 
    echo '
    <div class="top-item first">
        <a href="cart/cart.php?product_id=' . urlencode($topItems[0]['itemname']) . '">
            <img class="topImg" src="media/' . $topItems[0]['imgname'] . '" alt="' . $topItems[0]['itemname'] . '">
        </a>
        <h3 id="top">' . $topItems[0]['itemname'] . '</h3>
    </div>
    <div class="top-item second">
        <a href="cart/cart.php?product_id=' . urlencode($topItems[1]['itemname']) . '">
            <img class="topImg" src="media/' . $topItems[1]['imgname'] . '" alt="' . $topItems[1]['itemname'] . '">
        </a>
        <h3 id="top">' . $topItems[1]['itemname'] . '</h3>
    </div>
    <div class="top-item third">
        <a href="cart/cart.php?product_id=' . urlencode($topItems[2]['itemname']) . '">
            <img class="topImg" src="media/' . $topItems[2]['imgname'] . '" alt="' . $topItems[2]['itemname'] . '">
        </a>
        <h3 id="top">' . $topItems[2]['itemname'] . '</h3>
    </div>';
}

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professionals - Home</title>
    <link rel="icon" href="media/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
 </head>
 <body>
    <div id="head"></div>   

    <header class="header">
        <div class="header_content">
            <a href="#head" class="logo">Professionals Catering</a>

            <nav class="nav">
                <ul class="nav_list">
                    <li class="nav_item">
                        <a href="menu/menu.php" class="nav_link">Menu</a>
                    </li>
                    <li class="nav_item">
                        <a href="order/order.php" class="nav_link">Order</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav_item">
                            <a href="logout.php" class="nav_link">Logout</a>
                        </li>
                        <li class="nav_item">
                            <span class="nav_link">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                        </li>
                    <?php else: ?>
                        <li class="nav_item">
                            <a href="login/login.php" class="nav_link">Login</a>
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

    <div class="content">
        <div class="banner">
            <div class="slideshow-container">
                <img id="slideshow" src="media/banner.png" alt="Banner Image">
                <a onclick='prevImage();' class="prev" >&#10094;</a>
                <a onclick='nextImage();' class="next" >&#10095;</a>
            </div>
        </div>
        <br>
        <h2><u>Best Sellers</u></h2>
        <div class="topseller">
            <?php popular($conn); ?>
        </div>
        <br>
        <h2><u>About Us</u></h2>
        <div class="aboutus">
            <div class="aboutImg">
                <img src="media/aboutus.png" alt="Aboutus Image">
            </div>
            <div class="aboutText">
                <h3>Welcome to Professionals Catering, where we bring culinary excellence to your events. Our team of experienced chefs and dedicated staff are committed to providing exceptional service and delicious food that will leave a lasting impression on your guests. Whether it's a corporate event, wedding, or private party, we tailor our menus to suit your needs and preferences. </h3>
                <br>
                <h3>At Professionals Catering, we believe in using the freshest ingredients and innovative recipes to create memorable dining experiences. Let us take care of the details so you can enjoy your special occasion to the fullest.</h3>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer_content">
            <div class="footer_section">
                <h4><a href="feedback/feedback.php">Contact Us</a></h4>
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

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.logo');
    
            for (const link of links) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            }
        });
    </script>
 </body>
 </html>






