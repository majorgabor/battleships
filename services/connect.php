<?php

$database = new mysqli("127.0.0.1", "root", "", "battleships");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

//used in register.php
function insert_new_user($user){
    global $database;
    $sql = "INSERT INTO users (id, firstname, lastname, username, email, password, code, battles, wins, points) VALUES ('null', '".$user["firstname"]."', '".$user["lastname"]."', '".$user["username"]."', '".$user["email"]."', '".$user["password"]."', '".$user["code"]."', 0, 0, 0)";
    return $database->query($sql);
}

//used in auth.php
//used in register.php
function is_existing_username($username){
    global $database;
    $result = [];
    $sql = "SELECT username FROM users WHERE username = '".$username."'";
    if($select = $database->query($sql)){
        if($select->num_rows === 1){
            return true;
        }
    }
    return false;
}

//used in auth.php
//used in modify.php
function get_password_for_verify($username){
    global $database;
    $result = [];
    $sql = "SELECT password FROM users WHERE username = '".$username."'";
    if($select = $database->query($sql)){
        if($select->num_rows){
            $row = $select->fetch_assoc();
            return $row["password"];
        }
    }
    return NULL;
}

//used in accountinfo.php
//used in modify.php
function get_accountinfo_by_username($username){
    global $database;
    $sql = "SELECT firstname, lastname, username, email, battles, wins, points FROM  users WHERE username = '".$username."'";
    if($select = $database->query($sql)){
        if($select->num_rows){
            $result = $select->fetch_assoc();
            return $result;
        }
    }
    return NULL;
}

//used in changepwd.php
function change_password($username, $password){
    global $database;
    $sql = "UPDATE users SET password = '".$password."' WHERE username = '".$username."'";
    return $database->query($sql);

}

//used in modify.php
function modify_user_data($username, $data){
    global $database;
    $sql = "UPDATE users SET firstname = '".$data["firstname"]."', lastname = '".$data["lastname"]."', email = '".$data["email"]."' WHERE username = '".$username."'";
    return $database->query($sql);
}

function get_usernames(){
    global $database;
    $result = [];
    $sql = "SELECT username FROM users";
    if($select = $database->query($sql)){
        if($select->num_rows){
            while($row = $select->fetch_assoc()){
                array_push($result, $row["username"]);
            }
            return $result;
        }
    }
    return NULL;
}

//used in methods.php
function get_code_for_remember($username){
    global $database;
    $sql = "SELECT code FROM users WHERE username = '".$username."'";
    if($select = $database->query($sql)){
        if($select->num_rows){
            $row = $select->fetch_assoc();
            return $row["code"];
        }
    }
    return NULL;
}

function get_user_by_username($username){
    global $database;
    $sql = "SELECT firstname, lastname, username, email FROM users WHERE username = '".$username."'";
    if($select = $database->query($sql)){
        if($select->num_rows){
            return $select->fetch_assoc();
        }
    }
    return NULL;
}
?>