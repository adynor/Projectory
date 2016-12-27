<?php

if(!session_id()) 
{
     session_start();
}

include ('db_config.php');
include ('header.php');

?>
<br><br><br><br>
   <div class="container" >
       
 <div class="row " style="padding:0px 0px">
           <div class="ady-row">


<?php 


$l_UR_id        = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
$l_UR_Type     = $_SESSION['g_UR_Type']; 
if(is_null($l_UR_id) || $l_UR_Type!='T')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the Zaireprojects Admin. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}

// For date and time 
$l_LastLoginDate_query = 'select  UR_LastLogin from Users where UR_id = "'.$l_UR_id.'"' ;
$l_LastLoginDate = mysql_query($l_LastLoginDate_query) or die(mysql_error());
$l_Date=mysql_fetch_row($l_LastLoginDate);
$l_LoginDate_res=$l_Date[0];

$l_LoginDate_res= date("d-M-Y h:i A", strtotime($l_LoginDate_res));


$instquery='select * from Institutes';
$runquery=mysql_query($instquery);


print('<div class="alert alert-info">Last logged in on&nbsp;' .$l_LoginDate_res. '</div>');
?>
  <div class="panel-group accordion" id="accordion2">
  
<?php
$i=1;
while($row=  mysql_fetch_row($runquery)){
    $programsquery='select Pro.PG_Name,ITpro.PG_id from Programs as Pro,Institutes_Program as ITpro   where Pro.PG_id=ITpro.PG_id and ITpro.IT_id='.$row[0].'';
    $result=mysql_query($programsquery);
  
    
   ?>
  <div class="panel panel-default accordion-group">
    <div class="row" style="
         
     background-color: rgba(158, 158, 158, 0.28); " class="panel-heading">
     
         <a style="text-align:left;" class="  col-md-1"><?php echo $i; ?> </a> 
         <a style="text-align:left;"  class="btn text-left col-md-6" data-toggle="collapse" href="#<?php echo $row[0];?>"><?php echo $row[1]; ?>
         </a><a class=" btn  col-md-5" data-toggle="collapse" href="#<?php echo $i.$row[0];?>">Programs</a>
     
    </div>
    <div id="<?php echo $row[0];?>" class="panel-collapse collapse " data-toggle="collapse" data-parent="#accordion2">
     <ul style="
    color: #2196F3;
" class="list-group">
        <li class="list-group-item">Address :<?php echo $row[2]; ?></li>
        <li class="list-group-item">Contact :<?php echo $row[3]; ?></li>
        <li class="list-group-item">City    :<?php echo $row[4]; ?></li>
        <li class="list-group-item">state   :<?php echo $row[5]; ?></li>
        <li class="list-group-item">Country :<?php echo $row[6]; ?></li>
        <li class="list-group-item">Zip Code:<?php echo $row[7]; ?></li>
        
      </ul>
      <div style="
        background-color: rgba(158, 158, 158, 0.28); " class="panel-footer"></div>
    </div>
      <div id="<?php echo $i.$row[0];?>" class="panel-collapse collapse" data-toggle="collapse" data-parent="#accordion2">
     <ul style="
    color: #2196F3;
" class="list-group">
         <?php $j=1; while($branch=mysql_fetch_row($result)){?>
          <li class="list-group-item"><?php echo $j.'.'.' '.$branch[0]; ?></li>
       <?php   $j++;} ?>
       
      </ul>
      <div style="
        background-color: rgba(158, 158, 158, 0.28); " class="panel-footer"></div>
    </div>
      
      </div>
  <?php $i++;} ?>
    
</div> 
</div></div></div>
<?php include('footer.php')?>