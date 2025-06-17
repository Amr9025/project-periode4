<?php
// Ensure session is started (usually in header.php, but good to double-check)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is admin, otherwise redirect to home
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="admin-panel">
    <div class="white-background" style="padding: 20px; border-radius: 10px;">
        <h1>Admin Panel</h1>
        <p>Welcome, Admin! Here you will be able to manage car listings.</p>
        
        <h2 style="margin-top: 30px;">Manage Car Listings</h2>
        <?php
        // Database connection is already included via header.php, but ensure $conn is available.
        // require_once __DIR__ . '/../database/connection.php'; // Usually not needed if header does it.

        try {
            $stmt = $conn->query("SELECT id, brand, type, price, main_image, capacity, steering, gasoline FROM cars ORDER BY id ASC");
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error fetching cars: " . htmlspecialchars($e->getMessage()) . "</p>";
            $cars = []; // Ensure $cars is an array even on error
        }
        ?>

        <?php if (empty($cars)): ?>
            <p>No cars found in the database.</p>
        <?php else: ?>
            <table class="admin-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Brand</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Type</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Image</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Price</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($car['id']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($car['brand']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($car['type']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <?php if (!empty($car['main_image'])): ?>
                                    <img src="/assets/images/products/<?= htmlspecialchars($car['main_image']) ?>" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['type']) ?>" style="width: 100px; height: auto; object-fit: cover;">
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">&euro;<?= htmlspecialchars(number_format($car['price'], 2, ',', '.')) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <a href="/admin/edit-car?id=<?= htmlspecialchars($car['id']) ?>" class="button-secondary" style="margin-right: 5px; text-decoration: none; padding: 5px 10px; font-size: 0.9em;">Edit</a>
                                <a href="/admin/delete-car?id=<?= htmlspecialchars($car['id']) ?>" class="button-danger" style="text-decoration: none; padding: 5px 10px; font-size: 0.9em;" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <!-- Example: Link to add a new car -->
        <!-- <a href="/admin/add-car" class="button-primary" style="margin-top: 30px; display: inline-block;">Add New Car</a> -->

    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
