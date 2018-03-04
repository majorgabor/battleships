<?php

require_once "methods.php";
require_once "connect.php";

$inputs = [];
$errors = [];
$messages = [];

$json = file_get_contents("php://input");
$post_data = json_decode($json);

$response = [];

if(isset($post_data->username) && !empty($post_data->username)){
    $inputs["username"] = defence($post_data->username);
} else {
    $errors["username"] = "Username required.";
}

if(isset($post_data->password) && !empty($post_data->password)){
    $inputs["password"] = defence($post_data->password);
} else {
    $errors["password"] = "Password required.";
}

if(!$errors){
    if(is_existing_username($inputs["username"]) && password_verify($inputs["password"], get_password_for_verify($inputs["username"]))){
        unset($inputs["password"]);
        if(isset($post_data->remember) || !empty($post_data->remember)){
            $cookie = [
                "username" => $inputs["username"],
                "code" => password_hash(get_code_for_remember($inputs["username"]), PASSWORD_DEFAULT)
            ];
            setcookie("remember", serialize($cookie), time() + 86400, "/");
        }        
        $_SESSION["logged_in"] = $inputs["username"];
        $response["success"] = true;
        $response["message"] = "Sucsessfully LoggedIn.";
    } else {
        $response["success"] = false;
        $response["message"] = "Wrong username or password.";
    }
} else {
    $response["success"] = false;
    $response["errors"] = $errors;
    $response["message"] = "Failed to LogIn.";
}

echo json_encode($response);

?>