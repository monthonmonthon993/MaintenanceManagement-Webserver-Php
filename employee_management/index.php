<?php 
session_start();
require_once("../authentication.php");

if (check_authentication()) {
	require_once("../database_connection/db_connect.php");

	$sql = "SELECT * FROM employee";
	$result = $conn->query($sql);	
?>
<html>
<head>
	<link href="./css/index.css" rel="stylesheet" type="text/css" />
	<title>Employee</title>
</head>
<body>
	<ul>
  		<li><a href="index.php">Home</a></li>
		<li><a href="../machine_management/machine.php">Machine</a></li>
  		<li style="float:right"><a href="./php_action/logout.php" onclick="return confirm('Are you sure to logout?')">Log out</a></li>
		<li class="idname">User ID: <i class="user"><?php echo $_SESSION["employee"]["userid"] . "</i> Username: <i class='user'>" . $_SESSION["employee"]["username"]?></i></li>
	</ul>

	<div class="button_link"><a href="create_employee_form.php">Add New</a></div>
	<table class="tbl-qa">	
		<thead>
			 <tr>
			 	<th class="table-header" width="5%"> Userimage </th>
				<th class="table-header" width="5%"> Userid </th>
				<th class="table-header" width="5%"> Username </th>
				<th class="table-header" width="5%"> Password </th>
				<th class="table-header" width="5%"> Department </th>
				<th class="table-header" width="5%" colspan="2">Action</th>
			  </tr>
		</thead>
		<tbody>		
			<?php
				if ($result->num_rows > 0) {		
					while($row = $result->fetch_assoc()) {
			?>
			<tr>
        		<td class="table-row"><img id="emp_image" src="../assets/emp_images/<?php echo $row["emp_image"];?>" width="75" alt="<?php echo $row["username"]; ?>" /></td>
				<td class="table-row"><?php echo $row["userid"]; ?></td> 
				<td class="table-row"><?php echo $row["username"]; ?></td>
				<td class="table-row"><?php echo $row["password"]; ?></td>
				<td class="table-row"><?php echo $row["department"]; ?></td>
				<!-- action -->
				<td class="table-row" colspan="2"><a href="update_employee_form.php?id=<?php echo $row["id"]; ?>" class="link"><img title="Edit" src="icon/edit.png"/></a> <a href="./php_action/delete_employee.php?id=<?php echo $row["id"]; ?>" class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png"/></a></td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</body>
</html>
<?php } else {
	echo '<script language="javascript">';
	echo 'alert("PLEASE LOGIN.");';
	echo 'window.location = "./login.php"';
	echo '</script>';
} ?>