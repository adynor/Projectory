<?php
    //////////////////////////////////////////////
    // Name :   Cmentorlist01
    // Purpose: Shows the mentors list of the company
    // Called By: CHome
    // Calls: NA
    //////////////////////////////////////////////
    
   
    
   include ('db_config.php');
    include ('header.php');
    
    ?>
<div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">

<?php  
    print('<br><br><br><br><div style="clear:left">');
    
    //session id to local variables
    $l_UR_Name             = $_SESSION['g_UR_Name'];
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];
    
    //Check if the user is loggged in and if is a company type
    if(is_null($l_UR_id) || $l_UR_Type!='C')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a company. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';
        
        print($l_alert_statement );
    }
    
    //select all mentors of the same company
    $l_mentor_query = 'select UR.UR_FirstName, UR.UR_MiddleName, UR.UR_LastName,UR.UR_emailid ,UR.UR_emailiddomain, UR.UR_id, UR.UR_Profileinfo from Users as UR Where UR.UR_CompanyName = "'.$l_UR_id.'" and UR.Org_id = "'.$_SESSION['g_Org_id'].'"';
    
    
    $l_result_mentor = mysql_query($l_mentor_query) or die(mysql_error()); //run the actual SQL
    
    print ('<table style="width:100%;" border=1 class="ady-table-content ">');
    print ('<th> Mentor Name </th>');
    print ('<th>Email id</th>');
    print ('<th> Company profile</th>');
    
    //show all the mentor information
    while($l_row_mentor=mysql_fetch_row($l_result_mentor))
    {
        $l_mentor_fname=$l_row_mentor[0];
        $l_mentor_Mname=$l_row_mentor[1];
        $l_mentor_Lname=$l_row_mentor[2];
        $mentorname=$l_row_mentor[0].' '.$l_row_mentor[1].' '.$l_row_mentor[2];
        $l_mentor_emailid= $l_row_mentor[3].'@'.$l_row_mentor[4];
        $l_Profileinfo=$l_row_mentor[6];
        
        print ('<tr >');
        print( '<td>' .$mentorname. '</td>');
        
        print( '<td>' .$l_mentor_emailid. '</td>');
        print( '<td>' .$l_Profileinfo. '</td>');
        print('</tr>');
        
    }
    print('</table>');
    ?>

</div></div>

<?php include('footer.php');?>