<?php
header("Content-Type:application/json");
require "get_data.php";

if(!empty($_GET["username"]) && !empty($_GET["password"]))
{
    $username=$_GET["username"];
    $password=$_GET["password"];
	$employee = getEmployee($username, $password);
	
	if (!empty($employee))
	{
		echo json_encode($employee);
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
