<?php session_start();
require_once("../authentication.php");

if (check_authentication()) {
	require_once("../database_connection/db_connect.php");
?>
<!DOCTYPE html>
<html>
<head>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset=utf-8 />
<title>Add machine</title>
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
<form action="./php_action/create_machine.php" method="post" enctype="multipart/form-data" style="border:1px solid #ccc">
  <div class="container">
    <h1>Create New Machine</h1>
    <p>Please fill in this form to add an machine.</p>
    <hr>

    <div class="responsive">
      <div class="gallery">
        <img id="profile" src="../assets/machine_images/machine_images/default.jpg" width="300" height="200" alt="machine" />
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
      <input type="text" placeholder="Enter Machine Name" name="name_machine" required>

      <label for="code_machine"><b>Machine Code</b></label>
      <input type="text" placeholder="Enter Machine Code" name="code_machine" required>

      <label for="type_machine"><b>Machine Type</b></label>
      <div class="styled-select slate">
        <select for="type" name="type_machine">
          <option value="motor" selected>Motor</option>
          <option value="compressor">Compressor</option>
          <option value="boiler">Boiler</option>
          <option value="transformer">Transformer</option>
        </select>
      </div>
    </div>

    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" name="submit" class="signupbtn">Add</button>
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
$('#psw, #confirm-psw').on('keyup', function () {
    if ($('#psw').val() == $('#confirm-psw').val()) {
        $('#message-match').html('Matching').css('color', 'green');
    } else {
        $('#message-match').html('Not Matching').css('color', 'red');
    }
});

</script>
</body>
</html>
<?php } else {
	echo '<script language="javascript">';
	echo 'alert("PLEASE LOGIN.");';
	echo 'window.location = "../employee_management/login.php"';
	echo '</script>';
} ?>
