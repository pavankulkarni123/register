<?php
session_start();

if (!isset($_SESSION['form_data'])) {
    header("Location: register.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$form_data = $_SESSION['form_data'];

$sql = "INSERT INTO users (full_name, gender, birth_date, mobile_number, email, country, state, city)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", 
    $form_data['full_name'], 
    $form_data['gender'], 
    $form_data['birth_date'], 
    $form_data['mobile_number'], 
    $form_data['email'], 
    $form_data['country'], 
    $form_data['state'], 
    $form_data['city']
);

if ($stmt->execute()) {
    echo "Registration successful!";
    unset($_SESSION['form_data']);
    unset($_SESSION['otp']);
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
