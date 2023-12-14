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

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

// Update or remove items in the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $updateType = isset($_POST['update_type']) ? $_POST['update_type'] : '';

    if ($productId && isset($_SESSION['cart'][$productId])) {
        if ($updateType == 'remove') {
            // Remove the item from the cart
            unset($_SESSION['cart'][$productId]);
            setcookie('cart', json_encode($cart), time() + 86400, "/"); // Update the cookie after removing the item

        } elseif ($updateType == 'update') {
            // Update the quantity
            $newQuantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
            if ($newQuantity > 0) {
                $_SESSION['cart'][$productId] = $newQuantity;
                setcookie('cart', json_encode($cart), time() + 86400, "/"); // Set the updated cart as a cookie

            } elseif ($newQuantity == 0) {
                unset($_SESSION['cart'][$productId]);
            }
        }
    }

    // Redirect to the same page to display updated cart
    header("Location: cart.php");
    exit();
}

// Fetch cart from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Initialize total cost
$totalCost = 0;

// Fetch product details for items in the cart
$cartItems = [];
foreach ($cart as $productId => $quantity) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['quantity'] = $quantity; // Add the quantity to the product details
            $cartItems[] = $row;

            // Add the line here to update the total cost
            $totalCost += $row['price'] * $quantity;
        }
    }
    $stmt->close();
}

$db->close();
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

<body>
    <!-- include the menu sidebar -->
    <?php include 'sidebar.php'; ?>

    <a href="cart.php" id="cart-icon" title="View Cart">
        <img src="../assets/images/shopping-cart.png" alt="Cart">
    </a>

    <h1>My Cart 🛒</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($item['name']) ?>
                </td>
                <td>$
                    <?= number_format($item['price'], 2) ?>
                </td>
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0">
                        <input type="submit" name="update_type" value="update">
                    </form>
                </td>
                <td>$
                    <?= number_format($item['price'] * $item['quantity'], 2) ?>
                </td>
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <input type="submit" name="update_type" value="remove"
                            onclick="return confirm('Are you sure you want to remove this item?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <!-- Add a row for the total cost -->
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total (before tax):</strong></td>
            <td colspan="2">$
                <?= number_format($totalCost, 2) ?>
            </td>
        </tr>
    </table>
    <p><a href="product_page.php">Continue Shopping</a></p>
    <p><a href="checkout.php">Proceed to Checkout</a></p>
</body>

</html>