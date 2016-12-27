<?php
include ('db_config.php');

$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_Datetime = $date->format( 'YmdHi' );

    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];
print('<table>');

/*        
if(is_null($l_UR_id)||$l_UR_Type !='A')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}  */

if(isset($_POST['download']))
{
     wp_redirect($l_filehomepath.'/PDFView');
}

print ('<form action="" method="POST">');
if(isset($_GET['PR_id']))
    {
        $l_PR_id = $_GET['PR_id'];
        
        $l_PR_sql = 'select PR_Name, PR_Desc, PR_SynopsisURL from Projects where PR_id='.$l_PR_id.' ';
        
        $l_PR_res = mysql_query($l_PR_sql);
        if($l_PR_row = mysql_fetch_row($l_PR_res))
        {
            $l_PR_Name      = $l_PR_row[0];
            $l_PR_Desc = $l_PR_row[1];
            $_SESSION['g_pdf_view'] = $l_PR_row[2];

            print( '<tr><td>Project Name :</td><td colspan=2> '.$l_PR_Name.' </td></tr>');
            print( '<tr><td>Project Description:</td><td colspan=2>'.$l_PR_Desc.'</td></tr>');
             print( '<tr><td>Project Synopsis:</td><td colspan=2><a href='.$_SESSION['g_pdf_view'].'><input type=submit value="View" name="download"></input></a></td></tr>');
        }
        $l_SD_sql = 'select SD.SD_id, SD.SD_Name from SubDomain as SD, Project_SubDomains as PS where PS.SD_id = SD.SD_id and PS.PR_id = '.$l_PR_id;
        $l_SD_res = mysql_query($l_SD_sql);
        print ('<tr><td>Technology Used -:</td>');
        print('<td colspan=2>');
        while($l_SD_row = mysql_fetch_row($l_SD_res))
        {
            
            $l_SD_id      = $l_SD_row[0];
            $l_SD_Name    = $l_SD_row[1];

               print($l_SD_Name.'<br/>');           
        }
        print('</td></tr>');


print('</table><br>');
        
    }

?>