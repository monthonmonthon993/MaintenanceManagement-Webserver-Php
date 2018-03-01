<?php
session_start();
$oldmachine = $_SESSION["oldmachine"];
$old_name_machine = $oldmachine["name_machine"];
$old_code_machine = $oldmachine["code_machine"];
$old_image_machine = $oldmachine["image_machine"];
$old_image_detail = $oldmachine["image_detail"];

$image_root = "../../assets/machine_images/machine_images/";
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$real_image_name = $_POST['code_machine'] . '.' . end($temp);
$target_file = $image_root . $real_image_name;
$target_old_file = $image_root . $old_image_machine;
$temp_image = $_FILES["fileToUpload"]["tmp_name"];

$detail_root = "../../assets/machine_images/detail_images/";
$temp = explode(".", $_FILES["detailUpload"]["name"]);
$image_detail_machine = $_POST["name_machine"] . "." . end($temp);
$target_file_detail = $detail_root . $image_detail_machine;
$target_old_detail = $detail_root . $old_image_detail;
$temp_detail = $_FILES["detailUpload"]["tmp_name"];

$uploadOk = 1;
$success_message = "Edited Successfully";
$error_message = "Problem in Adding New Record";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$detailFileType = strtolower(pathinfo($target_file_detail,PATHINFO_EXTENSION));

$status_image = 1;
$status_image_default = 1;
$status_detail = 1;
$status_detail_default = 1;

if (isset($_POST["submit"])) {
    require_once("../../database_connection/db_connect.php");
    $sql =  "UPDATE `machine` SET `name_machine`=?, `code_machine`=?, `image_machine`=?, `image_detail`=? WHERE `id_machine`=?";
    $stml = $conn->prepare($sql);  
    
    $stml->bind_param("ssssi", $name_machine, $code_machine, $image_machine, $detail_machine, $machine_id); 

    $machine_id = $oldmachine["id_machine"];
    $name_machine = $_POST["name_machine"];
    $code_machine = $_POST["code_machine"];
    $image_machine = $real_image_name;
    $detail_machine = $image_detail_machine;

    try {
        if (!isset($_FILES['fileToUpload']['error']) && !isset($_FILES["detailUpload"]["error"])) {
            throw new RuntimeException('Invalid parameters.');
        }
        if ($_FILES["fileToUpload"]["error"] == 0) {
            $check = getimagesize($temp_image);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                $uploadOk = 0;
            }
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                throw new RuntimeException("Sorry, your file is too large.");
                $uploadOk = 0;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                throw new RuntimeException("Invalid file format.");
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                throw new RuntimeException("Sorry, your file was not uploaded.");
                echo "Sorry, your file was not uploaded.";
            } else {
                $status_image = 1;
                $status_image_default = 0;
            }
        } else {
            $status_image = 0;
            $status_image_default = 1;
        }
        if ($_FILES["detailUpload"]["error"] == 0) {
            $check_detail = getimagesize($temp_detail);
            if($check_detail !== false) {
                echo "File is an image - " . $check_detail["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                $uploadOk = 0;
            }
            if ($_FILES["detailUpload"]["size"] > 1000000) {
                throw new RuntimeException("Sorry, your file is too large.");
                $uploadOk = 0;
            }
            if($detailFileType != "jpg" && $detailFileType != "png" && $detailFileType != "jpeg" && $detailFileType != "gif" ) {
                throw new RuntimeException("Invalid file format.");
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                throw new RuntimeException("Sorry, your file was not uploaded.");
            } else {
                $status_detail = 1;
                $status_detail_default = 0;
            }
        } else {
            $status_detail = 0;
            $status_detail_default = 1;
        }
        function setDefaultImageToNewId($machine, $old_machine) {
            global $target_old_file, $image_machine, $image_root, $old_image_machine;
            if ($machine !== $old_machine) {
                $tmp = explode(".", $old_image_machine);
                rename($target_old_file, $image_root . $machine . "." . end($tmp));
                $image_machine = $machine . "." . end($tmp);
            } else { $image_machine = $old_image_machine; }
        }
        function setDefaultDetailToNewId($machine, $old_machine) {
            global $target_old_detail, $detail_machine, $detail_root, $old_image_detail;
            if ($machine !== $old_machine) {
                $tmp = explode(".", $old_image_detail);
                rename($target_old_detail, $detail_root . $machine . "." . end($tmp));
                $detail_machine = $machine . "." . end($tmp);
            } else { $detail_machine = $old_image_detail; }
        }
        function uploadFile($target, $target_old, $temp_file) {
            unlink(file_exists($target) ? $target : $target_old);
            move_uploaded_file($temp_file, $target);
        }

        if ($status_image && $status_detail) {
            uploadFile($target_file, $target_old_file, $temp_image);
            uploadFile($target_file_detail, $target_old_detail, $temp_detail);
        } 
        elseif ($status_image && $status_detail_default) {
            uploadFile($target_file, $target_old_file, $temp_image);
            setDefaultDetailToNewId($name_machine, $old_name_machine); 
        }
        elseif ($status_image_default && $status_detail) {
            setDefaultImageToNewId($code_machine, $old_code_machine);
            uploadFile($target_file_detail, $target_old_detail, $temp_detail);
        } 
        elseif ($status_image_default && $status_detail_default) {
            setDefaultImageToNewId($code_machine, $old_code_machine);
            setDefaultDetailToNewId($name_machine, $old_name_machine); 
        } 
        else { throw new RuntimeException("Somthing wrong.!!"); }
    
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
    echo '<script language="javascript"> window.location = "../machine.php"</script>';	
    exit;
} 
?>