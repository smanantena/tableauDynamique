<?php
namespace App\Database\Queries;

use PDO;
use Exception;
use App\Database\Database;

require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

class AllProducts
{
    public const LIMIT_OF_PRODUCT_REGISTER = 20;
    
    public static function numberOfProducts () : int
    {
        try {

            $PDO = Database::connect();
            $query = $PDO->query("SELECT id FROM products;");
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception) {}

        return count($products);
    }

    /**
     * Products
     *
     * @param   int     $offset          number of ignored register
     * @param   string  $productsSearch  the keywords that user search
     * @param   string  $sort            sort method for sql SORT statement
     * @param   id                       default value of sort method
     * @param   string  $direction       direction method for sql ORDER BY statement
     * @param   asc                      default value of direction method
     *
     * @return  array                    list of products
     */
    public static function products (?int $limit, ?int $offset = 0, ?string $productsSearch = null , ?string $sort = 'id', ?string $direction = 'ASC') : ?array
    {
        try {

            $PDO = Database::connect();
            $direction = strtoupper($direction);
            $query_str = "SELECT * FROM products ORDER BY {$sort} {$direction}";
                        
            if (!is_null($productsSearch)) {
                $productsSearchTemp = htmlentities($productsSearch);
                $query_str = "SELECT * FROM products WHERE name LIKE '%{$productsSearchTemp}%' OR address LIKE '%{$productsSearchTemp}%' OR city LIKE '%{$productsSearchTemp}%' ORDER BY {$sort} {$direction}";
            }

            if (!is_null($limit)) {
                $query_str = $query_str . " LIMIT {$limit} OFFSET {$offset}";
            }

            
            $query = $PDO->query($query_str);
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception) {}

        return $products ?? null;
    }

    public static function productsSearch (string $keywords) : ?array
    {
        try {

            $PDO = Database::connect();
            $query = $PDO->prepare("SELECT * FROM products WHERE name LIKE :name OR city LIKE :city OR address LIKE :address;");
            $query->execute([
                "name" => "%{$keywords}%",
                "city" => "%{$keywords}%",
                "address" => "%{$keywords}%"
            ]);
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception) {}

        return $products ?? null;
    }
}
