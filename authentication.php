<?php
function check_authentication() {
    if (isset($_SESSION["authentication"]) && $_SESSION["authentication"]) {
        $id_authentication = $_SESSION["employee"]["id"];
        return true;
    } else {
        return false;
    }
}
?>