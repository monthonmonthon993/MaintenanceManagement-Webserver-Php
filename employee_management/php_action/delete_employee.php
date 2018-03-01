<?php 
    require_once("../../database_connection/db_connect.php");
	
	$sql = $conn->prepare("DELETE FROM employee WHERE id=?");  
	$sql->bind_param("i", $_GET["id"]); 
	$sql->execute();
	$sql->close(); 
	$conn->close();
	echo '<script language="javascript"> window.location = "../index.php"</script>';	
?>