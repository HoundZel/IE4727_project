<!-- this is the landing page -->
 <?php
    session_start();
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professionals</title>
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
                        <a href="#" class="nav_link">Order</a>
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
            <div class="first">
                <img class="topImg" src="media/curryfish.jpg">
                <h3 id="top">Super Value</h3>
            </div>
            <div class="second">
                <img class="topImg" src="media/springroll.jpg">
                <h3 id="top">Mini Buffet A</h3>
            </div>
            <div class="third">
                <img class="topImg" src="media/muffin.jpg">
                <h3 id="top">High Tea Set</h3>
            </div>
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


