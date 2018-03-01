<?php

require_once "connect.php";
require_once "methods.php";

$inputs = [];
$errors = [];
$message = [];

$json = file_get_contents("php://input");
$post_data = json_decode($json);

$original_data = get_accountinfo_by_username($_SESSION["logged_in"]);

if(isset($post_data->firstname) && !empty($post_data->firstname)){
    $inputs["firstname"] =  defence($post_data->firstname);
} else {
    $inputs["firstname"] =  $original_data["firstname"];
}

if(isset($post_data->lastname) && !empty($post_data->lastname)){
    $inputs["lastname"] =  defence($post_data->lastname);
} else {
    $inputs["lastname"] =  $original_data["lastname"];
}

if(isset($post_data->email) && !empty($post_data->email)){
    $inputs["email"] =  defence($post_data->email);
} else {
    $inputs["email"] =  $original_data["email"];
}

if(isset($post_data->password) && !empty($post_data->password)){
    $inputs["password"] = defence($post_data->password);
} else {
    $errors["password"] = "Password required.";
}

if(!$errors){
    if(password_verify($inputs["password"], get_password_for_verify($_SESSION["logged_in"]))){
        unset($inputs["password"]);
        if(modify_user_data($_SESSION["logged_in"], $inputs)){
            $response["success"] = true;
            $response["message"] = "Profile successfully modified.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to modify profile.";
        }
    } else {
        $response["success"] = false;
        $response["error"] = ["password" => "Wrong password."];
        $response["message"] = "Wrong password.";        
    }
} else {
    $response["success"] = false;
    $response["errors"] = $errors;
    $response["message"] = "Invalid data, please fix it.";
}

echo json_encode($response);

?>