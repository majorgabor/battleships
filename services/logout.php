<?php

require_once "methods.php";

unset($_SESSION["logged_in"]);

setcookie("remember", "", time() - 3600, "/");

save_to_flash([
    "message" => "Sucsesfully logged out."
]);

redirect("../view/login/login.php");

?>