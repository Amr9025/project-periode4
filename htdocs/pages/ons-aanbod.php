<?php require __DIR__ . "/../includes/header.php" ?>

<main class="aanbod-page">
    <div class="aanbod-container">
        <div class="filters-sidebar">
            <form id="filter-form" method="get" action="/ons-aanbod">
                <div class="filter-section">
                    <h3>TYPE</h3>
                    <div class="filter-options filter-options-modern">
                        <?php 
                        // Haal de geselecteerde filters op
                        $selectedFilters = isset($_GET['filters']) ? $_GET['filters'] : [];
                        
                        // Als de bedrijfswagen filter is toegepast, zorg dat SUV automatisch is geselecteerd
                        if (isset($_GET['type']) && $_GET['type'] === 'bedrijfswagen') {
                            $selectedFilters[] = 'SUV';
                        }
                        // Als de reguliere auto filter is toegepast, selecteer alle types behalve SUV
                        elseif (isset($_GET['type']) && $_GET['type'] === 'regular') {
                            $selectedFilters = ['Sport', 'Sedan', 'Hatchback'];
                        }
                        
                        // Definieer alle beschikbare autotypes met iconen
                        $autoTypes = [
                            'Sport' => ['label' => 'Sport'],
                            'SUV' => ['label' => 'SUV'],
                            'Sedan' => ['label' => 'Sedan'],
                            'Hatchback' => ['label' => 'Hatchback'],
                        ];
                        
                        // Genereer checkboxes voor elk autotype
                        foreach ($autoTypes as $value => $data): ?>
                            <label class="filter-option-modern">
                                <input type="checkbox" 
                                       id="type-<?= strtolower($value) ?>" 
                                       name="filters[]" 
                                       value="<?= $value ?>" 
                                       class="car-type-filter"
                                       <?= in_array($value, $selectedFilters) ? 'checked' : '' ?>>
                                <span class="custom-checkbox-modern"></span>
                                <span class="filter-label-text"><?= $data['label'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="filter-actions" style="margin-top: 20px;">
                    <button type="submit" class="button-primary">Filters toepassen</button>
                    <a href="/ons-aanbod" class="button-secondary" style="margin-top: 10px; display: inline-block;">Reset filters</a>
                </div>
            </form>
        </div>

        <div class="car-listings">
            <div class="listings-header">
                <h2>Ons Aanbod</h2>
                <div class="search-container">
                    <form action="" method="get" class="search-form">
                        <input type="text" name="search" placeholder="Zoek op merk, type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                        <?php 
                        // Als er filters zijn geselecteerd, behoud deze in de zoekopdracht
                        if (isset($_GET['filters']) && is_array($_GET['filters'])) {
                            foreach ($_GET['filters'] as $filter) {
                                echo "<input type='hidden' name='filters[]' value='" . htmlspecialchars($filter) . "'>";
                            }
                        }
                        // Behoud type filter als die aanwezig is
                        if (isset($_GET['type'])) {
                            echo "<input type='hidden' name='type' value='" . htmlspecialchars($_GET['type']) . "'>";
                        }
                        ?>
                    </form>
                </div>
            </div>

            <div class="car-grid">
                <?php
                // Include database connection
                require_once __DIR__ . "/../database/connection.php";
                
                try {
                    // Get current user ID if logged in
                    $currentUserId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

                    // Initiële status van checkboxes instellen op basis van query parameters
                    $selectedFilters = isset($_GET['filters']) ? $_GET['filters'] : [];
                    
                    // Check of we een type filter hebben vanuit de URL (voor de knoppen op de homepage)
                    $typeFilter = isset($_GET['type']) ? $_GET['type'] : null;
                    
                    // Zoekterm ophalen
                    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
                    
                    // Parameterarray voor prepared statements
                    $params = [];
                    $conditions = [];

                    // Base SELECT statement including like status if user is logged in
                    $selectClause = "SELECT c.*";
                    if ($currentUserId) {
                        $selectClause .= ", (
                            SELECT cl.like_status 
                            FROM car_likes cl 
                            WHERE cl.car_id = c.id AND cl.user_id = :current_user_id
                        ) as user_has_liked";
                    } else {
                        $selectClause .= ", 0 as user_has_liked"; // Default to not liked if user not logged in
                    }
                    
                    // SQL samenstellen
                    if ($typeFilter === 'bedrijfswagen') {
                        // Voor bedrijfswagens, toon alleen SUVs
                        $conditions[] = "type = 'SUV'";
                    } else if ($typeFilter === 'regular') {
                        // Voor reguliere auto's, toon alles behalve SUVs
                        $conditions[] = "type != 'SUV'";
                    } else if (!empty($selectedFilters)) {
                        // Filters vanuit de checkbox sidebar
                        $placeholders = str_repeat('?,', count($selectedFilters) - 1) . '?';
                        $conditions[] = "type IN ($placeholders)";
                        $params = array_merge($params, $selectedFilters);
                    }
                    
                    // Zoekconditie toevoegen als er een zoekterm is
                    if (!empty($searchTerm)) {
                        $searchCondition = "(brand LIKE ? OR type LIKE ? OR description LIKE ?)";
                        $conditions[] = $searchCondition;
                        $params[] = "%$searchTerm%";
                        $params[] = "%$searchTerm%";
                        $params[] = "%$searchTerm%";
                    }
                    
                    // Query samenstellen
                    $sqlBase = $selectClause . " FROM cars c";

                    if (!empty($conditions)) {
                        $whereClause = " WHERE " . implode(" AND ", $conditions);
                        $sql = $sqlBase . $whereClause;
                    } else {
                        $sql = $sqlBase;
                    }
                    
                    $stmt = $conn->prepare($sql);

                    // Bind the named placeholder for the subquery in SELECT, if user is logged in
                    if ($currentUserId) {
                        $stmt->bindParam(':current_user_id', $currentUserId, PDO::PARAM_INT);
                    }

                    // Execute the statement with the array of positional parameters for the WHERE clause
                    // The $params array was already built to contain values for all '?' placeholders from filters and search
                    $stmt->execute($params);
                    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "<div class='message'>Database error: " . $e->getMessage() . "</div>";
                    $cars = [];
                }

                foreach ($cars as $car) :
                ?>
                <div class="car-card">
                    <div class="car-header">
                        <div class="car-info">
                            <h3><?= $car['brand'] ?></h3>
                            <span class="car-type"><?= $car['type'] ?></span>
                        </div>
                        <button class="like-toggle-button" data-car-id="<?= $car['id'] ?>" title="Like this car">
                            <i class="fa <?= (isset($car['user_has_liked']) && $car['user_has_liked'] == 1) ? 'fa-heart liked' : 'fa-heart-o' ?>"></i>
                            <span class="like-count"><?= '' // We can fetch and display total likes later if needed ?></span>
                        </button>
                    </div>
                    <div class="car-image">
                        <img src="/assets/images/products/<?= $car['main_image'] ?>" alt="<?= $car['brand'] ?>">
                    </div>
                    <div class="car-specs">
                        <div class="spec-item">
                            <img src="assets/images/icons/gas-station.svg" alt="Brandstof">
                            <span><?= $car['gasoline'] ?></span>
                        </div>
                        <div class="spec-item">
                            <img src="assets/images/icons/car.svg" alt="Handmatig">
                            <span><?= $car['steering'] ?></span>
                        </div>
                        <div class="spec-item">
                            <img src="assets/images/icons/profile-2user.svg" alt="Personen">
                            <span><?= $car['capacity'] ?></span>
                        </div>
                    </div>
                    <div class="car-footer">
                        <div class="price">
                            <span class="amount">€<?= number_format((float)$car['price'], 2, ',', '.') ?></span>
                            <span class="period">/dag</span>
                        </div>
                        <a href="/car-detail?id=<?= $car['id'] ?>" class="rent-now-btn">Huur Nu</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<style>
    /* Zoekbalk styling */
    .listings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .search-container {
        margin-left: auto;
    }
    
    .search-form {
        display: flex;
        position: relative;
    }

    .search-input {
        padding: 10px 15px;
        border: 1px solid #D1D5DB; /* Tailwind gray-300 */
        border-radius: 8px; /* Tailwind rounded-lg */
        font-size: 1rem;
        width: 300px; /* Adjust as needed */
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #2563EB; /* Tailwind blue-600 */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3); /* Tailwind ring-blue-500 */
    }

    .search-button {
        background-color: #2563EB; /* Tailwind blue-600 */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        margin-left: -1px; /* Overlap border */
        transition: background-color 0.3s;
    }

    .search-button:hover {
        background-color: #1D4ED8; /* Tailwind blue-700 */
    }

    /* Responsieve styling */
    @media (max-width: 768px) {
        .listings-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .search-container {
            width: 100%;
            margin-top: 15px;
            margin-left: 0;
        }
        
        .search-form .search-input {
            width: 100%;
        }
        .search-form .search-button {
             border-radius: 0 8px 8px 0; /* Ensure button keeps its shape */
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-toggle-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent any default button action if it's in a form
            const carId = this.dataset.carId;
            const icon = this.querySelector('i');

            // Check if user is logged in (simple check, more robust might be needed)
            <?php if (!$currentUserId): ?>
            // Redirect to login or show message if user is not logged in
            // For now, let's assume login is required and this button might not even show or be disabled.
            // If it does show and is clickable, you might want to redirect to login page.
            // alert('Please log in to like cars.');
            // window.location.href = '/login.php'; // Example redirect
            // return; // Stop if not logged in and client-side check is desired
            <?php endif; ?>

            fetch('/actions/toggle_like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'car_id=' + encodeURIComponent(carId)
            })
            .then(response => {
                if (!response.ok) {
                    // Try to parse error if server sent JSON error response
                    return response.json().then(err => { 
                        throw new Error(err.message || 'Server error: ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.liked) {
                        icon.classList.remove('fa-heart-o');
                        icon.classList.add('fa-heart', 'liked');
                    } else {
                        icon.classList.remove('fa-heart', 'liked');
                        icon.classList.add('fa-heart-o');
                    }
                    // Update like count if you implement it in toggle_like.php and HTML
                    // const likeCountSpan = this.querySelector('.like-count');
                    // if (likeCountSpan && data.total_likes !== undefined) {
                    //    likeCountSpan.textContent = data.total_likes > 0 ? data.total_likes : '';
                    // }
                } else {
                    // Display message from server (e.g., 'User not logged in', 'Invalid car ID')
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Toggle like error:', error);
                alert('An error occurred: ' + error.message + '. Please try again.');
            });
        });
    });
});
</script>

<?php require __DIR__ . "/../includes/footer.php" ?>
