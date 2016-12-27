<?php
//////////////////////////////////////////////
// Aadd_Results01.php
// Project          : projectory
// Purpose         : college admin will insert the semester
// Called By      : AHome01.php
// Calls             :AHome01.php
// Mod history:
//////////////////////////////////////////////
   ?>
<style>

    .ady-cus-th{
        text-align: left !important;
        padding-left:20px !important;
        width:50%
    }
.backbutton{
    border: 2px solid;
    padding: 9px 26px;
    border-radius: 5px;
    margin-bottom: 0px;
    margin-left: 1px;
}
.backbutton:hover{
background:rgba(19, 121, 150, 0.98);
border:none;
color:#FFFFFF !important;
}

</style>
 <?php
include ('db_config.php');
include ('header.php');  
?>
<div class="row" style="padding:10px"></div>
<div class="row" style="padding:10px"></div>
<div class="container" >
<br />
 <?php   

$l_UR_id        = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
$l_IT_id        = $_SESSION['g_IT_id'];
$l_UR_Semester_SR =$_SESSION['g_UR_Semester'];//this session is coming from sr01.php
$l_PG_id_SR     = $_SESSION["g_PG_id"];//this session is coming from sr01.php
 if(empty($l_UR_Semester_SR)||empty($l_PG_id_SR)){
            echo "<script>window.location.href='AStudent_Result.php';</script>";
            
        }
$l_UR_Type = $_SESSION['g_UR_Type'];

if(is_null($l_UR_id) || $l_UR_Type!='A')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the college admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';

        print($l_alert_statement );
}


if(isset($_POST['SaveRec']))
    {
        $l_UR_Semester = $_POST['l_UR_Semester'];
        $l_UR_id_arr = $_POST['l_UR_id'];
       
        $l_UR_id_size_arr = count($l_UR_id_arr);
        $l_UR_id_index = 0;
        $l_TM_id_arr = array();
        
        while ($l_UR_id_index <  $l_UR_id_size_arr )
            {
                $l_Update_sem = 'Update  Users  set UR_Semester ='.$l_UR_Semester.'  
                                                where UR_id="'.$l_UR_id_arr[$l_UR_id_index].'" and Org_id="'.$_SESSION['g_Org_id'].'"' ;
                 mysql_query($l_Update_sem) or die(mysql_error());    // run the actual SQL

                 $l_query='select UR.TM_id from Users as UR where UR.UR_id="'.$l_UR_id_arr[$l_UR_id_index].'" and Org_id="'.$_SESSION['g_Org_id'].'"' ;
                 //echo $l_query;
                 $l_result=mysql_query($l_query) or die(mysql_error());    // run the actual SQL
                 $l_row = mysqL_fetch_row($l_result);
                 $l_TM_id_arr[] = $l_row[0];
                 
                 /*$l_update_TM= 'Update  Users  set TM_id = NULL
                                              where UR_id= "'.$l_UR_id_arr[$l_UR_id_index].'" ' ;
                 mysql_query($l_update_TM) or die(mysql_error());    // run the actual SQL
*/
                 $l_UR_id_index =  $l_UR_id_index + 1;

             }//end :while ($l_UR_id_index <  $l_UR_id_size_arr )
            mysql_free_result($l_result);

            $l_TM_id_arr= array_unique($l_TM_id_arr);
            $l_TM_id_index = 0;

            while($l_TM_id_index < count($l_TM_id_arr))
                {
                    $l_Update_sem = 'Update  Users  set TM_id = NULL,PR_id=NULL
                                                where TM_id="'.$l_TM_id_arr[$l_TM_id_index].'" and Org_id="'.$_SESSION['g_Org_id'].'"' ;
                 mysql_query($l_Update_sem) or die(mysql_error());    // run the actual SQL
                $l_TM_id_index= $l_TM_id_index +1;
                }

    }//end if(isset($_POST['SaveRec']))

$l_query="select UR.UR_id, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_Emailid, UR.UR_EmailidDomain,  UR.UR_USN, UR.UR_Semester from Users as UR, Teams as TM where UR.UR_Type = 'S' and UR.IT_id = ".$l_IT_id." and UR.UR_Semester=".$l_UR_Semester_SR." and UR.PG_id=".$l_PG_id_SR." and Org_id='".$_SESSION['g_Org_id']."' and UR.TM_id=TM.TM_id and TM.TM_EndDate <> 0 order by TM.TM_id";
$l_show_result=mysql_query($l_query) or die(mysql_error());    // run the actual SQL
print('<a class="backbutton" href="AStudent_Result.php">Back</a>');
print('<form action = "" method = "POST" class="table-responsive">');
print('<table class="ady-table-content" border=1 style="width:100%" >');
print ('<tr>');
print ('<th >Student Name </th>');
print ('<th >Student Email </th>');
print ('<th >Student USN </th>');
print ('<th  >Student Semester</th>');
print ('<th colspan=6 style="text-align:center">Students Result<h5 >If the button is checked, they will be passed otherwise they will be failed </h5></th>');
print ('</tr>');

$l_count = mysql_num_rows($l_show_result);

 if($l_count > 0)
 {
        while ($l_row = mysql_fetch_row($l_show_result))
        {
           
            $l_UR_Receiver    = $l_row[0] ;
            $l_UR_FirstName = $l_row[1];
            $l_UR_MiddleName = $l_row[2];
            $l_UR_LastName = $l_row[3];
            $l_UR_Emailid = $l_row[4];
            $l_UR_EmailidDomain = $l_row[5];
            $l_UR_USN = $l_row[6];
            $l_UR_Semester = $l_row[7];
            print ('<tr>');
            print ('<td>'.$l_UR_FirstName.''.$l_UR_MiddleName.''.$l_UR_LastName.'</td>');
            print ('<td>'.$l_UR_Emailid.'@'.$l_UR_EmailidDomain.'</td>');
            print ('<td>'.$l_UR_USN.'</td>');
            print ('<td>'.$l_UR_Semester.'</td>');

            print('<td style="text-align:center"><input type =checkbox checked="yes"  name =l_UR_id[]   value='.$l_UR_Receiver.'  ></td>');
            print('</tr>');
          }
         
   
           
/////////////Auto increment for student semester/////////////
$l_sql    = 'select max(UR_Semester) from Users  where UR_id ="'.$l_UR_Receiver.'"and IT_id ='.$l_IT_id.' and Org_id="'.$_SESSION['g_Org_id'].'"';
$l_result = mysql_query($l_sql) or die(mysql_error());
$l_data   = mysql_fetch_row($l_result);
$l_UR_Semester=$l_data[0]+1;
mysql_free_result($l_result);
/////////////Auto increment for student semester/////////////

print('<td colspan = 3>Please enter the Semester for those who have qualified for the next semester<td/>'
        . '<td  style ="text-align:center">'
        . '<input type="text" name ="l_UR_Semester" class="input-lg" style="width:50px" value ='.$l_UR_Semester.' ></td></tr>');
print('<tr><td style ="text-align:center" colspan="5">'
        . '<input type=submit name=SaveRec  accesskey=Alt-S  class="btn  btn-primary btn-md" value="Submit Semester" > '
        . '</td></tr>');
}
else 
{
print('<td colspan = 4>You do not have any students to pass</td>');
}
   print('</table>');
//////////////////////////// end :Search by Student name /////////////////////////////////////
?>
</div>

<?php include('footer.php')?>