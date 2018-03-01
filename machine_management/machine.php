<?php 
session_start();
require_once("../authentication.php");

if (check_authentication()) {
	require_once("../database_connection/db_connect.php");

	$sql = "SELECT * FROM machine";
	$result = $conn->query($sql);	
    $conn->close();
?>
<html>
<head>
	<link href="../employee_management/css/index.css" rel="stylesheet" type="text/css" />
	<title>Machine</title>
</head>
<body>
	<ul>
  		<li><a href="../employee_management/index.php">Home</a></li>
		<li><a href="#">Machine</a></li>
  		<li style="float:right"><a href="../employee_management/php_action/logout.php" onclick="return confirm('Are you sure to logout?')">Log out</a></li>
		<li class="idname">User ID: <i class="user"><?php echo $_SESSION["employee"]["userid"] . "</i> Username: <i class='user'>" . $_SESSION["employee"]["username"]?></i></li>
	</ul>

	<div class="button_link"><a href="create_machine_form.php">Add New</a></div>
	<table class="tbl-qa">	
		<thead>
			 <tr>
				<th class="table-header" width="5%"> Image </th>
			 	<th class="table-header" width="5%"> Name </th>
				<th class="table-header" width="5%"> Code </th>
				<th class="table-header" width="5%" colspan="2">Action</th>
			  </tr>
		</thead>
		<tbody>		
			<?php
				if ($result->num_rows > 0) {		
					while($row = $result->fetch_assoc()) {
			?>
			<tr>
                <td class="table-row"><img id="mch_image" src="../assets/machine_images/machine_images/<?php echo $row["image_machine"];?>" width="75" alt="<?php echo $row["name_machine"]; ?>" /></td>
				<td class="table-row"><a href="machine_detail.php?image_detail=<?php echo $row['image_detail']; ?>&amp;id_machine=<?php echo $row["id_machine"]; ?>"><?php echo $row["name_machine"]; ?></a></td> 
				<td class="table-row"><?php echo $row["code_machine"]; ?></td>
				<td class="table-row" colspan="2"><a href="update_machine_form.php?id_machine=<?php echo $row["id_machine"]; ?>" class="link"><img title="Edit" src="icon/edit.png"/></a> <a href="./php_action/delete_machine.php?id_machine=<?php echo $row["id_machine"]; ?>" class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png"/></a></td>
			</tr>
            <?php } } ?>
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
