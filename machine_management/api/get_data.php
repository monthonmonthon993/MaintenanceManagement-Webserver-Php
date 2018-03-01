<?php 
    require_once("../../database_connection/db_connect.php");
    require_once("../../database_connection/db_config.php");
    
    function getMachine($name_machine) {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM machine WHERE name_machine=?");
        $sql->bind_param("s", $name_machine);
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

    function getAllMachine() {
        global $conn ,$base_url;
        $sql = "SELECT * FROM machine";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {		
            $array = array();	
            while($row = $result->fetch_assoc()) {
                $row["url_machine"] = $base_url . "assets/machine_images/machine_images/" . $row["image_machine"];
                $row["url_detail"] = $base_url . "assets/machine_images/detail_images/" . $row["image_detail"];
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