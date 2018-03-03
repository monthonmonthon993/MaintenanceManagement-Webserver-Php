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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <title>Machine</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<ul class="navbar-nav  mr-auto">
  	  <li class="nav-item">
		<a class="nav-link" href="../employee_management/index.php">Employee</a>
	  </li>
	  <li class="nav-item active">
	    <a class="nav-link" href="machine.php">Machine</a>
	  </li>
	</ul>
	<span class="navbar-text">User ID: <?php echo $_SESSION["employee"]["userid"] . " - Username: " . $_SESSION["employee"]["username"]?></span>
	<ul class="navbar-nav ml-auto">
  	  <li class="nav-item">
		<a class="nav-link" href="./php_action/logout.php" onclick="return confirm('Are you sure to logout?')"> Log out </a>
	  </li>
	</ul>
	<form class="form-inline my-2 my-lg-0" action="create_machine_form.php">
	  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Add new</button>
	</form>
  </nav>

  <table class="table">	
    <thead thead-light>
	  <tr>
		<th scope="col" width="5%"> Image </th>
		<th scope="col" width="5%"> Name </th>
		<th scope="col" width="5%"> Code </th>
		<th scope="col" width="5%" colspan="2">Action</th>
	  </tr>
	</thead>
	<tbody>		
			<?php
				if ($result->num_rows > 0) {		
					while($row = $result->fetch_assoc()) {
			?>
			<tr>
                <td><img id="mch_image" src="../assets/machine_images/machine_images/<?php echo $row["image_machine"];?>" width="75" alt="<?php echo $row["name_machine"]; ?>" /></td>
				<td><a href="machine_detail.php?image_detail=<?php echo $row['image_detail']; ?>&amp;id_machine=<?php echo $row["id_machine"]; ?>"><?php echo $row["name_machine"]; ?></a></td> 
				<td><?php echo $row["code_machine"]; ?></td>
				<td colspan="2"><a class="btn btn-primary" role="button" href="update_machine_form.php?id_machine=<?php echo $row["id_machine"]; ?>" class="link">Edit</a> <a class="btn btn-danger" role="button" href="./php_action/delete_machine.php?id_machine=<?php echo $row["id_machine"]; ?>" class="link" onclick="return confirm('Are you sure you want to delete?')"/>Delete</a></td>
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
