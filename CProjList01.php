<?php
    //////////////////////////////////////////////
    // Name :   CProjList01
    // Purpose: Shows the projects list by the company
    // Called By: CHome
    // Calls: CProjList02
    //////////////////////////////////////////////
include ('db_config.php');
include ('header.php');

?>


<div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
<?php
    
    
    //session id to local variables
    $l_UR_Name             = $_SESSION['g_UR_Name'];
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];
    
    //Check if the user is loggged in and if is a company type
    if(is_null($l_UR_id) || $l_UR_Type!='C')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a company. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login.php"; </script> ';
        
        print($l_alert_statement );
    }
    
    
    $l_PR_Name = 'Dummyname';
    $l_SD_Name = 'Dummyname';
    
    print('<form action="" method="POST">');
    
    if(isset($_POST['SaveRec']))
    {
        $l_PR_Name             = $_POST['l_PR_Name'];
        $l_SD_Name             = $_POST['l_SD_Name'];
        if($l_SD_Name==-99)
            $l_SD_Name='Dummyname';
        if($l_PR_Name=='')
            $l_PR_Name='Dummyname';
        
        //echo "PR_Name.".$l_PR_Name.".".'<br>';
        //echo "SD_Name ".$l_SD_Name.'<br>';
    }
    
    //select projects and their details from the compny
    if ($l_PR_Name == 'Dummyname' && $l_SD_Name=='Dummyname') /// no filters
    {
        $l_query='Select distinct PR.PR_id, PR.PR_Name, PR.PR_Desc, PR.PR_ComplexityLevel, PR.PR_SynopsisURL, PR.PR_NoOfPastAttempts, outerUR.UR_FirstName, outerUR.UR_LastName from Users as outerUR, Projects as PR where PR.UR_Owner = (select UR.UR_id from Users as UR where UR.UR_CompanyName = "'.$l_UR_id.'" and outerUR.UR_id = UR.UR_id) and PR.Org_id = "'.$_SESSION['g_Org_id'].'"';
        
    }
    
    else if ($l_PR_Name == 'Dummyname' && $l_SD_Name!='Dummyname') ///with project name filter
    {
        $l_query='Select distinct PR.PR_id, PR.PR_Name, PR.PR_Desc, PR.PR_ComplexityLevel, PR.PR_SynopsisURL, PR.PR_NoOfPastAttempts, outerUR.UR_FirstName, outerUR.UR_LastName from Users as outerUR,  Projects as PR, SubDomain SD,Project_SubDomains PS
        where PR.PR_id=PS.PR_id
        and PS.SD_id=SD.SD_id
        and SD.SD_Name like "%'.$l_SD_Name.'%"
        and PR.UR_Owner = (select UR.UR_id from Users as UR where UR.UR_CompanyName = "'.$l_UR_id.'" and outerUR.UR_id = UR.UR_id) and PR.Org_id = "'.$_SESSION['g_Org_id'].'"';
        
        
    }
    
    
    else if ($l_PR_Name != 'Dummyname' and $l_SD_Name=='Dummyname') ///with technologies selected in filter
    {
        $l_query='Select PR.PR_id, PR.PR_Name, PR.PR_Desc, PR.PR_ComplexityLevel, PR_SynopsisURL, PR_NoOfPastAttempts, outerUR.UR_FirstName, outerUR.UR_LastName from Users as outerUR,  Projects as PR where PR.PR_Name like "%'.$l_PR_Name.'%" and PR.UR_Owner = (select UR.UR_id from Users as UR where UR.UR_CompanyName = "'.$l_UR_id.'" and outerUR.UR_id = UR.UR_id) and PR.Org_id = "'.$_SESSION['g_Org_id'].'"';
    }
    
    else if ($l_PR_Name != 'Dummyname' && $l_SD_Name!='Dummyname') ///with project name and technologies selected in filter
    {
        $l_query='Select distinct PR.PR_id, PR.PR_Name, PR.PR_Desc, PR.PR_ComplexityLevel, PR.PR_SynopsisURL, PR.PR_NoOfPastAttempts, outerUR.UR_FirstName, outerUR.UR_LastName from Users as outerUR, Projects as PR,Project_SubDomains PS,SubDomain SD
        where PR.PR_id=PS.PR_id
        and PS.SD_id=SD.SD_id
        and PR.Org_id = and SD.Org_id 
        and PR.Org_id = "'.$_SESSION['g_Org_id'].'"
        and PR.PR_Name like "%'.$l_PR_Name.'%"
        and SD.SD_Name like "%'.$l_SD_Name.'%"
        and PR.UR_Owner = (select UR.UR_id from Users as UR where UR.UR_CompanyName = "'.$l_UR_id.'" and outerUR.UR_id = UR.UR_id)';
        
        
    }
    
    $l_result=mysql_query($l_query);
    
    print('<br><br><br><div class="alert alert-info"><table class="ady-table-content" style="width:100%">');
    print ('<tr><td>Search by Project Name  <input class="form-control " type=text name=l_PR_Name ></td>');
    print ('<td> Filter by domain <select  class="form-control" name="l_SD_Name" align="right">');
    //to show all the technologies in the filter
    $l_sql_SD      ='SELECT SD_Name, SD_id FROM SubDomain WHERE Org_id = "'.$_SESSION['g_Org_id'].'"';
    $l_result_SD =mysql_query($l_sql_SD);
    $l_row = 'Dummyname';
    while ($l_data=mysql_fetch_row($l_result_SD))
    {
        if($l_row == 'Dummyname')
        {
            print ('<option value="-99">--</option>' );
        }
        else
        {
            print ('<option value='. $l_data[0]. '>'. $l_data[0]. '</option> ' );
        }
        $l_row = $l_data[0];
    }
    mysql_free_result($l_result_SD);
    print('</select>');
    print('</td>       ');
    
    print ('<td style="padding-top: 25px; text-align:center" colspan=4> <input class="form-control ady-req-btn btn-primary" type=submit name="SaveRec"  accesskey=Alt-S value="Search Project" ></td>');
    print('</tr>');
    print('</table></div><br>');
    
    $l_PR_count = mysql_num_rows($l_result);
    
    if($l_PR_count == 0)     //if the number of projects to show are 0
    {
        print('<br><table class="ady-table-content" border=1 style="width:100%">');
        print ('<tr>');
        print ('<th >Project  Name </th>');
        print ('<th > Project Description </th>');
        print ('<th>View Synopsis</th>');
        print ('<th >Mentor</th>');
        print ('<th >Edit Project </th>');
        
        print ('</tr>');
        
        print ('<td colspan =5><br>There are no projects to  shown </td>');
        print('</table><br>');
        
    }
    else   //if the number of projects to show are more than 0
    {
        
        // print all the column header - ie the column names
        print('<br><table class="ady-table-content" border=1 style="width:100%">');
        print ('<tr>');
        print ('<th >Project  Name </th>');
        print ('<th > Project Description </th>');
        print ('<th> Current <br> Applications</th>');
        print ('<th >View Synopsis</th>');
        print ('<th >Mentor</th>');
        print ('<th>Edit Project</th>');
        
        
        print ('</tr>');
        // Get DateTime
        $timezone = new DateTimeZone("Asia/Kolkata" );
        $date = new DateTime();
        $date->setTimezone($timezone );
        $l_CM_DateTime = $date->format( 'YmdHi' );
        
        //show the list of details of the project based on the filters
        while ($l_row = mysql_fetch_row($l_result))
        {
            $l_PR_id                = $l_row[0];
            $l_PR_Name              = $l_row[1];
            $l_PR_Desc              = $l_row[2];
            $l_PR_ComplexityLevel   = $l_row[3];
            $l_PR_URL               = $l_row[4];
            $l_PR_NoOfPastAttempts  = $l_row[5];
            $l_UR_Owner             = $l_row[6].' '.$l_row[7];
            print ('<tr>');
            print( '<td>  <a  href=./CProjList02?PR_id='.$l_PR_id.'>'.$l_PR_Name.'</a></td>');
            print( '<td>  '.$l_PR_Desc.'</td>');
            
            $l_PR_NoOfCurrentApp_query  = 'Select count(TM_id) from Teams
            where PR_id = '.$l_PR_id.' and TM_EndDate is NULL and Org_id = "'.$_SESSION['g_Org_id'].'"';
            $l_PR_NoOfCurrentApp_res    = mysql_query($l_PR_NoOfCurrentApp_query);
            $l_PR_NoOfCurrentApp_row    = mysql_fetch_row($l_PR_NoOfCurrentApp_res);
            $l_PR_NoOfCurrentApp         = $l_PR_NoOfCurrentApp_row[0];
            
            
            print ('<td>'.$l_PR_NoOfCurrentApp.'</td>');
            print("<td> <input class='btn btn-primary' type=button onClick=\"location.href='".$l_PR_URL."'\" value='Download'></td>") ;
            print ('<td>'.$l_UR_Owner.'</td>');
            print('<td> <input class="btn btn-primary" type=button value="Edit Project" onClick="location.href=\''.$l_filehomepath.'/EditProject.php?g_PR_id='.$l_PR_id.'\'" ></td>') ;
            print ('</tr>');
            
            mysql_free_result($l_PR_NoOfCurrentApp_res);
        }//// while ($l_row = mysql_fetch_row($l_result))
        print('</table><br></body></html>');
    }
   
    
?> 
 </div></div>
<?php include('footer.php'); ?>  