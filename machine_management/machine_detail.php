<?php
session_start();
require_once("../authentication.php");

if (check_authentication()) {
		require_once("../database_connection/db_connect.php");
		$detail_machine = $_GET["image_detail"];
		$id_machine = $_GET["id_machine"];
		$sql_mac = "SELECT * FROM machine WHERE id_machine=$id_machine";
		$result_mac = $conn->query($sql_mac);	
		if ($result_mac->num_rows > 0) {
				$row = $result_mac->fetch_assoc();
				$_SESSION["machine"] = $row;
		}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>detail machine</title>
<style>

</style>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
	  <li class="nav-item">
	    <a class="nav-link" href="../employee_management/index.php">Home</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="machine.php">Machine</a>
	  </li>
	</ul>  
	<ul class="navbar-nav ml-auto">
	  <span class="navbar-text">User ID: <?php echo $_SESSION["employee"]["userid"] . " Username: " . $_SESSION["employee"]["username"]?></span>
	  <li class="nav-item">
	    <a class="nav-link" href="../employee_management/php_action/logout.php" onclick="return confirm('Are you sure to logout?')">Log out</a>
      </li>
	</ul>  
  </nav>
  <figure class="figure">
  	<img class="figure-img img-fluid rounded" src="../assets/machine_images/detail_images/<?php echo $detail_machine; ?>" alt="detail machine">
  </figure>

  <div>
		<form action="./php_action/add_datasheet.php?id_machine=<?php echo $id_machine ?>" method="post" enctype="multipart/form-data" style="border:1px solid #ccc">
  <div class="container">
    <h1>Add Datasheet</h1>
    <hr>
    <div class="responsive">
      <div class="gallery">
        <div class="desc">Select datasheet (PDF) to upload:
          <input type="file" accept=".pdf" name="pdfToUpload" id="pdfToUpload" class="btn btn-file">
        </div>
        <div class="desc">Select datasheet (JPEG) to upload:
          <input type="file"  accept="image/*" name="jpgToUpload" id="jpgToUpload" class="btn btn-file">
        </div>
      </div>
    </div>
    <div>
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" name="submit" class="signupbtn">upload</button>
    </div>
  </div>
</form>
	</div>






  <div class="container">
	<?php
		$sql = $conn->prepare("SELECT * FROM pm_plan_daily WHERE id_machine=?");
		$sql->bind_param("i",$_GET["id_machine"]);
		$sql->execute();
		$result = $sql->get_result();
	?>
    <div class="table-responsive-sm">
	  <table class="table">
	    <div class="row">
		  <div class="col-12 text-center text-primary"><h1>DAILY</h1></div>
	    </div>
	    <thead>
		  <tr>
		    <th scope="col">Id</th>
		    <th scope="col">Datetime</th>
		    <th scope="col">Status</th>
		    <th scope="col">Note</th>
		  </tr>
	    </thead>
		<?php if ($result->num_rows > 0) {		
			$row = $result->fetch_assoc(); ?>
	    <tbody>
		  <tr>
		    <th scope="row"><?php echo $row["id_daily"]; ?></th>
		    <td><?php echo $row["datetime"]; ?></td>
		    <td><?php echo $row["status"]; ?></td>
		    <td><?php echo $row["note"]; ?></td>
		  </tr>
	    </tbody>
		<?php } ?>
	  </table>
	</div>
    <div class="table-responsive-sm">
	  <?php
		$sql = $conn->prepare("SELECT * FROM pm_plan_monthly WHERE id_machine=?");
		$sql->bind_param("i",$_GET["id_machine"]);
		$sql->execute();
		$result = $sql->get_result();
	  ?>
	<table class="table">
	  <div class="row">
		<div class="col-12 text-center text-primary"><h1>MONTHLY</h1></div>
	  </div>
	  <thead>
		<tr>
		  <th scope="col">Id</th>
		  <th scope="col">MONTH</th>
		  <th scope="col">Status</th>
		  <th scope="col">Note</th>
		</tr>
	  </thead>
	    <?php if ($result->num_rows > 0) {		
			$row = $result->fetch_assoc(); ?>
	  <tbody>
		<tr>
		  <th scope="row"><?php echo $row["id_monthly"]; ?></th>
		  <td><?php echo $row["month"]; ?></td>
		  <td><?php echo $row["status"]; ?></td>
		  <td><?php echo $row["note"]; ?></td>
		</tr>
	  </tbody>
		<?php } ?>
	</table>
		</div>
    <div class="table-responsive-sm">
	  <?php
		$sql = $conn->prepare("SELECT * FROM pm_plan_yearly WHERE id_machine=?");
		$sql->bind_param("i",$_GET["id_machine"]);
		$sql->execute();
		$result = $sql->get_result();
	  ?>
	<table class="table">
	  <div class="row">
		<div class="col-12 text-center text-primary"><h1>YEARLY</h1></div>
	  </div>
	  <thead>
		<tr>
		  <th scope="col">Id</th>
		  <th scope="col">Year</th>
		  <th scope="col">Status</th>
		  <th scope="col">Note</th>
		</tr>
	  </thead>
		<?php if ($result->num_rows > 0) {		
			$row = $result->fetch_assoc(); ?>
	  <tbody>
		<tr>
		  <th scope="row"><?php echo $row["id_yearly"]; ?></th>
		  <td><?php echo $row["year"]; ?></td>
		  <td><?php echo $row["status"]; ?></td>
		  <td><?php echo $row["note"]; ?></td>
		</tr>
	  </tbody>
		<?php }
			$conn->close(); ?>
	</table>
		</div>
  </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
<?php } else {
	echo '<script language="javascript">';
	echo 'alert("PLEASE LOGIN.");';
	echo 'window.location = "../employee_management/login.php"';
	echo '</script>';
} ?>
