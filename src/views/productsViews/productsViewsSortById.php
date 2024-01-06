<?php

use App\Database\Queries\AllProducts;
use App\Database\Queries\AllProductsSortedByIdLimit;

try {
    $productsNumber = AllProducts::numberOfProducts();
    if (strtolower($_GET['direction']) === "desc") {
        $products = AllProductsSortedByIdLimit::execute(20, 'desc', 'id');
    } else {
        $products = AllProductsSortedByIdLimit::execute(20);
    }
} catch (Exception $e) {

}

if (isset($products)) {
    if (is_array($products) && count($products)) {
        $pageTitle = 'Products sorted by id';
        ob_start();
        echo "<main>";
        echo '<div class="container">';
        echo '<article>';
        echo '<table>';
        echo '<thead>';
        if (strtolower($_GET['direction']) === 'desc') {
            echo '<th scope="col"><a class="link-asc" href="/sort?sort-by=id&direction=asc">id</a></th><th scope="col"><a class="link-sort-muted link-asc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        } else {
            echo '<th scope="col"><a class="link-desc" href="/sort?sort-by=id&direction=desc">id</a></th><th scope="col"><a class="link-sort-muted link-asc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        }
        echo '</thead>';
        echo '<tbody>';
        foreach ($products as $product) {
            echo '<tr>';
            echo "<td>{$product['id']}</td>";
            echo "<td>{$product['name']}</td>";
            echo "<td>{$product['price']}</td>";
            echo "<td>{$product['address']}</td>";
            echo "<td>{$product['city']}</td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<section id="pagination-section">';
        for ($i = 1 ; $i <= $productsNumber/20 ; $i++) {
            echo "<a class=\"anchor-none-style\" href=\"/products-page?page={$i}\"><button class=\"btn btn-primary\">{$i}</button></a>";
        }
        
        echo '</section>';
        echo '</article>';
        echo '</div>';
        echo '</main>';
        $pageContent = ob_get_clean();
    }
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
