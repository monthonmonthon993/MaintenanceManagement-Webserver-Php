<?php
session_start();
$oldemployee = $_SESSION["oldemployee"];
$olduserid = $oldemployee["userid"];
$olduserimage = $oldemployee["emp_image"];

$root = "../../assets/emp_images/";
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$real_image_name = $_POST["userid"] . '.' . end($temp);
$target_file = $root . $real_image_name;
$target_old_file = $root . $olduserimage;

$uploadOk = 1;
$success_message = "Updated Successfully";
$error_message = "Problem in Update Record";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    require_once("../../database_connection/db_connect.php");
    $sql =  "UPDATE `employee` SET `userid`=?, `username`=?, `password`=?, `emp_image`=?, `department`=? WHERE `id`=?";
    $stml = $conn->prepare($sql);  
    $stml->bind_param("sssssi", $userid, $username, $password, $emp_image, $department, $id); 

    $id = $oldemployee["id"];
    $userid = $_POST["userid"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $emp_image = $real_image_name;
    $department = $_POST["department"];

    try {
        if (!isset($_FILES["fileToUpload"]["error"])) {
            $uploadOk = 0;
            throw new RuntimeException("Invalid parameters.");
        }
        if ($_FILES["fileToUpload"]["error"] == 0) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                // echo "File is not an image.";
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
                if (file_exists($target_file)) {
                    unlink($target_file);
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                } else {
                    unlink($target_old_file);
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                }
            }
        } else {
            if ($userid == $olduserid) {
                $emp_image = $olduserimage;
            } else {
                $tmp = explode(".", $olduserimage);
                rename($target_old_file, $root . $userid . "." . end($tmp));
                $emp_image = $userid . "." . end($tmp);
            }
        }
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
    if ($uploadOk && $stml->execute()) {
        echo $success_message;
    } else {
        echo $error_message;
    }
    $stml->close();
    $conn->close();
    echo '<script language="javascript"> window.location = "../index.php"</script>';
    exit;
} 
?>