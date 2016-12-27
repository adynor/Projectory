<?php
    //////////////////////////////////////////////
    // Name            : GMview_STeams
    // Project         : Projectory
    // Purpose         :  Display The Teams ,which are under same Guide/Mentor
    // Called By       : Ghome,Mhome
    // Calls           : gmprojectdetails,
    // Mod history:
    //////////////////////////////////////////////

 include ('header.php');
 include ('db_config.php');  
 ?>

<div class="row" style="padding:20px"></div>
<div class="row" style="padding:20px"></div>
<div class="container" > 
<?php
if(isset($_POST['update_user'])){
    $l_update_Project_Status = 'Update Users set PR_id=NULL,TM_id=NULL WHERE Org_id="'.$_SESSION['g_Org_id'].'" and TM_id='.$_POST['l_student_tm_id'].'';
            mysql_query($l_update_Project_Status);
    $l_update_Teams_status = 'Update Teams set TM_Revise=0 WHERE Org_id="'.$_SESSION['g_Org_id'].'" and TM_id='.$_POST['l_student_tm_id'].'';
            mysql_query($l_update_Teams_status);
}
$l_UR_USN	                 = $_SESSION['g_UR_USN']; // this is needed by the SQLs that run in this php
$l_UR_id	                 = $_SESSION['g_UR_id'];
$l_UR_Type                     = $_SESSION['g_UR_Type'];
$l_UR_Receiver =$l_UR_id;
// Check the user login as Guide or Mentor
if(is_null($l_UR_id) || ($l_UR_Type!='G' && $l_UR_Type!='M'))
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a guide. Please login correctly")
        window.location.href="login.php"; </script> ';

        print($l_alert_statement );
}
?>
 <div class="panel panel-success">
        <div class="panel-heading"><h4>Teams currently under you</h4></div>
<?php

// Check the User Type  is Guide 
 if($l_UR_Type == 'G')
   {
   //Display the details of Teams(which are currently Under the same guide) with Project and team members
   //check with TM_EndDate column is  null
$l_query1 =  "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno,UR.UR_LastLogin,PR.PR_id,TM.TM_id
 from Projects as PR, Teams as TM, Users as UR where  UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Guide   = '".$l_UR_Receiver."'  and TM.TM_EndDate is NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
   }
   // Check the User Type  is Mentor 
   else if ($l_UR_Type == 'M')
       {
//Display the details of Teams(which are currently Under the same Mentor) with Project and team members
 //check with TM_EndDate column is  null
 $l_query1 =  "select PR.PR_Name,TM.TM_Name,UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno,UR.UR_LastLogin,PR.PR_id,TM.TM_id
 from Projects as PR, Teams as TM, Users as UR where  UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Mentor   = '".$l_UR_Receiver."'  and TM.TM_EndDate is NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
   }

$l_proj_res1 = mysql_query($l_query1) or die(mysql_error());    // run the actual SQL
$l_count1 = mysql_num_rows($l_proj_res1);
?>

    <div class="panel-body table-responsive table">
