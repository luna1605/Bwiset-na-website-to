<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // Generate a unique token
    $expiration = time() + 3600; // 1 hour expiration time

    // Save the token with the email and expiration (to a file for this example)
    $file = 'tokens.txt';
    file_put_contents($file, "$email:$token:$expiration\n", FILE_APPEND);

    // Create the password reset link
    $reset_link = "http://yourdomain.com/reset_password.php?token=$token"; // Change to your domain

    // Send the email
    $subject = "Password Reset Request";
    $message = "Click the following link to reset your password: $reset_link";
    $headers = "From: noreply@yourdomain.com"; // Change to your desired sender

    if (mail($email, $subject, $message, $headers)) {
        echo "Reset link sent to your email!";
    } else {
        echo "Failed to send email.";
    }
}
?>
