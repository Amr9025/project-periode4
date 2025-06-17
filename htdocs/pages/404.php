<?php 
require_once __DIR__ . '/../includes/header.php'; 
http_response_code(404);
?>

<main style="text-align: center; padding: 50px;">
    <h1>404 - Pagina Niet Gevonden</h1>
    <p>Sorry, de pagina die je zoekt bestaat niet of is verplaatst.</p>
    <p><a href="/" class="button-primary">Terug naar de homepage</a></p>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
