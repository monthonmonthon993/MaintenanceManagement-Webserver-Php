<?php 
session_start();
$id_machine = $_GET["id_machine"];
$machine = $_SESSION["machine"];
$name_machine = $machine["name_machine"];

$number_sheet = 1;
$number_image = 1;

$datasheet_root = "../../assets/datasheets/";
$temp = explode(".", $_FILES["pdfToUpload"]["name"]);
$real_pdf_name = "Datasheet" . $name_machine . $number_sheet . '.' . end($temp);
$target_file = $datasheet_root . $real_pdf_name;

$image_sheet_root = "../../assets/datasheets/";
$image_temp = explode(".", $_FILES["jpgToUpload"]["name"]);
$real_jpg_name = "Data-" . $name_machine . $number_image . '.' . end($image_temp);
$target_image = $image_sheet_root . $real_jpg_name;

$uploadOk = 1;
$success_message = "Added Successfully";
$error_message = "Problem in Adding New Record";
$pdfFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$jpgFileType = strtolower(pathinfo($target_image,PATHINFO_EXTENSION));

$status_pdf = 1;
$status_pdf_default = 1;
if (isset($_POST['submit'])) {
    require_once("../../database_connection/db_connect.php");
    $sql = "INSERT INTO datasheet (datasheet, image_sheet, id_machine) VALUES (?, ?, ?)";
    $stml = $conn->prepare($sql);  
    $stml->bind_param("ssi", $datasheet, $image_sheet, $id_machine); 
    $id_machine = $_GET["id_machine"];
    $datasheet = $real_pdf_name;
    $image_sheet = $real_jpg_name;

    try {
        if (!isset($_FILES['pdfToUpload']['error']) || !isset($_FILES["jpgToUpload"]["error"])) {
            throw new RuntimeException('Invalid parameters.');
        }
        if ($_FILES["pdfToUpload"]["error"] == 0) {
            while (file_exists($target_file)) {
                $number_sheet = $number_sheet + 1;
                $datasheet = "Datasheet". $name_machine . $number_sheet . "." . end($temp);
                $target_file = $datasheet_root . $datasheet;
            }
            if ($_FILES["pdfToUpload"]["size"] > 16000000) {
                throw new RuntimeException("Sorry, your file is too large.");
                $uploadOk = 0;
            }
            if($pdfFileType != "pdf") {
                throw new RuntimeException("Invalid file format.");
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                throw new RuntimeException("Sorry, your file was not uploaded.");
            } else {
                if (move_uploaded_file($_FILES["pdfToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". basename($_FILES["pdfToUpload"]["tmp_name"]). " has been uploaded.";
                } else {
                    $uploadOk = 0;
                    throw new RuntimeException("Sorry, there was an error uploading your file.");
                }
            }
        } else {
            echo $_FILES["pdfToUpload"]["error"];
            if(copy($datasheet_root . "default.pdf", $datasheet_root . $name_machine . $number_sheet . ".pdf")) {
                echo "The datasheet was used a default.";
            } else {
                throw new RuntimeException("The default image cannot been used or not exist.");
                $uploadOk = 0;
            }
        }


        if ($_FILES["jpgToUpload"]["error"] == 0) {
            while (file_exists($target_image)) {
                $number_image = $number_image + 1;
                $image_sheet = "Data-". $name_machine . $number_image . "." . end($image_temp);
                $target_image = $image_sheet_root . $image_sheet;
            }
            $check_detail = getimagesize($_FILES["jpgToUpload"]["tmp_name"]);
            if($check_detail !== false) {
                echo "File is an image - " . $check_detail["mime"] . ".";
            } else {
                throw new RuntimeException("File is not an image.");
                $uploadOk = 0;
            }
            if ($_FILES["jpgToUpload"]["size"] > 6000000) {
                throw new RuntimeException("Sorry, your file is too large.");
                $uploadOk = 0;
            }
            if($jpgFileType != "jpg" && $jpgFileType != "png" && $jpgFileType != "jpeg" && $jpgFileType != "gif") {
                throw new RuntimeException("Invalid file format.");
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                throw new RuntimeException("Sorry, your file was not uploaded.");
            } else {
                if (move_uploaded_file($_FILES["jpgToUpload"]["tmp_name"], $target_image)) {
                    echo "The file ". basename($_FILES["jpgToUpload"]["tmp_name"]). " has been uploaded.";
                } else {
                    $uploadOk = 0;
                    throw new RuntimeException("Sorry, there was an error uploading your file.");
                }
            }
        } else {
            echo $_FILES["jpgToUpload"]["error"];
            if(copy($datasheet_root . "default.jpg", $image_sheet_root . $name_machine . $number_image . ".jpg")) {
                echo "The image was used a default.";
            } else {
                throw new RuntimeException("The default image cannot been used or not exist.");
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
        echo "error";
    }
    $stml->close();
    $conn->close();
    echo '<script language="javascript"> window.location = "../machine.php"</script>';
    exit;
} else {
    echo "not found.";
}

        
?>