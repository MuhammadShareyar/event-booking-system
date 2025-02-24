<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Booking;
use App\Services\ImportJsonService;
use Exception;

class BookingController
{
    // Import JSON file 
    public function import()
    {
        try {


            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('Invalid CSRF token');
            }

            if(($_FILES['json_file']['tmp_name']) == '') {
                throw new Exception('No file uploaded');
            }

            if ($_FILES['json_file']) {
                
                $json = file_get_contents($_FILES['json_file']['tmp_name']);
                $json = json_decode($json, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid JSON file');
                }

                $importJsonService = new ImportJsonService();
                $importJsonService->import($json);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function index()
    {
        $db = Database::connect();
        try {

            $employeeName = $_GET['employee_name'] ?? '';
            $eventName = $_GET['event_name'] ?? '';
            $eventDate = $_GET['event_date'] ?? null;

            $bookings = new Booking($db);
            return $bookings->getAll($employeeName, $eventName, $eventDate);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
