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

$db = new mysqli("127.0.0.1", "root", "1453", "cs315_project") or die("could not connect to mysql"); // Open up the connection
if ($db->connect_error)
    die("Connection failed: " . $db->connect_error);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../styles-mobile.css" media="screen and (max-width: 767px)">
    <link rel="stylesheet" type="text/css" href="../styles-desktop.css" media="screen and (min-width: 768px)">
    <title>Home Page</title>
</head>

<body>

    <!-- include the menu sidebar -->
    <?php include 'sidebar.php'; ?>

    <a href="cart.php" id="cart-icon" title="View Cart">
        <img src="../assets/images/shopping-cart.png" alt="Cart">
    </a>
    <!-- Header -->
    <header>

        <h1>InnerSoul Journeys</h1>

    </header>

    <p>Welcome to InnerSoul Journeys, your destination for self-help and meditation resources. We believe that everyone
        has the power to transform their lives, and we're here to help you on that journey.</p>

    <p>Our collection of guided meditations, mindfulness exercises, and self-help articles are designed to help you
        reduce stress, increase focus, and cultivate a sense of inner peace. Whether you're new to meditation or a
        seasoned practitioner, we have something for everyone.</p>

    <p>At InnerSoul Journeys, we believe that self-care is essential to living a happy and fulfilling life. That's why
        we offer a variety of resources to help you take care of your mind, body, and spirit. From yoga classes to
        nutrition tips, we're here to support you every step of the way.</p>

    <p>Thank you for choosing InnerSoul Journeys as your partner on your journey to self-discovery and personal growth.
        We can't wait to see where this journey takes you.</p>

    <!-- BEGIN: Table -->
    <table>
        <thead>
            <tr>
                <th>Page Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Home</td>
                <td>The main landing page of the website, providing an overview of the site's purpose and content.</td>
            </tr>
            <tr>
                <td>About</td>
                <td>A page providing more information about the website, its creators, and its mission.</td>
            </tr>
            <tr>
                <td>Affirmations</td>
                <td>A page containing a collection of positive affirmations and mantras to help users cultivate a
                    positive mindset.</td>
            </tr>
            <tr>
                <td>Resources</td>
                <td>A page containing a variety of resources related to self-help, meditation, and personal growth,
                    including articles, videos, and podcasts.</td>
            </tr>
            <tr>
                <td>Source Code</td>
                <td>A page containing the source code for the website, allowing users to learn more about how it was
                    built and potentially contribute to its development.</td>
            </tr>
            <tr>
                <td>Journaling</td>
                <td>A page containing prompts and exercises to help users engage in reflective journaling and
                    self-exploration.</td>
            </tr>
            <tr>
                <td>Meditation</td>
                <td>A page containing guided meditations and mindfulness exercises to help users reduce stress and
                    cultivate inner peace.</td>
            </tr>
            <tr>
                <td>Inspiration</td>
                <td>A page containing inspiring quotes, stories, and images to help users stay motivated and focused on
                    their personal growth journey.</td>
            </tr>
            <tr>
                <td>Seek Help</td>
                <td>A page containing information and resources for users who may be struggling with mental health
                    issues or other challenges, including hotlines, support groups, and therapy resources.</td>
            </tr>
            <tr>
                <td>Contact</td>
                <td>A page containing contact information for the website's creators, allowing users to get in touch
                    with questions, feedback, or collaboration opportunities.</td>
            </tr>
        </tbody>
    </table>
    <!-- END: Table -->
</body>

<footer>
    <p style="text-align: center;"><em>Designed and Created by Cüneyt Aksoy and Paul Keiser
            <br>
            MIT License - 2023</em>
    </p>
</footer>

</html>