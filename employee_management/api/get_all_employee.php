<?php
header("Content-Type:application/json");
require "get_data.php";
$employee = getAllEmployee();	
if (!empty($employee)) {
    echo json_encode($employee);
} else {
    echo "Not found.";
}	
?>