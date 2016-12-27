<?php
    //////////////////////////////////////////////
    // Name            : MHome
    // Project         : Projectory
    // Purpose         : Interface for Mentor Dasboad
    // Called By       : Login
    // Calls           : AddProject,GMview_STeams,GMview_Team_ProjFiles01,GMTeamDocs,MProjList01,GMPendingRequest,mentorhelp
    // Mod history:
     //////////////////////////////////////////////
include ('db_config.php');
include ('header.php');  
?>
<<<<<<< HEAD


<div class="container" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js" integrity="sha256-xoE/2szqaiaaZh7goVyF5p9C/qBu9dM3V5utrQaiJMc=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" integrity="sha256-zV9aQFg2u+n7xs0FTQEhY0zGHSFlwgIu7pivQiwJ38E=" crossorigin="anonymous" />   
    
<style>


.mystyle{
border: 1px solid rgba(128, 128, 128, 0.34) !important;
    
    width: 100px !important;
    height: 27px !important;
    }
    
    .yourstyle{
    border: 1px solid #d9534f !important;
    width: 100px !important;
    height: 27px !important;
    }
</style>





=======
<div class="container" >
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac

 <?php   

$l_UR_id = $_SESSION['g_UR_id'];
$l_UR_Type = $_SESSION['g_UR_Type'];


// Select the User Last Login
$l_LastLoginDate_query = 'select  UR_LastLogin from Users where UR_id = "'.$l_UR_id.'" and Org_id = "'.$_SESSION['g_Org_id'].'"' ;
$l_LastLoginDate = mysql_query($l_LastLoginDate_query) or die(mysql_error());
$l_Date=mysql_fetch_row($l_LastLoginDate);
$l_LoginDate_res=$l_Date[0];

$l_LoginDate_res= date("d-M-Y h:i A", strtotime($l_LoginDate_res));


print('<div style="clear:left">');


//Check the User Id null or user type not M(Mentor)
/*if(is_null($l_UR_id) || $l_UR_Type!='M')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a Mentor. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}

else
{*/
$l_UR_Details_query = 'select UR_FirstName from Users where UR_id = "'.$l_UR_id.'" and Org_id = "'.$_SESSION['g_Org_id'].'"';
$l_UR_Details_result = mysql_query($l_UR_Details_query) or die(mysql_error);
$l_UR_Name_row = mysql_fetch_row($l_UR_Details_result);
$l_UR_FName = $l_UR_Name_row[0];

$l_checkrequest_query = 'select TM_id from Users where UR_id = "'.$l_UR_id.'" and UR_Type = \'M\' and Org_id = "'.$_SESSION['g_Org_id'].'"';
$l_checkrequest_result = mysql_query($l_checkrequest_query) or die(mysql_error());
$l_TM_id_row = mysql_fetch_row($l_checkrequest_result);
$l_TM_id = $l_TM_id_row[0];

/*print('<div  style="float:left;"><h2><b> <font color="#4682b4">Welcome to Projectory :</font><font color="ff6347"> '.$l_UR_FName.'</font></b></h2></div>
<br><div  style="float:right;"> <a href="'.$l_filehomepath.'/EditProfile" ><font color="00ccff"><u>[Edit Profile]</u></font></a> <a href="'.$l_filehomepath.'/mentorhelp"><u> Help </u></a></div>');


print('<div align="center"><font color="#4682b4">logged in at '.$l_LoginDate_res. '</font></div>');*/
<<<<<<< HEAD
$days=array('....','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'); 

function getDayvalue($date_m){
  $days=array('','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'); 
   return $currentvalue= array_search(date('l', strtotime($date_m)),$days);
 }

  function getSlot($day)
  {
  $sql="SELECT * FROM Mentor_Calendar WHERE UR_id='$_SESSION[g_UR_id]' AND MC_DayNo='$day'" ;
  $que=mysql_query($sql);
  $slots=array();
 While($row=mysql_fetch_array($que)){
 //print_r($row);
  $a=$row['MC_StartTime'];
  $b=$row['MC_EndTime'];
 $hours=array('12:00 AM','01:00 AM','02:00 AM', '03:00 AM', '04:00 AM', '05:00 AM', '06:00 AM', '07:00 AM', '08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM', '01:00 PM','02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM', '07:00 PM', '08:00 PM','09:00 PM','10:00 PM','11:00 PM','12:00 AM');
	 for($a;$a < $b;$a++){
	 $c=$a+1;
	 $kV=$a.'-'.$c;
	 $slots[$kV]= $hours[$a].'-'.$hours[$c];
	 //array_push($slots,$sol);
	 
	
	 }



 }
 return $slots;
 }

?>

