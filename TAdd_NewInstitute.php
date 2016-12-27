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




 if(isset($_POST['SaveRec'])) // the button name is also same
 {
$l_IT_Name= $_POST['l_IT_Name'];
$l_IT_Address= $_POST['l_IT_Address'];     
$l_IT_Contact= $_POST['l_IT_Contact'];
$l_IT_City= $_POST['l_IT_City'];
$l_IT_State= $_POST['l_IT_State'];
$l_IT_Country= $_POST['l_IT_Country'];
$l_IT_ZipCode= $_POST['l_IT_ZipCode'];

$l_check_Institute = 'select IT.IT_id from Institutes as IT where IT.IT_Name = "'.$l_IT_Name.'"';
$l_result_check_Institute = mysql_query($l_check_Institute);
$l_count_check_Institute = mysql_num_rows($l_result_check_Institute);

     if(empty($l_IT_Name))
     {
         echo "No name entered";
     }
     else if($l_count_check_Institute >= 1)
     {
          echo "Institute already exists";
     }
     else
     {
          $l_get_IT_id = 'select max(IT_id) from Institutes';
          $l_result_check_Institute = mysql_query($l_get_IT_id);
          $l_row = mysql_fetch_row($l_result_check_Institute);
          $l_max_IT_id = $l_row[0];
          $l_IT_id = $l_max_IT_id + 1;

           $l_insert_Institute = 'insert into Institutes (IT_id, IT_Name,IT_Address, IT_Phno, IT_City, IT_State, IT_Country, IT_Zipcode) values ('.$l_IT_id .',"'.$l_IT_Name .'","'.$l_IT_Address.'","'.$l_IT_Contact.'", "'.$l_IT_City .'", "'.$l_IT_State .'","'.$l_IT_Country.'","'.$l_IT_ZipCode.'")';
           $success = mysql_query($l_insert_Institute);    // run the actual SQL

             $l_PG_sel_id_arr = $_POST['l_PG_sel'];
             $l_size_PG_sel_id_arr = count(  $l_PG_sel_id_arr);
             $l_PG_id_arr_index =0;
             
             while ($l_PG_id_arr_index < $l_size_PG_sel_id_arr)
             {
                 $l_insert_sql = "insert into Institutes_Program (PG_id, IT_id) values (".$l_PG_sel_id_arr[$l_PG_id_arr_index] .",".$l_IT_id .")";
                 $result=mysql_query($l_insert_sql);    // run the actual SQL
                 
                 $l_PG_id_arr_index = $l_PG_id_arr_index + 1;
                 
             }
       
     }
     if($result || $success ){print('<div class="alert alert-success"><b>'.$l_IT_Name.'</b> Institute added successfully!!</span></div>');}    
}


print('<form method = "POST" action = ""    style=" border: 1px solid #045B6F;
    border-radius: 10px;">');
 print('<table class="ady-table-content"  style="width:100%; 
 "');
print('<tr><th colspan=2>Add New Institute</th></tr>');
 print('<tr><td>Institute Name</td><td><input class="form-control"  type="text" name="l_IT_Name"></td></tr>');

print('<tr><td>Institute Address </td><td><input class="form-control"  type="text" name="l_IT_Address"></td></tr>'); 


print('<tr><td>Contact number </td><td><input class="form-control"  type="number" name="l_IT_Contact"></td></tr>');

print('<tr><td>City </td><td><input class="form-control"  type="text" name="l_IT_City"></td></tr>');

print('<tr><td>State </td><td><input class="form-control"  type="text" name="l_IT_State"></td></tr>');

print('<tr><td>Country</td><td><input class="form-control"  type="text" name="l_IT_Country"></td></tr>');

print('<tr><td>Zip code </td><td><input class="form-control"  type="number" name="l_IT_ZipCode"></td></tr>');

print('<tr><td style="font-weight:bold" colspan=2><font color="00CCFF">Select Programs for the Institute </td></tr>');
 
 $l_select_sql = 'select PG_id , PG_Name  from Programs';
 $l_result_sql = mysql_query($l_select_sql);
 
 while($l_row = mysql_fetch_row($l_result_sql))
 {
     print ('<tr>');
     $l_PG_id = $l_row[0];
     $l_PG_Name= $l_row[1];
     
     print( '<td>'.$l_PG_Name.'</td>');
     
     print('<td>');
     print('<center><input   type="checkbox" class="g_checkbox_select_DM" value="'.$l_PG_id.'" name="l_PG_sel[]"></center></td>');
     
     print('</tr>');
 }
 
print('<td style ="text-align:center" colspan=2><br><input  class="btn-primary ady-cus-btn" type=submit name=SaveRec  accesskey=Alt-S value="Add Institute" ></td></tr>');
print('</table>');
print('</form>');


?>

                          </div></div></div>
<?php include('footer.php')?>