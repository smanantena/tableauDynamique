<?php
namespace App\Database;
use \PDO;
use \Exception;

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

class Database {
    public static function connect () : ?object
    {
        try {
            return new PDO('sqlite:' . dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'data.db');
        } catch (Exception $e) {
            echo 'The database are not yet work.';
        }
    }
}



