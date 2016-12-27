<?php
if(!session_id()) {
     @session_start();
}

$conn=  mysql_connect('localhost','zairepro_dbuser','4dyn0rtech!');
$db=mysql_select_db("zairepro_Projectory",$conn);
if(!$db){
    echo "Db connection failed".mysql_error();
}

require_once('sendmail.php');
?>