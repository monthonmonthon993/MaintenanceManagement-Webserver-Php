<?php
require_once("../../database_connection/db_connect.php");
require_once("../../database_connection/db_config.php");

function getDatasheetByMachine($id_machine) {
    global $conn, $base_url;
    $sql = "SELECT * FROM datasheet WHERE id_machine=$id_machine";
    $result = $conn->query($sql);

    $array_datasheet = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row["datasheet_url"] = $base_url . "assets/datasheets/" . $row["datasheet"];
            $row["imagesheet_url"] = $base_url . "assets/datasheets/" . $row["image_sheet"];
            array_push($array_datasheet, $row);
        }
        return $array_datasheet;
    }
}
?>