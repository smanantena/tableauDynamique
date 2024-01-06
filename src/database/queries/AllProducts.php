<?php
namespace App\Database\Queries;

use PDO;
use Exception;
use App\Database\Database;

require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

class AllProducts
{
    
    public static function numberOfProducts () : int
    {
        try {

            $PDO = Database::connect();
            $query = $PDO->query("SELECT id FROM products;");
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception) {}

        return count($products);
    }

    public static function products () : ?object
    {
        try {

            $PDO = Database::connect();
            $query = $PDO->query("SELECT * FROM products;");
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception) {}

        return $products ?? null;
    }
}
