<?php
<<<<<<< HEAD
    
    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();
        
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                
                curl_setopt($curl, CURLOPT_PUT, 0);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        
        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        
        curl_close($curl);
        
        return $result;
    }
    
    $call = CallAPI("GET","https://zaireprojects.com/api/api.php?rquest=users|".md5('zprojects')."",0);
    

    $decoded= json_decode($call);
    echo "<br/><br/>";
   
    $o_connection = mysql_connect('localhost','zairepro_dbuser', '4dyn0rtech!');
    mysql_select_db('zairepro_Projectory');

    $count=count($decoded);
    for($i=0;$i<$count;$i++)
    {
     
  
       echo "<br>";
       // print_r($decoded[$i]);
       echo "<font color=green>User id:</font>".$decoded[$i]->UR_id."<br>";
       echo "Name:".$decoded[$i]->UR_FirstName.' '.$decoded[$i]->UR_LastName."<br>";
       echo "<font color=red> Email id:</font>".$decoded[$i]->UR_emailid.'@'.$decoded[$i]->UR_emailidDomain;
     
       $Check_query="Select UR_id from Users Where UR_id='".$decoded[$i]->UR_id."'";
        echo $Check_query;
       
       $l_query= mysql_query($Check_query);
       $count=mysql_num_rows($l_query);
         echo $count;
         
          if($count==0)
          {
          
        $token= md5(time().$decoded[$i]->UR_emailid.'@'.$decoded[$i]->UR_emailidDomain);  
    
       $insert_query="insert into Users(UR_id,UR_Tokenid) values('".$decoded[$i]->UR_id."','".$token."')"; 
      
      echo $insert_query;
      
      mysql_query($insert_query);
        
       CallAPI("PUT","https://zaireprojects.com/api/api.php?rquest=updateUsers|".md5('zprojects')."&tokenid=".$token."&URid=".$decoded[$i]->UR_id,0);
    
       
        }
        else if($count==1)
        {
        
       $token= md5(time().$decoded[$i]->UR_emailid.'@'.$decoded[$i]->UR_emailidDomain);  
       
       $Update_query="UPDATE  Users SET UR_Tokenid ='".$token."' WHERE UR_id='".$decoded[$i]->UR_id."'";
       
        echo $Update_query;
       mysql_query($Update_query);
       
       CallAPI("PUT","https://zaireprojects.com/api/api.php?rquest=updateUsers|".md5('zprojects')."&tokenid=".$token."&URid=".$decoded[$i]->UR_id,0);
      
       }
    
 }
?>


