<?php
session_start();
include('db_config.php');
//$_POST = json_decode(file_get_contents('php://input'), true);

$itid=$_SESSION['g_IT_id'];
$q= "SELECT TM.TM_id FROM  `Users` AS UR, Teams AS TM
WHERE (
UR.UR_id = TM.UR_id_Guide
AND 
UR.IT_id ='".$itid."' AND UR.UR_Type ='G') Order by UR.UR_Type ASC";
$run=mysql_query($q);

$data = array();
while ($row = mysql_fetch_assoc($run)) {
$qf= "SELECT UR.UR_id, UR.UR_Type, UR.UR_FirstName, TM.TM_Name,TM.TM_id,TM.PR_id
FROM  `Users` AS UR, Teams AS TM
WHERE TM.TM_id =".$row['TM_id']."
AND (UR.UR_id = TM.UR_id_Mentor OR UR.UR_id = TM.UR_id_Guide) Order by UR.UR_Type ASC";
$qrun=mysql_query($qf);

while($row=mysql_fetch_assoc($qrun)){

$data[] = array(
       "PR_id" => $row['PR_id'],
       "TM_id" => $row['TM_id'], 
        "TM_Name" => $row['TM_Name'], 
        "UR_FirstName" => $row['UR_FirstName'], 
        "UR_Type" => $row['UR_Type']
    
    );
    
}

}

   print json_encode($data);

?>