<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['hdksks8272nsksl3839sjsj2938djs'])) {
    header("Location: login.php");
    exit();
}

// Database connection (replace with your connection details)
$db = new mysqli("127.0.0.1", "root", "1453", "cs315_project");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$userId = $_SESSION['hdksks8272nsksl3839sjsj2938djs']; // Assuming this session variable holds the user ID
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
$totalCost = 0;
$premiumDiscount = 0;
$missouriTaxRate = 0.04225; // Missouri state tax rate as of my knowledge cutoff in 2021

// Check if the user is a premium member
$stmt = $db->prepare("SELECT premium_member FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$isPremiumMember = $user['premium_member'] == 1;
$stmt->close();

// Calculate total cost and apply discounts
foreach ($cart as $productId => $quantity) {
    $stmt = $db->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalCost += $row['price'] * $quantity;
        }
    }
    $stmt->close();
}

// Apply premium member discount
if ($isPremiumMember) {
    $premiumDiscount = $totalCost * 0.15;
}

// Calculate total cost after tax and discount
$totalCostAfterTax = $totalCost * (1 + $missouriTaxRate) - $premiumDiscount;

// ... (rest of your PHP code)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../styles-mobile.css" media="screen and (max-width: 767px)">
    <link rel="stylesheet" type="text/css" href="../styles-desktop.css" media="screen and (min-width: 768px)">
    <title>My Cart</title>
</head>

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <!-- Add any additional head elements here -->
</head>

<body>
    <h2>Checkout</h2>
    <p>Total Cost Before Tax: $
        <?= number_format($totalCost, 2) ?>
    </p>
    <p>Tax: $
        <?= number_format($totalCost * $missouriTaxRate, 2) ?>
    </p>
    <?php if ($isPremiumMember): ?>
        <p>Premium Member Discount: -$
            <?= number_format($premiumDiscount, 2) ?>
        </p>
    <?php endif; ?>
    <p><strong>Total Cost After Tax: $
            <?= number_format($totalCostAfterTax, 2) ?>
        </strong></p>

    <!-- Credit Card and Shipping Address Form -->
    <form action="process_checkout.php" method="post">
        <!-- Add fields for credit card information -->
        <!-- IMPORTANT: This should be handled with a secure method in production -->
        <div>
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="card_number" required>
        </div>
        <div>
            <label for="card_expiry">Expiry Date:</label>
            <input type="text" id="card_expiry" name="card_expiry" required>
        </div>
        <div>
            <label for="card_cvv">CVV:</label>
            <input type="text" id="card_cvv" name="card_cvv" required>
        </div>

        <!-- Shipping Address -->
        <div>
            <label for="shipping_address">Shipping Address:</label>
            <textarea id="shipping_address" name="shipping_address" required></textarea>
        </div>

        <!-- Items Ordered -->
        <h3>Items Ordered:</h3>
        <ul>
            <?php foreach ($cart as $productId => $quantity): ?>
                <?php
                $stmt = $db->prepare("SELECT name FROM products WHERE id = ?");
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    echo "<li>" . htmlspecialchars($product['name']) . " x " . $quantity . "</li>";
                }
                $stmt->close();
                ?>
            <?php endforeach; ?>
        </ul>

        <!-- Submit Button -->
        <div>
            <input type="submit" value="Place Order">
        </div>
    </form>
</body>

</html>