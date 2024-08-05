<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $session_otp = $_SESSION['otp'];

    if ($entered_otp == $session_otp) {
        // OTP is correct, redirect to save data page
        header("Location: save_data.php");
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
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
