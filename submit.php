<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
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

    // Send OTP using SMS API (example with Textlocal)
    $apiKey = urlencode('Njg2NzQyNDE3MzcxNmQ0ZjMzNjE3NjRhNzA0OTRmN2E=');
    $numbers = urlencode($mobile_number); // Ensure this includes country code
    $sender = urlencode('TXTLCL'); // Verify sender ID or use a valid sender ID
    $message = rawurlencode("Your OTP is $otp");

    $data = array(
        'apikey' => $apiKey,
        'numbers' => $numbers,
        'sender' => $sender,
        'message' => $message
    );

    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['status']) && $responseData['status'] == 'success') {
        // Redirect to OTP verification page
        header("Location: verify_otp.php");
        exit();
    } else {
        $errorMessage = isset($responseData['errors'][0]['message']) ? $responseData['errors'][0]['message'] : 'Unknown error';
        echo "Failed to send OTP: " . $errorMessage;
    }
}
?>
