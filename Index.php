<?php

// Start the session to manage user data
session_start();
// Include the database connection file
include "db_conn.php";

// Check if the username and password are provided
if (isset($_POST['uname']) && isset($_POST['password'])) {
    // Function to validate user input
    function validate($data){
        $data = trim($data);        // Remove whitespace from the beginning and end of the input
        $data = stripslashes($data);   // Remove backslashes (\) from the input
        $data = htmlspecialchars($data);   // Convert special characters to HTML entities
        return $data;
    }
    // Validate the provided username and password
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    // Check if the username is empty
    if (empty($uname)) {
        header("Location: Loginform.php?error=User Name is required");
        exit();
    }
    // Check if the password is empty
    else if (empty($pass)) {
        header("Location: Loginform.php?error=Password is required");
        exit();
    }
    // If both username and password are provided
    else {

        // SQL query to select user data based on the provided username
        $sql = "SELECT * FROM user WHERE username='$uname'";
        $result = mysqli_query($conn, $sql);

        // Check if the query returned exactly one row (user found)
        if (mysqli_num_rows($result) === 1) {
            // Get the user data as an associative array
            $row = mysqli_fetch_assoc($result);
            // Check if the user's email is verified
            if($row['is_verified'] == 1)
            {
                 // Check if the provided password matches the password in the database
                 if ($pass === $row['password']) {
                    echo "Logged in!";
                    // Store user data in the session
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["name"] = $row['name'];
                    $_SESSION["id"] = $row['id'];   
                    // Redirect to the home page
                    header("Location: home.php");
                    exit();
                } else {
                    // Redirect with an error message if the password is incorrect
                    header("Location: Loginform.php?error=Incorrect User Name or password");
                    exit();
                }
            }
            else {
                // Redirect with an error message if the email is not verified
                header("Location: Loginform.php?error=Check your Email to verify");
                exit();
            }
        }else {
            // Redirect with an error message if the email is not verified
            header("Location: Loginform.php?error=Incorrect User Name or password");
            exit();
        }
    }
} else {
    // Redirect if the username or password is not provided
    header("Location: loginform.php");
    exit();
}
?>
