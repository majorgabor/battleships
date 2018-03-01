<?php
session_start();
require_once "connect.php";

echo json_encode(get_accountinfo_by_username($_SESSION["logged_in"]));

?>