<?php

session_start();

echo "you are ".$_SESSION["logged_in"]."<br>";
echo "your enemy is ".$_SESSION["enemy"]."<br>";
?>