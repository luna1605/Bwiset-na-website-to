<?php
session_start();
include 'db.php'; // Include your database connection

if (isset($_POST['reset_password'])) {
    $email = $_POST['reset_email'];

    // Prepare a statement to find the user
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['reset_email'] = $email; // Store email in session for the next step
        echo "<script>alert('Password reset link has been sent to $email.');</script>";
        echo "<p>Please <a href='reset_password.php'>click here</a> to reset your password.</p>";
    } else {
        echo "<script>alert('Email not found.');</script>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="accadmin.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-form">
            <h2>Forgot Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="reset_email">Enter your registered email:</label>
                <input type="email" id="reset_email" name="reset_email" required>
                <input type="submit" name="reset_password" value="Send Reset Link">
            </form>
            <p>Remember your password? <a href="accadmin.php">Login</a></p>
        </div>
    </div>
</body>
</html>
