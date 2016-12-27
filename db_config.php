<?php
<<<<<<< HEAD
//error_reporting(E_ALL);
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
if(!session_id()) {
     @session_start();
}

<<<<<<< HEAD
$conn=  mysql_connect('localhost','zairepro_test','test@123');
$db=mysql_select_db("zairepro_projectory_test",$conn);
if(!$db){
    echo "Db connection failed".mysql_error();
}
require_once('sendmail.php');
?>
=======
$conn=  mysql_connect('localhost','zairepro_dbuser','4dyn0rtech!');
$db=mysql_select_db("zairepro_Projectory",$conn);
if(!$db){
    echo "Db connection failed".mysql_error();
}

require_once('sendmail.php');
?>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
