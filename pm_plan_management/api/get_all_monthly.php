<?php
header("Content-Type:application/json");
require "get_data.php";
$monthly = getAllMonthly();
if (!empty($monthly)) {
    echo json_encode($monthly);
} else {
    echo "Not found.";
}	
?>