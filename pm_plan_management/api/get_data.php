<?php 
    require_once("../../database_connection/db_connect.php");
    require_once("../../database_connection/db_config.php");
    
    function getAllDaily() {
        global $conn ,$base_url;
        $sql = "SELECT * FROM pm_plan_daily";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {		
            $array = array();	
            while($row = $result->fetch_assoc()) {
                array_push($array, $row);
            }
            return $array;
        } else {
            return NULL;
        }
        $sql->close();
        $conn->close();
    }
    function getAllMonthly() {
        global $conn ,$base_url;
        $sql = "SELECT * FROM pm_plan_monthly";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {		
            $array = array();	
            while($row = $result->fetch_assoc()) {
                array_push($array, $row);
            }
            return $array;
        } else {
            return NULL;
        }
        $sql->close();
        $conn->close();
    }
    function getAllYearly() {
        global $conn ,$base_url;
        $sql = "SELECT * FROM pm_plan_yearly";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {		
            $array = array();	
            while($row = $result->fetch_assoc()) {
                array_push($array, $row);
            }
            return $array;
        } else {
            return NULL;
        }
        $sql->close();
        $conn->close();
    }

    function getPmByMachine($id_machine) {
        global $conn;
        $sql = "SELECT * FROM pm_plan_daily WHERE id_machine= $id_machine";
        $sql2 = "SELECT * FROM pm_plan_monthly WHERE id_machine= $id_machine";
        $sql3 = "SELECT * FROM pm_plan_yearly WHERE id_machine= $id_machine";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3);
        $array = array();
        $array_pm = array();
        $array_daily = array();
        $array_monthly = array();
        $array_yearly = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row["datetime"]);
                $setTimeZone = new DateTimeZone("Asia/Bangkok");
                $datetime->setTimezone($setTimeZone);
                $timestamp = strtotime($datetime->format("Y-m-d H:i:s"));
                $row["day"] = date('D', $timestamp);
                $row["month"] = date("F", $timestamp);
                $row["year"] = date("Y", $timestamp);
                $row["date"] = date("d", $timestamp);
                $row["time"] = date("H:i", $timestamp);
                array_push($array_daily, $row);
            }
            $array_pm["daily"] = $array_daily;
        } else {
            $array_daily = NULL;
        }
        
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()) {
                $datetime = new DateTime($row["datetime"]);
                $setTimeZone = new DateTimeZone("Asia/Bangkok");
                $datetime->setTimezone($setTimeZone);
                $timestamp = strtotime($datetime->format("Y-m-d H:i:s"));
                $row["year"] = date("Y", $timestamp);
                $row["day"] = date('D', $timestamp);
                $row["date"] = date("d", $timestamp);
                $row["time"] = date("H:i", $timestamp);
                array_push($array_monthly, $row);
                
            }
            $array_pm["monthly"] = $array_monthly;
        } else {
            $array_monthly = NULL;
        }

        if ($result3->num_rows > 0) {
            while($row = $result3->fetch_assoc()) {
                $datetime = new DateTime($row["datetime"]);
                $setTimeZone = new DateTimeZone("Asia/Bangkok");
                $datetime->setTimezone($setTimeZone);
                $timestamp = strtotime($datetime->format("Y-m-d H:i:s"));
                $row["day"] = date('D', $timestamp);
                $row["month"] = date("F", $timestamp);
                $row["date"] = date("d", $timestamp);
                $row["time"] = date("H:i", $timestamp);
                array_push($array_yearly, $row);
            }
            $array_pm["yearly"] = $array_yearly;
        } else {
            $array_yearly = NULL;
        }
        array_push($array, $array_pm);
        return $array;
        $sql->close();
        $conn->close();
    }

?>