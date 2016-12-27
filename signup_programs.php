<?php 
include ('db_config.php');
 $l_IT_id=$_GET['user_institute_id'];
unset($l_programs);
 $l_programs= array();
  
<<<<<<< HEAD
 $l_programs_sql ='Select IT.PG_id, PG.PG_Name from Institutes_Program as IT, Programs as PG 
        where IT.IT_id ='.$l_IT_id.'
        and IT.PG_id = PG.PG_id 
        AND PG.PG_id <> 0';
=======
 $l_programs_sql ='Select IT.PG_id, PG.PG_Name from Institutes_Program as IT, Programs as PG
        where IT.IT_id ='.$l_IT_id.'
        and IT.PG_id = PG.PG_id ';
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
    $l_programs_result =mysql_query($l_programs_sql);
    while($l_row__program_results=mysql_fetch_row($l_programs_result)){
        array_push($l_programs,$l_row__program_results);
    }
    echo json_encode($l_programs);
<<<<<<< HEAD
?>
=======
?>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
