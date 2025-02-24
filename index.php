<?php

require "./vendor/autoload.php";

use App\Config\Database;

try {
    $db = Database::connect();

    echo "Connected successfully";
    
} catch (Exception $e) {
    echo $e->getMessage();
}
