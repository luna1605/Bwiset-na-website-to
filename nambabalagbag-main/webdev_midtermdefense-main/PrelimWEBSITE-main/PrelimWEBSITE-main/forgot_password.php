<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $userFound = false;

    // Read user data from users.txt
    if (file_exists('users.txt')) {
        $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($users as $user) {
            list($storedEmail) = explode(':', $user); // Assuming the first part is the email

            if ($storedEmail === $email) {
                $userFound = true;
                break;
            }
        }
    }

    // If user is found, generate a password reset token
    if ($userFound) {
        $token = bin2hex(random_bytes(50)); // Generate a random token

        // Here you would ideally store the token and its association with the user in a secure way
        // For this example, we will just send the token in the email

        // Create reset link
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;

        // Send email (using mail() or any other email service)
        $subject = "Password Reset Request";
        $message = "To reset your password, please click the following link: " . $resetLink;
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email address.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Email address not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST" action="">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <p><a href="accadmin2.php">Back to Login</a></p>
    </div>
</body>
</html>
