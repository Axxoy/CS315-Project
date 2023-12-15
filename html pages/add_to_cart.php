<?php

// Set the default timezone to America/Chicago
date_default_timezone_set('America/Chicago');

session_start();
ob_start();

// Check if the user is logged in. If not, redirect them to the login page
if (!isset($_SESSION['hdksks8272nsksl3839sjsj2938djs'])) {
    header("Location: login.php");
    exit();
}

// Database connection (replace with your connection details)
$db = new mysqli("127.0.0.1", "root", "1453", "cs315_project");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to add a product to the cart
function addToCart($productId, $quantity)
{
    // Check if the cart cookie exists
    if (isset($_COOKIE['cart'])) {
        // If yes, retrieve the cart data
        $cart = json_decode($_COOKIE['cart'], true);
    } else {
        // If not, create a new cart array
        $cart = array();
    }

    // Check if the product already exists in the cart
    if (isset($cart[$productId])) {
        // Update the quantity
        $cart[$productId] += $quantity;
    } else {
        // Add the product with its quantity
        $cart[$productId] = $quantity;
    }

    // Save the updated cart back into the cookie
    // Set a reasonable expiration time for the cookie, e.g., 30 days
    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); // 86400 = 1 day
}
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

    // Check if the inputs are valid
    if ($productId && $quantity && $quantity > 0) {
        // Check if the product exists and if there is enough stock
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            if ($product['quantity'] >= $quantity) {
                // Add the product to the cart
                addToCart($productId, $quantity);
                // Redirect to a confirmation page or back to the products page
                header('Location: cart.php');
                exit;
            } else {
                // Not enough stock
                header('Location: product_page.php?error=out_of_stock');
                exit;
            }
        } else {
            // Product does not exist
            header('Location: product_page.php?error=product_not_found');
            exit;
        }
    } else {
        // Handle the error, redirect back to the product page or display an error message
        header('Location: product_page.php?error=invalid_input');
        exit;
    }
} else {
    // Redirect to the products page if the script is accessed without posting data
    header('Location: product_page.php');
    exit;
}
?>