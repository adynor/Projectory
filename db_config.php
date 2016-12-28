<?php
if(!session_id()) {
     @session_start();
}
$conn=  mysql_connect('localhost','zairepro_dev','4dyn0rtech!');
$db=mysql_select_db("zairepro_dev",$conn);
if(!$db){
    echo "Db connection failed".mysql_error();
}

require_once('sendmail.php');
?>
