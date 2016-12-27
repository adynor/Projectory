<?php
    
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
                curl_setopt($curl, CURLOPT_PUT, 1);
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
    
<<<<<<< HEAD
    $call = CallAPI("GET","https://zaireprojects.com/test/api/api.php?rquest=projects|3eb424ee2828c68a796b5136634a1d25",0);
    
echo $call;
=======
    $call = CallAPI("GET","http://zaireprojects.com/api/api.php?rquest=projects|3eb424ee2828c68a796b5136634a1d25",0);
    
   $mentor = CallAPI("GET","http://zaireprojects.com/api/api.php?rquest=mentors|3eb424ee2828c68a796b5136634a1d25",0);
    
echo $call;
 echo "<hr>";
echo $mentor;
 echo "<hr>";
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
   $decoded= json_decode($call);
    echo "<br/><br/>";
   echo  md5('zprojects');
    echo"<pre>";
   print_r($decoded);
    echo"</pre>";
<<<<<<< HEAD
    
 $count=count($decoded);
=======
     echo "<hr>";
     $decoded1= json_decode($mentor);
    echo "<br/><br/>";
   //echo  md5('zprojects');
    echo"<pre>";
   print_r($decoded1);
    echo"</pre>";
     echo "<hr>";
 $count=count($decoded);
 echo "========================================================================================================<br>";
  for($i=0;$i<$count;$i++){
 echo $decoded[$i]->Project_id.'<br>';
 }
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
    for($i=0;$i<$count;$i++){
  
  if ($decoded[$i]->Project_Price==0)
  {
  $decoded[$i]->Project_Price=Free;
  
  }
   $technology=$decoded[$i]->Project_Technology;
  $technologies=implode(',',$technology);
<<<<<<< HEAD
=======
  $Solutions= implode(',',$decoded[$i]->Project_Solution);
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
  echo "<br>";
   // print_r($decoded[$i]);
   echo "<font color=green>Project Name:</font>".$decoded[$i]->Project_Name."<br>";
     echo "Description:".$decoded[$i]->Project_Desc."<br>";
     echo "<font color=red> Price:</font>".$decoded[$i]->Project_Price."<br>";
<<<<<<< HEAD
     echo "<font color=blue> Technology:</font>".$technologies."<br>";
    
    
    }
  
  
=======
      echo "<font color=blue> Technology:</font>".$technologies."<br>";
      echo "<font color=blue>Prefered Technology:</font>".$decoded[$i]->Prefered_Technology."<br>";
       echo "<font color=blue> Industry:</font>".$decoded[$i]->Project_Industry."<br>";
     echo "<font color=blue> Solution:</font>".$Solutions."<br>";
    
    
     //new  code for projects' stream
      $stream=$decoded[$i]->Project_Stream;
      $streams=implode(',',$stream);
      echo "<font color=browen> Stream:</font>".$streams."<br>";
      
    }
    
     
  echo  '<b style="color:red">Mentors</b><br>';
   echo "<hr>";
   $count=count($decoded1);
    for($i=0;$i<$count;$i++){
    
    $technology1=$decoded1[$i]-> Mentor_Technology;
    $Profile=$decoded1[$i]-> MentorProfile;
    if(count($technology1)!=0){
  $technologies1=implode(',',$technology1);
  }else{
  $technologies1="";
  }
    echo '<b style="color:blue">'.$decoded1[$i]-> Mentor."</b><br>";
   
    echo 'Name:'.$technologies1."<br>";
    echo 'Profile:'.$Profile."<br>";
   
    }
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
    
   
?>