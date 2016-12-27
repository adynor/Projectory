<?php   

include ('db_config.php');
include ('header.php');

?>
<br><br><br><br>
<div class="container" >
       <div class="row" style="width:100%;">
           <div class=" ady-row">


<?php



$l_UR_Type = $_SESSION['g_UR_Type'];
$l_UR_id = $_SESSION['g_UR_id'];

if(empty($l_UR_id) || $l_UR_Type!='T')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as an authorised person to add an Institute. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}


print('<div style="clear:left">');

 if(isset($_POST['SaveRec'])) // the button name is also same
 {
$l_PG_Name= $_POST['l_PG_Name'];

$l_check_Programs = 'select PG.PG_id from Programs as PG where PG.PG_Name = "'.$l_PG_Name.'"';
$l_result_check_Programs = mysql_query($l_check_Programs);
$l_count_check_Programs = mysql_num_rows($l_result_check_Programs);

     if(empty($l_PG_Name))
     {
         echo "No name entered";
     }
     else if($l_count_check_Programs>= 1)
     {
          echo "Program already exists";
     }
     else
     {
          $l_get_PG_id = 'select max(PG_id) from Programs';
          $l_result_check_Programs= mysql_query($l_get_PG_id);
          $l_row = mysql_fetch_row($l_result_check_Programs);
          $l_max_PG_id = $l_row[0];
          $l_PG_id = $l_max_PG_id + 1;

           $l_insert_Programs = 'insert into Programs (PG_id, PG_Name) values ('.$l_PG_id .',"'.$l_PG_Name .'")';
           mysql_query($l_insert_Programs);    // run the actual SQL
         
    echo "<font color=blue>".$l_PG_Name."</font> Program Added";
             
             
       }
         
}


print('<form method = "POST" action = "">');
 print('<br><br><table class="ady-table-content"  style="width:100%; 
 border=1px;"> ');
print('<tr ><th colspan=2>Add New Programme</th></tr>');

 print('<tr><td>Enter Programe Name</td><td><input class="form-control" type="text" name="l_PG_Name"></td></tr>');

 print('<td style ="text-align:center" colspan=2><br><input class="btn-primary ady-cus-btn"type=submit name=SaveRec  accesskey=Alt-S value="Add Program" ></td></tr>');
print('</table>');
print('</form>');
print('</div>');

?>

                          </div></div></div>
<?php include('footer.php')?>