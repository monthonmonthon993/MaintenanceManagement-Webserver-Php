<?php
session_start();
require_once("../database_connection/db_connect.php");
$sql = $conn->prepare("SELECT * FROM employee WHERE id=?");
$sql->bind_param("i",$_GET["id"]);
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
<title>Update employee</title>
<style>
article, aside, figure, footer, header, hgroup, 
  menu, nav, section { display: block; }

body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

button:hover {
    opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}

.styled-select {
   background: url(http://i62.tinypic.com/15xvbd5.png) no-repeat 96% 0;
   margin: 5px 0 22px 0;
   height: 29px;
   overflow: hidden;
   width: 240px;
}

.styled-select select {
   background: transparent;
   border: none;
   font-size: 14px;
   height: 29px;
   padding: 5px; /* If you add too much padding here, the options won't show in IE */
   width: 268px;
}

.styled-select.slate {
   background: url(http://i62.tinypic.com/2e3ybe1.jpg) no-repeat right center;
   height: 34px;
   width: 240px;
}

.styled-select.slate select {
   border: 1px solid #ccc;
   font-size: 16px;
   height: 34px;
   width: 268px;
}

div.gallery {
    border: 1px solid #ccc;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
    vertical-align:middle;
}

div.desc {
    padding: 15px;
    text-align: center;
}

* {
    box-sizing: border-box;
}


.responsive {
    margin: 5px 0 22px 0;
    padding: 0 6px;
    width: 24.99999%;
}

@media only screen and (max-width: 700px){
    .responsive {
        width: 49.99999%;
        margin: 6px 0;
    }
}

@media only screen and (max-width: 500px){
    .responsive {
        width: 100%;
    }
}

</style>
</head>

<body>
<form action="./php_action/update_employee.php" method="post" enctype="multipart/form-data" style="border:1px solid #ccc">
  <div class="container">
    <h1>Update Employee</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <?php if ($result->num_rows > 0) {		
			$row = $result->fetch_assoc(); ?>
    <div class="responsive">
      <div class="gallery">
        <img id="profile" src="../assets/emp_images/<?php echo $row["emp_image"] ?>" width="300" height="200" alt="your image" />
          <div class="desc">Select image to upload:
            <input type="file"  onchange="readURL(this);" name="fileToUpload" id="fileToUpload" class="btn btn-file">
          </div>
      </div>
    </div>
    <div>
      <label for="userid"><b>UserID</b></label>
      <input type="text" placeholder="Enter ID" name="userid" value="<?php echo $row["userid"]; ?>" required>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" value="<?php echo $row["username"]; ?>" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" value="<?php echo $row["password"]; ?>" required>

      <label for="password-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="password-repeat" value="<?php echo $row["password"]; ?>" required>
    
      <b>Department</b>
      <div class="styled-select slate">
        <select for="dep" name="department">
          <option value="maintenance" selected>Maintenance</option>
        </select>
      </div>
    </div>
        <?php }
        $_SESSION["oldemployee"] = $row;
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
