<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? ''; // 'enquiry' or 'site_visit'
    $response = ['status' => 'error', 'message' => 'Invalid action'];

    if ($type === 'enquiry') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $property = $_POST['property'] ?? '';
        $message = $_POST['message'] ?? '';
        $source = $_POST['source_page'] ?? 'index.html';

        if (!empty($name) && !empty($phone)) {
            try {
                $sql = "INSERT INTO enquiries (name, email, phone, property_interest, message, source_page) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $email, $phone, $property, $message, $source]);
                $response = ['status' => 'success', 'message' => 'Thank you for your enquiry. We will contact you soon!'];
            } catch (Exception $e) {
                $response = ['status' => 'error', 'message' => 'Something went wrong. Please try again later.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Name and Phone are required.'];
        }
    } elseif ($type === 'site_visit') {
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $property = $_POST['property'] ?? '';
        $message = $_POST['message'] ?? '';

        if (!empty($name) && !empty($phone) && !empty($date)) {
            try {
                $sql = "INSERT INTO site_visits (name, phone, preferred_date, preferred_time, property_interest, message) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $phone, $date, $time, $property, $message]);
                $response = ['status' => 'success', 'message' => 'Site visit requested successfully!'];
            } catch (Exception $e) {
                $response = ['status' => 'error', 'message' => 'Something went wrong. Please try again later.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Name, Phone, and Preferred Date are required.'];
        }
    }

    echo json_encode($response);
    exit;
}
?>