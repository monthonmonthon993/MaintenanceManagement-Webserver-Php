<?php
session_start();
if (isset($_POST['submit'])) {
    require_once("../../database_connection/db_connect.php");
    $sql = $conn->prepare("SELECT * FROM employee WHERE username=? && password=?");
    $sql->bind_param("ss",$_POST["lg_username"],$_POST["lg_password"]);
    if ($sql->execute()) {
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            // echo "login successfully.";		
            $row = $result->fetch_assoc();
            $response["employee"] = $row;
            $response["status"] = "success";
            $response["message"] ="login successfully.";
            echo json_encode($response);
            $_SESSION["employee"] = $row;
            $_SESSION["authentication"] = true;
            echo '<script language="javascript"> window.location = "../index.php"</script>';
        } else {
            $response["status"] = "failure";
            $response["message"] ="login fail.";
            echo json_encode($response);
            echo '<script language="javascript">';
            echo 'alert("CHECK USER OR PASSWORD");';
            echo 'window.location = "../login.php"';
            echo '</script>';
        }
    } else {
        echo "This is an execute error!.";
    }
    $sql->close();
    $conn->close();
} else {
    echo "not submit.";
}
?>