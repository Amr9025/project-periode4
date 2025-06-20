<?php
require_once dirname(dirname(__DIR__)) . '/includes/header.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /');
    exit;
}
?>

<main class="admin-panel">
    <div class="white-background" style="padding: 20px; border-radius: 10px;">
        <h1>Nieuwe Aanbieding</h1>
        
        <form action="/actions/add-offer.php" method="POST" enctype="multipart/form-data" class="offer-form">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="price">Price (€):</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="capacity">Capacity (persons):</label>
                <input type="number" id="capacity" name="capacity" min="1" required>
            </div>

            <div class="form-group">
                <label for="steering">Steering (e.g., Manual, Automatic):</label>
                <input type="text" id="steering" name="steering" required>
            </div>

            <div class="form-group">
                <label for="gasoline">Gasoline (L/100km or type):</label>
                <input type="text" id="gasoline" name="gasoline" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="button-primary">Save Changes</button>
            <a href="/admin" class="button-secondary">Cancel</a>
        </form>
    </div>
</main>

<style>
.offer-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.button-secondary {
    margin-left: 10px;
    text-decoration: none;
    color: white;
    background-color: #6c757d;
    padding: 8px 16px;
    border-radius: 4px;
    display: inline-block;
}

.button-secondary:hover {
    background-color: #5a6268;
}

/* Add the same styling as the admin panel */
.admin-panel {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.white-background {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

h1 {
    color: #333;
    margin-bottom: 20px;
}

h2 {
    color: #444;
    margin-top: 30px;
    margin-bottom: 20px;
}

.button-primary {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.button-primary:hover {
    background-color: #0056b3;
}
</style>

<?php
require_once dirname(dirname(__DIR__)) . '/includes/footer.php';
?>
