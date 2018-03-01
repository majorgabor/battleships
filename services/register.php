<?php

require_once "methods.php";
require_once "connect.php";

$inputs = [];
$errors = [];
$messages = [];

$json = file_get_contents("php://input");
$post_data = json_decode($json);

// $users = get_usernames();

if(isset($post_data->firstname) && !empty($post_data->firstname)){
    $inputs["firstname"] = defence($post_data->firstname);
} else {
    $errors["firstname"] = "Firstname required.";
}

if(isset($post_data->lastname) && !empty($post_data->lastname)){
    $inputs["lastname"] = defence($post_data->lastname);
} else {
    $errors["lastname"] = "Lastname required.";
}

if(isset($post_data->username) && !empty($post_data->username)){
    if(!is_existing_username(defence($post_data->username))){
        $inputs["username"] = defence($post_data->username);
    } else {
        $errors["username"] = "Username already exist.";
    }
} else {
    $errors["username"] = "Unique username required.";
}

if(isset($post_data->email) && !empty($post_data->email)){
    $inputs["email"] = defence($post_data->email);
    
} else {
    $errors["email"] = "Email required.";
}

if(isset($post_data->password) && !empty($post_data->password) && strlen($post_data->password) > 5){
    if(isset($post_data->password2) && !empty($post_data->password2)){
        if($post_data->password === $post_data->password2){
            $inputs["password"] = defence($post_data->password);
        } else {
            $errors["password2"] = "Passwords don't match.";
        }
    } else {
        $errors["password2"] = "Password again required.";
    }
} else {
    $errors["password"] = "6 character long password required.";
}

if(!isset($post_data->agree) || empty($post_data->agree)){
    $errors["agree"] = "You must accept terms & conditions.";
}

if(!$errors){
    $newUser = array(
        "firstname" => $inputs["firstname"],
        "lastname" => $inputs["lastname"],
        "username" => $inputs["username"],
        "email" => $inputs["email"],
        "password" => password_hash($inputs['password'], PASSWORD_DEFAULT),
        "code" => password_hash(generate_code(8), PASSWORD_DEFAULT)
    );
    
    if(insert_new_user($newUser)){
        $respond["success"] = true;
        $respond["message"] = "Sucsessfuly Signed Up.";
    } else {
        $respond["success"] = false;
        $respond["message"] = "Faild to Sign Up!.";
    }
} else {
    $respond["success"] = false;
    $respond["errors"] = $errors;
    $respond["message"] = "Invalid data, please fix it.";
}

echo json_encode($respond);

?>