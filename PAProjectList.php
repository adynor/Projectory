<?php
    //////////////////////////////////////////////
    // Name            :PAprojects
    // Project         :Projectory
    // Purpose         :Interface for Project admin To see the pending Projects and confirm the Projects
    // Called By       :PAHome
    // Calls           :PAProjectdetails
    // Mod history:
    //////////////////////////////////////////////
    
//// check the sesion Id 
 include ('header.php');
 
include ('db_config.php');
 ?>
<link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>
<div class="container" >
<?php
$l_UR_id        = $_SESSION['g_UR_id'];
$l_UR_Type     = $_SESSION['g_UR_Type']; 
////check the  user id is empty and user type not PA
if(is_null($l_UR_id) || $l_UR_Type!='PA')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the Adynor Project Admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';

        print($l_alert_statement );
}
if(isset($_POST['pid'])){
$l_PIDS=$_POST['pid'];
foreach ($l_PIDS as $l_pid){
///Set the project Status is 'C'(Confirm)
$pro_query_status_change= mysql_query('UPDATE Projects SET PR_Status="C" WHERE PR_id='.$l_pid.'');
if($pro_query_status_change){
////count how many query executed
$Accept_Pro_Count +=1;
}
}
///check the count and display the notification
if($Accept_Pro_Count > 0){
echo'<div class="alert alert-success"><b>'.$Accept_Pro_Count.'</b> project confirmed</div>';
}else{
 echo'<div class="alert alert-danger">!!Sorry Please Try again</div>';
}
}
//Display the pending projects 

$Pro_query=mysql_query('SELECT PR.PR_id, PR.PR_Name, MO.MO_Name, SD.SD_Name
FROM Projects AS PR, Model AS MO, SubDomain AS SD, Project_SubDomains AS PS
WHERE PR.MO_id = MO.MO_id
AND SD.SD_id = PS.SD_id
AND PR.PR_id = PS.PR_id
AND PS.SD_Preference =  "R"
AND PR.PR_Status =  "P"');
$Pro_Count_Query=mysql_num_rows($Pro_query);
  // check the pending projects available
if($Pro_Count_Query > 0){
    ?>
      <form action="" method="POST">
    <div class="panel panel-primary">
        <div class="panel-heading"><h4 style="text-align:center">List of Pending Projects</h4></div>
         <div class="panel-body table-responsive table">
              <table id="myTable" class="display" cellspacing="0" width="100%" >
            <thead>
            <tr>
            <th >SL No.</th>
            <th >Project  Name </th>
            <th >Prefered Domain </th>
            <th >Project Model </th>
            <th >Select Project</th>
            </tr>
            </thead>
<tbody>
  
    <?php
$i=1;
while($Prow=mysql_fetch_array($Pro_query)){
////encode the project id 
$pid_encode=md5(162).'=='.base64_encode($Prow[0]);
?>
<tr>
    <td style><?php echo $i ;?></td>
<td>

    <a href="PAProjectDetails.php?PID=<?php echo $pid_encode; ?>" target="new"><?php echo $Prow[1] ;?></a>
</td>
<td><?php echo $Prow[3]; ?></td>
<td><?php echo $Prow[2] ;?></td>
<td style="text-align:center;">
<input type="checkbox" name="pid[]" value="<?php echo $Prow[0]; ?>">
</td>
</tr>
<?php
$i++;
 }?>

</tbody>
<tfooter>
    <tr>
    <td  colspan="4">
        <input type="submit" style="float:right" class="btn btn-primary" name="submit" value="Submit">
    </td>
</tr>
</tfooter>
</table>

</form>
<?php
} else{ 
echo '<div class="alert alert-info">Pending Projects Are Not Available</div>';
}
    ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>

<?php include('footer.php')?>