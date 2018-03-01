<?php
header("Content-Type:application/json");
require "get_data.php";

if(!empty($_GET["name_machine"]))
{
    $name_machine=$_GET["name_machine"];
	$machine = getMachine($name_machine);
	
	if (!empty($machine))
	{
		echo json_encode($machine);
	}
	else
	{
		echo "Not found.";
	}
	
}
else
{
	echo "400" . " Invalid Request";
}
