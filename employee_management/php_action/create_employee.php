<?php
$root = "../../assets/emp_images/";
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$real_image_name = $_POST['userid'] . '.' . end($temp);
$target_file = $root . $real_image_name;

$uploadOk = 1;
$success_message = "Added Successfully";
$error_message = "Problem in Adding New Record";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (isset($_POST['submit'])) {
    require_once("../../database_connection/db_connect.php");
    $sql =  "INSERT INTO employee (userid,username,password,emp_image,department) VALUES (?, ?, ?, ?, ?)";
    $stml = $conn->prepare($sql);  
    $stml->bind_param("sssss", $userid, $username, $password, $emp_image, $department); 

    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $emp_image = $real_image_name;
    $department = $_POST['department'];
    try {
        if (!isset($_FILES['fileToUpload']['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
        if ($_FILES["fileToUpload"]["error"] == 0) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                throw new RuntimeException("File is not an image.");
                // echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                throw new RuntimeException("Sorry, file already exists.");
                // echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                throw new RuntimeException("Sorry, your file is too large.");
                // echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                throw new RuntimeException("Invalid file format.");
                // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                throw new RuntimeException("Sorry, your file was not uploaded.");
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                    throw new RuntimeException("Sorry, there was an error uploading your file.");
                    // echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            if (copy($root . "default.jpg", $root . $userid . ".jpg")) {
                $emp_image = $userid . ".jpg";
                echo "The image was used a default.";
            } else {
                throw new RuntimeException("The default image cannot been used or not exist.");
                // echo "The default image cannot been used or not exist.";
                $uploadOk = 0;
            }
        }
        if ($uploadOk && $stml->execute()) {
            echo $success_message;
        } else {
            echo $error_message;
        }
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
    $stml->close();
    $conn->close();
    echo '<script language="javascript"> window.location = "../index.php"</script>';
    exit;
} 
?>