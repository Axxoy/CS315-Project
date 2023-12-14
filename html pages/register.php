<?php

// Set the default timezone to America/Chicago
date_default_timezone_set('America/Chicago');

session_start();
ob_start();

// Initialize operator
if (!(isset($_POST['operation'])))
    $_POST['operation'] = "";

// Check if logged in
if (isset($_SESSION['hdksks8272nsksl3839sjsj2938djs'])) {
    // unset($_SESSION['hdksks8272nsksl3839sjsj2938djs']);
    header("Location: index.php");
}

// Switch that decides on which function is to be called depending on the parameter value it receives.
switch ($_POST['operation']) {
    case 'register':
        register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['first_name'], $_POST['last_name']);
        main_page();
        break;
    default:
        main_page();
}


function register($username, $email, $password, $confirm_password, $first_name, $last_name)
{
    $db = new mysqli("127.0.0.1", "root", "1453", "cs315_project") or die("could not connect to mysql"); // Open up the connection
    if ($db->connect_error)
        die("Connection failed: " . $db->connect_error);

    // Sanitize user input
    $username = $db->real_escape_string($username);
    $email = $db->real_escape_string($email);
    $password = $db->real_escape_string($password);
    $confirm_password = $db->real_escape_string($confirm_password);
    $first_name = $db->real_escape_string($first_name);
    $last_name = $db->real_escape_string($last_name);

    // Check if password and confirm_password match
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // Check if username or email already exists
    $checkUser = $db->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($checkUser->num_rows > 0) {
        $_SESSION['error_message'] = "Username or Email already exists!";
        header("Location: register.php");
        exit();
    }

    // Hash the password
    $hashed_password = hash('sha256', $password);

    // Use an INSERT query to add the new user to the database
    $result = $db->query("INSERT INTO users (username, email, password, first_name, last_name) VALUES ('$username', '$email', '$hashed_password', '$first_name', '$last_name')");

    if ($result) {
        $_SESSION['success_message'] = "User has been registered!";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $db->error;
    }

    $db->close(); // Close the database connection
}

function main_page()
{
    echo "<!DOCTYPE HTML>";
    echo "<html>";
    echo "<head>";
    echo "<title>Login Page</title>";
    echo "<meta charset=\"utf-8\" />";
    echo "<link rel=\"stylesheet\" href=\"../css/main.css\"/>";
    echo "</head>";
    echo "<body>";
    echo "<div id=\"container\">";
    echo "<div id=\"login-form\">";
    echo "<center>";
    echo "<img src='../assets/images/is_logo.png' alt='Banner' style='width: 30em; background-image: linear-gradient(45deg, #673ab7 15%, #3f51b5 85%);'>";
    echo "<br/>";
    echo "<br/>";
    echo "</center>";

    if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        // clear the message after displaying it
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        // clear the message after displaying it
        unset($_SESSION['success_message']);
    }

    // Registration form
    echo "<form method='post' name=registrationForm action='register.php'>";
    echo "<input type=\"text\" name=\"username\" placeholder=\"Username\" required>";
    echo "<input type=\"text\" name=\"email\" placeholder=\"Email\" required>";
    echo "<input type=\"password\" name=\"password\" placeholder=\"Password\" required>";
    echo "<input type=\"password\" name=\"confirm_password\" placeholder=\"Re-enter Password\" required>";
    echo "<input type=\"text\" name=\"first_name\" placeholder=\"First Name\" required>";
    echo "<input type=\"text\" name=\"last_name\" placeholder=\"Last Name\" required>";
    echo "<input type=\"submit\" value=\"Create user\" />";
    echo "<center>";
    echo "<a href=\"login.php\" class=\"button\">Go to Login</a>";
    echo "</center>";
    echo "<input type=hidden name=operation value='register'>";
    echo "</form>";
}
?>