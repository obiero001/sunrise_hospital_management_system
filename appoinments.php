<?php
// api/appointments.php - JSON API Endpoint (Task 7 Option B)
header('Content-Type: application/json; charset=utf-8');
require_once 'connect_db.php';

try {
    $stmt = $pdo->query("SELECT appointment_id, patient_name, national_id, gender, phone_number, email_address, department, appointment_date FROM appointments ORDER BY appointment_date ASC");
    $appointments = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'count' => count($appointments),
        'data' => $appointments
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch appointments: ' . $e->getMessage()
    ]);
}
?>