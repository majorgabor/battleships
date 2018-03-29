<?php

session_start();

require_once "connect.php";

function save_to_file($file, $data) {
    file_put_contents($file, json_encode($data));
}

function load_from_file($file) {
    return json_decode(file_get_contents($file), TRUE);
}

function not_empty(&$array, $key) {
    return isset($array[$key]) && !empty($array[$key]);
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function save_to_flash($data) {
    $_SESSION['_flash'] = $data;
}

function load_from_flash() {
    if (isset($_SESSION['_flash'])) {
        $data = $_SESSION['_flash'];
        unset($_SESSION['_flash']);
        return $data;
    } else {
        return NULL;
    }
}

function defence($str){
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
     
}

function auth() {
    if (!isset($_SESSION["logged_in"])) {
        if(!remember()){
            save_to_flash([
                "message" => "You must LogIn first."
            ]);
            redirect('./login');
        }
    }
}

function remember(){
    if(!isset($_SESSION["logged_in"]) && isset($_COOKIE["remember"])){
        $cookie = unserialize($_COOKIE["remember"]);
        if(password_verify(get_code_for_remember($cookie["username"]), $cookie["code"])){
            $_SESSION["logged_in"] = $cookie["username"];
            return true;
        }
    }
    return false;
}


function generate_code($length){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $code = "";
    for($i = 0; $i < $length; $i++){
        $code .= substr(str_shuffle($chars), random_int(0, strlen($chars)), 1);
    }
    return $code;
}

?>