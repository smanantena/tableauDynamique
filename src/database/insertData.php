<?php
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Database\Database;


$faker = Faker\Factory::create();
$PDO = Database::connect();
$query = $PDO->prepare('INSERT INTO products (name, price, address, city) VALUES (:name, :price, :address, :city)');

for ($i = 1; $i <= 1005 ; $i++) {
    $query->execute([
        'name' => $faker->name,
        'address' => $faker->address,
        'city' => $faker->city,
        'price' => $faker->ean8,
    ]);
}
