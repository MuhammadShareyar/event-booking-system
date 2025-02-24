<?php

require "./vendor/autoload.php";

use App\Config\Database;
use App\Controllers\BookingController;

function generateCsrfToken()
{
    return bin2hex(random_bytes(32));
}

session_start();

if (!isset($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = generateCsrfToken();
}


try {
    $db = Database::connect();

    $request = $_SERVER['REQUEST_METHOD'];

    $bookingController = new BookingController();

    if ($request === 'POST') {

        $bookingController->import();
        header('Location: index.php');
        exit;
    } else if ($request === 'GET') {

        $bookings = $bookingController->index();

        require_once "./app/Views/index.php";
    }
    
} catch (Exception $e) {
    echo $e->getMessage();
}
