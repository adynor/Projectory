<?php   

include ('db_config.php');
include ('header.php');

?>
<br><br><br><br>
<div class="container" >
       <div class="row" style="width:100%;">
           <div class=" ady-row">



<?php


$l_UR_id                = $_SESSION['g_UR_id'];  // For the communication table we need the from id
//$l_TM_id            =$_SESSION['g_TM_id'];
$l_UR_Type        = $_SESSION['g_UR_Type'];

if(is_null($l_UR_id) || $l_UR_Type!='T')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the admin. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}


print('<body>');

// Update the existing the query to UR.IN_id = Admins id and UR.Sem_id = Admins sem id
$l_select_sql = 'Select UR.UR_id, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName from Users as UR where UR.UR_Type = "C" and UR.UR_RegistrationStatus = "C"';
$l_result = mysql_query($l_select_sql);
$l_UR_count = mysql_num_rows($l_result);
       
print('<form action="" method="POST">');

print ('<table class="ady-table-content" border=1 style="width:100%">');
        print ('<tr>');
       
        print ('<th>Company <br>Name</th>');

        print ('</tr>');
        if($l_UR_count == 0)
        {
            print ('<tr>');
            print('<td colspan=5>There are no companies</td>');
        }
        else
        {
        while ($l_row = mysql_fetch_row($l_result))
        {
            print ('<tr>');
       print( '<td><a href="'.$l_filehomepath.'/TView_Projects02.php?UR_id='.$l_row[0].'">' . $l_row[1].' '. $l_row[2].' '.$l_row[3].'</a></td>');

            print('</tr>');
         }

              }

print('</table>'); 

print('</form>');

print('</body>');
mysql_free_result($l_result);


?>
</div></div></div>
<?php include('footer.php')?>