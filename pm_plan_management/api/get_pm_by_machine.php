<?php
header("Content-Type:application/json");
require "get_data.php";
$id_machine = $_GET["id_machine"];
$pm = getPmByMachine($id_machine);
if (!empty($pm)) {
    echo json_encode($pm);
} else {
    echo "Not found.";
}	
?>