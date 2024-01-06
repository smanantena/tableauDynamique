<?php
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$requestURI = $_SERVER['REQUEST_URI'];
$uri_pattern_page = '/products-page\?page=\d+/';
if (preg_match($uri_pattern_page, $requestURI)) {
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsPage.php';
    
} else {

    switch ($requestURI) {
        case '/index.php':
            header('Location:/');
            break;
        case '/':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews.php';
            break;
        case '/not-found':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'notFoundPage.php';
            break;
        case '/sort?sort-by=id&direction=asc':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsSortById.php';
            break;
        case '/sort?sort-by=id&direction=desc':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsSortById.php';
            break;
        case '/sort?sort-by=name&direction=asc':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsSortByName.php';
            break;
        case '/sort?sort-by=name&direction=desc':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsSortByName.php';
            break;
        case '/products-page?page=1':
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'productsViews' . DIRECTORY_SEPARATOR . 'productsViewsPage.php';
            break;
    
        default:
            header('Location:/not-found');
            break;
    }
}
