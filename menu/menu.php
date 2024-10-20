<!-- this is the menu page -->
<?php
    session_start();
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professionals - Menu</title>
   <link rel="icon" href="../media/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="../styles.css">
   <!-- <link rel="stylesheet" href="menu.css"> -->
</head>

<style>
.content{
    display: flex;
    flex-direction: row;
    min-height: 85vh;
}

.content div{
}

.left {
    margin: 0;
    padding: 0;
    max-width: 20vw;
    background-color: #e8f0f7;
    position: fixed;
    height: 87%;
    top: 50px;
}

.categories{
    margin: 30px 10px 0 30px;
    padding: 10px;
    border: 1px solid gray;
    border-radius: 10px;
    max-width: 12vw;
    text-align: center;
    background-color: #fff;
    list-style-type: none;
    font-size: 0.8em;
}

li :hover{

    background-color: #f0f0f0;
}

.right{
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}

.menu_items {
    resize: both;
    overflow: auto;
    display: grid;
    gap: 4px;
    padding: 4px;
    justify-items: start;
    align-items: left;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
}

.card {
    border-radius: 20%;
    max-width: 320px;
    background-color: #444;
    text-align: center;
    color: #ddd;
    font-family: sans-serif;
    font-size: 1.2rem;
    padding: 12px;
}

.order{
    color: #000000;
    background-color: #ffff;
    border: 1px solid black;
    border-radius: 5px;
}

img {
    border-radius: 20%;
    width: 100%;
    height: auto;
}

/* Mobile version */
@media (max-width: 768px) {
    .left{
        width: 0;
        display: none;
    }
    .right div{
        width: 100vw
    }
}

/* PC version */
@media (min-width: 769px) {
    .left{
        width: 20vw;
    }
    .right{
        margin-left: 20vw;
    }
    .right div{
        width: 78vw
    }
}
</style>


<body>
    <div id="head"></div> 

   <header class="header">
       <div class="header_content">
           <a href="../index.php" class="logo">Professionals Catering</a>

           <nav class="nav">
                <ul class="nav_list">
                    <li class="nav_item">
                        <a href="#head" class="nav_link">Menu</a>
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

   <div class="content">
       <div class="left">
            <div class="categories">
                <ul>
                    <br>
                    <li><a href="#regular"><h2>Regular Buffet</h2></a></li>
                    <br>
                    <hr>
                    <br>
                    <li><a href="#mini"><h2>Mini Buffet</h2></a></li>
                    <br>
                    <hr>
                    <br>
                    <li><a href="#bento"><h2>Bento Box</h2></a></li>
                    <br>
                    <hr>
                    <br>
                    <li><a href="#hightea"><h2>High Tea</h2></a></li>
                    <br>
                </ul>
            </div>
       </div>
       <div class="right">
            <div class="menu">
                <div id="regular">
                    <br>
                    <h2>&nbsp;&nbsp;<u>Regular Buffet</u></h2>
                    <br>
                    <div class="menu_items">
                        <?php
                            $sql = "SELECT * FROM menu WHERE category='regular'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<div class='card'>";
                                    echo "<img src='../media/menu/" . $row["imgname"] . ".jpg' alt='" . $row["imgname"] . "'>";
                                    echo "<p>" . $row["name"] . "</p>";
                                    echo "<br>";
                                    echo "<p>Price: $" . $row["price"] . "/pax</p>";
                                    echo "<br>";
                                    echo "<a class='order' href='../cart/cart.php?product_id=". $row["name"] ."' value='regular'>&nbsp;&nbsp;&nbsp;&nbsp;Order&nbsp;&nbsp;&nbsp;&nbsp;</a>";
                                    echo "</div>";
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </div>
                </div>
                <div id="mini">
                    <br>
                    <h2>&nbsp;&nbsp;<u>Mini Buffet</u></h2>
                    <br>
                    <div class="menu_items">
                    <?php
                            $sql = "SELECT * FROM menu WHERE category='mini'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<div class='card'>";
                                    echo "<img src='../media/menu/" . $row["imgname"] . ".jpg' alt='" . $row["imgname"] . "'>";
                                    echo "<p>" . $row["name"] . "</p>";
                                    echo "<p>Price: $" . $row["price"] . "/pax</p>";
                                    echo "<br>";
                                    echo "<a class='order' href='../cart/cart.php?product_id=". $row["name"] ."' value='mini'>&nbsp;&nbsp;&nbsp;&nbsp;Order&nbsp;&nbsp;&nbsp;&nbsp;</a>";
                                    echo "</div>";
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </div>
                </div>
                <div id="bento">
                    <br>
                    <h2>&nbsp;&nbsp;<u>Bento Buffet</u></h2>
                    <br>
                    <div class="menu_items">
                    <?php
                            $sql = "SELECT * FROM menu WHERE category='bento'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<div class='card'>";
                                    echo "<img src='../media/menu/" . $row["imgname"] . ".jpg' alt='" . $row["imgname"] . "'>";
                                    echo "<p>" . $row["name"] . "</p>";
                                    echo "<p>Price: $" . $row["price"] . "/pax</p>";
                                    echo "<br>";
                                    echo "<a class='order' href='../cart/cart.php?product_id=". $row["name"] ."' value='bento'>&nbsp;&nbsp;&nbsp;&nbsp;Order&nbsp;&nbsp;&nbsp;&nbsp;</a>";
                                    echo "</div>";
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </div>
                </div>
                <div id="hightea">
                    <br>
                    <h2>&nbsp;&nbsp;<u>High Tea</u></h2>
                    <br>
                    <div class="menu_items">
                    <?php
                            $sql = "SELECT * FROM menu WHERE category='hightea'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<div class='card'>";
                                    echo "<img src='../media/menu/" . $row["imgname"] . ".jpg' alt='" . $row["imgname"] . "'>";
                                    echo "<p>" . $row["name"] . "</p>";
                                    echo "<p>Price: $" . $row["price"] . "/pax</p>";
                                    echo "<br>";
                                    echo "<a class='order' href='../cart/cart.php?product_id=". $row["name"] ."' value='hightea'>&nbsp;&nbsp;&nbsp;&nbsp;Order&nbsp;&nbsp;&nbsp;&nbsp;</a>";
                                    echo "</div>";
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </div>
                    <br>
                    <br>
                </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.categories a');

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


