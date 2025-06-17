<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is admin, otherwise redirect to home
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../database/connection.php';

$car_id = $_GET['id'] ?? null;
$car = null;
$message = '';

if (!$car_id || !filter_var($car_id, FILTER_VALIDATE_INT)) {
    $message = '<p style="color:red;">Invalid car ID provided.</p>';
} else {
    try {
        $stmt = $conn->prepare("SELECT * FROM cars WHERE id = :id");
        $stmt->bindParam(':id', $car_id, PDO::PARAM_INT);
        $stmt->execute();
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$car) {
            $message = '<p style="color:red;">Car not found.</p>';
        }
    } catch (PDOException $e) {
        $message = "<p style='color:red;'>Error fetching car details: " . htmlspecialchars($e->getMessage()) . "</p>";
        $car = null; 
    }
}

?>

<main class="admin-panel">
    <div class="white-background" style="padding: 20px; border-radius: 10px;">
        <h1>Edit Car (ID: <?= htmlspecialchars($car_id ?? 'Unknown') ?>)</h1>

        <?php if ($message): ?>
            <?= $message ?>
            <p><a href="/admin" class="button-secondary">Back to Admin Panel</a></p>
        <?php elseif ($car): ?>
            <form action="/actions/update-car.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">

                <div style="margin-bottom: 15px;">
                    <label for="brand">Brand:</label><br>
                    <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="type">Type:</label><br>
                    <input type="text" id="type" name="type" value="<?= htmlspecialchars($car['type']) ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="price">Price (&euro; per day):</label><br>
                    <input type="number" id="price" name="price" value="<?= htmlspecialchars($car['price']) ?>" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="capacity">Capacity (persons):</label><br>
                    <input type="number" id="capacity" name="capacity" value="<?= htmlspecialchars($car['capacity']) ?>" step="1" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="steering">Steering (e.g., Manual, Automatic):</label><br>
                    <input type="text" id="steering" name="steering" value="<?= htmlspecialchars($car['steering']) ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="gasoline">Gasoline (L/100km or type):</label><br>
                    <input type="text" id="gasoline" name="gasoline" value="<?= htmlspecialchars($car['gasoline']) ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= htmlspecialchars($car['description'] ?? '') ?></textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label>Current Main Image:</label><br>
                    <?php if (!empty($car['main_image'])): ?>
                        <img src="/assets/images/products/<?= htmlspecialchars($car['main_image']) ?>" alt="Current Image" style="max-width: 200px; max-height: 150px; margin-bottom: 10px; display: block;">
                        <p><small>Current file: <?= htmlspecialchars($car['main_image']) ?></small></p>
                    <?php else: ?>
                        <p>No current image.</p>
                    <?php endif; ?>
                    <label for="main_image_upload">Upload New Image (optional, replaces current):</label><br>
                    <input type="file" id="main_image_upload" name="main_image_upload" accept="image/*" style="padding: 8px;">
                </div>

                <button type="submit" class="button-primary" style="padding: 10px 15px;">Save Changes</button>
                <a href="/admin" class="button-secondary" style="padding: 10px 15px; text-decoration: none; margin-left: 10px;">Cancel</a>
            </form>
        <?php else: ?>
            <p>Could not load car data. <a href="/admin" class="button-secondary">Back to Admin Panel</a></p>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
