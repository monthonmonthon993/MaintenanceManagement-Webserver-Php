<?php


if (isset($_POST["note"]) && isset($_POST["status"]) && isset($_POST["id_machine"]) && isset($_POST["type_pm"])) {
    echo $_POST["note"] . " " . $_POST["status"] . " " . $_POST["id_machine"] . " " .  $_POST["type_pm"];
    insertPmPlan($_POST["type_pm"]);
} else {
    echo "error.";
}


function insertPmPlan($type_pm) {
    echo $type_pm;
    require_once("../../database_connection/db_connect.php");
    $message_success = "insert successfully.";
    if ($type_pm == "daily") {
        $sql =  "INSERT INTO pm_plan_daily (id_machine, datetime, status, note) VALUES (?, ?, ?, ?)";
        $stml = $conn->prepare($sql);  
        $stml->bind_param("isis", $id_machine, $datetime, $status, $note); 

        $id_machine = (int)$_POST["id_machine"];
        $datetime = date("Y-m-d H:i:s");
        $status = (int)$_POST["status"];
        $note = $_POST["note"];
       
    } else if ($type_pm == "monthly") {
        $sql =  "INSERT INTO pm_plan_monthly (id_machine, month, datetime, status, note) VALUES (?, ?, ?, ?, ?)";
        $stml = $conn->prepare($sql);  
        $stml->bind_param("issis", $id_machine, $month, $datetime, $status, $note); 

        $id_machine = (int)$_POST["id_machine"];
        $month = date("F");
        $datetime = date("Y-m-d H:i:s");
        $status = (int)$_POST["status"];
        $note = $_POST["note"];
    } else if ($type_pm == "yearly") {
        $sql =  "INSERT INTO pm_plan_yearly (id_machine, year, datetime, status, note) VALUES (?, ?, ?, ?, ?)";
        $stml = $conn->prepare($sql);  
        $stml->bind_param("issis", $id_machine, $year, $datetime, $status, $note); 

        $id_machine = (int)$_POST["id_machine"];
        $year = date("Y");
        $datetime = date("Y-m-d H:i:s");
        $status = (int)($_POST["status"]);
        $note = $_POST["note"];

    } else {
        echo "wrong type.";
    }
    
    
    if ($stml->execute()) {
        echo $message_success;
    } else {
        echo "error.";
    }
    $stml->close();
    $conn->close();
}
?>