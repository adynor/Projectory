<?php

    include ('header.php');
    include ('db_config.php');
    ?>
   <div class="row" style="padding:20px"></div>
   <div class="container" >
       <div class="row" style="padding:20px 0px">
      <div class="panel panel-primary">
  <div class="panel-heading">Mentor Details</div>     
      <div class="panel-body">
 <?php
 $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
   $previous = $_SERVER['HTTP_REFERER'];
}
print('<a href="'.$previous.'">Back</a>');

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_Datetime = $date->format( 'YmdHi' );

    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];
    
    $l_sql=$_REQUEST['g_query'];
    $l_sql=str_replace("\\","",$l_sql);
    $l_arry = explode("|",$l_sql);
    $l_UR_Mentorid= $l_arry[0];
    $l_Mentor_org= $l_arry[1];

print('<table class="ady-table-content" border="1" width="100%" >');

if(is_null($l_UR_id)||$l_UR_Type !='S')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}
// nav this query is for mentor details
$l_MDetails_sql = 'select UR_CompanyName,UR_FirstName,UR_MiddleName
, UR_LastName,UR_Emailid,UR_EmailidDomain
,UR_ProfileInfo from Users where UR_id="'.$l_UR_Mentorid.'" and Org_id = "'.$l_Mentor_org.'"';



$l_MDetails = mysql_query($l_MDetails_sql);
$l_Result_row= mysql_fetch_row($l_MDetails);
$l_Mcompanyid=$l_Result_row[0];


// nav this query is for mentor company name

$l_MCompanyname_sql = 'select UR_FirstName,UR_MiddleName
, UR_LastName from Users where UR_id="'.$l_Mcompanyid.'" and Org_id = "'.$l_Mentor_org.'"';

$l_M_Companyname = mysql_query($l_MCompanyname_sql);
$CompanyName_row=  mysql_fetch_row($l_M_Companyname);
$CompanyName= $CompanyName_row[0].' '.$CompanyName_row[1].' '.$CompanyName_row[2];



 $l_Mentor_Name= $l_Result_row[1].' '.$l_Result_row[2].' '.$l_Result_row[3];
     

 
$l_Profile_Info = $l_Result_row[6];
            

        print( '<tr><td style="width:20%;">Mentor Name :</td><td colspan=2> '.$l_Mentor_Name.' </td></tr>');
            print( '<tr><td>Profile Info:</td><td colspan=2>'.$l_Profile_Info .'</td></tr>');
             
print( '<tr><td>Company Name:</td><td colspan=2>'.$CompanyName.'</td></tr>');

// this query is to show the sub domains
$l_SD_sql = 'select USD.SD_id, SD.SD_Name from SubDomain as SD, UR_Subdomains as USD where USD.SD_id = SD.SD_id and USD.UR_id="'.$l_UR_Mentorid.'"  and USD.Org_id = "'.$l_Mentor_org.'"';
 $l_SD_res = mysql_query($l_SD_sql);
        print ('<tr><td>Technology known :</td>');
        print('<td colspan=2>');
        echo "<ul>";
        while($l_SD_row = mysql_fetch_row($l_SD_res))
        {
            
            $l_SD_id      = $l_SD_row[0];
            $l_SD_Name    = $l_SD_row[1];
            print('<li>'.$l_SD_Name.'</li>');           
        }
       echo "</ul>";
       
print('</td></tr>');

print('</table>');
    
   

?>
 			</div> 
 		</div>
       </div>
</div>
   <?php include('footer.php')?>