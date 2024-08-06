<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the OTP entered by the user
    $entered_otp = $_POST['otp'];

    // Retrieve the OTP stored in the session
    $stored_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';

    // Validate OTP
    if ($entered_otp == $stored_otp) {
        // Connect to your database
        $conn = new mysqli("localhost", "root", "", "registration_db");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data from session
        $form_data = $_SESSION['form_data'];
        $full_name = $form_data['full_name'];
        $gender = $form_data['gender'];
        $birth_date = $form_data['birth_date'];
        $mobile_number = $form_data['mobile_number'];
        $email = $form_data['email'];
        $country = $form_data['country'];
        $state = $form_data['state'];
        $city = $form_data['city'];

        // Insert form data into the database
        $sql = "INSERT INTO users (full_name, gender, birth_date, mobile_number, email, country, state, city)
                VALUES ('$full_name', '$gender', '$birth_date', '$mobile_number', '$email', '$country', '$state', '$city')";

        if ($conn->query($sql) === TRUE) {
            // Clear session data
            unset($_SESSION['otp']);
            unset($_SESSION['form_data']);
            
            // Show success message
            echo "<script>
                alert('Data saved successfully. Thank you for registration! We will launch soon.');
                window.location.href = 'thank_you.php';
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "<script>
            alert('Invalid OTP. Please try again.');
            window.location.href = 'verify_otp.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>Verify OTP</header>
        <form action="verify_otp.php" method="POST">
            <div class="input-field">
                <label>Enter OTP</label>
                <input type="number" name="otp" placeholder="Enter the OTP sent to your mobile" required>
            </div>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="buttons">
                <button class="submit">
                    <span class="btnText">Verify</span>
                    <i class="uil uil-navigator"></i>
                </button>
            </div>
        </form>
    </div>
</body>
</html>