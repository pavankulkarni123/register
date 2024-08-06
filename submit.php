<?php
session_start();
require 'PHPMailer/PHPMailerAutoload.php'; // Update the path according to your setup

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $country_code = $_POST['country_code'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store form data and OTP in session
    $_SESSION['form_data'] = $_POST;
    $_SESSION['otp'] = $otp;

    // Send OTP using MSG91 API
    $apiKey = '391918AYBmLKVYTbm64225f20P1';
    $senderId = 'SKIBIN'; // Your sender ID
    $route = '4'; // Route for transactional SMS
    $countryCode = '91'; // Country code for India
    $templateId = '1001083062209433956'; // Replace with your actual template ID

    $postData = array(
        'authkey' => $apiKey,
        'mobiles' => $countryCode . $mobile_number,
        'message' => urlencode("Your OTP is $otp"),
        'sender' => $senderId,
        'route' => $route,
        'country' => $countryCode,
        'template_id' => $templateId // Add template ID
    );

    $url = "https://api.msg91.com/api/sendhttp.php";

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
    ));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status code
    $error = curl_error($ch); // Get cURL error if any
    curl_close($ch);

    // Debugging output
    echo "HTTP Status Code: " . $httpCode . "<br>";
    echo "Raw Response: " . $response . "<br>";
    echo "cURL Error: " . $error . "<br>";

    // Check if response is a non-empty string (message ID or success response)
    if ($httpCode == 200 && !empty($response)) {
        // Assuming non-empty response is a success (message ID or confirmation)
        // Send thank you email using PHPMailer
        $mail = new PHPMailer;

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'pavankulkarni904@gmail.com'; // Your SMTP username (Gmail address)
        $mail->Password = 'wzwkugdryfzcqnzn'; // Your SMTP password (Gmail password)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pavankulkarni904@gmail.com', 'Pavan Kulkarni'); // From email and name
        $mail->addAddress($email); // Add a recipient

        // Email subject and body
        $mail->Subject = 'Thank You for Registration';
        $mail->Body = "Dear $full_name,\n\nThank you for registering with us. We will contact you soon.\n\nBest regards,\nVirabh";

        if ($mail->send()) {
            // Redirect to OTP verification page
            header("Location: verify_otp.php");
            exit();
        } else {
            echo "Failed to send thank you email. Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Failed to send OTP: " . $response;
    }
}
?>
