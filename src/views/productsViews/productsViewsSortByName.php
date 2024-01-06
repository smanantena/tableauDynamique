<?php
use App\Database\Queries\AllProductsLimit;
use App\Database\Queries\AllProductsSortedByNameLimit;

try {
    if (strtolower($_GET['direction']) === "desc") {
        $products = AllProductsSortedByNameLimit::execute(20, 'desc', 'name');
    } else {
        $products = AllProductsSortedByNameLimit::execute(20, 'asc', 'name');
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
        if (strtolower($_GET['direction']) === 'asc') {
            echo '<th scope="col"><a class="link-asc link-sort-muted" href="/sort?sort-by=id&direction=desc">id</a></th><th scope="col"><a class="link-asc" href="/sort?sort-by=name&direction=desc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        } else {
            echo '<th scope="col"><a class="link-asc link-sort-muted" href="/sort?sort-by=id&direction=desc">id</a></th><th scope="col"><a class="link-desc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';

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
        echo '</article>';
        echo '</div>';
        echo '</main>';
        $pageContent = ob_get_clean();
    }
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
