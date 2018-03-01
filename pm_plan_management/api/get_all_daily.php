<?php
header("Content-Type:application/json");
require "get_data.php";
$daily = getAllDaily();
if (!empty($daily)) {
    echo json_encode($daily);
} else {
    echo "Not found.";
}	
?>