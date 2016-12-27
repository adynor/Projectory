<?php
    //////////////////////////////////////////////
    // Name :   CProjList02
    // Purpose: Shows the projects details based on the project tapped on in previous page
    // Called By: CProjList01
    // Calls: CProjList01
    //////////////////////////////////////////////

    ?>


<?php   
include ('db_config.php');
include ('header.php');

?>


<div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
           <br><br><br>
<?php
    
    
    print('<div style="clear:left">');
    
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
    
    //get the PR_id from the request from the project list
    if(isset($_GET['PR_id']))
    {
        $l_PR_id = $_GET['PR_id'];
        
        //select the information of the students who have performed the project selected
         $l_PR_sql = 'select distinct(UR.UR_FirstName), UR.UR_id, PR.PR_Name from Users as UR, Projects as PR, Teams as TM where PR.PR_id='.$l_PR_id.' and TM.TM_id=UR.TM_id and TM.PR_id=PR.PR_id and UR.Org_id=PR.Org_id=TM.Org_id = "'.$_SESSION['g_Org_id'].'"' ;
        
        $l_PR_res = mysql_query($l_PR_sql);
        $l_PR_count = mysql_num_rows($l_PR_res);
        
        //check if there are any students who have performed this project in the past
        if($l_PR_count > 0)
        {
            $l_PR_row = mysql_fetch_row( $l_PR_res);
           $l_PR_PrjName      = $l_PR_row[2];
            
            print('<table  id="StudentsList" <table style="width:100%;" border=1 class="ady-table-content ">');
            print ('<tr  >');
            print ('<th>  Project Name</th>');
            print ('<th>  Student Name</th>');
            print ('<th> Student Email</th>');
            //        print ('<th> Student USN</th>');
            print ('<th> Student Phone</th>');
            //        print ('<th> Institute</th>');
           // print ('<th> Program</th>');
            //        print ('<th> Project</th>');
            //        print ('<th> Student<br>Marks</th>');
            //        print ('<th> Feedback</th>');
            print ('</tr>');
            
            print ('<tr ><td  rowspan="'.$l_PR_count.'">'.$l_PR_PrjName.'</td>');
            
            //select the information of the students who have performed the project selected
            
           $l_PR_sql = 'select distinct(UR.UR_FirstName), UR.UR_MiddleName, UR.UR_LastName, UR.UR_Emailid, UR.UR_EmailidDomain, UR.UR_Phno, PR.PR_Name ,SR.ST_Marks, SR.ST_Feedback, SR.TM_id,UR.UR_id from Users as UR, Projects as PR, Teams as TM,Student_Results as SR where PR.PR_id='.$l_PR_id.' and TM.TM_id=UR.TM_id and  SR.PR_id = PR.PR_id AND SR.UR_Student=UR.UR_id  and PR.Org_id = "'.$_SESSION['g_Org_id'].'"' ;
            $l_UR_res = mysql_query($l_PR_sql);
            
            
            while($l_UR_row = mysql_fetch_row($l_UR_res))
            {
                
                $l_UR_Name      = $l_UR_row[0] . ' ' . $l_UR_row[1]. ' ' . $l_UR_row[2] ;
              $l_UR_Emailid    =$l_UR_row[3] . '@' .$l_UR_row[4];
               $l_UR_Phone      = $l_UR_row[5];
               $l_UR_id      = $l_UR_row[10];
                
                print('');
                print( '<td>  <a  href=./CStudentDetails03.php?UR_id='.$l_UR_id.'>' . $l_UR_Name. '</a></td> ');
                print( '<td>' . $l_UR_Emailid. '</td>  ');
                print( '<td>' . $l_UR_Phone. '</td>  ');
                
                print( '</tr>  ');
            }
            print('</table><br>');
        }// if($l_UR_count > 0)
        
        else
        {
            print ('<br><br><table style="width:100%;" border=1 class="ady-table-content ">');
            print ('<tr>');
            print ('<th>  Project Name</th>');
            print ('<th>  Student Name</th>');
            print ('<th> Student Email</th>');
            //        print ('<th> Student USN</th>');
            print ('<th> Student Phone</th>');
            //        print ('<th> Institute</th>');
            print ('<th> Program</th>');
            //        print ('<th> Project</th>');
            //        print ('<th> Student<br>Marks</th>');
            //        print ('<th> Feedback</th>');
            print ('</tr>');
            print ('<tr>');
            print ('<td colspan=5> No students have performed this project.</td>');
            print ('</tr>');
            print('</table><br>');
        }
        
        //}  ////while($l_UR_row = mysql_fetch_row($l_UR_res))
    }///if(isset($_GET['PR_id']))
    //
    ?>
  </div></div>
<?php include('footer.php'); ?>  