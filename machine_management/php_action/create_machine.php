<?php
$image_root = "../../assets/machine_images/machine_images/";
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$real_image_name = $_POST['code_machine'] . '.' . end($temp);
$target_file = $image_root . $real_image_name;

$detail_root = "../../assets/machine_images/detail_images/";
$temp = explode(".", $_FILES["detailUpload"]["name"]);
$image_detail_machine = $_POST["name_machine"] . "." . end($temp);
$target_file_detail = $detail_root . $image_detail_machine;

$uploadOk = 1;
$success_message = "Added Successfully";
$error_message = "Problem in Adding New Record";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$detailFileType = strtolower(pathinfo($target_file_detail,PATHINFO_EXTENSION));

$status_image = 1;
$status_image_default = 1;
$status_detail = 1;
$status_detail_default = 1;

if (isset($_POST['submit'])) {
    require_once("../../database_connection/db_connect.php");
    $sql =  "INSERT INTO machine (name_machine, code_machine, image_machine, image_detail, type) VALUES (?, ?, ?, ?, ?)";
    $stml = $conn->prepare($sql);  
    $stml->bind_param("sssss", $name_machine, $code_machine, $image_machine, $detail_machine, $type_machine); 

    $name_machine = $_POST["name_machine"];
    $code_machine = $_POST["code_machine"];
    $image_machine = $real_image_name;
    $detail_machine = $image_detail_machine;
    $type_machine = $_POST["type_machine"];

    try {
        if (!isset($_FILES['fileToUpload']['error']) && !isset($_FILES["detailUpload"]["error"])) {
            throw new RuntimeException('Invalid parameters.');
        }
        if ($_FILES["fileToUpload"]["error"] == 0) {
            $check_image = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check_image !== false) {
                echo "File is an image - " . $check_image["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                $uploadOk = 0;
            }
            if (file_exists($target_file)) {
                unlink($target_file);
                echo "Image machine file already exists.";
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
            } else {
                $status_image = 1;
                $status_image_default = 0;
            }
        } else {
            $status_image = 0;
            $status_image_default = 1;
        }
        if ($_FILES["detailUpload"]["error"] == 0) {
            $check_detail = getimagesize($_FILES["detailUpload"]["tmp_name"]);
            if($check_detail !== false) {
                echo "File is an image - " . $check_detail["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                $uploadOk = 0;
            }
            if (file_exists($target_file_detail)) {
                unlink($target_file_detail);
                echo "Image detail machine file already exists.";
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
        function moveUploadFile($file, $target_file) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "The file ". basename( $file["name"]). " has been uploaded.";
            } else {
                $uploadOk = 0;
                throw new RuntimeException("Sorry, there was an error uploading your file.");
            }
        }
        function copyDefaultFile($prefix_root, $name_image) {
            if(copy($prefix_root . "default.jpg", $prefix_root . $name_image . ".jpg")) {
                global $image_machine, $detail_machine;
                if ($name_image == $GLOBALS['code_machine']) {
                    $image_machine = $name_image . ".jpg";
                } else {
                    $detail_machine = $name_image . ".jpg";
                }
                echo "The image was used a default.";
            } else {
                throw new RuntimeException("The default image cannot been used or not exist.");
                $uploadOk = 0;
            }
        }
        $file_image = $_FILES["fileToUpload"];
        $file_detail = $_FILES["detailUpload"];

        if ($status_image && $status_detail) {
            moveUploadFile($file_image, $target_file);
            moveUploadFile($file_detail, $target_file_detail);

        } elseif ($status_image && $status_detail_default) {
            moveUploadFile($file_image, $target_file);
            copyDefaultFile($detail_root, $name_machine);

        } elseif ($status_image_default && $status_detail) {
            copyDefaultFile($image_root, $code_machine);
            moveUploadFile($file_detail, $target_file_detail);

        } elseif ($status_image_default && $status_detail_default) {
            copyDefaultFile($image_root, $code_machine);
            copyDefaultFile($detail_root, $name_machine);

        } else {
            throw new RuntimeException("Something wrong!!");
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
    echo '<script language="javascript"> window.location = "../machine.php"</script>';
    exit;
} 
?>