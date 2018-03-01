<?php 
    require_once("../../database_connection/db_connect.php");
    require_once("../../database_connection/db_config.php");
    
    function getEmployee($username, $password) {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM employee WHERE username=? && password=?");
        $sql->bind_param("ss", $username, $password);
        if ($sql->execute()) {
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
             } else {
                return NULL;
             }
        }
        $sql->close();
        $conn->close();
    }

    function getAllEmployee() {
        global $conn, $base_url;
        $sql = "SELECT * FROM employee";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {		
            $array = array();	
            while($row = $result->fetch_assoc()) {
                $row["image_url"] = $base_url . "assets/emp_images/" . $row["emp_image"];
                array_push($array, $row);
            }
            return $array;
        } else {
            return NULL;
        }
        $sql->close();
        $conn->close();
    }

?>