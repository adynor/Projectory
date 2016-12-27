<?php include('header_signup.php'); ?>
<?php  include ('db_config.php');?>
<div class="container cus-top">
<?php
$l_UR_Type          = $_SESSION['g_UR_signup_Type'];
 $l_UR_id            = $_SESSION['g_UR_signup_id'];
  
if(empty($l_UR_Type)||empty($l_UR_id))
     {
     /*$l_alert_statement =  ' <script type="text/javascript">
     window.alert("Please try signing up again!!")
     window.location.href="signup.php"; </script> ';*/
     
     //print($l_alert_statement );
    echo "<script> window.location.href = 'signup.php'</script>"; 
     }
    $l_UR_Semester     = $_SESSION['g_UR_Semester'] ;
    $l_UR_Salutation   =  $_SESSION['g_UR_Salutation'];
    $l_UR_FirstName    =  $_SESSION['g_UR_FirstName'];
    $l_UR_MiddleName   =  $_SESSION['g_UR_MiddleName'];
    $l_UR_LastName     =  $_SESSION['g_UR_LastName'];
    $l_company_id      =   $_SESSION['g_company_id'];
    $l_UR_USN          = $_SESSION['g_UR_USN'];
    $l_UR_Khufiya      = $_SESSION['g_UR_Khufiya'];
    $l_pass            = md5($l_UR_Khufiya);
    
    $l_UR_Emailid                    = $_SESSION['g_UR_Emailid'];
    $l_UR_EmailidDomain        =$_SESSION['g_UR_EmailidDomain'];
    $l_UR_ProfileInfo               = $_SESSION['g_UR_ProfileInfo'];
    $l_PG_id                           = $_SESSION['g_PG_id'];
    $l_IT_id                            = $_SESSION['g_IT_id'];
    $l_UR_RegistrationStatus           = $_SESSION['g_UR_RegistrationStatus'];
    $l_random_str                     = $_SESSION['g_random_str'];
    $l_Insert_Datetime                = $_SESSION['g_Insert_Datetime'];
    
    if(isset($_POST['Resend']))                                // the button name is also same but displays as Login
    {
        //            //////////////////resend verification code again ////////////////
        $l_webMaster                 = 'support@zaireprojects.com';
        $l_random_number = rand(100000,999999);
        $l_random_str = strval( $l_random_number) ;                     ///convert the random number to alfa (string)
        print('<input type=hidden name=l_random_str  value="' . $l_random_str . '">  ');
        
       // $l_message = "Thank you for registering with us. <br>Your verification Code is:".$l_random_str." 
<br><br>Sincerely,<br >Zaireprojects Support Team";
        
        $l_message ='<a href="www.adynor.com/test/experiment/verify.php?uverify='.$l_random_str.'">www.adynor.com/test/experiment/verify.php</a>';

        $l_subject = "Confirm Registration - New Verification Code";
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
        mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
        
    }
    
    else if(isset($_POST['Submit']))                                // the button name is also same but displays as Login
    {
        
        $l_input_number =  $_POST['l_input_number'];
        $l_random_str   =  $_POST['l_random_str'];
        
        if ($l_input_number == $l_random_str)  // that means that the  verification is passed
        {
           
            if($l_UR_Type=='M')
            {
                // just edited start
                //////////////checkbox for sub domains ////////////////////
                $l_SD_sel_id_arr = $_POST['l_SD_sel'];
                $l_size_SD_sel_id_arr = count(  $l_SD_sel_id_arr);
                $l_SD_id_arr_index =0;
                
                if($l_size_SD_sel_id_arr==0)
                {
                    echo "<font color=red>You have not selected any Skills.</font>";
                }
                else
                {
                    while ($l_SD_id_arr_index < $l_size_SD_sel_id_arr)
                    {
                        $l_query = "insert into UR_Subdomains (UR_id, SD_id) values ('".$l_UR_id."',".$l_SD_sel_id_arr[$l_SD_id_arr_index].")";
                        $l_mysql_query = mysql_query($l_query) or die(mysql_error());    // run the actual SQL
                        
                        $l_SD_id_arr_index = $l_SD_id_arr_index + 1;
                    }
                    
                    ////////////////////////checkbox for sub domains ////////////////////
                    // just edited end
                    $l_query = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_USN, UR_Salutation,UR_FirstName, UR_MiddleName,UR_LastName,UR_CompanyName,UR_ProfileInfo,UR_InsertDate,UR_RegistrationStatus) values
 ('".$l_UR_id."', '".$l_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_USN."','".$l_UR_Salutation."','".$l_UR_FirstName."',
'".$l_UR_MiddleName."','".$l_UR_LastName."','".$l_company_id."','".$l_UR_ProfileInfo."','". $l_Insert_Datetime ."','C')";
                    mysql_query($l_query);
                    
                    $l_webMaster       = 'support@zaireprojects.com';
                    
                    $l_message = "Thank you for registering with us successfully. <br>Please contact your concerned administrator to get access to the portal.<br><br>Sincerely,<br >Zaireprojects Support Team";
                    $l_subject = "Successfully Registered";
                    $l_headers2 = "From: $l_webMaster\r\n";
                    $l_headers2 .= "Content-type:  text/html\r\n";
                    mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
                    session_destroy();

                    echo "<script> window.location.href = 'login.php'</script>"; 
                }
            }
            else if($l_UR_Type=='C')
            {
                $l_query = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_FirstName, UR_MiddleName,UR_LastName,UR_InsertDate,UR_RegistrationStatus) values ('".$l_UR_id."', '".$l_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_FirstName."','".$l_UR_MiddleName."','".$l_UR_LastName."','". $l_Insert_Datetime ."','C')";
                mysql_query($l_query);

                $l_webMaster       = 'support@zaireprojects.com';
                
                    $l_message = "Thank you for registering with us successfully. <br>Please contact your concerned administrator to get access to the portal.<br><br>Sincerely,<br >Zaireprojects Support Team";
                $l_subject = "Successfully Registered";
                $l_headers2 = "From: $l_webMaster\r\n";
                $l_headers2 .= "Content-type:  text/html\r\n";
                mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
                session_destroy();

                echo "<script> window.location.href = 'login.php'</script>"; 
                
            }
            else if($l_UR_Type=='G')
            {
                // just edited start
                //////////////checkbox for sub domains ////////////////////
                $l_SD_sel_id_arr = $_POST['l_SD_sel'];
                $l_size_SD_sel_id_arr = count(  $l_SD_sel_id_arr);
                $l_SD_id_arr_index =0;
                
                if($l_size_SD_sel_id_arr==0)
                {
                    echo "<font color=red>You have not selected any Skills.</font>";
                }
                else
                {
                    while ($l_SD_id_arr_index < $l_size_SD_sel_id_arr)
                    {
                        $l_query = "insert into UR_Subdomains  (UR_id, SD_id) values ('".$l_UR_id."',".$l_SD_sel_id_arr[$l_SD_id_arr_index].")";
                        $l_mysql_query = mysql_query($l_query) or die(mysql_error());    // run the actual SQL
                        
                        $l_SD_id_arr_index = $l_SD_id_arr_index + 1;
                    }
                    //print_r($l_SD_sel_id_arr[$l_SD_id_arr_index]);
                    
                    ////////////////////////checkbox for sub domains ////////////////////
                    // just edited end
                    
                    $l_query = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_USN, UR_Salutation,UR_FirstName, UR_MiddleName,UR_LastName,IT_id,PG_id,UR_InsertDate,UR_RegistrationStatus) values ('".$l_UR_id."', '".$l_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_USN."','".$l_UR_Salutation."','".$l_UR_FirstName."','".$l_UR_MiddleName."','".$l_UR_LastName."','".$l_IT_id."','".$l_PG_id."','".$l_Insert_Datetime."','P')";
                    mysql_query($l_query) or die(mysql_error());
                    
                    $l_webMaster       = 'support@zaireprojects.com';
                    
                    $l_message = "Thank you for registering with us successfully. <br>Please contact your concerned administrator to get access to the portal.<br><br>Sincerely,<br >Zaireprojects Support Team";
                    $l_subject = "Successfully Registered";
                    $l_headers2 = "From: $l_webMaster\r\n";
                    $l_headers2 .= "Content-type:  text/html\r\n";
                    mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
                    session_destroy();
                    
                    echo "<script> window.location.href = 'login.php'</script>"; 
                }
            }
            else if($l_UR_Type=='S')
            {
                
                 $l_query = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_USN, UR_Salutation,UR_FirstName, UR_MiddleName,UR_LastName,IT_id,PG_id,UR_InsertDate,UR_Semester,UR_RegistrationStatus)
 values ('".$l_UR_id."', '".$l_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_USN."','".$l_UR_Salutation."','".$l_UR_FirstName."','".$l_UR_MiddleName."','".$l_UR_LastName."','".$l_IT_id."',
'".$l_PG_id."','".$l_Insert_Datetime."','".$l_UR_Semester."','P')";
                
