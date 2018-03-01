<?php 
    require_once("../../database_connection/db_connect.php");
	
	$sql = $conn->prepare("DELETE FROM machine WHERE id_machine=?");  
	$sql->bind_param("i", $_GET["id_machine"]); 
	$sql->execute();
	$sql->close(); 
	$conn->close();
	echo '<script language="javascript"> window.location = "../machine.php"</script>';	
?>