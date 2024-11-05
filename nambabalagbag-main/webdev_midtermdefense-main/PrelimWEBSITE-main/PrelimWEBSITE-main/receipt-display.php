<?php
session_start();

class Receipt {
    private $name;
    private $bankacc;
    private $amount;
    private $email;

    public function __construct($name, $bankacc, $amount, $email) {
        $this->name = $name;
        $this->bankacc = $bankacc;
        $this->amount = $amount;
        $this->email = $email;
    }

    public function generateReceipt() {
        // Generate a random 11-digit reference number
        $referenceNo = rand(10000000000, 99999999999);

        // Generate the receipt HTML
        $receiptHtml = "
            <h2>Official Receipt</h2> <!-- Changed to Official Receipt for consistency -->
            <div class='receipt-info'>
                <p><strong><span style='color: #B14749;'>Name:</span> $this->name</strong></p>
                <hr>
                <p><strong><span style='color: #B14749;'>Bank Account Number:</span> $this->bankacc</strong></p>
                <hr>
                <p><strong><span style='color: #B14749;'>Amount (PHP):</span> $this->amount</strong></p>
                <hr>
                <p><strong><span style='color: #B14749;'>Email:</span> $this->email</strong></p>
                <hr>
                <p><strong><span style='color: #B14749;'>Reference No.:</span> $referenceNo</strong></p>
            </div>
        ";

        // Output the receipt HTML
        echo $receiptHtml;
    }
}

// Check if necessary session variables are set
if (isset($_SESSION["full_name"]) && isset($_SESSION["bankacc"]) && isset($_SESSION["amount"]) && isset($_SESSION["email"])) {
    $name = $_SESSION["full_name"];
    $bankacc = $_SESSION["bankacc"];
    $amount = $_SESSION["amount"];
    $email = $_SESSION["email"];
} else {
    // Redirect back to payment page or show an error
    header("Location: payment.php?error=missingdata");
    exit();
}

// Create the receipt instance
$receipt = new Receipt($name, $bankacc, $amount, $email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" type="text/css" href="receipt.css"> <!-- Link to external CSS -->
</head>
<body>
    <header>
        <div class="app-bar">
            <a href="mainpage.html">
                <div><img src="assets/aid.png" alt="Logo"></div>
            </a>
            <nav>
                <button class="nav-btn emergency-planning" onclick="window.location.href='emergency planning.html';">Emergency Planning</button>    
                <button class="nav-btn disaster-management" onclick="window.location.href='disaster management.html';">Disaster Management</button>
                <button class="nav-btn resources" onclick="window.location.href='resources.html';">Resources</button>
                <button class="nav-btn charity-programs" onclick="window.location.href='charity.html';">Charity Programs</button>
                <button class="nav-btnn new-button" onclick="window.location.href='../PrelimWEBSITE-main/donations.php';">Send Donations</button>
            </nav>
        </div>
    </header>
    
    <div class="receipt-container">
        <?php $receipt->generateReceipt(); ?>
    </div>

    <div class="contact-section">
        <h2>Contact Us</h2>
        <div class="contact-container">
            <div class="contact-info">
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Email:</strong> contact@charity.org</p>
                <p><strong>Address:</strong> 123 Charity Lane, Goodville, GV 12345</p>
            </div>
            <div class="contact-social">
                <p><strong>Follow Us:</strong></p>
                <a href="https://www.facebook.com/charity" class="contact-link">Facebook</a> |
                <a href="https://twitter.com/charity" class="contact-link">Twitter</a> |
                <a href="https://www.instagram.com/charity" class="contact-link">Instagram</a>
            </div>
        </div>
    </div>
</body>
</html>
