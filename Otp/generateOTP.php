<?php
function generateOTP() {
    return rand(100000, 999999); // Generates a 6-digit OTP
}