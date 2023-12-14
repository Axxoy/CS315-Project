<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../styles-mobile.css" media="screen and (max-width: 767px)">
    <link rel="stylesheet" type="text/css" href="../styles-desktop.css" media="screen and (min-width: 768px)">
    <title>Submission</title>
</head>

<body>
    <!-- include the menu sidebar -->
    <?php include 'sidebar.php'; ?>

    <a href="cart.php" id="cart-icon" title="View Cart">
        <img src="../assets/images/shopping-cart.png" alt="Cart">
    </a>

    <h1>Submission JSON</h1>

    <p id="data" style="text-align: center;"></p>


    <footer>
        <p style="text-align: center;"><em>Designed and Created by Cüneyt Aksoy and Paul Keiser
                <br>
                MIT License - 2023</em>
        </p>
    </footer>


    <script>

        var paragraphElement = document.getElementById("data");

        // Retrieve the data from localStorage
        var jsonData = localStorage.getItem("data");

        // Check if the data exists in localStorage
        if (jsonData) {
            paragraphElement.innerHTML = jsonData;
        } else {
            // Handle the case where data is not found in localStorage
            paragraphElement.innerHTML = "No data available.";
        }

    </script>

</body>

</html>