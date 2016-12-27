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
       <div class="alert alert-info" > New Companies</div>
 <div class="row " style="padding:0px 0px">
           <div class="ady-row">

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



if(isset($_POST['submit']) )
    {
    if(isset ($_POST['l_UR_id_sel']))
    {
        $l_UR_sel_id_arr = $_POST['l_UR_id_sel'];

        $l_size_UR_sel_id_arr = count(  $l_UR_sel_id_arr);

        $l_UR_id_arr_index =0;

        while ($l_UR_id_arr_index < $l_size_UR_sel_id_arr)
        {
            $l_upd_query = 'Update Users set UR_RegistrationStatus = "C" where UR_id="'.$l_UR_sel_id_arr[$l_UR_id_arr_index].'"';

            mysql_query($l_upd_query);    // run the actual SQL

            $l_UR_id_arr_index = $l_UR_id_arr_index + 1;

        }
    }
     //header('Location: SHome01.php');
    }

print('<body>');

// Update the existing the query to UR.IN_id = Admins id and UR.Sem_id = Admins sem id
$l_select_sql = 'Select UR.UR_id, UR.UR_CompanyName, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_Type = "C" and UR.UR_RegistrationStatus = "P"' ; //=-=-=- ADD inst later
$l_result = mysql_query($l_select_sql);
$l_UR_count = mysql_num_rows($l_result);
   

print('<form action="" method="POST">');

print ('<table class="ady-table-content" border=1 style="width:100%">');
        print ('<tr>');
       
        print ('<th>Company <br>Name</th>');
        print ('<th>Company <br>Email Id</th>');
        print ('<th>Select<br>Company</th>');

        print ('</tr>');
        if($l_UR_count == 0)
        {
            print ('<tr>');
            print('<td colspan=5>There are no new companies</td>');
        }
        else
        {
        while ($l_row = mysql_fetch_row($l_result))
        {
            print ('<tr>');
       print( '<td>' . $l_row[2].' '. $l_row[3].' '.$l_row[4].'</td>');
            print( '<td>' . $l_row[5].'@'.$l_row[6]. '</td>');
            print('<td>');
            print('<center><input type="checkbox" class="g_checkbox_select_AL" value="'.$l_row[0].'" name="l_UR_id_sel[]"></center></td>');

            print('</tr>');
         }

        print('<tr>');
        print('<td><input type="submit" name="submit" value="Submit" ></td>');
        print( '</tr>');
        }

print('</table>'); 

print('</form>');

print('</body>');
mysql_free_result($l_result);


?>
</div></div></div>
<?php include('footer.php')?>