<?php
if($l_count1 > 0)
{

print('<table class="ady-table-content table" border=1 style="width:100%" >');
print ('<tr>');
print ('<th text-align:center">Team </th>');
print ('<th text-align:center"> Project </th>');
print ('<th text-align:center">Team Members</th>');
print ('<th text-align:center">Team Member  Details</th>');
print ('<th text-align:center">Last Login Details</th>');
print ('</tr>');


        $l_prev_teamname = 'Dummyname';
                
        while ($l_row = mysql_fetch_row($l_proj_res1)) 
        {
           print ('<tr>');
            $l_TM_Name= $l_row[1];
            $l_PR_Name= $l_row[0];
            $l_UR_Name= $l_row[2] . ' ' . $l_row[3] . ' ' . $l_row[4];
            $l_UR_USN= $l_row[5];
            $l_UR_Semester= $l_row[6];
            $l_UR_Phno= $l_row[7];
            $l_UR_LastLogin= $l_row[8];
             $l_PR_id        = $l_row[9];
             $l_TM_id        = $l_row[10];
//Date Time
 $l_LoginDate_res= date("d-M-Y   h:i A",          strtotime($l_UR_LastLogin));
          //Check the members of team should be same team 
            if($l_prev_teamname <> $l_TM_Name)
                    {
                        ?>
               <td>
            <span class="glyphicons glyphicons-group"> <?php echo $l_TM_Name;?>
            </span>
                   <?php
                    $l_PD_sql = 'select distinct (PD.AL_id) from Project_Documents as PD where  PD.TM_id ='.$l_TM_id.' and PD.PD_Status = "A"';
        $l_PD_res = mysql_query($l_PD_sql);
        if($l_PD_res!=Null)
        {
             $l_count_PD = mysql_num_rows($l_PD_res);
        }
        $l_PS_id_arr = array();
        
        $sql_MaxPS_num='select max(PS_Seq_No) from ProjectDocument_Sequence as PDS  WHERE PDS.PR_id='.$l_PR_id.'';
        $l_result_num = mysql_query($sql_MaxPS_num) ;
        $l_row= mysql_fetch_row($l_result_num);
        $l_max_num=$l_row[0];
        $done_mile=0;
        $final_mile = $l_max_num+2;
        
        if($l_count_PD==0) //team is formed along with guide or mentor but without any doc approved
        {
            $done_mile=2;
            $percentage = round(($done_mile/$final_mile)*100);
            
        }
        else
        {
            $done_mile=$l_count_PD + 2;
            $percentage = round(($done_mile/$final_mile)*100);
            
            
        }
        
                   ?>
                    <div class="progress" style="background-color: rgba(111, 85, 91, 0.32);">
            <div class="progress-bar-success"  role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="2" aria-valuemax="100" style="min-width: 2em;color:#FFFFFF; width:<?php echo $percentage.'%'; ?>;">
                <?php echo $percentage; ?>%
                
            </div>
        </div>
                       </td>
                                <?php
                       print ( '<td><span class="glyphicon glyphicon-hand-right"></span>&nbsp;<a href="GMProjectDetails.php?PR_id='.$l_PR_id.'">'.$l_PR_Name.'</a></td>');
                   
 }
                    else
                    {
                        print ('<td> </td>');
                        print ('<td> </td>');
                    }
                print ('<td><span class="glyphicon glyphicon-user"> </span> '. $l_UR_Name. '</td>');
                //print ('<td>' . 'USN- '.$l_UR_USN.' Semester- '. $l_UR_Semester.'Phone- '.$l_UR_Phno.'</td>');
                print ('<td>Semester- '. $l_UR_Semester.'</td>');
                print ('<td><span class="glyphicon glyphicon-time">'.$l_LoginDate_res.'</span></td>');
                $l_prev_teamname =  $l_TM_Name;
                
         }

print ('</table>');
    }
else
    {

    print ('<table class="ady-table-content table" border=1 style="width:100%" > ');
print ('<tr>');
print ('<th font-weight:bold ; text-align:center">Team </th>');
print ('<th font-weight:bold ; text-align:center"> Project </th>');
print ('<th font-weight:bold ; text-align:center">Team Members</th>');
print ('<th font-weight:bold ; text-align:center">Team Member  Details</th>');
print ('</tr>');
    print ('<tr>');
    print ('<td colspan=4> <div class="alert alert-danger" role="alert"> There are currently no Teams under you.</div></td>');
    print ('</tr>');
    print ( '</table>');
}

?>
        </div>
 </div>
 <div class="panel panel-success">
        <div class="panel-heading"><h4 >Teams that were under you</h4></div>

<?php

