<?php
session_start();
// DEBUGGING LINE - REMOVE AFTER TESTING
error_log("toggle_like.php - SESSION: " . print_r($_SESSION, true));
require_once __DIR__ . '/../database/connection.php'; // Adjust path if necessary

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if (!isset($_POST['car_id']) || !is_numeric($_POST['car_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid car ID.']);
    exit;
}

$userId = $_SESSION['user_id'];
$carId = (int)$_POST['car_id'];
$newLikeStatus = 0;

try {
    // Check if a like record already exists for this user and car
    $stmt = $conn->prepare("SELECT id, like_status FROM car_likes WHERE user_id = :user_id AND car_id = :car_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
    $stmt->execute();
    $existingLike = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingLike) {
        // Record exists, toggle like_status
        $newLikeStatus = $existingLike['like_status'] ? 0 : 1; // Toggle
        $updateStmt = $conn->prepare("UPDATE car_likes SET like_status = :like_status WHERE id = :id");
        $updateStmt->bindParam(':like_status', $newLikeStatus, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $existingLike['id'], PDO::PARAM_INT);
        $updateStmt->execute();
    } else {
        // No record exists, insert a new like (status = 1)
        $newLikeStatus = 1;
        $insertStmt = $conn->prepare("INSERT INTO car_likes (user_id, car_id, like_status) VALUES (:user_id, :car_id, :like_status)");
        $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $insertStmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
        $insertStmt->bindParam(':like_status', $newLikeStatus, PDO::PARAM_INT);
        $insertStmt->execute();
    }

    // Optionally, get the total likes for the car to return
    $countStmt = $conn->prepare("SELECT COUNT(*) as total_likes FROM car_likes WHERE car_id = :car_id AND like_status = 1");
    $countStmt->bindParam(':car_id', $carId, PDO::PARAM_INT);
    $countStmt->execute();
    $likesData = $countStmt->fetch(PDO::FETCH_ASSOC);
    $totalLikes = $likesData ? $likesData['total_likes'] : 0;

    echo json_encode([
        'success' => true, 
        'message' => 'Like status updated.', 
        'liked' => (bool)$newLikeStatus, // True if liked, false if unliked
        'total_likes' => $totalLikes
    ]);

} catch (PDOException $e) {
    // Log error $e->getMessage()
    echo json_encode(['success' => false, 'message' => 'Database error. Could not update like status.']);
}
?>
