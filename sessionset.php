<?php
    require_once('db_config.php');
    $urid=$_SESSION['g_UR_id'];
    $urorg=$_SESSION['g_Org_id'];
       $l_query_users='select UR.UR_id,UR.IT_id, UR.PG_id, UR.UR_Type,UR.TM_id,UR.UR_Semester, UR.PR_id,UR.UR_USN, UR.UR_RegistrationStatus,UR.UR_PR_Type,UR.Org_id from  Users as UR where UR.UR_id="'.$urid.'" and UR.Org_id="'.$urorg.'"';
    $l_result_users = mysql_query($l_query_users) or die(mysql_error());
    $l_row_users = mysql_fetch_row($l_result_users);
    $_SESSION['g_UR_id']=$l_row_users[0];
    $_SESSION['g_IT_id']=$l_row_users[1];
    $_SESSION['g_PG_id']=$l_row_users[2];
    $_SESSION['g_UR_Type']= $l_row_users[3];
    $_SESSION['g_TM_id']=$l_row_users[4];
    $_SESSION['g_Semester_id']=$l_row_users[5];
    $_SESSION['g_PR_id']=$l_row_users[6];
    $_SESSION['g_UR_PR_Type']=$l_row_users[9];
    $_SESSION['g_Org_id']=$l_row_users[10];
    $_SESSION['LAST_ACTIVITY'] = time();
    // echo "<a href='SHome.php'>back</a>";
    // echo "<script>window.location.href='SHome.php'</script>";
?>   