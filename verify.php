<?php 
session_start();
// Include the database connection file
include "db_conn.php";

// Check if email and verification code are set in the URL
if (isset($_GET['email']) && isset($_GET['v_code'])) {
    // Retrieve email and verification code from the URL
    $email = $_GET['email'];
    $v_code = $_GET['v_code'];
    
    // Select user with the provided email and verification code
    $sql = "SELECT * FROM user WHERE email = '$email' AND verification_code = '$v_code'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if only one row was found
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            // Check if the user is not already verified
            if ($row['is_verified'] == 0) {
                // Update the user's verification status to verified
                $update = "UPDATE user SET is_verified = '1' WHERE email = '$email'";
                if (mysqli_query($conn, $update)) {
                    // Email verification successful
                    echo "Email verification successful";
                    // Redirect to the login form
                    header("Location: Loginform.php");
                    exit();
                } else {
                    // Redirect to the login form with an error message
                    header("Location: Loginform.php?error=Cannot run query");
                    exit();
                }
            } else {
                // Redirect to the login form with an error message
                header("Location: Loginform.php?error=Email is already registered");
                exit();
            }
        } else {
            // Redirect to the login form with an error message
            header("Location: Loginform.php?error=Invalid verification code");
            exit();
        }
    } else {
        // Redirect to the login form with an error message
        header("Location: Loginform.php?error=Cannot run query");
        exit();
    }
} else {
    // Redirect to the login form
    header("Location: Loginform.php");
    exit();
}
?>
