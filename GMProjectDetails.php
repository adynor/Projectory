<?php
    //////////////////////////////////////////////
    // Name            : GMProjectDetails
    // Project         : Projectory
    // Purpose         : Display the single project Details 
    // Called By       : Ghome,GMview_STeams
    // Calls           : PDFView
    // Mod history:
    //////////////////////////////////////////////

 include ('header.php');
include ('db_config.php');  
 ?>
<div class="row" style="padding:20px"></div>
<div class="row" style="padding:20px"></div>
<div class="container" >
<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_Datetime = $date->format( 'YmdHi' );

    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];
    
    $l_sql=$_REQUEST['PR_id'];
    $l_sql=str_replace("\\","",$l_sql);
    $l_arry = explode("|",$l_sql);
    $l_PR_id= $l_arry[0];
    ?>
<div class="panel panel-primary">
        <div class="panel-heading"><h4>Project Details</h4></div>
         <div class="panel-body table-responsive table" style="background-color: powderblue;">
        <?php
      
        
print('<table class="ady-table-dashboard" border=1 style="width:100%" >');
// Check The User login as Guide     
if(is_null($l_UR_id) || ($l_UR_Type!='G' && $l_UR_Type!='M'))
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="Signout.php"; </script> ';
        print($l_alert_statement );
}

if(isset($_POST['download']))
{
    echo "<script> window.location.href = 'PDFView.php'</script>"; 

}

print ('<form action="" method="POST">');
if(isset($_GET['PR_id']))
    {
        $l_PR_id = $_GET['PR_id'];
        // Select the Details Of the Project
        $l_PR_sql = 'select PR_Name, PR_Desc, PR_SynopsisURL,PR_Duration from Projects where Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id.' ';
        
        $l_PR_res = mysql_query($l_PR_sql);
        if($l_PR_row = mysql_fetch_row($l_PR_res))
        {
            $l_PR_Name      = $l_PR_row[0];
            $l_PR_Desc = $l_PR_row[1];
            $_SESSION['g_pdf_view'] = $l_PR_row[2];
            $l_PR_DurationMonth = ($l_PR_row[3]/30);
$l_PR_Duration_months=round($l_PR_DurationMonth,1);
$l_PR_Duration_Weeks = round($l_PR_row[3]/7);
?>
       <tr>
           <td>Project Name :</td>
           <td > <?php echo $l_PR_Name; ?> </td>
       </tr>
        <tr>
            <td>Project Description:</td><td><?php echo htmlspecialchars_decode($l_PR_Desc); ?></td>
        </tr>
        <tr>
            <td>Project Synopsis:</td>
            <td >
                <a class='btn btn-primary' href='ViewSynopsis.php?prid=<?php echo $l_PR_id;?>'>View</a>
            </td>
        </tr>
        <tr>
            <td>Project Duration:</td
            ><td ><?php echo $l_PR_Duration_Weeks.'Weeks/'.$l_PR_Duration_months.'Months' ?></td>
        </tr>
<?php
        }
        $l_SD_sql = 'select SD.SD_id, SD.SD_Name from SubDomain as SD, Project_SubDomains as PS where  PS.SD_id = SD.SD_id and PS.PR_id = '.$l_PR_id;
        $l_SD_res = mysql_query($l_SD_sql);
        print ('<tr><td>Technology Used -:</td>');
        print('<td >');
        while($l_SD_row = mysql_fetch_row($l_SD_res))
        {
            
            $l_SD_id      = $l_SD_row[0];
            $l_SD_Name    = $l_SD_row[1];

               print($l_SD_Name.'<br/>');           
        }
        print('</td></tr>');

 print('</form>');   

     
print('</tr>');

print('</table>');
    
    }

?>
    
        </div>
    </div>
</div>
<?php include('footer.php')?>