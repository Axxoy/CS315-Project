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

// Function to sanitize input data
function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$userId = $_SESSION['hdksks8272nsksl3839sjsj2938djs'];
$card_number = sanitize($_POST['card_number']);
$card_expiry = sanitize($_POST['card_expiry']);
$card_cvv = sanitize($_POST['card_cvv']);
$shipping_address = sanitize($_POST['shipping_address']);
$total_price = filter_input(INPUT_POST, 'total_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

if (isset($_POST['total_price'])) {
    // Sanitize the input as a float
    $total_price = filter_input(INPUT_POST, 'total_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Convert the sanitized string to a float
    $total_price = filter_var($total_price, FILTER_VALIDATE_FLOAT);

    // Check if the conversion was successful
    if ($total_price === false) {
        die("Invalid total price.");
    }
    // Now you have $total_price as a float
} else {
    die("Total price is not set.");
}

// Simulate payment processing
$payment_success = true; // Replace with actual payment processing result

$message = '';
if ($payment_success) {
    // Payment was successful, insert order into database
    $stmt = $db->prepare("INSERT INTO orders (user_id, shipping_address, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $userId, $shipping_address, $total_price);
    if ($stmt->execute()) {
        $orderId = $db->insert_id;

        // Now insert the payment details into payment_details table
        $stmt_payment = $db->prepare("INSERT INTO payment_details (order_id, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?)");
        $stmt_payment->bind_param("isss", $orderId, $card_number, $card_expiry, $card_cvv); // Assuming expiry date is a string in 'YYYY-MM-DD' format

        // Decode the JSON cart data from the cookie
        $cart_items = json_decode($_COOKIE['cart'], true);

        // ---
        // Prepare the statement for inserting order items
        $stmt_order_items = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");

        // Insert each cart item into the order_items table
        foreach ($cart_items as $product_id => $quantity) {
            // Bind the parameters for each item
            $stmt_order_items->bind_param("iii", $orderId, $product_id, $quantity);
            // Execute the query for each item
            $stmt_order_items->execute();
        }
        // ---

        if ($stmt_payment->execute()) {
            // Payment details inserted successfully
            $paymentId = $db->insert_id;
            // You can use $paymentId if you need to reference the payment details record
        } else {
            $message = "There was a problem with your order, please try again.";
        }

        // Clear the cart after processing
        setcookie('cart', '', time() - 3600);

        $message = "Thank you for your purchase! Your order ID is " . $orderId . ".";

        // Redirect to a success page or display a confirmation message
        // This could be a header("Location: success_page.php?order_id=".$orderId) to redirect
    } else {
        $message = "There was a problem with your order, please try again.";
    }
    $stmt->close();
} else {
    $message = "Payment processing failed, please try again.";
}

$db->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body>
    <h1>Order Confirmation</h1>
    <p>
        <?= $message ?>
    </p>
    <a href="index.php">Return to Home Page</a>
</body>

</html>