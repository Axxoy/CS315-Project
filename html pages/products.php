<?php

// Set the default timezone to America/Chicago
date_default_timezone_set('America/Chicago');

session_start();
ob_start();

// Initialize operator
if (!(isset($_POST['operation'])))
    $_POST['operation'] = "";

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

// Fetch products from the database
$result = $db->query("SELECT * FROM products");
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
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
    <title>Products</title>
</head>

<body>

    <!-- include the menu sidebar -->
    <?php include 'sidebar.php'; ?>

    <a href="cart.php" id="cart-icon" title="View Cart">
        <img src="../assets/images/shopping-cart.png" alt="Cart">
    </a>

    <header>
        <h1>Products 🛒</h1>
    </header>

    <!-- Products Section -->
    <section id="products">
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <!-- Display each product in a grid format using the product-card class -->
                <div class="product-card">
                    <div class="product-header">
                        <h2 class="product-name">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h2>
                    </div>
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars('../assets/images/' . $product['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?> Image" class="product-image">
                    <?php endif; ?>
                    <div class="product-details">
                        <p class="product-description">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                        <p class="product-price">Price: $
                            <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                        </p>
                        <p class="product-quantity">Available Quantity:
                            <?php echo htmlspecialchars($product['quantity']); ?>
                        </p>
                    </div>
                    <form action="add_to_cart.php" method="post">
                        <input type="number" name="quantity" value="1" min="1"
                            max="<?php echo htmlspecialchars($product['quantity']); ?>" class="quantity-input">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <button type="submit" class="btn-add-cart">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</body>

</html>