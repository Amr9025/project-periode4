<?php

/**
 * Dit bestand is een héél belangrijk bestand van je applicatie.
 * Alle websitebezoeken komen eerst binnen via deze index.php.
 * Dit bestand gaat vervolgens kijken voor welke pagina de bezoeker komt.
 *
 * Stel: een bezoeker komt binnen op localhost/rental/auto-huren,
 * dan zoekt dit bestand in de 'pages'-folder het bestand auto-huren.php.
 *
 * Waarom doen we dit?
 *  - We krijgen er mooiere URL’s door (auto-huren in plaats van auto-huren.php).
 *  - We kunnen hier één keer logica schrijven voor “wat als de pagina niet bestaat”.
 *  - (Buiten het niveau van dit project) We kunnen ook hier logica toevoegen
 *    om te controleren of iemand is ingelogd, in plaats van dat per pagina te herhalen.
 *
 * Deze manier van je verzoeken afhandelen heet zogenaamd de 'front-controller pattern' en dit is daar een eenvoudige versie van.
 *
 *  Deze comment mág je verwijderen nadat je het hebt gelezen.
 */


$requestUri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($requestUri, PHP_URL_PATH), '/');

if ($path === 'logout') {
    require_once __DIR__ . '/actions/logout.php';
    exit;
}


if ($path === 'register-handler') {
    require_once __DIR__ . '/actions/register.php';
    exit;
}

if ($path === 'add-review') {
    require_once __DIR__ . '/actions/add-review.php';
    exit;
}

if ($path === 'toggle-like') {
    require_once __DIR__ . '/actions/toggle-like.php';
    exit;
}

if ($path === 'admin/edit-car') {
    require_once __DIR__ . '/pages/edit-car.php';
    exit;
}

if ($path === 'admin') {
    require_once __DIR__ . '/pages/admin.php';
    exit;
}

if ($path === 'account') {
    require_once __DIR__ . '/pages/account.php';
    exit;
}

if ($path === 'update-account') {
    require_once __DIR__ . '/actions/update-account.php';
    exit;
}

if ($path === 'create-reservation') {
    require_once __DIR__ . '/actions/create-reservation.php';
    exit;
}

if ($path === 'my-reservations') {
    require_once __DIR__ . '/pages/my-reservations.php';
    exit;
}

if ($path === 'hulp') {
    require_once __DIR__ . '/pages/hulp.php';
    exit;
}

if ($path === 'onze-visie') {
    require_once __DIR__ . '/pages/onze-visie.php';
    exit;
}

if ($path === 'events') {
    require_once __DIR__ . '/pages/events.php';
    exit;
}

if ($path === 'blog') {
    require_once __DIR__ . '/pages/blog.php';
    exit;
}

if ($path === 'podcast') {
    require_once __DIR__ . '/pages/podcast.php';
    exit;
}

$page = $path ?: 'home';
$file = __DIR__ . '/pages/' . $page . '.php';

if (file_exists($file)) {
    include $file;
} else {
    http_response_code(404);
    include __DIR__ . '/pages/404.php';
}