=======

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
    $l_UR_Semester = $_GET["UR_Semester"];
    $l_UR_USN = $_GET["UR_USN"];
    $l_PR_id = $_GET["PR_id"];
    $l_IT_Name = $_GET["IT_Name"];
    $l_PG_Name = $_GET["PG_Name"];
    $l_Org_id = $_GET["ORG_Name"];
    $l_UR_Type = 'S';
    $l_IT_id = NULL;
    $l_PG_id = NULL;
    $l_UR_PR_Type='N';
    
    $IT_success_flag='';
    $PG_success_flag='';
    $PG_IT_success_flag='';
    $UR_success_flag='';
 
 $l_insert_UR_pass = md5($l_UR_pass);
 
     if($l_UR_id == NULL || $l_UR_pass == NULL || $l_UR_Emailid == NULL || $l_PR_id == NULL || $l_IT_Name == NULL || $l_PG_Name == NULL || $l_Org_id == NULL)
    {
        echo "Apologies!! Some error has occured. Please try again.<a href='".$_SERVER['HTTP_REFERER']."'>Back</a>";
        //header("Content-type: text/xml; charset=utf-8");
  	//echo sendResponse("Fail",$l_PR_id,$l_Insert_Datetime,$l_UR_id);

    }
    else
    {
        $l_ITcheck_query = 'select IT_id from Institutes where IT_Name = "'.$l_IT_Name.'"' ;
        $l_ITcheck_result = mysql_query($l_ITcheck_query) or die(mysql_error());
        $l_ITnum_count = mysql_num_rows($l_ITcheck_result);
        if($l_ITnum_count >= 1)
        {
            $l_IT_row = mysql_fetch_row($l_ITcheck_result);
            $l_IT_id = $l_IT_row[0];
            $IT_success_flag='Y';

        }
        else
        {
            $l_get_IT_id = 'select max(IT_id) from Institutes';
            $l_result_check_max_IT = mysql_query($l_get_IT_id);
            $l_row = mysql_fetch_row($l_result_check_max_IT);
            $l_max_IT_id = $l_row[0];
            $l_IT_id = $l_max_IT_id + 1;
            $l_insert_Institute = 'insert into Institutes (IT_id, IT_Name,Org_id) values ('.$l_IT_id .',"'.$l_IT_Name .'","'.$l_Org_id.'")';
            $l_IT_success = mysql_query($l_insert_Institute);
            if($l_IT_success)
            {
            	     $IT_success_flag='Y';
            }
            else
            {
                     $IT_success_flag='N';

            }
        }
        
        
        $l_PGcheck_query = 'select PG_id from Programs where PG_Name = "'.$l_PG_Name.'" AND Org_id="'.$l_Org_id.'"' ;
        $l_PGcheck_result = mysql_query($l_PGcheck_query) or die(mysql_error());
        $l_PGnum_count = mysql_num_rows($l_PGcheck_result);
        if($l_PGnum_count >= 1)
        {
            $l_PG_row = mysql_fetch_row($l_PGcheck_result);
            $l_PG_id = $l_PG_row[0];
            $PG_success_flag='Y';

        }
        else
        {
            $l_get_PG_id = 'select max(PG_id) from Programs';
            $l_result_max_PG = mysql_query($l_get_PG_id);
            $l_row = mysql_fetch_row($l_result_max_PG);
            $l_max_PG_id = $l_row[0];
            $l_PG_id = $l_max_PG_id + 1;
            $l_insert_Programs = 'insert into Programs (PG_id, PG_Name,Org_id) values ('.$l_PG_id .',"'.$l_PG_Name .'","'.$l_Org_id.'")';
            $l_PG_success = mysql_query($l_insert_Programs);
            if($l_PG_success)
            {
            	  $PG_success_flag='Y';

            }
            else
            {
                 $PG_success_flag='N';

            }
        }
        
        
        $l_PGITcheck_query = 'select PG_id, IT_id from Institutes_Program as IP where IP.PG_id = '.$l_PG_id.' and IP.IT_id = '.$l_IT_id.' AND IP.Org_id="'.$l_Org_id.'"' ;
        $l_PGITcheck_result = mysql_query($l_PGITcheck_query) or die(mysql_error());
        $l_PGITnum_count = mysql_num_rows($l_PGITcheck_result);
        if($l_PGITnum_count == 1)
        {
            $l_PGIT_row = mysql_fetch_row($l_PGITcheck_result);
            $l_PG_id = $l_PG_row[0];
            $PG_IT_success_flag='Y';

        }
        else
        {
            $l_insert_sql = "insert into Institutes_Program (PG_id, IT_id,Org_id) values (" .$l_PG_id .", ".$l_IT_id .",'".$l_Org_id."')";
            $PG_IT_success = mysql_query($l_insert_sql);
            if($PG_IT_success)
            {
            	  $PG_IT_success_flag='Y';

            }
            else
            {
                  $PG_IT_success_flag='N';

            }

        }

        
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
            
            $l_insert_UR = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_USN,UR_FirstName, UR_MiddleName,UR_LastName,IT_id,PG_id,PR_id,UR_InsertDate,UR_Semester,UR_RegistrationStatus,UR_PR_Type,Org_id) values ('".$l_UR_id."', '".$l_insert_UR_pass."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_USN."','".$l_UR_FirstName."','".$l_UR_MiddleName."','".$l_UR_LastName."',".$l_IT_id.",".$l_PG_id.",".$l_PR_id.",'".$l_Insert_Datetime."','".$l_UR_Semester."','C','".$l_UR_PR_Type."','".$l_Org_id."')";

            $UR_success = mysql_query($l_insert_UR);
	    if($UR_success)
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
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
