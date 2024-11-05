<?php
session_start();

// Check if the donation amount is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount'])) {
    // Assuming you are also capturing other session variables like name, bankacc, email
    $_SESSION['name'] = $_SESSION['name']; // Get from user data (or wherever it's stored)
    $_SESSION['bankacc'] = $_SESSION['bankacc']; // Get from user data
    $_SESSION['amount'] = $_POST['amount']; // Set the donation amount
    $_SESSION['email'] = $_SESSION['email']; // Get from user data

    // Redirect to receipt page
    header("Location: receipt.php");
    exit();
} else {
    // Handle case where amount is not set
    header("Location: accadmin.php"); // Redirect to error page or similar
    exit();
}
?>
