<?php

use App\Database\Queries\AllProducts;
use App\Database\Queries\AllProductsSortedByIdLimit;

session_start();
try {
    if (isset($_POST['keywords']) || isset($_SESSION['keywords'])) {
        if (isset($_POST['keywords'])) {
            $_SESSION['keywords'] =  htmlentities($_POST['keywords']);
        }
        $keywords = $_SESSION['keywords'];
        $products = AllProducts::productsSearch($keywords);
        $productsNumber = (is_array($products)) ? count($products) : 0 ;
    } else {
        $products = AllProductsSortedByIdLimit::execute();
        $productsNumber = AllProducts::numberOfProducts();
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
        echo '<h1>Products</h1>';
        echo '<form method="post">';
        echo '<input class="form-controls" type="text" name="keywords" id="keywords" placeholder="Keywords that you search." value="' . ($keywords ?? '') . '">';
        echo '<button class="btn form-controls" type="submit">Submit</button>';
        echo '</form>';
        echo '<section class="py-1">';
        echo "<h2>Number of product : {$productsNumber}</h2>";
        echo "<p>This is the page n°<strong>" . ($_GET['page'] ?? 1) . "</strong><em> /" . (($productsNumber / 20 > floor($productsNumber / 20)) ? ceil($productsNumber / 20) : $productsNumber / 20) . "</em></p>";
        echo '</section>';
        echo '<table>';
        echo '<thead>';
        if (strtolower($_GET['direction']) === 'desc') {
            echo '<th scope="col"><a class="link-asc" href="/sort?sort-by=id&direction=asc">id</a></th><th scope="col"><a class="link-sort-muted link-asc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        } else {
            echo '<th scope="col"><a class="link-desc" href="/sort?sort-by=id&direction=desc">id</a></th><th scope="col"><a class="link-sort-muted link-asc" href="/sort?sort-by=name&direction=asc">name</a></th><th scope="col">price</th><th scope="col">address</th><th scope="col">city</th>';
        }
        echo '</thead>';
        echo '<tbody>';
        if (isset($_GET['page'])) {
            $page = intval($_GET['page']);
            $pageMax = ($productsNumber / 20 > floor($productsNumber / 20)) ? ceil($productsNumber / 20) : $productsNumber / 20 ;
            if ($page > $pageMax) {
                header('Location:/');
            }
        } else {
            $page = 1;
        }
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
    } else {
        ob_start();
        echo "<main>";
        echo '<div class="container">';
        echo '<article>';
        echo '<h1>Products</h1>';
        echo '<form method="post">';
        echo '<input class="form-controls" type="text" name="keywords" id="keywords" placeholder="Keywords that you search." value="' . ($keywords ?? '') . '">';
        echo '<button class="btn form-controls" type="submit">Submit</button>';
        echo '</form>';
        echo '<section class="py-1">';
        echo "<h2>None product have this keywords !</h2>";
        echo "<p><a href=\"/\">Please return to the homepage</a></p>";
        echo '</section>';
        echo '</main>';
        $pageContent = ob_get_clean();
        unset($keywords, $_SESSION['keywords'], $_POST['keywords']);
    }
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
