<?php
include('header.php');
include ('db_config.php');
print('<div class="row" style="padding:10px"></div><div class="container" >'); 

$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$l_Datetime = $date->format('YmdHi');
$l_PR_id= $_REQUEST[PR_id];

$backurl= $l_filehomepath."/B2BProjects.php";

    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];

print('<br><br><br><br><br>')
 ?>
<a type="button" class="btn btn-default" href="<?php echo $backurl; ?>" >Back</a>
  <?php 
 print(' <div class="panel panel-primary">
  <div class="panel-heading" style="    font-weight: bold;
    text-align: center;
}">Project Details</div>
  <div class="panel-body">');
 
print('<table border=1 class="ady-table-content" style="width:100%">');
        
if(is_null($l_UR_id)||$l_UR_Type !='S')
{
        //$l_alert_statement =  ' <script type="text/javascript">
        //window.alert("You have not logged in. Please login correctly");
       // window.location.href="'.$l_filehomepath.'/login"; </script> ';

       // print($l_alert_statement );
}



print ('<form action="" method="POST">');
if(isset($l_PR_id))
    {
       // $l_PR_id = $_GET['PR_id'];
        
        $l_PR_sql = 'select PR.PR_Name, PR.PR_Short_Desc,PR.PR_Duration,PR_ip,MO_Amount from Projects AS PR,Model as MO where PR.PR_id='.$l_PR_id.' AND PR.MO_id=MO.Mo_id';
        $l_PR_res = mysql_query($l_PR_sql);
     
 $l_PR_count_sql = 'select PR_id from Users where PR_id='.$l_PR_id.' ';
   $l_PR_count_res = mysql_query($l_PR_count_sql);
   $l_PR_count= mysql_num_rows($l_PR_count_res);
 $l_TM_count_sql = 'select PR_id from Teams where PR_id='.$l_PR_id.' ';
   $l_TM_count_res = mysql_query($l_TM_count_sql);
   $l_TM_count= mysql_num_rows($l_TM_count_res); 

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
print( '<tr><td style="width:40%">Project Name </td><td colspan=2> '.$l_PR_Name.' </td></tr>');
            print( '<tr><td>Project Description</td><td colspan=2>'.htmlspecialchars_decode($l_PR_Desc).'</td></tr>');
             
//print( '<tr><td>Project Synopsis:</td><td colspan=2><a href='.$_SESSION['g_pdf_view'].'><input class="btn btn-primary" type=submit value="View" name="download"></input></a></td></tr>');
$_SESSION['g_PR_Name_pay']=$l_PR_Name ;
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
            



}
        $l_SD_sql = 'select SD.SD_id, SD.SD_Name from SubDomain as SD, Project_SubDomains as PS where PS.SD_id = SD.SD_id and PS.PR_id = '.$l_PR_id.' GROUP BY SD.SD_id';
        $l_SD_res = mysql_query($l_SD_sql);
        print ('<tr><td>Technology Used </td>');
        print('<td colspan=2><ul style="margin:0px; padding:0px;list-style-type: none;">');
        while($l_SD_row = mysql_fetch_row($l_SD_res))
        {
            
            $l_SD_id      = $l_SD_row[0];
            $l_SD_Name    = $l_SD_row[1];

               print('<li style="background:menu;padding:5px ;border-bottom:1px solid #FFFFFF">'.$l_SD_Name.'</li>');           
        }
        print('</ul></td></tr>');
        ?>
        </td>
</tr>


<?php
if(isset($_POST['yes']))
{
     $l_ur_pr_type="C";
    
 
$_SESSION['g_PR_id']="$l_PR_id";
$_SESSION['l_User_PR_Type']=$l_ur_pr_type;
$l_query_update_PR_id="UPDATE Users SET  PR_id =".$l_PR_id." WHERE  UR_id ='".$l_UR_id."'";

mysql_query($l_query_update_PR_id);
$l_query_insert_PR_id='insert into Project_Applications(UR_id,PR_id,PP_ApplicationDate) values ("'.$_SESSION['g_UR_id'].'",'.$l_PR_id.','.$l_Datetime.')';
mysql_query($l_query_insert_PR_id);

$_SESSION['g_PR_id']=$l_PR_id;


echo "<script> window.location.href = 'SHome.php'</script>"; 
}


     
print('</tr>');

print('</table><br>');
        
    }

?>
<div style="text-align:center">

<input  style="width: 170px;" class="btn btn-primary" type=submit value="yes" name="yes"></input>
<a class="btn btn-danger" href="<?php echo $l_filehomepath;?>/B2BProjects.php" >Cancel and Go Back</a></div>
</div></div></div>
      <?php include('footer.php');
          
          ?>
