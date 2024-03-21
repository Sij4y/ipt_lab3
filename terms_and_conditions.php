<?php
// Start the PHP session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <style>
        /* Add CSS styles for the body to set the background image */
        body {
            background-image: url('star_wars_the_rise_of_skywalker_3-wallpaper-1920x1080.jpg');
            /* Set background size to cover the entire viewport */
            background-size: cover;
            /* Set background attachment to fixed so it doesn't scroll with content */
            background-attachment: fixed;
            /* Set background position to center */
            background-position: center;
            /* Set font family and color for better readability */
            font-family: Arial, sans-serif;
            color: #fff; /* Change text color to white */
        }
        /* Add CSS styles for the content */
        h2 {
            text-align: center;
            margin-top: 50px;
        }
        p, ul {
            max-width: 600px;
            margin: 0 auto 20px auto;
            padding: 0 20px;
            color: #fff; /* Change text color to white */
        }
        ul {
            padding-left: 20px;
        }
        /* Add styles for the button */
        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
        /* Style the link button */
        .btn-primary {
            background-color: #007bff; /* Blue background color */
            color: #fff; /* White text color */
            padding: 10px 20px; /* Add padding */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Add border radius */
            transition: background-color 0.3s; /* Smooth transition */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    
    <!-- Button to go back to the registerform page -->
    <div class="back-btn">
        <a href="registerform.php" class="btn btn-primary">Back to Register Form</a>
    </div>
</body>
</html>
