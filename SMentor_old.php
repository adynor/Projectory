<?php
 ////////////////////////////////////////
//Name: SMentor
//Purpose : Show all the mentor list to student
//Project: Projectory
//Calls:
//called by:
////////////////////////////////////////

   include ('header.php');
   include ('db_config.php');
    ?>
   <div class="row" style="padding:20px"></div>
   <div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
               
 <?php
 $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
   $previous = $_SERVER['HTTP_REFERER'];
}
print('<a href="'.$previous.'">Back</a>');
    $l_PR_id=$_SESSION['g_PR_id'];
    $l_UR_id=$_SESSION['g_UR_id'];
    $l_TM_id=$_SESSION['g_TM_id'];
    $l_UR_Sender=$l_UR_id;
    $l_TM_Message="I want to add you as my Team Mentor";
    $timezone = new DateTimeZone("Asia/Kolkata" );
    $date = new DateTime();
    $date->setTimezone($timezone );
    $l_CM_Datetime = $date->format( 'YmdHi' );
    $l_TT_SentDateTime = $date->format( 'YmdHi');
    $l_UR_Type = $_SESSION['g_UR_Type'];
    
    /*Check The Mentor Status*/
    
    $l_query_MStatus='Select MR.MR_ResponseDateTime FROM Mentor_Requests AS MR WHERE MR.TM_id ='.$l_TM_id.' AND MR.MR_ResponseDateTime is NULL and MR.Org_id = "'.$_SESSION['g_Org_id'].'"';
    $l_result_MStatus= mysql_query($l_query_MStatus);
    if($l_result_MStatus){
    $l_count_MStatus=mysql_num_rows($l_result_MStatus);
    }
    /*Mentor Status End*/
    
    // nav checking if project is added by guide a
    
          
          $l_query_UR='select UR.UR_Type from Users as UR where UR.UR_id= (select PR.UR_Owner from Projects as PR where PR.PR_id='.$l_PR_id.') and UR.Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_URType= mysql_query($l_query_UR);
          $l_row_URtype = mysql_fetch_row($l_result_URType);
          
          $l_UR_Gtype=$l_row_URtype[0];
          
          if(is_null($l_UR_id) || $l_UR_Type!='S') {
          
          $l_alert_statement =  ' <script type="text/javascript">
          window.alert("You have not logged in as a student. Please login correctly")
          window.location.href=" login"; </script> ';
          
          print($l_alert_statement );
          }
          
          else if($l_UR_Gtype=='G' && $l_UR_PR_Type =='C') {
          
          
          print ('<table class="ady-table-content" border="1" width="100%" >');
          print ('<th> Name </th>');
          print ('<th> Email ID </th>');
          print ('<th> Phone Number </th>');
          print ('<th> Select Guide </th></tr>');
          print ('<tr><td colspan=5><div class="alert alert-danger">Sorry!! You cannot add  Mentor in this project</div></td></tr>');
          print ('</table>');
          
          }
          else
          {
          
          print('<div style="clear:left">');
          if(!empty($l_TM_id))
          {
          $l_query_checkMentor='select UR_id_Mentor,UR_id_Guide from Teams where TM_id='.$l_TM_id.' and Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_checkMentor=mysql_query($l_query_checkMentor) ;
          $l_row_Mentor=mysql_fetch_row($l_result_checkMentor);
          $l_Mentor=$l_row_Mentor[0];
          $l_Guide=$l_row_Mentor[1];
          }
          print ('<form action="" method="POST">');
          
          if($l_TM_id==NULL || ($l_Guide==NULL && $l_UR_PR_Type=="C"))
          {
          if($l_UR_PR_Type == "C"){
          $l_alert_statement =  ' <script type="text/javascript"> var x=window.alert("You can not add a Mentor since you do not have a Team prepared or selected a Guide!"); window.location=" SHome.php"; </script> ';
           print($l_alert_statement );
          
          }else{
                 if(isset($_POST['yes']))  // if student wants to perform project alone and pressed Yes
        {
            $l_countteam_query = 'select max(TM_id) from Teams WHERE Org_id = "'.$_SESSION['g_Org_id'].'"';
            $l_countteam_result = mysql_query($l_countteam_query) or die(mysql_error());
            
            if ($l_countteam_row = mysql_fetch_row($l_countteam_result))
            {
                if($l_countteam_row[0] == NULL)
                {
                    $l_countteam_row[0] = 0;
                }
                $l_TM_id = $l_countteam_row[0] + 1;
                $l_insert_Receiver = 'insert into Teams (TM_id, TM_Name, PR_id, TM_StartDate,Org_id) values ('.$l_TM_id .',\' Team'.$l_TM_id.' \', \''.$l_PR_id.'\','.$l_CM_Datetime.',"'.$_SESSION['g_Org_id'].'")';
                mysql_query( $l_insert_Receiver) or die(mysql_error());
            }
            
            $l_upd_Sender = 'Update Users set TM_id = '.$l_TM_id.'
            where UR_id = "'.$l_UR_id.'" and Org_id = "'.$_SESSION['g_Org_id'].'"';
            $l_upd_Sender= mysql_query($l_upd_Sender) or die(mysql_error());
            $_SESSION['g_TM_id']=$l_TM_id;
            
        }
        else if(isset($_POST['no']))   // student doesn't want to perform projects alone and presses NO
        {
          echo "<script> window.location.href = 'STeam.php'</script>"; 
        } 
            print ('<form action="" method="POST">');
            print('<div class="panel panel-primary"><div class="panel-heading">');
            print('<center><div class="" style="font-size:18px;color:#FFFFFF">Do you wish to commence this project alone?</div></center>');
            print('</div><div class="panel-body">');
            print ('<center><input class="btn-primary ady-cus-btn" style="margin: 0px 45px;" type=submit value="yes" name=yes></input>');
            print ('<input class="btn-primary ady-cus-btn"  style="margin: 0px 45px;"  type=submit value="no" name=no></input></center>');
            print('</div></div>');
            print('</form>');
          }
         
          }
          else if(!is_null($l_Mentor) ) {
          
          print ('<table class="ady-table-content" border="1" width="100%" >');
          print ('<th> Name </th>');
          print ('<th> Email ID </th>');
          print ('<th> Phone Number </th>');
          print ('<th> Select Guide </th></tr>');
          print ('<tr><td colspan=5><div class="alert alert-danger">Sorry!! You cannot add any Mentor in the middle of the project</div></td></tr>');
          print ('</table>');
          }
          else if($l_TM_id==-99)
          {
          
          $l_alert_statement =  ' <script type="text/javascript"> var x=window.alert("You still have some pending Requests!") window.location=" SHome.php"; </script> ';
          print($l_alert_statement );
          }
          
          
          else if($l_TM_id!=NULL && $l_TM_id!=-99)
          {
          /*If mentor request pending*/
             if( $l_count_MStatus >0 )
              {
          print ('<table class="ady-table-content" border="1" width="100%" >');
          print ('<th> Name </th>');
          print ('<th> Email ID </th>');
          print ('<th> Phone Number </th>');
          print ('<th> Select Guide </th></tr>');
          print ('<tr><td colspan=5><div class="alert alert-danger">Sorry Your Mentor Request Pending</div></td></tr>');
          print ('</table>');
              }
          else
             {
          $l_query_pm='select UR_owner from Projects where PR_id='.$l_PR_id.' and Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_pm= mysql_query($l_query_pm);    // get project owner-id
          $l_row_pm = mysql_fetch_row($l_result_pm);
          
          $l_query_mentor='select UR_id ,UR_FirstName, UR_LastName, UR_Emailid, UR_EmailidDomain,UR_Phno from Users where UR_id="'.$l_row_pm[0].'" and (Org_id = "'.$_SESSION['g_Org_id'].'" OR Org_id = "AL")';
          $l_result_mentor = mysql_query($l_query_mentor);    // get owner name
          
          //for company name and id
          
        $l_sql_Companyid= 'select UR_CompanyName from Users where UR_id="'.$l_row_pm[0].'" and Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_Companyid = mysql_query($l_sql_Companyid);      // get company id of the project owner
          $l_row_Companyid = mysql_fetch_row($l_result_Companyid);
          
          $l_sql_CompanyName = 'select  UR.UR_FirstName , UR_LastName from Users as UR where UR_id = "'.$l_row_Companyid[0].'" and Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_CN = mysql_query($l_sql_CompanyName);   // get company name of the project owner
          $l_row_CN = mysql_fetch_row($l_result_CN);
          
          $l_count_mentor= mysql_num_rows($l_result_mentor);
          
          
          print ('<table class="ady-table-content" border="1" width="100%" >');
          print ('<th> Name </th>');
          print ('<th> Email ID </th>');
          print ('<th> Phone Number </th>');
          print('<th>Company name</th>');
          print ('<th> Select mentor </th>');
          
          
          if( $l_count_mentor > 0)
          {
          while($l_row_mentor=mysql_fetch_row($l_result_mentor))
          {
          
          print('<tr>');
          $l_UR_Receiver=$l_row_mentor[0];
          print('<td><a href=" MentorDetails.php?g_query='.$l_UR_Receiver.'|'.$l_PR_id.'">'.$l_row_mentor[1].' '.$l_row_mentor[2].'</a></td>');
          print('<td>'.$l_row_mentor[3].'@'.$l_row_mentor[4].'</td>');
          print('<td>'.$l_row_mentor[5].'</td>');
          print('<td>'.$l_row_CN[0].'</td>');
          print('<td style="text-align:center">
<a  class="btn btn-primary" href="SInsertMentor.php?g_query='.$l_UR_Sender.'|'.$l_UR_Receiver.'|'.$l_TM_id.'|'.$l_TT_SentDateTime .'|'.$l_TM_Message.'|MR">Send Request</a></td>');
          print('</tr>');
          }
          }
          else
          {
          print('<tr><td colspan = 6>There are not other Mentors in this company</td></tr>');
          }
          print ('</table><br><br>');
          
          
          ////naveen  u have your code from here for all company mentors
          
          // new query for technology based mentors
       echo $l_query='SELECT distinct(US.UR_id) FROM UR_Subdomains as US, Project_SubDomains as PS WHERE PS.PR_id='.$l_PR_id.' and PS.SD_id = US.SD_id and US.UR_id<>"'.$l_row_pm[0].'" and ( US.Org_id = "'.$_SESSION['g_Org_id'].'" OR US.Org_id = "AL")';
        //echo "<br>";

          $l_mentor_query=mysql_query($l_query);
          $l_count_techUser= mysql_num_rows($l_mentor_query);
          
          print ('<table class="ady-table-content" border="1" width="100%" >');
          print ('<th> Name </th>');
          print ('<th> Email ID </th>');
          print ('<th> Phone Number </th>');
          print ('<th> Company name </th>');
          print ('<th> Select mentor </th>');
          
          if( $l_count_techUser > 0)
          {
          
          while($l_mentor_list=mysql_fetch_row($l_mentor_query))
          {
          
          $l_query_techUser=' select outerUR.UR_FirstName, outerUR.UR_LastName, outerUR.UR_Emailid,outerUR.UR_EmailidDomain,outerUR.UR_Phno,outerUR.UR_id FROM Users as outerUR WHERE outerUR.UR_type="M" and outerUR.UR_id="'.$l_mentor_list[0].'" and outerUR.Org_id = "'.$_SESSION['g_Org_id'].'"';
          //echo "<br>";
          $l_result_techUser = mysql_query($l_query_techUser);
          $l_rows_techUser = mysql_fetch_row($l_result_techUser);
          $count=mysql_num_rows($l_result_techUser);
          
          if($count!=0)
          {
          $counter_mentor +=1;
         $l_sql_Companyid= 'select UR_CompanyName from Users where UR_id="'.$l_rows_techUser[5].'" and Org_id = "'.$_SESSION['g_Org_id'].'"';
          $l_result_Companyid = mysql_query($l_sql_Companyid);
          $l_row_Companyid = mysql_fetch_row($l_result_Companyid);
          //echo "<br>";

        $l_sql_CompanyName = 'select  UR.UR_FirstName , UR_LastName from Users as UR where UR_id = "'.$l_row_Companyid[0].'" and UR.Org_id = "'.$_SESSION['g_Org_id'].'"';
       //echo "<br>";

          $l_result_CN = mysql_query($l_sql_CompanyName);
          $l_row_CN = mysql_fetch_row($l_result_CN);
          
          print('<tr>');
          $l_UR_Receiver=$l_rows_techUser[5];
          print('<td><a href=" MentorDetails.php?g_query='.$l_UR_Receiver.'|'.$l_PR_id.'">'.$l_rows_techUser[0].' '.$l_rows_techUser[1].'</a></td>');
          print('<td>'.$l_rows_techUser[2].'@'.$l_rows_techUser[3].'</td>');
          print('<td>'.$l_rows_techUser[4].'</td>');
          print('<td>'.$l_row_CN[0].'</td>');
          print('<td style="text-align:center"><input type="button" class="btn-primary ady-req-btn" value="Send Request" onClick="window.location=\' SInsertMentor.php?g_query='.$l_UR_Sender.'|'.$l_UR_Receiver.'|'.$l_TM_id.'|'.$l_TT_SentDateTime .'|'.$l_TM_Message.'|MR\'"></input></td>');
          print('</tr>');
          
          }
         
          
          }
          }
          if( empty($counter_mentor) || $l_count_techUser==0)
          {
          
          print('<tr><td colspan = 6> No other Mentors in this company</td></tr>');
          }
          print ('</table>'); // code for all mentors of same company
          }
          }
          }
          
          
          print('</div>');
          ?>
 </div>
       </div>
</div>
   <?php include('footer.php')?>