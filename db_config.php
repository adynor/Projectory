<?php
if(!session_id()) {
     @session_start();
}
$conn=  mysql_connect('localhost','root','root');
$db=mysql_select_db("zairepro_dev",$conn);
if(!$db){
    echo "Db connection failed".mysql_error();
}

require_once('sendmail.php');
?>
