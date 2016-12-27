<?php
 session_start();
    $conn=  mysql_connect("localhost","zairepro_dbuser","4dyn0rtech!");
    $db=mysql_select_db("zairepro_Projectory",$conn);
    if(!$db){
        echo "Db connection failed".mysql_error();
    }
    
 function sendResponse($status,$pid,$date,$UR_id) {

    $response = '<?xml version="1.0" encoding="utf-8"?>';

            $response = $response.'<response><status >'.$status.'</status >';
            $response = $response.'<proid >'.$pid.'</proid >';
            $response = $response.'<datetime >'.$date.'</datetime >';
            $response = $response.'<userd >'.$UR_id.'</userd ></response>';

            return $response;
 }


    $l_UR_id = $_GET["UR_id"];
    $l_UR_pass = $_GET["UR_pass"];
    $l_UR_Emailid = $_GET["UR_emailid"];
    $l_UR_Name = $_GET["UR_Name"];
    $l_UR_CompanyName= $_GET["UR_CompanyName"];
    $l_Org_id = $_GET["ORG_Name"];
    $l_Skills= $_GET["UR_Skills"];
    $l_SkillsArr=explode('|', $l_Skills);
    $l_UR_Type = 'M';
    
    $IT_success_flag='';
    $PG_success_flag='';
    $PG_IT_success_flag='';
    $UR_success_flag='';
 
 $l_insert_UR_pass = md5($l_UR_pass);
 
     if($l_UR_id == NULL || $l_UR_pass == NULL || $l_UR_Emailid == NULL || $l_Org_id == NULL || $l_Skills == NULL)
    {
        echo "Apologies!! Some error has occured. Please try again.<a href='".$_SERVER['HTTP_REFERER']."'>Back</a>";
        //header("Content-type: text/xml; charset=utf-8");
  	//echo sendResponse("Fail",$l_PR_id,$l_Insert_Datetime,$l_UR_id);

    }
    else
    {
       

        
        $l_URcheck_query = 'select UR.UR_id from Users as UR where UR.UR_id = "'.$l_UR_id.'" AND UR.Org_id="'.$l_Org_id.'"';
        $l_URcheck_result = mysql_query($l_URcheck_query) or die(mysql_error());
        $l_URcheck_count = mysql_num_rows($l_URcheck_result);
        if($l_URcheck_count == 1)
        {
            $timezone = new DateTimeZone("Asia/Kolkata" );
            $date = new DateTime();
            $date->setTimezone($timezone );
            $l_Insert_Datetime = $date->format( 'YmdHi' );
            
            $l_update_UR = 'update Users set PR_id ='.$l_PR_id .' where UR_id = "'.$l_UR_id.'" AND Org_id="'.$l_Org_id.'"';
            mysql_query($l_update_UR);
            $URid_encode=md5(162).'=='.base64_encode($l_UR_id);
            $ORGid_encode=md5(162).'=='.base64_encode($l_Org_id);
            //echo '<script>window.location.href="https://zaireprojects.com/loginOrganization.php?UR_id='.$URid_encode.'&ORG_id='.$ORGid_encode.'"</script>';
		header("Content-type: text/xml; charset=utf-8");
		echo sendResponse("Success",$l_PR_id,$l_Insert_Datetime,$l_UR_id);


        }
        else
        {
            
            $array_Email=explode('@',$l_UR_Emailid);
            $l_UR_Emailid =$array_Email[0];
            $l_UR_EmailidDomain = $array_Email[1];
            
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
                       $l_insert_UR = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_FirstName, UR_MiddleName,UR_LastName,UR_CompanyName,UR_InsertDate,UR_RegistrationStatus,Org_id) values ('".$l_UR_id."', '".$l_insert_UR_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_FirstName."','".$l_UR_MiddleName."','".$l_UR_LastName."','".$l_UR_CompanyName."','".$l_Insert_Datetime."','C','".$l_Org_id."')";

            $UR_success = mysql_query($l_insert_UR);
            
            foreach($l_SkillsArr as $skillsid){
                       $l_insert_UR_skill = "insert into Users (UR_id, SD_id,Org_id) values ('".$l_UR_id."', '".$skillsid."','".$l_Org_id."')";

            $UR_success_skill = mysql_query( $l_insert_UR_skil); 
            }
            
	    if($UR_success
	    {
	    	$UR_success_flag='Y';
	    }
	    else
	    {
	    	$UR_success_flag='N';
	    }
	    
	    if($IT_success_flag='Y' && $PG_success_flag='Y' &&$PG_IT_success_flag='Y'&&$UR_success_flag='Y')
	    {    
			header("Content-type: text/xml; charset=utf-8");
		         echo sendResponse("Success",$l_PR_id,$l_Insert_Datetime,$l_UR_id);
  	    }


  	    $URid_encode=md5(162).'=='.base64_encode($l_UR_id);
            $ORGid_encode=md5(162).'=='.base64_encode($l_Org_id);
            /*echo '<script>window.location.href="https://zaireprojects.com/loginOrganization.php?UR_id='.$URid_encode.'&ORG_id='.$ORGid_encode.'"</script>';*/

        }
    	
    }

?>
