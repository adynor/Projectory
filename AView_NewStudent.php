<?php
   
    //////////////////////////////////////////////
    // Name            : Aview_newstudents
    // Project         : Projectory
    // Purpose         : Admin views new students in the portal and approve
    // Called By       : AHome
    // Calls           : AHome
    // Mod history:
    //////////////////////////////////////////////
   
include ('db_config.php');
include ('header.php');  
?>
<div class="row" style="padding:10px"></div>
<div class="row" style="padding:10px"></div>
<div class="container" >
    <br/>
 <?php
   
    
    //session id to local variables
    $l_UR_USN          = $_SESSION['g_UR_USN'];  // this is needed by the SQLs that run in this php
    $l_UR_Name         = $_SESSION['g_UR_Name'];  // this is needed by the SQLs that run in this php
    $l_UR_id                = $_SESSION['g_UR_id'];  // For the communication table we need the from id
    //$l_TM_id            =$_SESSION['g_TM_id'];
    $l_UR_Sender  =$l_UR_id; /// this is for the communication table there we seeing UR_Send
    $l_IT_id           = $_SESSION['g_IT_id'];
    
    $l_UR_Type        = $_SESSION['g_UR_Type'];
    
    //check if the user is logged in and is a college admin
    if(is_null($l_UR_id) || $l_UR_Type!='A')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the college admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';
        
        print($l_alert_statement );
    }

    // check if the button is pressed

    if(isset($_POST['submit']) )
    {
        //check if there are any checked students for confirmation
        
        if(isset ($_POST['l_UR_id_sel']))
        {
                $l_UR_sel_id_arr = $_POST['l_UR_id_sel'];
                $l_size_UR_sel_id_arr = count(  $l_UR_sel_id_arr);
                $l_UR_id_arr_index =0;
                  
                //update confirmed state for the students checked
            
                while ($l_UR_id_arr_index < $l_size_UR_sel_id_arr)
                {
                      $l_upd_query = 'Update Users set UR_RegistrationStatus = "C" where UR_id = "'.$l_UR_sel_id_arr[$l_UR_id_arr_index].'" and Org_id="'.$_SESSION['g_Org_id'].'"';
                      mysql_query($l_upd_query);    // run the actual SQL
                      $l_UR_id_arr_index = $l_UR_id_arr_index + 1;
          
                }
        }
    }
          
    // get the information of the students of pending status of the same institute
    $l_select_sql = 'Select UR.UR_id, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_Type = "S" and UR.UR_RegistrationStatus = "P" and UR.IT_id =  '.$l_IT_id.' and Org_id="'.$_SESSION['g_Org_id'].'"'; //=-=-=- ADD inst later
    $l_result = mysql_query($l_select_sql);
    $l_UR_count = mysql_num_rows($l_result);
    ?>
    <div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading"><h4 style="text-align:center">List Of New Students</h4></div>
  <div class="panel-body table-responsive">
     <?php
    print('<form action="" method="POST">');     
    print('<table class="ady-table-content" border=1 style="width:100%" >');
    print ('<tr>');
    print ('<th >Name </th>');
    print ('<th > USN </th>');
    print ('<th >Semester</th>');
    print ('<th > Email Id </th>');
    print ('<th >Student</th>');
    print ('</tr>');
    
    //if there are no new guides in the portal from your institute
    if($l_UR_count == 0)
    {
        print ('<tr>');
        print('<td colspan=5 ><div style="text-align:center" class="alert alert-danger">There are no new Students</div></td></tr>');
        
    }
    else
    {
        //display all the guide information
        while ($l_row = mysql_fetch_row($l_result))
        {
            print ('<tr>');
            print( '<td>' . $l_row[1]. '</td>');
            print( '<td>' . $l_row[4]. '</td>');
            print( '<td>' . $l_row[5]. '</td>');
            print( '<td>' . $l_row[6].'@'. $l_row[7] .'</td>');
            
            print('<td style="text-align:center">');
            print('<input type="checkbox" class="g_checkbox_select_AL" value="'.$l_row[0].'" name="l_UR_id_sel[]"></td>');
            
            print('</tr>');
        }
        
        print('<tr>');
        print('<td colspan="5" style="text-align:center"><input type="submit" class="btn btn-primary"name="submit" value="Submit" ></td>');
        print( '</tr>');
    }
    
    print('</table>');
    print('</form>');
 
?>

        </div> 
    </div> 
</div> 

<?php include('footer.php')?>