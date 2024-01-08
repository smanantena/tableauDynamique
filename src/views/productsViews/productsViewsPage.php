<?php
require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Database\Queries\AllProducts;
use App\Views\ProductsViews\ProductsViewsGenerator;

try {
    $keywords = null;
    $pageNumber = 1;
    $limit = AllProducts::LIMIT_OF_PRODUCT_REGISTER;
    $offset = 0;
    
    $sort = 'id';
    $direction = 'asc';
    
    if (isset($_GET['keywords'])) {
        $keywords = htmlentities($_GET['keywords']);
    }

    if (isset($_GET['page'])) {
        if (is_int(intval(htmlentities($_GET['page'])))) {
            $pageNumber = intval(htmlentities($_GET['page']));
        }
    }

    

    if (isset($_GET['sort'])) {
        $sort = htmlentities($_GET['sort']);
    }

    if (isset($_GET['dir'])) {
        $direction = htmlentities($_GET['dir']);
    }

    $products = AllProducts::products(null, null, $keywords);
    $productsNumber = ( is_array($products) ) ? count( $products ) : 0 ;
    $offset = ( (($pageNumber - 1) * 20) < $productsNumber ) ? (($pageNumber - 1) * 20) : 0 ;
    
    $products = AllProducts::products($limit, $offset, $keywords, $sort, $direction);
    
   

} catch (Exception $e) {

}

if (isset($products)) {
    if (is_array($products) && count($products)) {
        
        $pageTitle = 'Products list';
        ob_start();
        echo "<main>";
        echo '<div class="container">';
        echo '<article>';
        echo '<h1>Products</h1>';
        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="1">';
        echo '<input class="form-controls" type="text" name="keywords" id="keywords" placeholder="Keywords that you search." value="' . ($keywords ?? '') . '">';
        echo '<button class="btn form-controls" type="submit">Submit</button>';
        if ($keywords) {
            echo '<a class="btn form-controls" href="/">Clear</a>';
        }
        echo '</form>';
        echo '<section class="py-1">';
        echo "<h2>Number of product : {$productsNumber}</h2>";
        echo "<p>This is the page n°<strong>" . ($_GET['page'] ?? 1) . "</strong><em> /" . (($productsNumber / 20 > floor($productsNumber / 20)) ? ceil($productsNumber / 20) : $productsNumber / 20) . "</em></p>";
        echo '</section>';
        echo '<table>';
        echo '<thead>';
        if (isset($_GET['dir'])) {

            if (strtolower($_GET['dir']) === 'desc') {
                $directionLink = 'asc';
            } else {
                $directionLink = 'desc';
            }
        }
        echo '<th scope="col">';
        echo  ProductsViewsGenerator::filterLink($direction, 'id', $sort, $keywords);
        echo '</th>';
        echo '<th scope="col">';
        echo  ProductsViewsGenerator::filterLink($direction, 'name', $sort, $keywords);
        echo '</th>';
        echo '<th scope="col">';
        echo  ProductsViewsGenerator::filterLink($direction, 'price', $sort, $keywords);
        echo '</th>';
        echo '<th scope="col">';
        echo ProductsViewsGenerator::filterLink($direction, 'address', $sort, $keywords);
        echo '</th>';
        echo '<th scope="col">';
        echo ProductsViewsGenerator::filterLink($direction, 'city', $sort, $keywords);
        echo '</th>';

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
            echo "<a class=\"anchor-none-style\" href=\"?page={$i}". ( (isset($keywords)) ? ("&keywords={$keywords}") : null) . ((isset($sort)) ? ("&sort={$sort}") : null) . ((isset($direction)) ? ("&dir={$direction}") : null) ."\"><button class=\"btn btn-primary\">{$i}</button></a>";   
        }
        
        if (floor($productsNumber/20) < $productsNumber/20) {
            echo "<a class=\"anchor-none-style\" href=\"?page=" . ceil($productsNumber/20) . ( (isset($keywords)) ? ("&keywords={$keywords}") : null) . ((isset($sort)) ? ("&sort={$sort}") : null) . ((isset($direction)) ? ("&dir={$direction}") : null) . "\"><button class=\"btn btn-primary\">" . ceil($productsNumber/20) . "</button></a>";
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
        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="1">';
        echo '<input class="form-controls" type="text" name="keywords" id="keywords" placeholder="Keywords that you search." value="' . ($keywords ?? '') . '">';
        echo '<button class="btn form-controls" type="submit">Submit</button>';
        echo '</form>';
        echo '<section class="py-1">';
        echo "<h2>None product have this keywords !</h2>";
        echo "<p><a href=\"/\">Please return to the homepage</a></p>";
        echo '</section>';
        echo '</article>';
        echo '</div>';
        echo '</main>';
        $pageContent = ob_get_clean();
    }
} else {
    ob_start();
    echo '<main>';
    echo '<article>';
    echo '<div class="container">';
    echo '<h1>There are some problems !</h1>';
    echo '<p><a href="/">Please wait. We solve them.</a></p>';
    echo '</div>';
    echo '</article>';
    echo '</main>';
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
