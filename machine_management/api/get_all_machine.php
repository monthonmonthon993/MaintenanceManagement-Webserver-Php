<?php
header("Content-Type:application/json");
require "get_data.php";
$machine = getAllMachine();
if (!empty($machine)) {
    echo json_encode($machine);
} else {
    echo "Not found.";
}	
?>