<?php

header('Content-Type: application/json; charset=utf-8');
require_once 'connect_db.php';


$response = [
    'success' => false,
    'message' => '',
    'errors'  => []
];


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['message'] = 'Method Not Allowed. Please submit the form via POST.';
    echo json_encode($response);
    exit;
}


$patient_name     = trim($_POST['patient_name'] ?? '');
$national_id      = trim($_POST['national_id'] ?? '');
$gender           = trim($_POST['gender'] ?? '');
$phone_number     = trim($_POST['phone_number'] ?? '');
$email_address    = trim($_POST['email_address'] ?? '');
$department       = trim($_POST['department'] ?? '');
$appointment_date = trim($_POST['appointment_date'] ?? '');

// 2. Server-Side Validation
$errors = [];

// Name Validation
if (empty($patient_name)) {
    $errors['patient_name'] = 'Patient Name is required.';
} elseif (strlen($patient_name) < 3) {
    $errors['patient_name'] = 'Patient Name must be at least 3 characters.';
}

// National ID Validation
if (empty($national_id)) {
    $errors['national_id'] = 'National ID Number is required.';
}

// Gender Validation
$allowed_genders = ['Male', 'Female', 'Other'];
if (empty($gender)) {
    $errors['gender'] = 'Please select a gender.';
} elseif (!in_array($gender, $allowed_genders, true)) {
    $errors['gender'] = 'Invalid gender selected.';
}

// Phone Number Validation (Regex checks standard 10 to 12 digit format)
$phone_regex = '/^(?:\+254|0)[17]\d{8}$/';
if (empty($phone_number)) {
    $errors['phone_number'] = 'Phone Number is required.';
} elseif (!preg_match($phone_regex, $phone_number)) {
    $errors['phone_number'] = 'Enter a valid phone number (e.g., 0712345678 or +254712345678).';
}

// Email Address Validation
if (empty($email_address)) {
    $errors['email_address'] = 'Email Address is required.';
} elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
    $errors['email_address'] = 'Enter a valid email address format.';
}

// Department Validation
$allowed_departments = ['General Medicine', 'Pediatrics', 'Obstetrics & Gynecology', 'Dental Care'];
if (empty($department)) {
    $errors['department'] = 'Please select a department.';
} elseif (!in_array($department, $allowed_departments, true)) {
    $errors['department'] = 'Invalid department selected.';
}

// Appointment Date Validation (Must not be in the past)
if (empty($appointment_date)) {
    $errors['appointment_date'] = 'Appointment Date is required.';
} else {
    $selected_timestamp = strtotime($appointment_date);
    $today_timestamp    = strtotime(date('Y-m-d'));

    if ($selected_timestamp === false) {
        $errors['appointment_date'] = 'Invalid date format.';
    } elseif ($selected_timestamp < $today_timestamp) {
        $errors['appointment_date'] = 'Appointment date cannot be in the past.';
    }
}

// Check for validation errors
if (!empty($errors)) {
    http_response_code(400);
    $response['success'] = false;
    $response['message'] = 'Validation failed. Please correct the highlighted errors.';
    $response['errors']  = $errors;
    echo json_encode($response);
    exit;
}

// 3. Database Insertion using PDO Prepared Statements
try {
    $sql = "INSERT INTO appointments 
            (patient_name, national_id, gender, phone_number, email_address, department, appointment_date) 
            VALUES 
            (:patient_name, :national_id, :gender, :phone_number, :email_address, :department, :appointment_date)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':patient_name'     => $patient_name,
        ':national_id'      => $national_id,
        ':gender'           => $gender,
        ':phone_number'     => $phone_number,
        ':email_address'    => $email_address,
        ':department'       => $department,
        ':appointment_date' => $appointment_date,
    ]);

    $appointment_id = $pdo->lastInsertId();

    http_response_code(201);
    $response['success'] = true;
    $response['message'] = "Appointment booked successfully! Your reference ID is #" . $appointment_id;
    $response['appointment_id'] = $appointment_id;

} catch (PDOException $e) {
    http_response_code(500);
    $response['success'] = false;
    $response['message'] = 'Database error occurred: Failed to record appointment.';
    // Log real exception message securely on server: error_log($e->getMessage());
}

echo json_encode($response);
exit;