<?php
    //////////////////////////////////////////////
    // Name            : GMTeamDocs
    // Project         : Projectory
    // Purpose         : Display Files/Documents of the Teams 
    // Called By       : GHome,MHome
    // Calls           :gmview_team_projfiles02
    // Mod history:
    //////////////////////////////////////////////
 
 include ('header.php');
 include ('db_config.php'); 
 ?>
<div class="row" style="padding:20px"></div>
<div class="container" >
<?php
    $l_UR_id	                 = $_SESSION['g_UR_id'];
    $l_UR_Type                     = $_SESSION['g_UR_Type'];
    $l_UR_Receiver =$l_UR_id;
    
//check the User id is Empty
//Check the user login as a Guide or Mentor
    if(is_null($l_UR_id) || ($l_UR_Type!='G' && $l_UR_Type!='M'))
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a guide. Please login correctly")
        window.location.href="Signout.php" </script> ';
        
        print($l_alert_statement );
    }
    else
    
    ?>
    
   <div class="alert alert-info">
       <h4 style="text-align:center">Please click on the team whose documents you wish to view</h4>
   </div>
    <div class="panel panel-success">
        <div class="panel-heading"><h4>Teams currently under you</h4></div>
         <div class="panel-body table-responsive table">
    
  <?php
    //Check the User Type as Guide 
    if($l_UR_Type == 'G')
    {
    //Select The Teams, Which are currently under The Guide .
        $l_query1 =  "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno,UR.UR_LastLogin,TM.TM_id
        from Projects as PR, Teams as TM, Users as UR where UR.TM_id   = TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Guide   = '".$l_UR_Receiver."'  and TM.TM_EndDate is NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
    }
    //Check the User Type as mentor
    else if ($l_UR_Type == 'M')
    {
    //Select The Teams,Which Are Currently Under The Mentor
        $l_query1 =  "select PR.PR_Name, TM.TM_Name,UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno,UR.UR_LastLogin,TM.TM_id
        from Projects as PR, Teams as TM, Users as UR where UR.TM_id= TM.TM_id and PR.PR_id= TM.PR_id and TM.UR_id_Mentor   = '".$l_UR_Receiver."'  and TM.TM_EndDate is NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
    
    }
    
    $l_proj_res1 = mysql_query($l_query1) or die(mysql_error());    // run the actual SQL
    $l_count1 = mysql_num_rows($l_proj_res1);
    
    if($l_count1 > 0)
    {
        
        print('<table class="ady-table-content" border=1 style="width:100%" >');
        print ('<tr>');
        print ('<th text-align:center">Team </th>');
        print ('<th text-align:center"> Project </th>');
        print ('<th text-align:center">Team Members</th>');
        print ('<th text-align:center">Team Member  Details</th>');
        print ('<th text-align:center">Last Login Details</th>');
        print ('</tr>');
        
        
        $l_prev_teamname = 'Dummyname';
        
        while ($l_row = mysql_fetch_row($l_proj_res1))
        {
            print ('<tr>');
            $l_TM_Name= $l_row[1];
            $l_PR_Name= $l_row[0];
            $l_UR_Name= $l_row[2] . ' ' . $l_row[3] . ' ' . $l_row[4];
            $l_UR_USN= $l_row[5];
            $l_UR_Semester= $l_row[6];
            $l_UR_Phno= $l_row[7];
            $l_UR_LastLogin= $l_row[8];
            $l_TM_id=$l_row[9];
            $l_LoginDate_res= date("d-M-Y   h:i A",          strtotime($l_UR_LastLogin));
            //check the members of team should be same team
            if($l_prev_teamname <> $l_TM_Name)
            {
                print ('<td><a href="GMView_Team_ProjFiles02.php?g_query='.$l_TM_id.'|'.$l_TM_Name.'">'.$l_TM_Name.'</a></td>');
                print ('<td>' . $l_PR_Name. '</td>');
            }
            else
            {
                print ('<td> </td>');
                print ('<td> </td>');
            }
            print ('<td>' . $l_UR_Name. '</td>');
            //print ('<td>' . 'USN- '.$l_UR_USN.' Semester- '. $l_UR_Semester.'Phone- '.$l_UR_Phno.'</td>');
            print ('<td>Semester- '. $l_UR_Semester.'</td>');
            print ('<td>'.$l_LoginDate_res.'</td>');
            $l_prev_teamname =  $l_TM_Name;
            
        }
        
        print ('</table>');
    }
    else
    {
        
        print ('<table class="ady-table-content" border=1 style="width:100%" >');
        print ('<tr>');
        print ('<th >Team </th>');
        print ('<th > Project </th>');
        print ('<th >Team Members</th>');
        print ('<th >Team Member  Details</th>');
        print ('</tr>');
        print ('<tr>');
        print ('<td colspan = "4" font-weight:bold; text-align:center"> There are currently no Teams under you.</td>');
        print ('</tr>');
        print ( '</table>');
    }
    ?>
   </div></div>
   <div class="panel panel-success">
        <div class="panel-heading"><h4>Teams that were under you</h4></div>
         <div class="panel-body table-responsive table"> 
    <?php
    if($l_UR_Type == 'G')
    {
    //select the teams ,which completed the project under the same guide
        $l_query =  "select PR.PR_Name, TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno, TM.TM_id from Projects as PR, Teams as TM, Users as UR where UR.TM_id= TM.TM_id and PR.PR_id= TM.PR_id and TM.UR_id_Guide   = '".$l_UR_Receiver."'  and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
    }
    else if ($l_UR_Type == 'M')
    {
     //select the teams ,which completed the project under the Mentor
    $l_query =  "select PR.PR_Name, TM.TM_Name,UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName, UR.UR_USN, UR.UR_Semester, UR.UR_Phno, TM.TM_id from Projects as PR, Teams as TM, Users as UR where UR.TM_id= TM.TM_id and PR.PR_id   = TM.PR_id and TM.UR_id_Mentor   = '".$l_UR_Receiver."'  and TM.TM_EndDate is not NULL order by TM.TM_Name, UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName";
 
    }
    
    $l_proj_res = mysql_query($l_query) or die(mysql_error());   // run the actual SQL
    $l_count = mysql_num_rows($l_proj_res);
    
    if($l_count > 0)
    {
        
        print('<table class="ady-table-content" border=1 style="width:100%" >');
        print ('<tr>');
        print ('<th text-align:center">Team </th>');
        print ('<th text-align:center"> Project </th>');
        print ('<th text-align:center">Team Members</th>');
        print ('<th text-align:center">Team Member  Details</th>');
        print ('</tr>');
        
        $l_prev_teamname = 'Dummyname';
        
        while ($l_row = mysql_fetch_row($l_proj_res))
        {
            print ('<tr>');
            $l_TM_Name= $l_row[1];
            $l_PR_Name= $l_row[0];
            $l_UR_Name= $l_row[2] . ' ' . $l_row[3] . ' ' . $l_row[4];
            $l_UR_USN= $l_row[5];
            $l_UR_Semester= $l_row[6];
            $l_UR_Phno= $l_row[7];
            $l_TM_id=$l_row[8];
               //check the members of team should be same team
            if($l_prev_teamname <> $l_TM_Name)
            {
                print ('<td><a href="GMView_Team_ProjFiles02.php?g_query='.$l_TM_id.'|'.$l_TM_Name.'">'.$l_TM_Name.'</a></td>');
                print ('<td>' . $l_PR_Name. '</td>');
            }
            else
            {
                print ('<td> </td>');
                print ('<td> </td>');
            }
            print ('<td>' . $l_UR_Name. '</td>');
            //print ('<td>' . 'USN- '.$l_UR_USN.' Semester- '. $l_UR_Semester.'Phone- '.$l_UR_Phno.'</td>');
            print ('<td>Semester- '. $l_UR_Semester.'</td>');
            
            $l_prev_teamname =  $l_TM_Name;
            
        }
        
        print ('</table>');
    }
    else
    {
        
        print ('<table class="ady-table-content" border=1 style="width:100%" >');
        print ('<tr>');
        print ('<th >Team </th>');
        print ('<th >Project </th>');
        print ('<th >Team Members</th>');
        print ('<th >Team Member  Details</th>');
        print ('</tr>');
        print ('<tr>');
        print ('<td colspan = "4" font-weight:bold; text-align:center"> No Teams to show.</td>');
        print ('</tr>');
        print ( '</table>');
    }

    
    ?>
            </div>
        </div> 
</div>
<?php include('footer.php')?>