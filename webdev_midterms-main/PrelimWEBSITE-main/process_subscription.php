<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: accadmin.php"); // Redirect to login page if not logged in
    exit();
}

// Process the subscription form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $frequency = $_POST['frequency'];
    $payment_method = $_POST['payment_method'];

    // Here, you would typically process the payment and store the subscription
    // For example, save to a database or interact with a payment gateway

    // Example response
    echo "Thank you for subscribing! You will be donating $amount every $frequency using $payment_method.";
} else {
    echo "Invalid request.";
}
?>
