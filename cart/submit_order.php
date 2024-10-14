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

// Execute the statement
if ($stmt->execute()) {
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>