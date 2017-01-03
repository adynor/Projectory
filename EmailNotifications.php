<?php
    @session_start();
    //////////////////////////////////////////////
    // Name :   EmailNotifications
    // Purpose: This is email notifications to send notification mails to the team members and the mentors and guides.
    // Called By: multiple pages
    // Calls: multiple pages
    //////////////////////////////////////////////
    
   include ('db_config.php');    
   include ('LinkHeader.php');
    
    
    //get request from the previous page
    $l_Details=$_REQUEST['g_query'];
    
    
    $l_Details=str_replace("\\","",$l_Details);
    $l_array = explode("|",$l_Details);
    //extract the user type
    $l_UR_Type = $l_array[0];
    //if user is a student
    if($l_UR_Type == 'Student')
    {
        
        $l_UR_id        =  $_SESSION['g_UR_id'];
        $l_TM_id        = $l_array[1];
        $l_AccessType   = $l_array[2];
        
        // to notify other members of the team about submission of document
        $l_query_Teammates = 'Select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_id<>"'.$l_UR_id .'" and Org_id="'.$_SESSION['g_Org_id'].'" and UR.TM_id = '.$l_TM_id;
        $l_result_Teammates  = mysql_query($l_query_Teammates);
        $l_count_Teammates = mysql_num_rows($l_result_Teammates);
        
        $l_webMaster = 'support@zaireprojects.com';
        if($l_count_Teammates>0)
        {
            while($l_row_Teammates=mysql_fetch_row($l_result_Teammates))
            {
                $l_UR_EmailidTeammate = $l_row_Teammates[0];
                $l_UR_EmailidDomainTeammate = $l_row_Teammates[1];
                
                
                $toEmailid = $l_UR_EmailidTeammate.'@'.$l_UR_EmailidDomainTeammate;
                $subject     = 'Document Submit';
                $l_message = 'Hi, <br><br> Your team has submitted a/an '.$l_AccessType.' successfully!<br><br>Regards, <br>Zaireproject Support Team';
                $l_headers2 = "From: $l_webMaster\r\n";
                $l_headers2 .= "Content-type:  text/html\r\n";
                mail($toEmailid ,$subject,$l_message,$l_headers2);
            }
        }
        
        //to get the name of the team
        $l_TM_Name_query = 'select TM.TM_Name from Teams  as TM where Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id ='.$l_TM_id;
        $l_TM_Name_result  = mysql_query($l_TM_Name_query);
        $l_TM_Name_row  = mysql_fetch_row($l_TM_Name_result);
        $l_TM_Name = $l_TM_Name_row[0];
        
        // to notify team guide submission of document
        
        $l_guide_sql = 'Select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_id = (Select TM.UR_id_Guide from Teams as TM where Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id ='.$l_TM_id.')';
        $l_guide_res  = mysql_query($l_guide_sql);
        $l_guide_row  = mysql_fetch_row($l_guide_res);
        
        $l_GuideMail = $l_guide_row[0] . '@' . $l_guide_row[1];
        
        $subject= 'Team Document Submit';
        
        $l_message       = 'Hi, <br><br>'.$l_TM_Name.' has submitted a/an '.$l_AccessType.'. Please give your feedback by logging into your account and view them in '.$l_filehomepath.'/GMview_Team_ProjFiles01 <br><br>  Regards, <br>Zaireprojects Team';
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
        
        mail($l_GuideMail,$subject,$l_message,$l_headers2);
        
        // to notify team mentor submission of document
        
        $l_mentor_sql= 'Select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_id = (Select TM.UR_id_Mentor from Teams as TM where Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id= '.$l_TM_id.')';
        $l_mentor_res  = mysql_query($l_mentor_sql);
        $l_mentor_row  = mysql_fetch_row($l_mentor_res);
        
        $l_MentorMail = $l_mentor_row[0] . '@' . $l_mentor_row[1];
        
        $subject= 'Team Document Submit';
        
        $l_message       = 'Hi, <br><br>'.$l_TM_Name.' has submitted a/an '.$l_AccessType.'. Please give your feedback by logging into your account and view them in '.$l_filehomepath.'/GMview_Team_ProjFiles01 <br><br>  Regards, <br>Zaireprojects Team';
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
        
        mail($l_MentorMail,$subject,$l_message,$l_headers2);
        
echo "<script>window.location.href='SHome.php'</script>";
        
    }
    //if user is a guide
    else if ($l_UR_Type == 'Guide')
    {
        $l_TM_id        = $l_array[1];
        $l_PD_id        = $l_array[2];
        $l_PD_Feedback  = $l_array[3];
        $l_PD_Status    = $l_array[4];
        $l_PD_sql = 'select PD.PD_Name from Project_Documents as PD where PD.Org_id="'.$_SESSION['g_Org_id'].'" and PD.PD_id = '.$l_PD_id;
        
        $l_PD_res = mysql_query($l_PD_sql);
        $l_PD_row = mysql_fetch_row($l_PD_res);
        
        
        $l_PD_Name = $l_PD_row[0];
        
        //To notify all students of the team about guide feedback
        
        $l_query = 'select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where Org_id="'.$_SESSION['g_Org_id'].'" and UR.TM_id = '.$l_TM_id;
        $l_result_Teammates  = mysql_query($l_query);
        $l_count = mysql_num_rows($l_result_Teammates);
        if($l_PD_Status == 'A')
        {
            $l_PD_Status = 'Accepted';
        }
        else if ($l_PD_Status == 'R')
        {
            $l_PD_Status = 'Rejected';
        }
        
        if($l_count>0)
        {
            while($l_row_Teammates=mysql_fetch_row($l_result_Teammates))
            {
                
                $l_UR_EmailidTeammate = $l_row_Teammates[0];
                $l_UR_EmailidDomainTeammate = $l_row_Teammates[1];
                
                $l_webMaster = 'support@zaireprojects.com';
                $toEmailid = $l_UR_EmailidTeammate.'@'.$l_UR_EmailidDomainTeammate;
                $subject     = 'Document Feedback';
                $l_message         = 'Hi,<br><br>  Your '.$l_PD_Name.' has been '.$l_PD_Status.'. Your Guide\'s feedback is "'.$l_PD_Feedback.'" <br><br> Regards, <br>Zaireprojects Support Team';
                $l_headers2 = "From: $l_webMaster\r\n";
                $l_headers2 .= "Content-type:  text/html\r\n";
                mail($toEmailid ,$subject,$l_message,$l_headers2);
            }
        }
        
        // Get the name of the team
        $l_TM_Name_query = 'select TM.TM_Name from Teams  as TM where TM.Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id = '.$l_TM_id;
        $l_TM_Name_result  = mysql_query($l_TM_Name_query);
        $l_TM_Name_row  = mysql_fetch_row($l_TM_Name_result);
        $l_TM_Name = $l_TM_Name_row[0];
        
        //To notify mentor about guide feedback
        $l_mentor_sql= 'select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_id = (Select TM.UR_id_Mentor from Teams as TM where TM.Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id = '.$l_TM_id.')';
        $l_mentor_res  = mysql_query($l_mentor_sql);
        $l_mentor_row  = mysql_fetch_row($l_mentor_res);
        
        $l_webMaster = 'support@zaireprojects.com';
        $l_MentorMail = $l_mentor_row[0] . '@' . $l_mentor_row[1];
        $subject= 'Team Document Submit';
        $l_message     = 'Hi, <br><br>'.$l_TM_Name.' has got a feedback from their Guide. You can view them at '.$l_filehomepath.'/GMview_Team_ProjFiles01 and give your feedback.<br><br>  Regards, <br>Zaireprojects Team';
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
        
        mail($l_MentorMail,$subject,$l_message,$l_headers2);
        
       // header('Location:GHome.php');
echo "<script>window.location.href='GHome.php'</script>";
        
    }
    //if user is a mentor
    else if ($l_UR_Type == 'Mentor')
    {
        $l_TM_id        = $l_array[1];
        $l_PD_id        = $l_array[2];
        $l_PD_MFeedback  = $l_array[3];
        $l_PD_sql = 'select PD.PD_Name from Project_Documents as PD where PD.Org_id="'.$_SESSION['g_Org_id'].'" and PD.PD_id = '.$l_PD_id;
        
        $l_PD_res = mysql_query($l_PD_sql);
        $l_PD_row = mysql_fetch_row($l_PD_res);
        
        
        $l_PD_Name = $l_PD_row[0];
        
        //To notify all students of the team about Mentor feedback
        
        $l_query = 'select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.Org_id="'.$_SESSION['g_Org_id'].'" and UR.TM_id = '.$l_TM_id;
        $l_result_Teammates  = mysql_query($l_query);
        $l_count = mysql_num_rows($l_result_Teammates);
        
        if($l_count>0)
        {
            while($l_row_Teammates=mysql_fetch_row($l_result_Teammates))
            {
                
                $l_UR_EmailidTeammate = $l_row_Teammates[0];
                $l_UR_EmailidDomainTeammate = $l_row_Teammates[1];
                
                $l_webMaster = 'support@zaireprojects.com';
                $toEmailid = $l_UR_EmailidTeammate.'@'.$l_UR_EmailidDomainTeammate;
                $subject     = 'Document Feedback';
                $l_message         = 'Hi,<br><br>  Your Mentor has given feedback to '.$l_PD_Name.'. The feedback is "'.$l_PD_MFeedback.'" <br><br> Regards, <br>Zaireprojects Support Team';
                $l_headers2 = "From: $l_webMaster\r\n";
                $l_headers2 .= "Content-type:  text/html\r\n";
                mail($toEmailid ,$subject,$l_message,$l_headers2);
            }
        } 
        
        // Get the name of the team
        $l_TM_Name_query = 'select TM.TM_Name from Teams  as TM where TM.Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id = '.$l_TM_id;
        $l_TM_Name_result  = mysql_query($l_TM_Name_query);
        $l_TM_Name_row  = mysql_fetch_row($l_TM_Name_result);
        $l_TM_Name = $l_TM_Name_row[0];
        
        //To notify Guide about Mentor feedback
        $l_guide_sql= 'select UR.UR_Emailid, UR.UR_EmailidDomain from Users as UR where UR.UR_id = (Select TM.UR_id_Guide from Teams as TM where Org_id="'.$_SESSION['g_Org_id'].'" and TM.TM_id ='.$l_TM_id.')';
        $l_guide_res  = mysql_query($l_guide_sql);
        $l_guide_row  = mysql_fetch_row($l_guide_res);
        
        $l_webMaster = 'support@zaireprojects.com';
        $l_GuideMail = $l_guide_row[0] . '@' . $l_guide_row[1];
        $subject= 'Team Document Submit';
        $l_message     = 'Hi, <br><br>'.$l_TM_Name.' has got a feedback from their Mentor. You can view them at '.$l_filehomepath.'/GMview_Team_ProjFiles01 and give your feedback.<br><br>  Regards, <br>Zaireprojects Team';
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
        
        mail($l_GuideMail,$subject,$l_message,$l_headers2); 
        
        //header('location:"MHome.php" ');
 echo "<script>window.location.href='MHome.php'</script>";
        
    }
    include ('footer.php');

    
    ?>
