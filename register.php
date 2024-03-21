<?php 
session_start();

// Include the database connection file
include "db_conn.php";

// Include the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to send email verification
function sendMail($email, $v_code) 
{
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cjmarquez6000@gmail.com';
        $mail->Password   = 'wjaw cacm gjpy tjhq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    
        // Recipients
        $mail->setFrom('cjmarquez6000@gmail.com', 'MarquezLAB_3');
        $mail->addAddress($email);     
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = "Thanks for registration! 
        Click the following link to verify your email address:<br>
        <a href='http://localhost/ipt_lab3/verify.php?email=$email&v_code=$v_code'>Verify Email</a>";

    
        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to sanitize and validate user input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email field is empty
    if (empty($email)) {
        // If the email field is empty, redirect with an error message
        header("Location: registerform.php?error=Email is required.");
        exit();
    }

    // Check if the email address contains "gmail.com"
    if (strpos($email, 'gmail.com') === false) {
        // If the email does not contain "gmail.com", redirect with an error message
        header("Location: registerform.php?error=Email must be a Gmail address.");
        exit();
    }

    // Validate and store user input in variables
    $uname = validate($_POST['uname']);
    $fname = validate($_POST['fname']);
    $mname = validate($_POST['mname']);
    $lname = validate($_POST['lname']);
    $password = validate($_POST['password']);

    // Generate a verification code
    $v_code = bin2hex(random_bytes(16));

    // Hash the password (ensure you use proper password hashing methods)
    // Replace this with your preferred password hashing method

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Check if email already exists
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    // Check if there are any rows returned from the database query
    if ($result->num_rows > 0) {
        // If the email already exists, terminate the script and display a message
        echo "<div style='background-color: #f44336; color: white; padding: 10px; text-align: center;'>Email already exists. Please choose another email. <a href='register.php'>Register Another</a></div>";
        exit;
    }

    // SQL query to insert user data into the database
    $sql = "INSERT INTO user (username, first_name, middle_name, lastname, email, password, verification_code, is_verified) 
            VALUES ('$uname', '$fname', '$mname', '$lname', '$email', '$password', '$v_code', '0')";

    // Execute the SQL query
    if (mysqli_query($conn, $sql) && sendMail($email, $v_code)) {
        // If registration is successful, set the username in the session and redirect to success page
        $_SESSION["username"] = $uname;  
        header("Location: success.php"); 
        exit();
    } else {
        // If registration fails, redirect to the registration form with an error message
        header("Location: registerform.php?error=Registration failed. Please try again.");
        exit();
    }
} else {
    // If the form is not submitted using POST method, redirect to the registration form
    header("Location: registerform.php");
    exit();
}
?>
