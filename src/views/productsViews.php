<?php
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Database\Database;
use App\Database\Queries\AllProducts;
use App\Database\Queries\AllProductsLimit;
use App\Database\Queries\AllProductsSortedByIdLimit;

$pageTitle = 'Products lists';

$products = AllProductsSortedByIdLimit::execute(20);
$productsNumber = AllProducts::numberOfProducts();

if (isset($products)) {
    if (is_array($products) && count($products)) {
        ob_start();
        echo '<main>';
        echo '<div class="container">';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col"><a class="link-asc" href="/sort?sort-by=id&direction=asc">id</a></th><th scope="col"><a class="link-asc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($products as $product) {
            echo '<tr>';
                echo "<td>{$product['id']}</td><td>{$product['name']}</td><td>\$ {$product['price']}</td><td>{$product['address']}</td><td>{$product['city']}</td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<section id="pagination-section">';
        
        for ($i = 1 ; $i <= $productsNumber/20 ; $i++) {
            echo "<a class=\"anchor-none-style\" href=\"/products-page?page={$i}\"><button class=\"btn btn-primary\">{$i}</button></a>";   
        }
        
        if (floor($productsNumber/20) < $productsNumber/20) {
            echo "<a class=\"anchor-none-style\" href=\"/products-page?page=" . ceil($productsNumber/20) . "\"><button class=\"btn btn-primary\">" . ceil($productsNumber/20) . "</button></a>";
        }
        echo '</section>';
        echo '</div>';
        echo '</main>';
        $pageContent = ob_get_clean();
    }
}

require_once 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
