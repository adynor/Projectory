<?php
    
   /* session_start();
    $conn=  mysql_connect("localhost","zairepro_dbuser","4dyn0rtech!");
    $db=mysql_select_db("zairepro_Projectory",$conn);
    if(!$db){
        echo "Db connection failed".mysql_error();
    }*/

include('db_config.php');
   /* $l_UR_Emailid = $_GET["UR_email"];
    $l_UR_Name = $_GET["UR_Name"];
    $l_UR_Type = $_GET["UR_Type"];
    $l_UR_Phone = $_GET["UR_Phone"];
    $l_UR_State = $_GET["UR_State"];
    $l_UR_City = $_GET["UR_City"];*/
    
    $l_UR_Emailid = $_POST["UR_email"];
    $l_UR_Name = $_POST["UR_Name"];
    $l_UR_Type = $_POST["UR_Type"];
    $l_UR_Phone = $_POST["UR_phone"];
    $l_UR_State = $_POST["UR_State"];
    $l_UR_City = $_POST["UR_City"];
    $l_UR_id  =$_POST["UR_id"];
    //$l_UR_URN  =$_POST["UR_URN"];
    $l_UR_psw  =$_POST["UR_psw"];
    $l_UR_cpsw  =$_POST["UR_cpsw"];
    $l_Org_id = "ZAP";
   
   if(empty($l_UR_Emailid) || empty($l_UR_Name) || empty($l_UR_Type ) || empty($l_UR_Phone) || empty($l_UR_State) || empty($l_UR_City) || empty($l_UR_id)|| empty($l_UR_psw) )
   {
       
        echo "Apologies!! Some error has occured. Please try again.";
    } 
    else
    {
        
	$array_Email=explode('@',$l_UR_Emailid);
	$l_UR_Emailid =$array_Email[0];
	$l_UR_EmailidDomain = $array_Email[1]; 
        $l_URcheck_query = 'select UR.UR_Emailid from Users as UR where UR.UR_Emailid= "'.$l_UR_Emailid.'" and UR.UR_EmailidDomain= "'.$l_UR_EmailidDomain.'"';
        $l_URcheck_result = mysql_query($l_URcheck_query) or die(mysql_error());
        $l_URcheck_count = mysql_num_rows($l_URcheck_result);
         $l_URid_query = 'select UR.UR_id from Users as UR where UR.UR_id= "'. $l_UR_id .'" ';
        $l_URid_result = mysql_query($l_URid_query) or die(mysql_error());
        $l_URid_count = mysql_num_rows($l_URid_result);
        
        
        if($l_URid_count == 1)
        {
            echo "The user id already exists!!";

        }  else if($l_URcheck_count == 1)
        {
            echo "The email id already exists!!";

        }  else if( $l_UR_psw != $l_UR_cpsw){
       echo "These passwords don't match. Try again?";
    }
        else
        {
            
            
            $array_Name=explode(' ',$l_UR_Name);
            $l_count=count($array_Name);
            
            if($l_count == 1)
            {
                $l_UR_FirstName = $array_Name[0];
                $l_UR_MiddleName = "";
                $l_UR_LastName ="";
            }
            else if($l_count ==2)
            {
                $l_UR_FirstName = $array_Name[0];
                $l_UR_MiddleName = "";
                $l_UR_LastName =$array_Name[1];
            }
            else if($l_count ==3)
            {
                $l_UR_FirstName = $array_Name[0];
                $l_UR_MiddleName = $array_Name[1];
                $l_UR_LastName =$array_Name[2];
            }
            else if($l_count>3) //Naveen Singh Kumar Mat Pateriya
            {
                $l_UR_FirstName = $array_Name[0];
                $l_UR_MiddleName = "";
                for ($i=1; $i<$l_count-1; $i++)
                {  
                    
                    $l_UR_MiddleName = $l_UR_MiddleName.$array_Name[$i].' ';  
                    
                }
                
                $l_UR_LastName =$array_Name[$l_count-1];
            }
            $timezone = new DateTimeZone("Asia/Kolkata" );
            $date = new DateTime();
            $date->setTimezone($timezone );
            $l_Insert_Datetime = $date->format( 'YmdHi' );
               $l_webMaster                 = 'support@zaireprojects.com';
        $l_random_number = rand(100000,999999);
        $l_random_str = strval( $l_random_number) ;                     ///convert the random number to alfa (string)
        print('<input type=hidden name=l_random_str  value="' . $l_random_str . '">  ');
        
       // $l_message = "Thank you for registering with us. <br>Your Verification Code is:".$l_random_str." <br><br>Sincerely, <br>Zaireprojects Support Team";
     $l_message ='Hi '.$l_UR_FirstName.',<br>Thank you for registering with us. Please click on the link below to complete email verification<br> <a href="http://zaireprojects.com/verify.php?uverify='.$l_random_str.'&&uid='.$l_UR_id.'&&utype='.$l_UR_Type.'">http://zaireprojects.com/verify.php</a><br><br>Sincerely, <br> Support Team';
       
       $subject= "Confirm Registration";
       $subject1= "New User Registered Through Adynor";
       $l_message1='User Information<br>';
       $l_message1.='Name'.$l_UR_Name.'<br>';
       $l_message1.='Email'.$l_UR_Emailid.'@'.$l_UR_EmailidDomain.'<br>';
        $l_message1.='Mobile'.$l_UR_Phone.'<br>';
       $l_message1.='City'. $l_UR_City.'<br>';
       $l_message1.='State'.$l_UR_State.'<br>';
            $to=array($l_UR_Emailid.'@'.$l_UR_EmailidDomain);
            $to1=array('info@adynor.com');
            $l_insert_UR = "insert into Users (UR_id , UR_Khufiya,UR_Emailid ,UR_EmailidDomain, UR_Type, UR_FirstName, UR_MiddleName, UR_LastName, UR_InsertDate, UR_Phno, UR_State, UR_City, UR_RegistrationStatus,Org_id,UR_VerifyCode) values ('".$l_UR_id ."','".md5($l_UR_psw)."','".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."', '".$l_UR_FirstName."', '".$l_UR_MiddleName."','".$l_UR_LastName."', '".$l_Insert_Datetime."','".$l_UR_Phone."', '".$l_UR_State."','".$l_UR_City."','E','".$l_Org_id."','".$l_random_str."')";

            mysql_query($l_insert_UR) or die(mysql_error());
            sendmail($to,$subject,$l_message);
            sendmail($to1,$subject1,$l_message1);
         //mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
		echo "<script>window.location.href='http://www.adynor.com/signup03.php?user=".$l_UR_id."&&user_type=".$l_UR_Type."&&org=".$l_Org_id."&&path=adynor'</script>";
        }

    }

?>