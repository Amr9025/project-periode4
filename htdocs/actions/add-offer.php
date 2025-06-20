<?php
require_once __DIR__ . '/../database/connection.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate and sanitize input
        $brand = trim($_POST['brand']);
        $type = trim($_POST['type']);
        $price = floatval($_POST['price']);
        $capacity = intval($_POST['capacity']);
        $steering = trim($_POST['steering']);
        $gasoline = trim($_POST['gasoline']);
        $description = trim($_POST['description']);

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $targetDir = __DIR__ . '/../assets/images/offers/';
            $fileName = uniqid() . '_' . basename($image['name']);
            $targetPath = $targetDir . $fileName;

            // Create directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Move uploaded file
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                // Insert into cars table
                $stmt = $conn->prepare("INSERT INTO cars (brand, type, price, capacity, steering, gasoline, description, main_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$brand, $type, $price, $capacity, $steering, $gasoline, $description, $fileName]);

                // Add success message to session
                $_SESSION['success_message'] = "Voertuig succesvol toegevoegd aan Ons Aanbod.";
                
                header('Location: /admin');
                exit;
            } else {
                throw new Exception('Failed to upload image');
            }
        } else {
            throw new Exception('No valid image uploaded');
        }
    } catch (Exception $e) {
        // Add error message to session
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: /admin/add-offer?error=' . urlencode($e->getMessage()));
        exit;
    }
} else {
    header('Location: /admin');
    exit;
}