// Check the User Type  is Guide 
 if($l_UR_Type == 'G')
   {
   //Display the details of Teams(which completed the project Under the same Guide) with Project and team members
  //check with TM_EndDate column is not null
//$l_query =  "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno,TM.TM_id from Projects as PR, Teams as TM, Users as UR where UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Guide   = '".$l_UR_Receiver."'  and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
$l_query= "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno, TM.TM_id,TM.TM_Revise from Projects as PR, Teams as TM, Users as UR,Student_Results as SR where SR.TM_id = TM.TM_id and SR.UR_Student=UR.UR_id and PR.PR_id = TM.PR_id and TM.UR_id_Guide = '".$l_UR_Receiver."' and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
     }
   // Check the User Type  is Mentor 
   else if ($l_UR_Type == 'M')
       {
        //Display the details of Teams(which completed the project Under the same Guide) with Project and team members
     //check with TM_EndDate column is  not null
 $l_query= "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno, TM.TM_id,TM.TM_Revise from Projects as PR, Teams as TM, Users as UR,Student_Results as SR where  SR.TM_id = TM.TM_id and SR.UR_Student=UR.UR_id and PR.PR_id = TM.PR_id and TM.UR_id_Mentor = '".$l_UR_Receiver."' and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
     
//echo $l_query =  "select PR.PR_Name, TM.TM_Name,UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno from Projects as PR, Teams as TM, Users as UR where UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Mentor   = '".$l_UR_Receiver."'  and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
   }

$l_proj_res = mysql_query($l_query) or die(mysql_error());   // run the actual SQL
$l_count = mysql_num_rows($l_proj_res);
?>

    <div class="panel-body table-responsive table">
<?php
if($l_count > 0)
{

print('<table class="ady-table-content table" border=1 style="width:100%" >');
print ('<tr>');
print ('<th text-align:center">Team </th>');
print ('<th text-align:center"> Project </th>');

print ('<th text-align:center">Team Members</th>');
print ('<th text-align:center">Team Member  Details</th>');
 if ($l_UR_Type == 'G'){
     print ('<th text-align:center">Finish Project</th>');
 }
print ('</tr>');

        $l_prev_teamname = 'Dummyname';
                
        while ($l_row = mysql_fetch_row($l_proj_res)) 
        {
           print ('<tr>');
            $l_TM_Name= $l_row[1];
            $l_PR_Name= $l_row[0];
            $l_UR_Name= $l_row[2] . ' ' . $l_row[3] . ' ' . $l_row[4];
            $l_UR_USN= $l_row[5];
            $l_UR_Semester= $l_row[6];
            $l_UR_Phno= $l_row[7];
            $l_TMs_id=$l_row[8];
            $l_TMs_Status=$l_row[9];
            //Check the members of team should be same team 
            if($l_prev_teamname <> $l_TM_Name)
                    {
                        print ('<td><span class="glyphicons glyphicons-group"> ' .  $l_TM_Name. '</td>');
                        print ('<td><span class="glyphicon glyphicon-hand-right"> ' . $l_PR_Name. '</span></td>');
                        
         
                    }
                    else
                    {
                        print ('<td> </td>');
                        print ('<td> </td>');
                    }
                print ('<td><span class="glyphicon glyphicon-user"> '. $l_UR_Name. '</span></td>');
                //print ('<td>' . 'USN- '.$l_UR_USN.' Semester- '. $l_UR_Semester.'Phone- '.$l_UR_Phno.'</td>');
                print ('<td>Semester- '. $l_UR_Semester.'</td>');
                if ($l_UR_Type == 'G'){
                if($l_prev_teamname <> $l_TM_Name)
                    {
                         
                             if($l_TMs_Status == 1){
               print ('<td><form action="" method="POST"> <input type="hidden" name="l_student_tm_id" value="'.$l_TMs_id.'"/>
                      <input type="submit" name="update_user" value="Finish Project" class="btn btn-primary" /></form></td>');
                    }
                    else{
                        echo "<td>Finished</td>";
                        
                    }
                    
                
                    }
                     else
                    {
                        print ('<td> </td>');
                }
                
                    }
                $l_prev_teamname =  $l_TM_Name;
                  
         }

print ('</table>');
    }
else
    {

    print ('<table class="ady-table-content table" border=1 style="width:100%"  >');
print ('<tr>');
print ('<th font-weight:bold ; text-align:center">Team </th>');
print ('<th font-weight:bold ; text-align:center">Project </th>');
print ('<th font-weight:bold ; text-align:center">Team Members</th>');
print ('<th font-weight:bold ; text-align:center">Team Member  Details</th>');
print ('</tr>');
    print ('<tr>');
    print ('<td colspan=4><div class="alert alert-danger" role="alert"> No Teams to show.</div></td>');
    print ('</tr>');
    print ( '</table>');
}

?>
      </div>  
</div>
<?php include('footer.php')?>