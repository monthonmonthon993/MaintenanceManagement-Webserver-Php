<!DOCTYPE html>
<html>
<head>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset=utf-8 />
<title>Add employee</title>
<link href="./css/create.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="./php_action/create_employee.php" method="post" enctype="multipart/form-data" style="border:1px solid #ccc">
  <div class="container">
    <h1>Create New Employee</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <div class="responsive">
      <div class="gallery">
        <img id="profile" src="../assets/emp_images/default.jpg" width="300" height="200" alt="your image" />
          <div class="desc">Select image to upload:
            <input type="file"  onchange="readURL(this);" name="fileToUpload" id="fileToUpload" class="btn btn-file">
          </div>
      </div>
    </div>
    <div>
      <label for="userid"><b>UserID</b></label>
      <input type="text" placeholder="Enter ID" name="userid" required>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input type="password" id="psw" placeholder="Enter Password" name="password" required>

      <label for="password-repeat"><b>Repeat Password</b></label>
      <span id="message-match"></span>
      <input type="password" id="confirm-psw" placeholder="Repeat Password" name="password-repeat" required>
    
      <b>Department</b>
      <div class="styled-select slate">
        <select for="dep" name="department">
          <option value="maintenance" selected>Maintenance</option>
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