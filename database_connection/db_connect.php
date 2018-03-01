<?php

require_once('db_config.php');

$conn = new mysqli($db_server, $db_user, $db_password, $db_database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>