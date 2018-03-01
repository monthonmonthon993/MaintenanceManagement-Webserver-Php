<?php 
header("Content-Type:application/json");
require "get_data.php";
$id_machine = $_GET["id_machine"];
$datasheet = getDatasheetByMachine($id_machine);
if (!empty($datasheet)) {
    echo json_encode($datasheet);
} else {
    echo "Not found.";
}	
?>