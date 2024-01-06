<?php

use App\Database\Queries\AllProducts;
use App\Database\Queries\AllProductsSortedByIdLimit;

try {
    $productsNumber = AllProducts::numberOfProducts();
    $products = AllProductsSortedByIdLimit::execute();
    
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
        $page = intval($_GET['page']);
        for ($i = 0 + ($page - 1) * 20 ; $i < 20 + ($page - 1) * 20 && $i < $productsNumber ; $i++) {
            echo '<tr>';
            echo "<td>{$products[$i]['id']}</td>";
            echo "<td>{$products[$i]['name']}</td>";
            echo "<td>{$products[$i]['price']}</td>";
            echo "<td>{$products[$i]['address']}</td>";
            echo "<td>{$products[$i]['city']}</td>";
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
        echo '</article>';
        echo '</div>';
        echo '</main>';
        $pageContent = ob_get_clean();
    }
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
