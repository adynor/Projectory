<?php
include('header.php');
include ('db_config.php');
print('<div class="row" style="padding:10px"></div><div class="container" >'); 
$current_url= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";




$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$l_Datetime = $date->format('YmdHi');

 $l_sql=$_REQUEST['PR_id'];
   // echo $l_sql=str_replace("\\","",$l_sql);
    $l_arry = explode("|",$l_sql);
  $l_PR_id= $l_arry[0];
   //$l_MO_Amount=$l_arry[1];


if(isset($_POST['AcceptNda'])){
 $l_UR_NDA_Action = $_POST['AcceptNda'];
}
else{
$l_UR_NDA_Action = "N";
}
    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];

print('<br><br><br><br><br><div class="panel panel-primary">
  <div class="panel-heading">Project Details</div>
  <div class="panel-body">');
print('<table border=1 class="ady-table-content" style="width:100%">');
        
if(is_null($l_UR_id)||$l_UR_Type !='S')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}



print ('<form action="" method="POST">');
if(isset($l_PR_id))
    {
       // $l_PR_id = $_GET['PR_id'];
        
        $l_PR_sql = 'select PR.PR_Name, PR.PR_Desc,PR.PR_Duration,PR_ip,MO_Amount from Projects AS PR,Model as MO where PR.PR_id='.$l_PR_id.' AND PR.MO_id=MO.Mo_id';
        $l_PR_res = mysql_query($l_PR_sql);
     
 $l_PR_count_sql = 'select PR_id from Users where PR_id='.$l_PR_id.' ';
   $l_PR_count_res = mysql_query($l_PR_count_sql);
   $l_PR_count= mysql_num_rows($l_PR_count_res);
  



if($l_PR_row = mysql_fetch_row($l_PR_res))
        {
   // print_r($l_PR_row);
            $l_PR_Name      = $l_PR_row[0];
            $l_PR_Desc = $l_PR_row[1];
$l_PR_DurationMonth = ($l_PR_row[2]/30);
$l_PR_Duration_months=round($l_PR_DurationMonth,1);
$l_PR_Duration_Weeks = round($l_PR_row[2]/7);
            $l_PR_NDAstatus = $l_PR_row[3];
             $l_MO_Amount=$l_PR_row[4];
            $_SESSION['payment']= $l_MO_Amount;
print( '<tr><td>Project Name :</td><td colspan=2> '.$l_PR_Name.' </td></tr>');
            print( '<tr><td>Project Description:</td><td colspan=2>'.htmlspecialchars_decode($l_PR_Desc).'</td></tr>');
             
//print( '<tr><td>Project Synopsis:</td><td colspan=2><a href='.$_SESSION['g_pdf_view'].'><input class="btn btn-primary" type=submit value="View" name="download"></input></a></td></tr>');
   
 if($l_PR_NDAstatus != "NA")
        {
            $_SESSION['g_view_Nda'] = $l_PR_NDAstatus;
        }        
            
if($l_PR_NDAstatus == "NA")
            {
               // print( '<tr><td>Project Synopsis:</td><td colspan=2><input class="btn btn-primary" type=submit value="View" name="download"></input></td></tr>');
           }
          else
           {
               // print( '<tr><td>Project Synopsis:</td><td colspan=2 style="color:green">You can view synopsis only after applying the project</td></tr>');
           }
            
print( '<tr><td>Project Duration:</td><td colspan=2>'.$l_PR_Duration_Weeks.' Weeks / '.$l_PR_Duration_months.' Months</td></tr>');


print( '<tr><td>No. of people performing:</td><td colspan=2>'.$l_PR_count.'</td></tr>');



}
        $l_SD_sql = 'select SD.SD_id, SD.SD_Name from SubDomain as SD, Project_SubDomains as PS where PS.SD_id = SD.SD_id and PS.PR_id = '.$l_PR_id;
        $l_SD_res = mysql_query($l_SD_sql);
        print ('<tr><td>Technology Used -:</td>');
        print('<td colspan=2><ul style="margin:0px; padding:0px;list-style-type: none;">');
        while($l_SD_row = mysql_fetch_row($l_SD_res))
        {
            
            $l_SD_id      = $l_SD_row[0];
            $l_SD_Name    = $l_SD_row[1];

               print('<li style="background:menu;padding:5px ;border-bottom:1px solid #FFFFFF">'.$l_SD_Name.'</li>');           
        }
        print('</ul></td></tr>');
        ?>
<tr><td>Price:</td><td colspan=2><b><?php if($l_MO_Amount ==0){echo " FREE" ;} else{echo $l_MO_Amount ;}?>
        </b>
        </td>
</tr>
<?php
 if($l_PR_NDAstatus != "NA")
        {
        print( '<tr><td id="nda_td" colspan=3><input  type ="checkbox" name="AcceptNda"id="nda_data_accept" value="Y" required>I Accept the <a href="'.$l_filehomepath.'/ndaview" target="_blank">NDA</a></td></tr>');
        }

print ('<tr><td>Do you wish to perform this project? </td>');
?>
<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">What do You want as?</h4>
        </div>
        <div class="modal-body">
            <p><input type="radio" name="l_ur_pr_type" value="C" required="" <?php if($l_MO_Amount == 0){ echo "checked";}?>> Curriculum Project</p>
            <?php if($l_MO_Amount != 0){?>
            <p><input type="radio" name="l_ur_pr_type" value="N" required=""> Noncurriculum Project</p>
            <?php } ?>
        </div>
         <div class="modal-footer">
         <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
         <input class="btn btn-primary" type=submit value="yes" name="yes">
        </div>
      </div>
      
    </div>
</div>
   <td> <button type="button" class="btn btn-primary btn-md" id="myBtn3">Yes</button></td>
<?php
//print ('<td><input class="btn btn-primary" type=submit value="yes" name="yes"></input></td>');

?>
<td><a class="btn btn-primary" href="<?php echo $l_filehomepath;?>/Projects.php" >No</a></td></tr>
<?php
if(isset($_POST['yes']))
{
     $l_ur_pr_type=$_POST['l_ur_pr_type'];
    
   //  remove comment from here....................
  if($l_MO_Amount== 0)    // for free projects no payment gateway start
     {

//exit();
  $l_query_update_PR_id="UPDATE Users SET  PR_id =".$l_PR_id.",UR_PR_Type='".$l_ur_pr_type."' WHERE  UR_id ='".$l_UR_id."'";
if(mysql_query($l_query_update_PR_id)){
 $_SESSION['g_UR_PR_Type']=$l_ur_pr_type;
}
$l_query_insert_PR_id='insert into Project_Applications(UR_id,PR_id,PP_ApplicationDate) values ("'.$_SESSION['g_UR_id'].'",'.$l_PR_id.','.$l_Datetime.')';

mysql_query($l_query_insert_PR_id);

$_SESSION['g_PR_id']=$l_PR_id;

 echo "<script> window.location.href = 'SHome.php'</script>";  
      }    // for free projects no payment gateway start
    else
      {
//wp_redirect($l_filehomepath.'/payment_gateway/testpayment.php'); 
$_SESSION['g_PR_id']="";
$_SESSION['g_PR_id_pay']=$l_PR_id;
$_SESSION['g_PR_Name_pay']=$l_PR_Name ;
$_SESSION['l_User_PR_Type']=$l_ur_pr_type;
//$l_query_update_PR_id=mysql_query("UPDATE Users SET UR_PR_Type='".$l_ur_pr_type."' WHERE  UR_id ='".$l_UR_id."'");
//echo "<script> window.location.href = 'payment_gateway/testpayment.php'</script>";  
echo "<script> window.location.href = 'ProjectPayment.php'</script>";
// for payment gateway redirection


      }    //remove comment till here..........

// please comment from here after removing above comments .......

 /*$l_query_update_PR_id="UPDATE Users SET  PR_id =".$l_PR_id." WHERE  UR_id ='".$l_UR_id."'";

mysql_query($l_query_update_PR_id);
$l_query_insert_PR_id='insert into Project_Applications(UR_id,PR_id,PP_ApplicationDate) values ("'.$_SESSION['g_UR_id'].'",'.$l_PR_id.','.$l_Datetime.')';

mysql_query($l_query_insert_PR_id);

$_SESSION['g_PR_id']=$l_PR_id;


echo "<script> window.location.href = 'SHome.php'</script>"; 
  */

// comment till here......

}

else if(isset($_POST['no']))
{

//wp_redirect($l_filehomepath.'/projects');
 echo "<script> window.location.href = 'Projects.php'</script>"; 
}
     
print('</tr>');

print('</table><br>');
        
    }

?>
</div></div></div>
      <?php include('footer.php');?>
   
<script>
$(document).ready(function(){
    
    $("#myBtn3").click(function(){
        if($("#nda_data_accept").length){
        if (!$("#nda_data_accept").is(":checked")){
            $("#nda_td").css('border','2px solid red');  
        }else{
            $("#nda_td").css('border','2px solid green');
            $("#myModal3").modal({backdrop: "static"});
        }}
    else{
         $("#myModal3").modal({backdrop: "static"});
    }
     });
});
</script>