mysql_query($l_query) or die(mysql_error());
                
                $l_webMaster       = 'support@zaireprojects.com';
                
                    $l_message = "Thank you for registering with us successfully. <br>Please contact your concerned administrator to get access to the portal.<br><br>Sincerely,<br >Zaireprojects Support Team";
                $l_subject = "Successfully Registered";
                $l_headers2 = "From: $l_webMaster\r\n";
                $l_headers2 .= "Content-type:  text/html\r\n";
                mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
                session_destroy();
               echo "<script> window.location.href = 'login.php'</script>"; 
                
            }
            
            
        }
        else
        {
            print('<font color=red>Your validation code is incorrect. Please verify the email and try again or resend the verification mail again</font>');
        }
        
    }
    
    print('<form method = "POST" action="">');
    print('<table class="ady-table-content" style="width:100%">');
    print('<tr><th colspan=3><center>Confirm Details</center></th></tr>');
    print ('<tr><td>Your Name:</td><td colspan=2> '.$l_UR_FirstName.''.$l_UR_MiddleName.' '.$l_UR_LastName.'</td></tr>');
    if($l_UR_Type=='S')
    {
        print ('<tr><td>Your University Student <br>Number:</td> <td colspan=2> '.$l_UR_USN.'</td></tr>');
    }
    else if($l_UR_Type=='G')
    {
        print ('<tr><td>Your Guide Registration <br>Number:</td> <td colspan=2> '.$l_UR_USN.'</td></tr>');
    }
    else if($l_UR_Type=='M')
    {
        print ('<tr><td>Your Mentor Registration <br>Number:</td> <td colspan=2> '.$l_UR_USN.'</td></tr>');
    }
    if($l_UR_Type=='S'||$l_UR_Type=='G')
    {
        print ('<tr><td>Your Program:</td> <td colspan=2> '.$_SESSION['g_PG_Name'].'</td></tr>');
        print ('<tr><td>Your Institute:</td> <td colspan=2> '.$_SESSION['g_IT_Name'].'</td></tr>');
    }
    else if($l_UR_Type=='M')
    {
        print ('<tr><td>Your Company:</td> <td colspan=2> '.$_SESSION['g_Company_Name'] .'</td></tr>');
    }
    
    print ('<tr><td>Your Emailid:</td> <td> '.$l_UR_Emailid.'@'.$l_UR_EmailidDomain.'</td><td><input  class="btn btn-primary" type=submit value="Resend"  name ="Resend"> <br/><font size=2 color=violet>Please click resend if you did not receive any verification email from us</font></td></tr>');
    
    print ('</table>');
    
    // table for sub domains starts here
    if($l_UR_Type=='G' || $l_UR_Type=='M')
    {
        print('<table class="ady-table-content" style="width:100%">');
        print('<tr><th colspan=2><center>Select your skills</center></th></tr>');
        
        $l_select_sql = 'SELECT SD_id, SD_Name FROM SubDomain';
        $l_result_sql = mysql_query($l_select_sql);
        
        while($l_row = mysql_fetch_row($l_result_sql))
        {
            print ('<tr>');
            $l_SD_id       = $l_row[0];
            $l_SD_Name= $l_row[1];
            
            print( '<td>'.$l_SD_Name.'</td>');
            
            print('<td>');
            print('<center><input type="checkbox" class="g_checkbox_select_DM" value="'.$l_SD_id.'" name="l_SD_sel[]"></center></td>');
            
            print('</tr>'); 
            
        }
        print('</table>');
        mysql_free_result($l_result_sql);
        
    }
    
    print ('<table class="ady-table-content" style="width:100%">');
    print('<tr><th colspan=2>An email with a verification code is sent to you. Please enter the same here to complete the registration</th></tr>');
    print('<tr><td>Verify Code:</td><td><input type="text" class="form-control input-lg"size= 20 name="l_input_number" /><input type="hidden" name="l_random_str" value="' .$l_random_str.'" /></td></tr>');
    print('<tr><td colspan =2><input type="checkbox" required name="terms"/>I accept the <a href="'.$l_filehomepath.'/tc/">Terms and Conditions</a></td></tr>');
    print('<tr><td  colspan =10 style="text-align:center"><input type=submit  name="Submit" class="btn btn-primary" value=Submit></td></tr>');
    print('</table>');

    print('</form>');
    ?><br><br><br><br>