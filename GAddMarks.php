<?php
    //////////////////////////////////////////////
    // Name            :GAddMarks
    // Project         :Projectory
    // Purpose         :Mentor Feedback From
    // Called By       :Ghome
    // Calls           :
    // Mod history:
    //////////////////////////////////////////////


include ('header.php');
include ('db_config.php');
?>


<br><br><br>
   <div class="container" >

       <div class="row " style="padding:20px 0px">
           <div class="ady-row">
<?php

$l_UR_id                     = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
$l_UR_Type                = $_SESSION['g_UR_Type'];
//che the User Id is Empty
//Check The User Login As Mentor Or Guide
if(is_null($l_UR_id) || ($l_UR_Type!='G' && $l_UR_Type!='M'))
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a guide. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}
else
{

print('<div style="clear:left">');
//set the time zone
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_current_date = $date->format( 'Ymd' );
if(isset($_POST['SaveRec']))
{
$timezone = new DateTimeZone("Asia/Kolkata" );
    $date = new DateTime();
    $date->setTimezone($timezone );
    $l_current_date = $date->format( 'Ymd' );
    
    $l_UR_id                             = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
   
   // $l_PR_id                              = $_POST['l_PR_id'];   // not used
   // $l_TM_id                             = $_POST['l_TM_id'];    // not used
   
    $l_Student_id                      = $_POST['l_Student_id'];

    $l_TM_id_arr                    = $_POST['l_TM_id_arr'];
    $l_PR_id_arr                    = $_POST['l_PR_id_arr'];  // added dis line

    if ( $_POST['l_ST_Marks_arr_input']=='' )
    {
    $l_ST_Marks_arr            = 'null';
    }
    else
    {
    $l_ST_Marks_arr            =$_POST['l_ST_Marks_arr_input'];
    }

    if ($_POST['l_ST_Feedback_arr_input'] =='' )
    {
    $l_ST_Feedback_arr            = 'null';
    }
    else
    {
    $l_ST_Feedback_arr		= $_POST['l_ST_Feedback_arr_input'];
    }

    
    for ( $l_Student_arr_index = 0; $l_Student_arr_index < count($l_Student_id); $l_Student_arr_index ++)
    {
        // Query on the existing student marks
        $l_student_query = 'SELECT ST_Marks FROM Student_Results WHERE Org_id="'.$_SESSION['g_Org_id'].'" and UR_Student ="'.$l_Student_id[$l_Student_arr_index].'"
                                               and UR_GuideMentor = "'.$l_UR_id.'" ';
        $l_student_res = mysql_query($l_student_query);
        $l_student_row = mysql_fetch_row($l_student_res);
        //$l_ST_Marks = '';
        $l_ST_Marks_SR = $l_student_row[0];
        $l_ST_Marks_Submit = $l_ST_Marks_arr [$l_Student_arr_index];
        
        if (is_null( $l_ST_Marks_SR))
        {
            if($l_ST_Feedback_arr[$l_Student_arr_index]==NULL)
                {
                    $l_ST_Feedback_arr[$l_Student_arr_index]="No Feedback";
                }

                if($l_ST_Marks_Submit != null)
                    {
                    //Insert the Feedback and Marks
                $l_query = "insert into  Student_Results  (UR_Student, PR_id, TM_id , UR_GuideMentor ,  ST_Marks, ST_ResultDate,  ST_Feedback ,Org_id) values (\"".$l_Student_id[$l_Student_arr_index]."\", ". $l_PR_id_arr[$l_Student_arr_index].", ".$l_TM_id_arr[$l_Student_arr_index].", \"".$l_UR_id."\"," .$l_ST_Marks_arr [$l_Student_arr_index].",".$l_current_date.",\"".$l_ST_Feedback_arr[$l_Student_arr_index] . "\",\"".$_SESSION['g_Org_id']."\")";
                            
            mysql_query($l_query);
                    }
        }
        mysql_free_result($l_student_res);
    }

    // Get the TM_id for the Guide/Mentor from guide Req--- TM_id_arr[]
    // Get the students from Users -- Student_id_arr[]

    
    for ($l_TM_id_count = 0 ; $l_TM_id_count < count($l_TM_id_arr); $l_TM_id_count ++)
    {
        // Check for the team, count of students
        $l_count_student_sql = 'Select count(*) from Users as UR where UR.TM_id = '.$l_TM_id_arr[$l_TM_id_count].'';
        $l_count_student_res    = mysql_query($l_count_student_sql);
        $l_count_student_row  = mysql_fetch_row($l_count_student_res);
        
        $l_count_students   = $l_count_student_row[0];

        $l_UR_Guide_sql = 'Select UR_id_Guide from Teams where  TM_id = '.$l_TM_id_arr[$l_TM_id_count].'';
        $l_UR_Guide_res    = mysql_query($l_UR_Guide_sql);
        $l_UR_Guide_row    = mysql_fetch_row($l_UR_Guide_res);

        // Check in student_results for the team_id how many students are awarded marks
        $l_count_student_results_sql    = 'Select count(*) from Student_Results as SR where  SR.TM_id =  '.$l_TM_id_arr[$l_TM_id_count].' and SR.UR_GuideMentor = "'.$l_UR_Guide_row[0].'"';
        $l_count_student_results_res    = mysql_query($l_count_student_results_sql);
        $l_count_student_results_row    = mysql_fetch_row($l_count_student_results_res);
        $l_count_student_results = $l_count_student_results_row[0];

       //echo $l_count_students . $l_count_student_results;
        
        if($l_count_students == $l_count_student_results )
            {
            $l_update_Teams_sql = 'Update Teams set TM_EndDate = '.$l_current_date.' where TM_id = '.$l_TM_id_arr[$l_TM_id_count].'';
            mysql_query($l_update_Teams_sql);
             }

    }
}


$l_TM_id_arr       = array ();
$l_PR_id_arr         =array();   // naveen added this line here

if($l_UR_Type == 'G')
    {
            $l_query_TM ='select TM.TM_id, TM.TM_Name, TM.PR_id from Teams as TM where Org_id="'.$_SESSION['g_Org_id'].'" and UR_id_Guide = "'.$l_UR_id.'"
                            and TM.TM_EndDate is null';

    }
else if($l_UR_Type == 'M')
    {
            $l_query_TM ='select TM.TM_id, TM.TM_Name, TM.PR_id from Teams as TM where UR_id_Mentor = "'.$l_UR_id.'"
                            and TM.TM_EndDate is null';

    }

print('<form action="" method = "POST">');
    print('<div class="panel panel-primary" >');
print('<div class="panel-heading"><h5>Give Marks to the Teams</h5></div>');
print('<div class="panel-body table-responsive table" style="background-color: rgba(179, 202, 245, 0.65);">');


$l_result_TM =mysql_query($l_query_TM);    // run the actual SQL
$l_count = mysql_num_rows($l_result_TM);

if($l_count > 0)
{
    print('<table class="ady-table-content" border=1 style="width:100%"> ');
    print ('<tr>');
    print ('<th font-weight:bold"> Student Name </th>');
    print ('<th font-weight:bold"> Project Name </th>');
    print ('<th font-weight:bold">Marks</th>');
    print ('<th font-weight:bold; text-align:center"> Feedback </th>');
    print ('</tr>');

}
else
{
    print('<table class="ady-table-content" border=1 style="width:100%"> ');
    print ('<tr>');
    print ('<td font-weight:bold"> Student Name  </td>');
    print ('<td font-weight:bold"> Project Name </td>');
    print ('<td font-weight:bold">Marks</td>');
    print ('<td font-weight:bold; text-align:center"> Feedback </td>');
    print ('</tr>');
    print ('<tr>');
    print('<td colspan=4>You do not have any teams to give results</td>');
    print ('</tr>');
}
while ($l_row_TM = mysql_fetch_row($l_result_TM))
     {
        $l_TM_id_Teams    = $l_row_TM[0];
        $l_TM_Name        = $l_row_TM[1];

        $l_TM_id_arr[]      = $l_TM_id_Teams;

        $l_PR_id_arr[]  =  $l_row_TM[2];  // naveen added dis line
      
       
        print ('<tr>');
        print ('<td  colspan=4> ' .$l_TM_Name  . '</td>' );
        print ('</tr>' );
        
        $l_query_UR ='select UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName,  PR.PR_Name,   PR.PR_id , TM.TM_id, TM.TM_Name, UR.UR_id from Users as UR, Teams as TM, Projects as PR where TM.TM_id = UR.TM_id and PR.PR_id = TM.PR_id and TM.TM_id = '.$l_TM_id_Teams.' and TM.PR_id = '.$l_row_TM[2];
        $l_result_UR =mysql_query($l_query_UR);    // run the actual SQL
        
        while ($l_row_UR = mysql_fetch_row($l_result_UR))
                {
                    $l_UR_Name      = $l_row_UR[0] . ' ' . $l_row_UR[1] . ' ' . $l_row_UR[2];
                    $l_PR_Name      = $l_row_UR[3];
                    $l_PR_id        = $l_row_UR[4];
                                        
                    $l_TM_id        = $l_row_UR[5];                
                    $l_Student_id   = $l_row_UR[7];
                     
                    print ('<tr>');
                    print ('<td > <br><input class="form-control" type=hidden name= l_UR_Name > ' . $l_UR_Name  . '</td>');
                    print ('<td><br> <input class="form-control" type=hidden name=l_PR_Name_arr_input[]   value="' . $l_PR_Name . '">' .  $l_PR_Name  . '</td>' );
                    
               // print (' <input type=hidden name=l_PR_id  value="' . $l_PR_id . '" >' );  // already exist
               // print (' <input type=hidden name=l_TM_id  value="' . $l_TM_id . '">' );  // already exist
                   
                    print (' <input class="form-control" type=hidden name=l_Student_id[]  value="' . $l_Student_id . '">' );

                    print (' <input class="form-control" type=hidden name=l_TM_id_arr[]  value="' . $l_TM_id . '">' );
                    print (' <input class="form-control" type=hidden name=l_PR_id_arr[]  value="' . $l_PR_id . '">' ); // dis added

             
              //     print('<td></td>');
                    // Query if the marks already exists.
                   $l_student_query = 'SELECT ST_Marks, ST_Feedback FROM Student_Results 
                                                        WHERE UR_Student = "'.$l_Student_id.'"  and UR_GuideMentor = "'.$l_UR_id.'" and Org_id="'.$_SESSION['g_Org_id'].'" AND TM_id='.$l_TM_id.'';
                    $l_student_res = mysql_query($l_student_query);
                    $l_student_row = mysql_fetch_row($l_student_res);
                    if ($l_student_row[0] == NULL)
                    {
                        print('<td><br><input class="form-control" type =text  name =l_ST_Marks_arr_input[]></input></td>');
                        print('<td ><br><input class="form-control" type ="textarea" name =l_ST_Feedback_arr_input[]></input></td>');
                    }
                    else
                    {
                        $l_ST_Marks=$l_student_row[0];
                        $l_ST_Feedback=$l_student_row[1];
                        print ('<td>'.$l_ST_Marks.' <input class="form-control" type=hidden name=l_ST_Marks_arr_input[]    value=""> </td> ');
                        print ('<td>'.$l_ST_Feedback.' <input class="form-control" type=hidden name =l_ST_Feedback_arr_input[]    value=""> </td> ');
                    }
                    print('</tr>');
                    mysql_free_result($l_student_res);

                }///while ($l_row_UR = mysql_fetch_row($l_result_UR))
        mysql_free_result($l_result_UR);

        } //  while ($l_row_D2 = mysql_fetch_row($l_result_D2)):end:
mysql_free_result($l_result_TM);


if($l_count > 0)
{
    print ('<td colspan=6 style="text-align: center;">');
    print ('<input class="btn btn-primary"  type="submit" name=SaveRec   value="Submit Marks">');
    print ('</td>');
}
/*else{
    print('<br><br><br><table class="ady-table-content" border=1 style="width:100%"> ');
    print ('<tr>');
    print ('<td font-weight:bold"> Student Name  </td>');
    print ('<td font-weight:bold"> Project Name </td>');
    print ('<td font-weight:bold">Marks</td>');
    print ('<td font-weight:bold; text-align:center"> Feedback </td>');
    print ('</tr>');
    print ('<tr>');
    print ('<br><td colspan="4" font-weight:"bold"; text-align:"center"> There are no students available.</td>');
    print ('</tr>');
    echo '</table><br></body></html>';
}*/

print('</table><br>');
print('</form>');
print('</div>');
}
?>
</div></div></div>

<?php include('footer.php')?>