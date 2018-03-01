<?php
header("Content-Type:application/json");
require "get_data.php";
$yearly = getAllYearly();
if (!empty($yearly)) {
    echo json_encode($yearly);
} else {
    echo "Not found.";
}	
?>