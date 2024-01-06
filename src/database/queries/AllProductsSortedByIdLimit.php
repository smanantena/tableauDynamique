<?php
namespace App\Database\Queries;
require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PDO;
use Exception;
use App\Database\Database;

class AllProductsSortedByIdLimit
{
    
    /**
     * Return list of products that match of critary
     *
     * @param   int     $limit  Define limit of products to render, must greater than 0
     * @param   string  $order  critary for order = asc, desc
     * @param   string  $sort   Row for sort = id, name, price, address, city
     *
     * @return  array           This is the list of products result
     */
    public static function execute (int $limit = 0, string $order = 'asc') : ?array
    {
        try {
            $PDO = Database::connect();
            if (strtoupper($order) === 'DESC') {
                if ($limit > 0) {
                    $query = $PDO->prepare('SELECT * FROM products ORDER BY id DESC LIMIT :limit;');
                    
                    $query->execute([
                        "limit" => $limit
                    ]);
                } else {
                    $query = $PDO->query('SELECT * FROM products ORDER BY id DESC;');
                    
                }
            } else {
                if ($limit > 0) {
                    $query = $PDO->prepare('SELECT * FROM products ORDER BY id ASC LIMIT :limit;');
                    $query->execute([
                        "limit" => $limit
                    ]);
                } else {
                    $query = $PDO->query('SELECT * FROM products ORDER BY id ASC;');
            
                }
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
        
        }
    }
}
