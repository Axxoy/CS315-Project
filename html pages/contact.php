<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../styles-mobile.css" media="screen and (max-width: 767px)">
    <link rel="stylesheet" type="text/css" href="../styles-desktop.css" media="screen and (min-width: 768px)">
    <title>Contact</title>
</head>

<body>

    <!-- include the menu sidebar -->
    <?php include 'sidebar.php'; ?>

    <a href="cart.php" id="cart-icon" title="View Cart">
        <img src="../assets/images/shopping-cart.png" alt="Cart">
    </a>

    <h1>Contact Us!</h1>

    <!-- Set up the skeleton for the form -->
    <form id="contact-form">
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName" required><br>

        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName" required><br>

        <label for="phoneNumber">Phone Number:</label><br>
        <input type="tel" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br>

        <label for="message">Message:</label><br>
        <textarea name="message" rows="10" cols="30" placeholder="Enter your message here." required></textarea><br>

        <input type="submit" value="Submit">
    </form>

    <footer>
        <p style="text-align: center;"><em>Designed and Created by Cüneyt Aksoy and Paul Keiser
                <br>
                MIT License - 2023</em>
        </p>
    </footer>

    <script>
        // Select the form element by its ID
        const form = document.getElementById('contact-form');

        // Add a submit event listener to the form
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission behavior

            // Create a FormData object from the form
            const formData = new FormData(document.getElementById('contact-form'));
            const data = {};

            // Convert the form data to a JavaScript object
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            // Verify the form data
            let errorMessage = "";
            if (data.firstName.trim() === "") {
                errorMessage += "First name is required.\n";
            }
            if (data.lastName.trim() === "") {
                errorMessage += "Last name is required.\n";
            }
            if (data.phoneNumber.trim() === "") {
                errorMessage += "Phone number is required.\n";
            } else if (!/^[0-9]{10}$/.test(data.phoneNumber.trim())) {
                errorMessage += "Invalid phone number.\n";
            }
            if (data.email.trim() === "") {
                errorMessage += "Email is required.\n";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email.trim())) {
                errorMessage += "Invalid email address.\n";
            }
            if (data.subject.trim() === "") {
                errorMessage += "Subject is required.\n";
            }
            if (data.message.trim() === "") {
                errorMessage += "Message is required.\n";
            }

            // If there is an error, notify the user and stop the submission
            if (errorMessage !== "") {
                alert(errorMessage);
                return;
            }

            // Convert the data object to a JSON string
            const jsonData = JSON.stringify(data);

            // Store the JSON data in the local storage
            localStorage.setItem("data", jsonData);

            // Redirect to the submission page
            window.location.href = 'submission.php';

            // Send the form data to the server using fetch
            fetch("/your-server-endpoint", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the server
                    console.log("Server response:", data);
                    // You can update the page or perform other actions based on the server response
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>

</html>