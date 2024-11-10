<?php
session_start();

// Get the OTP entered by the user
$user_otp = $_POST['otp'];

// Check if OTP exists and hasn't expired
if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
    // Check if OTP has expired
    if (time() > $_SESSION['otp_expiry']) {
        echo json_encode([
            "status" => "error",
            "message" => "OTP has expired. Please request a new one.",
        ]);
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiry']);
        exit;
    }

    // Verify OTP
    if ($user_otp == $_SESSION['otp']) {
        echo json_encode([
            "status" => "success",
            "message" => "OTP verification successful.",
        ]);
        // Clear OTP after successful verification
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiry']);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid OTP. Please try again.",
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No OTP found. Please request a new one.",
    ]);
}
