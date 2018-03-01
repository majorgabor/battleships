<?php

require_once "methods.php";

unset($_SESSION["logged_in"]);

//setcookie("code", "", time() - 3600);

$response["messages"] = "Sucsesfully logged out.";

echo json_encode($response);

redirect("../view/login/login.php");

?>