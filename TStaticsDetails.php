<?php
include ('db_config.php');
include ('header.php');
<<<<<<< HEAD
=======
error_reporting(0);
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
?>
<style type="text/css">
.TFtableCol{
width:100%; 
border-collapse:collapse; 
}


#TFtableCold tr:first-child {
   vertical-align: top;
background: #25383C;
}
    /*  Define the background color for all the ODD table columns  */
.TFtableCol tr:nth-child(odd){ 
background: #ffffff;
               color: #221E44;
}
/*  Define the background color for all the EVEN table columns  */
.TFtableCol tr:nth-child(even){
background: #dae5f4;
               color: #221E44;
}
</style>
<<<<<<< HEAD
<link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>
=======
 <link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script> 
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
<nav class="navbar nav-cus-top"></nav>
<div class="container" >      
    <div class="row " style="padding:0px 0px">
        
            <?php
            $l_UR_id        = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
            $l_UR_Type     = $_SESSION['g_UR_Type']; 
            if(is_null($l_UR_id) || $l_UR_Type!='T')
            {
                    $l_alert_statement =  ' <script type="text/javascript">
                    window.alert("You are not authorised person. Please login correctly")
                    window.location.href="'.$l_filehomepath.'/login"; </script> ';
                    print($l_alert_statement );
            }
            ?>
            
                    <?php
                   $user_query=  mysql_query("SELECT UR_id FROM  Users WHERE UR_Type ='S' OR `UR_Type` ='G' OR `UR_Type` ='M'");
                   $users=  mysql_num_rows($user_query);
                   
                   $students_query=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id,PG_id FROM  Users WHERE UR_Type ='S'");
                   $students=  mysql_num_rows($students_query);
                   
                   $guide_query=  mysql_query("SELECT UR_id FROM  Users WHERE `UR_Type` ='G'" );
                   $guides=  mysql_num_rows($guide_query);
                   
                   $mentor_query=  mysql_query("SELECT UR_id FROM  Users WHERE `UR_Type` ='M'");
                   $mentors=  mysql_num_rows($mentor_query);
                           
                   $company_query=  mysql_query("SELECT UR_id FROM  Users WHERE UR_Type ='C'");
                   $companies=  mysql_num_rows($company_query);
                   
                   $project_query=  mysql_query("SELECT `PR_id` FROM `Projects` ");
                   $projects=  mysql_num_rows($project_query);
                   $performing_students_query=mysql_query("SELECT UR_id FROM  Users WHERE PR_id IS NOT NULL AND UR_Type ='S'");
                   $performing_students=mysql_num_rows($performing_students_query);
                   $performed_students_query=mysql_query("SELECT DISTINCT(`UR_Student`) FROM Student_Results");
                   $performed_students=mysql_num_rows($performed_students_query);
                    ?>
        
        <div> 
            <a href='TStatistics.php' >Back </a>
            <table id="myTable" class=" TFtableCol" cellspacing="0" width="100%"  border=1 >
        <?php 
        
        if(isset($_GET['req']))
          {  
        $reqkey=$_GET['req'];
             if($reqkey==1)
                   { ?><thead>
                   <tr><td>SL No.</td><td>Student Name</td><td>Email-ID</td><td>institute</td><td>Program</td><td>Reg. Status</td></tr> 
                   </thead><tbody>
        <?php
        $i=1;
                  while($row=  mysql_fetch_row($students_query))
                   {
<<<<<<< HEAD
$query='select IT_Name from Institutes where IT_id='.$row[7];
                      $sql=mysql_query($query);
                      $itname=  mysql_fetch_row($sql);
                    
$queryq='select PG_Name from Programs where PG_id='.$row[8];
                       $sqlq=mysql_query($queryq);
                      $pgname=  mysql_fetch_row($sqlq);
                      
                   echo "<tr><td>".$i."</td><td>".$row[1].' '.$row[2].' '.$row[3]."</td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$pgname[0]."</td><td>".$row[4]."</td></tr>";
=======
                   if($row[7]!=""){
$query='select IT_Name from Institutes where IT_id='.$row[7];
                      $sql=mysql_query($query);
                      $itname=  mysql_fetch_row($sql);
                    }
                    else{
                    $itname[0]="Not set";
                    }
                     
                     if($row[8]!=""){
$queryq='select PG_Name from Programs where PG_id='.$row[8];
                       $sqlq=mysql_query($queryq);
                      $pgname=  mysql_fetch_row($sqlq);
                      }else{$pgname[0]="Not set";}
                   echo "<tr><td>".$i."</td><td><a href='TStudentDetails.php?data=$row[0]'>".$row[1].' '.$row[2].' '.$row[3]."</a></td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$pgname[0]."</td><td>".$row[4]."</td></tr>";
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
              $i++;
                   } 
                   echo'</tbody>';
          }
        else if($reqkey==2)
            { 
            
            
<<<<<<< HEAD
            $students_queryC=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id,PG_id,UR_InsertDate FROM  Users WHERE UR_Type ='S' and UR_RegistrationStatus='C'");
                 
            ?><thead>
                   <tr><td>SL No.</td><td>Student Name</td><td>Email-ID</td><td>institute</td><td>Program</td><td>Reg. Date</td></tr>
=======
            $students_queryC=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id,PG_id,UR_InsertDate FROM  Users WHERE UR_Type ='S' and UR_RegistrationStatus='C' ORDER BY UR_InsertDate DESC ");
                 
            ?><thead>
                   <tr><td>SL No.</td><td>Student Name</td><td>Email-ID</td><td>institute</td><td>Program</td><td>Reg.Date</td></tr>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
                   </thead><tbody>
        <?php
         $i=1;
                  while($row=  mysql_fetch_row($students_queryC))
                   {
                      $sql=mysql_query('select IT_Name from Institutes where IT_id='.$row[7]);
                      $itname=  mysql_fetch_row($sql);
                      $sqlq=mysql_query('select PG_Name from Programs where PG_id='.$row[8]);
                      $pgname=  mysql_fetch_row($sqlq);
                      
<<<<<<< HEAD
                      $date = new DateTime($row[9]);
 $cdate=$date->format('d-m-Y H:i');
  

                      
                   echo "<tr><td>".$i."</td><td>".$row[1].' '.$row[2].' '.$row[3]."</td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$pgname[0]."</td><td>".$cdate."</td></tr>";
=======
                     $date = new DateTime($row[9]);
 $cdate=$date->format('d-m-Y H:i');
  

                   echo "<tr><td>".$i."</td><td><a href='TStudentDetails.php?data=$row[0]'>".$row[1].' '.$row[2].' '.$row[3]."</a></td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$pgname[0]."</td><td>".$cdate."</td></tr>";
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
                $i++;
                   } 
                    echo'</tbody>';
          }
          else if($reqkey==3)
            { 
<<<<<<< HEAD
           $students_queryM=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id FROM  Users WHERE UR_Type ='M' and UR_RegistrationStatus='C'");
=======
           $students_queryM=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id FROM  Users WHERE UR_Type ='M' and UR_RegistrationStatus='C' ORDER BY UR_InsertDate DESC ");
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
            ?><thead>
                   <tr><td>SL. No.</td><td>Mentor Name</td><td>Email-ID</td><td>Reg. Status</td></tr>
                   </thead><tbody>
        <?php $i=1;
                  while($row=  mysql_fetch_row($students_queryM))
                   {

<<<<<<< HEAD
echo "<tr><td>".$i."</td><td>".$row[1].' '.$row[2].' '.$row[3]."</td><td>".$row[5].'@'.$row[6]."</td><td>".$row[4]."</td></tr>";
                $i++;
=======

echo "<tr><td>".$i."</td><td><a href='TMentorDetails.php?data=$row[0]'>".$row[1].' '.$row[2].' '.$row[3]."</a></td><td>".$row[5].'@'.$row[6]."</td><td>".$row[4]."</td></tr>";
                $i++;
                  
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
                   } 
                    echo'</tbody>';
            }
            else if($reqkey==4)
            { 
<<<<<<< HEAD
           $students_queryG=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id FROM  Users WHERE UR_Type ='G' and UR_RegistrationStatus='C'");
=======
           $students_queryG=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id FROM  Users WHERE UR_Type ='G' and UR_RegistrationStatus='C' ORDER BY UR_InsertDate DESC ");
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
            ?><thead>
                   <tr><td>SL No.</td><td>Mentor Name</td><td>Email-ID</td><td>institute</td><td>Reg. Status</td></tr> 
                   </thead><tbody>
        <?php $i=1;
                  while($row=  mysql_fetch_row($students_queryG))
                   {
                      $sql=mysql_query('select IT_Name from Institutes where IT_id='.$row[7]);
                      $itname=  mysql_fetch_row($sql);
                   echo "<tr><td>".$i."</td><td>".$row[1].' '.$row[2].' '.$row[3]."</td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$row[4]."</td></tr>";
                $i++;
                   } 
                    echo'</tbody>';
            }
<<<<<<< HEAD
=======
            else if($reqkey==5)
            {
            
            $students_queryC=  mysql_query("SELECT UR_id,UR_FirstName,UR_MiddleName,UR_LastName,UR_RegistrationStatus,UR_Emailid,UR_EmailidDomain,IT_id,PG_id FROM  Users WHERE UR_Type ='S' and PR_id is not NULL ORDER BY UR_InsertDate DESC ");
                 
            ?><thead>
                   <tr><td>SL No.</td><td>Performing Student Name</td><td>Email-ID</td><td>institute</td><td>Program</td><td>Reg. Status</td></tr>
                   </thead><tbody>
        <?php
         $i=1;
                  while($row=  mysql_fetch_row($students_queryC))
                   {
                      $sql=mysql_query('select IT_Name from Institutes where IT_id='.$row[7]);
                      $itname=  mysql_fetch_row($sql);
                      $sqlq=mysql_query('select PG_Name from Programs where PG_id='.$row[8]);
                      $pgname=  mysql_fetch_row($sqlq);
                   echo "<tr><td>".$i."</td><td><a href='TStudentDetails.php?data=$row[0]'>".$row[1].' '.$row[2].' '.$row[3]."</a></td><td>".$row[5].'@'.$row[6]."</td><td>".$itname[0]."</td><td>".$pgname[0]."</td><td>".$row[4]."</td></tr>";
                $i++;
                   } 
                    echo'</tbody>';
            }
            
            
            
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
          } 
        
        ?>
          </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<?php include('footer.php')?>