=======
?>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
<div class="row alert alert-info" style="font-size: large;     margin-top: 14px;">
    <div class="col-md-5">
    <b>Welcome to Projectory:&nbsp;</b><font color="ff6347"><?php echo $l_UR_FName;?></font>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-4 ady-logged-in" >
   logged in at <?php echo $l_LoginDate_res;?>
    </div>
</div>

<<<<<<< HEAD
<?php 

$hours=array('12:00 AM','01:00 AM','02:00 AM', '03:00 AM', '04:00 AM', '05:00 AM', '06:00 AM', '07:00 AM', '08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM', '01:00 PM','02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM', '07:00 PM', '08:00 PM','09:00 PM','10:00 PM','11:00 PM','12:00 AM');

$dayarray= array("0"=>"","1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
$M_Time_req_query=mysql_query("select * from Booking_Slots where BS_Mentor_id='$l_UR_id' and BS_Status='P'");
echo $result=mysql_num_rows($M_Time_req_query);
/*if($result>0){
while($row=mysql_fetch_array($M_Time_req_query))
{

$requestStartTime= $row['BS_Start_Time'];
 $requestEndTime=$row['BS_End_Time'];
 echo $FianlReqTime= $hours[$requestStartTime].'-'.$hours[$requestEndTime];
 
$day=getDayvalue($row['BS_Date']);
$dayname = $dayarray[$day];
 

}
} */
?>
<span style="background-color: #f8b334;
    width: 22px;
    height: 22px;
    padding: 4px;     border: 1px solid #373c38;" class=" glyphicon glyphicon-pencil" title="Change Availability Time" data-toggle="popover" data-placement="right" data-content='
    <?php $k=1;
    while($row=mysql_fetch_array($M_Time_req_query))
{

$requestStartTime= $row['BS_Start_Time'];
 $requestEndTime=$row['BS_End_Time'];
 $FianlReqTime= $hours[$requestStartTime].'-'.$hours[$requestEndTime];
 
$day=getDayvalue($row['BS_Date']);
$dayname = $dayarray[$day]; ?>
 <span class="label label-primary"><?php echo $row['BS_ST_id']; ?></span> <?php
?>
 <div id="">
   <select class="mystyle" id="pre<?php echo $k ?>" disabled="disabled">
    <?php $ji=0;
   foreach($days as $data){  ?>
  <option value="<?php echo $ji; ?>" <?php if($dayname==$data){echo 'selected';}?>><?php echo $data;?></option>
<?php $ji++;
} ?>

</select> 
<select style="width: 153px !important;" class="mystyle changer" id="changedata<?php echo $k ?>" disabled="disabled">
  <?php $ji=0;
  foreach(getSlot(4) as $keys => $data)
   {  
   
   $key=explode('-',$keys);?>
   
  <option  data-startdate="<?php echo $key[0]; ?>" data-enddate="<?php echo $key[1]; ?>" <?php if($FianlReqTime==$data){echo 'selected';}?>><?php echo $data;?></option>
  
<?php $ji++;

} ?>
</select> 
<span class="btn btn-danger glyphicon glyphicon-pencil btn-sm" style="border-radius: 50%;border: 2px solid #cdcbc7;" onclick="change(<?php echo $k ?>);"></span><span style="border-radius: 50%;border: 2px solid #cdcbc7;" class="btn btn-success glyphicon glyphicon-ok btn-sm" onclick="confirm(<?php echo $k ?>)"></span>
<hr>
</div><?php $k++; } ?>  ' data-html="true"  data-placement="right"></span>
   
 
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
<?php
//Check the  pending Request
if($l_TM_id == -99)
{
      print('<div class="alert alert-warning" role="alert"> You have one or more Pending requests. Please <a  class="alert-link" href="GMPendingRequest.php">Click Here</a> to view them</div>');
}
 print('<div class="row "><div class="col-md-4 "></div>');
print('<div class="col-md-4 "><table class="ady-row" border ="0" bordercolor="#718DE2">');
print('<tr><td><a class="btn btn-primary ady-btn"  href="AddProject.php">Add a project</a></td></tr>');
print('<tr><td><a class="btn btn-primary ady-btn"  href="GMView_STeams.php">View Teams under you</a></td></tr>');
print('<tr><td><a  class="btn btn-primary ady-btn" href="GMView_Team_ProjFiles01.php">View Teams\' Documents </a></td></tr>');
print('<tr><td><a class="btn btn-primary ady-btn"  href="GMTeamDocs.php">View Teams\' Feedbacks </a></td></tr>');

print('<tr><td><a class="btn btn-primary ady-btn"  href="MProjList01.php">View your Projects</a></td></tr>');

print('<tr><td><a  class="btn btn-primary ady-btn"  href="GMPendingRequest.php">Pending Requests</a></td></tr>');
 print('</table></div>');
 print('<div class="col-md-4 "></div></div>');



//-- display the Dashboard --------------------------------//
    $l_sql_UR = 'Select UR.UR_ProfileInfo from Users as UR where UR.UR_id="' . $l_UR_id . '" and UR.Org_id = "'.$_SESSION['g_Org_id'].'"';
   //Display the User Profile Details
<<<<<<< HEAD
$l_sql_CompanyName = 'Select  UR.UR_FirstName , UR.UR_MiddleName , UR.UR_LastName from Users as UR where UR.UR_id = (select innerUR.UR_CompanyName from Users as innerUR where innerUR.UR_id="' . $l_UR_id . '") and UR.Org_id = "'.$_SESSION['g_Org_id'].'" ';
=======
$l_sql_CompanyName = 'Select  UR.UR_FirstName , UR.UR_MiddleName , UR.UR_LastName from Users as UR where UR.UR_id = (select innerUR.UR_CompanyName from Users as innerUR where innerUR.UR_id="' . $l_UR_id . '")';
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac

 $l_result_UR = mysql_query($l_sql_UR) or die(mysql_error);
 $l_result_CN = mysql_query($l_sql_CompanyName);   
   
 $l_row_UR = mysql_fetch_row($l_result_UR);
 $l_row_CN = mysql_fetch_row($l_result_CN);
 $l_count_CN = mysql_num_rows($l_result_CN);

 print('<table class="ady-table-dashboard" border=1 style="width:100%" >');
    print('<tr><th  colspan="2" ><center>Dashboard</th></tr>');
   print( "<tr><td><strong>Profile Info:</strong> ".$l_row_UR[0]."</td></tr>");
    print( "<tr><td><strong>Company name:</strong> ".$l_row_CN[0]." ".$l_row_CN[1]." ".$l_row_CN[2]."</td></tr></table>");
  

// to display the Teams With team Details
    $l_teaminfo_query =  "select PR.PR_Name, PR.PR_Desc, PR.PR_ComplexityLevel, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno from Projects as PR, Teams as TM, Users as UR where UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Mentor   = '".$l_UR_id."' and TM.Org_id = '".$_SESSION['g_Org_id']."' and TM.TM_EndDate is NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";

    $l_teaminfo_res = mysql_query($l_teaminfo_query) or die(mysql_error); 
    $l_count = mysql_num_rows($l_teaminfo_res);
    if($l_count>0)
    { 
        print('<br /><br/><table class="ady-table-dashboard" border=1 style="width:100%" >');
        print ('<tr><th>Teams currently under you</th></tr>');
    }


    $l_prev_teamname = 'Dummyname';
    
    while ($l_row = mysql_fetch_row($l_teaminfo_res)) 
        {
            $l_TM_Name= $l_row[3];
            $l_PR_Name= $l_row[0];
            $l_UR_Name= $l_row[4] . ' ' . $l_row[5] . ' ' . $l_row[6];
            $l_UR_USN= $l_row[7];
            //chek the teams list is not Zero
            if($l_prev_teamname <> $l_TM_Name)
                    {
                        print ('<tr style="background:#99CCFF"><td><strong>Team:</strong>' . $l_TM_Name. '</td><t/r>');
                        print ('<tr><td><strong>Project:</strong>' . $l_PR_Name. '</td></tr>');
                        print ('<tr><td colspan><strong>Students in the Team:</strong>');
                    }
                    
                print ('<br/>'.$l_UR_Name);
               
                $l_prev_teamname =  $l_TM_Name;
            
        }
    
        mysql_free_result($l_teaminfo_res);
         print('</td></tr>');
   print('</table><br>');
//}

?>
 </div> 
<<<<<<< HEAD
 
 
 <script>
 

 //$('.mystyle').attr('disabled', 'disabled');
//$(".mystyle").attr("disabled", true);
function change(k){
var kar1='#pre'+k;
var kar='#changedata'+k;

$(kar).addClass( "yourstyle" );
$(kar).removeAttr('disabled');
$(kar).removeClass( "mystyle" );

$(kar1).addClass( "yourstyle" );
$(kar1).removeAttr('disabled');
$(kar1).removeClass( "mystyle" );

    
}
function confirm(k){
//a = $('.mystyle').data('startdate');
//b = $('.mystyle').data('enddate');
var kar='#changedata'+k;

       var selected = $(kar).find('option:selected');
       var extra = selected.data('startdate'); 
       var extra1 = selected.data('enddate'); 
       alert(extra+'---'+extra1);
   

}

 </script>
<script>
  $('#stepExample1').timepicker({ 'step': 15 });
$('#stepExample2').timepicker({
   'step': function(i) {
       return (i%2) ? 15 : 45;
   }
});
</script>

</script>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
   

});



</script>

=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac

<?php include('footer.php')?>