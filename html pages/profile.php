<?php
date_default_timezone_set('America/Chicago');

session_start();

if (!(isset($_POST['operation'])))
    $_POST['operation'] = "";

if (!isset($_SESSION['hdksks8272nsksl3839sjsj2938djs'])) {
    header("Location: login.php");
    exit();
}

$db = new mysqli("127.0.0.1", "root", "1453", "cs315_project");
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

    <section id="welcome-page" class="" style="font-family: Arial, sans-serif; text-align: center;">
        <div class="container">
            <header>
                <?php
                $sql = "SELECT id, username, first_name, last_name, email, premium_member FROM users WHERE id = ?";

                if ($stmt = $db->prepare($sql)) {
                    $stmt->bind_param("i", $_SESSION['hdksks8272nsksl3839sjsj2938djs']);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        if ($result->num_rows == 1) {
                            $user = $result->fetch_assoc();
                        } else {
                            echo "No records were found for the provided user id.";
                            exit();
                        }
                    } else {
                        echo "Error: " . $db->error;
                        exit();
                    }
                } else {
                    echo "Error: " . $db->error;
                    exit();
                }
                ?>
                <h2>Hello,
                    <?php echo htmlspecialchars($user['first_name']); ?> 👋
                </h2>
                <br>
                <div class="profile-welcome">
                    <h4>Welcome to your profile page. Here you can view your information. 🎉</h4>
                </div>
            </header>
        </div>
    </section>

    <section id="my-profile" class="two light" style="font-family: Arial, sans-serif;">
        <div class="container">
            <header>
                <h2>My Profile 👤</h2>
            </header>
            <div class="profile-container">
                <table class="profile-table">
                    <tr>
                        <th>User ID</th>
                        <td>
                            <?php echo htmlspecialchars($user['id']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>
                            <?php echo htmlspecialchars($user['first_name']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>
                            <?php echo htmlspecialchars($user['last_name']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <?php echo htmlspecialchars($user['email']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Premium Member? </th>
                        <td>
                            <?php echo htmlspecialchars($user['premium_member']) == 1 ? 'Yes! 🎉' : 'Not yet!'; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</body>

</html>