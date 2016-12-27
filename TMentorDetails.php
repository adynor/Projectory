<?php
include ('db_config.php');
include ('header.php');
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
<link href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>
<nav class="navbar nav-cus-top"></nav>
<br><br><br><br>
   <div class="container" >
       
 <div class="row " style="padding:0px 0px">
           <div class="ady-row">
<?php


if(isset($_GET['data']))
          {  
    $Userid=$_GET['data'];
     $query='SELECT UR_FirstName,UR_MiddleName,UR_LastName,UR_Emailid,UR_EmailidDomain,IT_id,PR_id,PG_id FROM  Users WHERE UR_Type ="M" and UR_id="'.$Userid.'"';
       $students_query=  mysql_query($query);
   $students=  mysql_fetch_row($students_query);     
   
   
   $instquery='select UR_CompanyName from Users where UR_id='.$Userid.'';
   $runinstquery= mysql_query($instquery);
   if($runinstquery){
   $runinst= mysql_fetch_row($runinstquery);
   }
   if($runinst[0]){
    $prquery='select UR_FirstName,UR_MiddleName,UR_LastName from Users where UR_id='.$runinst[0].'';
   $runprs=  mysql_fetch_row(mysql_query($prquery));
 }
   
   ?>
   
   
  <table class="ady-table-content" border=1 style="width:100%">
  <tr><th colspan="2"><center>Performing Student Details</center></th></tr>
      <tr><td>Name:</td><td><?php echo $students[0];?> <?php echo $students[1]; ?> <?php echo $students[2]; ?></td><tr>
   <tr><td>Email id:</td><td><?php echo $students[3].'@'.$students[4];?></td><tr>
   <tr><td>Company Name:</td><td><?php echo $runprs[0];?></td><tr>
   
   
    </table>
     
               <?php   }
?>
</div></div></div>