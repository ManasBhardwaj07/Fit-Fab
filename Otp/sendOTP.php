<?php
// Start session
session_start();

// CORS headers to allow cross-origin requests
header("Access-Control-Allow-Origin: http://localhost:5175");  // Replace with specific origin for added security
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// If it's an OPTIONS request, respond and exit
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the email is provided
if (empty($_POST['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Email is required.",
    ]);
    exit();
}

// Configuration
$otp_length = 6;  // Length of OTP
$otp_expiry_time = 300;  // OTP expiry time in seconds (e.g., 5 minutes)

// Generate OTP
$otp = rand(pow(10, $otp_length - 1), pow(10, $otp_length) - 1);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + $otp_expiry_time;

// Email Configuration
$recipient_email = $_POST['email'];  // Email from the POST request
$subject = "Your OTP Code";
$message = "Your OTP code is: $otp\nThis OTP will expire in 5 minutes.";
$headers = "From: no-reply@yourdomain.com";

// Send the email (you can replace this with an API if necessary)
if (mail($recipient_email, $subject, $message, $headers)) {
    echo json_encode([
        "status" => "success",
        "message" => "OTP has been sent to your email.",
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to send OTP. Please try again later.",
    ]);
}
