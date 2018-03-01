<?php

require_once "methods.php";
require_once "connect.php";

$inputs = [];
$errors = [];
$messages = [];

$json = file_get_contents("php://input");
$post_data = json_decode($json);

if(isset($post_data->new) && !empty($post_data->new) && strlen($post_data->new) > 5){
    if(isset($post_data->new2) && !empty($post_data->new2)){
        if($post_data->new === $post_data->new2){
            $inputs["new"] = defence($post_data->new);
        } else {
            $errors["new2"] = "Passwords don't match.";
        }
    } else {
        $errors["new2"] = "New password again required.";
    }
} else {
    $errors["new"] = "6 character long password required.";
}

if(isset($post_data->old) && !empty($post_data->old) && strlen($post_data->old) > 5){
        $inputs["old"] =  defence($post_data->old);
} else {
    $errors["old"] = "Password reqired for confirm.";
}

if(!$errors){
    if(password_verify($inputs["old"], get_password_for_verify($_SESSION["logged_in"]))){
        unset($inputs["old"]);
        if(change_password($_SESSION["logged_in"], password_hash($inputs["new"], PASSWORD_DEFAULT))){
            unset($inputs["new"]);            
            $response["success"] = true;
            $response["message"] = "Password successfully changed.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to change password.";
        }
    } else {
        $response["success"] = false;
        $response["error"] = ["old" => "Wrong password."];
        $response["message"] = "Wrong password.";
    }
} else {
    $response["success"] = false;
    $response["errors"] = $errors;
    $response["message"] = "Invalid data, please fix it.";
}

echo json_encode($response);

?>