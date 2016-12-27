<?php
//////////////////////////////////////////////
// Project          : projectory
// Purpose         : college admin will insert the semester
// Called By      : AHome01.php
// Calls             :AHome01.php
// Mod history:
//////////////////////////////////////////////

include ('db_config.php');
include ('header.php');  
?>
<div class="row" style="padding:10px"></div>
<div class="row" style="padding:10px"></div>
<div class="container" >
    <br />
    <?php

$l_UR_id         = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
$l_UR_Semester   = $_SESSION['g_UR_Semester'];
$l_IT_id         = $_SESSION['g_IT_id'];
$l_PG_id         = $_SESSION['g_PG_id'];
$l_UR_Type       = $_SESSION['g_UR_Type'];
//For check the admin or not
if(is_null($l_UR_id) || $l_UR_Type!='A')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the college admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';

        print($l_alert_statement );
}


$l_sql ='SELECT PG_id, PG_Name FROM  Programs where Org_id="'.$_SESSION['g_Org_id'].'"';
$l_result =mysql_query($l_sql);
 if(isset($_POST['SaveRec']))
    {
      checkout();
    }

?>
   <div class="alert alert-info">
       <form action="" method="POST">
           
           <div class="row">
                <div class="col-md-5">
                   <div class="controls">
                       <label class="control-label" for="username">Student Department</label>
                       <select class="form-control input-lg" name="l_PG_id[]">
                           <?php
                                while ($l_data=mysql_fetch_row($l_result))
                                    {
                                        $l_PG_id=$l_data[0];
                                        $l_PG_Name=$l_data[1];
                                        print ('<option value='. $l_PG_id. '>'. $l_PG_Name. '</option> ' );
                                    }
                                mysql_free_result($l_result);
                           ?>
                       </select>
                    </div>
               </div>
               <div class="col-md-5">
                   <div class="controls">
                       <label class="control-label" for="username">Enter Semester</label>
                        <input type="text"  name="l_UR_Semester[]" placeholder="" class="form-control input-lg">
                    </div>
               </div>
             
               <div class="col-md-2">
                   <div class="controls">
                        <label class="control-label" for="Search" style="visibility: hidden;">.</label>
                         <input type="submit" class="form-control btn btn-primary input-lg" name="SaveRec"   value="Search" >
                    </div>
                </div>
           </div>
           </form>

 <?php
function checkout()  /// sending all sessions  to ordering02confirm_add.php against the Checkout button
// called when the checkout button is pressed
{
    $l_UR_Semester_arr             = $_POST['l_UR_Semester'];
    $l_PG_id_arr                          = $_POST['l_PG_id'];

   $l_UR_Semester_stg             =array_shift($l_UR_Semester_arr) ;// this converting the array to string and passing the sessions to next page
   $l_PG_id_stg                  =array_shift( $l_PG_id_arr) ;// this converting the array to string and passing the sessions to next page

   $_SESSION["g_UR_Semester"]          = $l_UR_Semester_stg ;
   $_SESSION["g_PG_id"]             = $l_PG_id_stg ;

   echo "<script> window.location.href = 'AAdd_Results.php'</script>"; 
 }

?>
    </div> 
</div> 
<?php include('footer.php')?>