<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: ../login/login.php");
    exit();
}

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

// Retrieve form data
$username = $_SESSION['username'];
$itemname = htmlspecialchars($_POST['product_id']);
$dishlist = isset($_POST['selected_dishes']) ? implode(',', $_POST['selected_dishes']) : '';
$address = htmlspecialchars($_POST['address']);
$unit = htmlspecialchars($_POST['unit_number']);
$postalcode = htmlspecialchars($_POST['postal_code']);
$date = htmlspecialchars($_POST['date']);
$time = htmlspecialchars($_POST['time']);
$quantity = htmlspecialchars($_POST['quantity']);
$total = htmlspecialchars($_POST['total']);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO orders (username, itemname, dishlist, address, unit, postalcode, date, time, quantity, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssii", $username, $itemname, $dishlist, $address, $unit, $postalcode, $date, $time, $quantity, $total);

// Get the user's email from the database
$email_query = $conn->prepare("SELECT email FROM users WHERE username = ?");
$email_query->bind_param("s", $username);
$email_query->execute();
$email_result = $email_query->get_result();

if ($email_result->num_rows > 0) {
    $row = $email_result->fetch_assoc();
    $user_email = $row['email'];
} else {
    header("Location: ../order/order.php");
    exit();
}

$to      = $user_email;
$subject = 'Order Confirmation';
$message = "
    Dear $username,

    Thank you for your order! Here are your order details:
    
    Product: $itemname
    Dishes: $dishlist
    Address: $address, Unit $unit, Postal Code $postalcode
    Delivery Date: $date
    Delivery Time: $time
    Quantity: $quantity
    Total Amount: $$total
    
    We will deliver your order as scheduled.
    
    Regards,
    Professionals Catering"; // Convert newlines to <br> tags for HTML email
$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff32ee@localhost');
header("Location: ../order/order.php");
exit();

// Close the statement and connection
$stmt->close();
$conn->close();
?>