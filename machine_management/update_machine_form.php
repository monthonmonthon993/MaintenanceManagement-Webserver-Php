<?php
session_start();
require_once("../authentication.php");
if (check_authentication()) {
    require_once("../database_connection/db_connect.php");
    $sql = $conn->prepare("SELECT * FROM machine WHERE id_machine=?");
    $sql->bind_param("i",$_GET["id_machine"]);
    $sql->execute();
    $result = $sql->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset=utf-8 />
<title>Update machine</title>
<link href="../employee_management/css/index.css" rel="stylesheet" type="text/css" />
<link href="../employee_management/css/create.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<ul>
  		<li><a href="../employee_management/index.php">Home</a></li>
		<li><a href="machine.php">Machine</a></li>
  		<li style="float:right"><a href="../employee_management/php_action/logout.php" onclick="return confirm('Are you sure to logout?')">Log out</a></li>
		<li class="idname">User ID: <i class="user"><?php echo $_SESSION["employee"]["userid"] . "</i> Username: <i class='user'>" . $_SESSION["employee"]["username"]?></i></li>
	</ul>
<form action="./php_action/update_machine.php" method="post" enctype="multipart/form-data" style="border:1px solid #ccc">
  <div class="container">
    <h1>Edit Machine</h1>
    <hr>
    <?php if ($result->num_rows > 0) {		
			$row = $result->fetch_assoc(); ?>
    <div class="responsive">
      <div class="gallery">
        <img id="profile" src="../assets/machine_images/machine_images/<?php echo $row["image_machine"] ?>" width="300" height="200" alt="your image" />
        <div class="desc">Select image to upload:
          <input type="file"  onchange="readURL(this);" name="fileToUpload" id="fileToUpload" class="btn btn-file">
        </div>
        <div class="desc">Select machine detail to upload:
          <input type="file" name="detailUpload" id="detaliUpload" class="btn btn-file">
        </div>
      </div>
    </div>
    <div>
      <label for="name_machine"><b>Machine Name</b></label>
      <input type="text" placeholder="Enter Machine Name" name="name_machine" value="<?php echo $row["name_machine"]; ?>" required>

      <label for="code_machine"><b>Machine Code</b></label>
      <input type="text" placeholder="Enter Machine Code" name="code_machine" value="<?php echo $row["code_machine"]; ?>" required>

      <label for="type_machine"><b>Machine Type</b></label>
      <div class="styled-select slate">
        <select for="type" name="type_machine">
          <option value="motor" <?php if ($row["type"] == "motor") {echo "selected";} ?>>Motor</option>
          <option value="compressor" <?php if ($row["type"] == "compressor") {echo "selected";} ?>>Compressor</option>
          <option value="boiler" <?php if ($row["type"] == "boiler") {echo "selected";} ?>>Boiler</option>
          <option value="transformer" <?php if ($row["type"] == "transformer") {echo "selected";} ?>>Transformer</option>
        </select>
      </div>
    </div>
        <?php }
        $_SESSION["oldmachine"] = $row;
        $conn->close(); ?>
    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" name="submit" class="signupbtn">Update</button>
    </div>
  </div>
</form>
<script>

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile')
               .attr('src', e.target.result)
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>
</body>
</html>
<?php } else {
	echo '<script language="javascript">';
	echo 'alert("PLEASE LOGIN.");';
	echo 'window.location = "../employee_management/login.php"';
	echo '</script>';
} ?>
