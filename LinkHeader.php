<?php
@session_start();
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}
$l_filehomepath= url()."/dev"; 
if($_SESSION['g_UR_id'] ==""){
    echo '<script>window.location.href="'.$l_filehomepath.'/Signout.php"</script>';
}
?>