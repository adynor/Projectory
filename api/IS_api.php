<?php
    require_once("rest.inc.php");


 class api extends REST
    {
        public $data = "";
        const DB_SERVER = "localhost";
        const DB_USER = "zairepro_test";
        const DB_PASSWORD = "test@123";
        const DB = "zairepro_projectory_test";
        const str = 'zprojects';

        private $db = NULL;
        
        public function __construct()
        {
            parent::__construct();// Init parent contructor
            $this->dbConnect();// Initiate Database connection
        }
        
        //Database connection
        public function dbConnect()
        {
            $this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
            if($this->db)
                mysql_select_db(self::DB,$this->db);
                else{
                
                echo "error";}
        }
        
        //Public method for access api.
        //This method dynmically call the method based on the query string
        public function processApi()
        {
            $key_check = md5(self::str);
            $check = explode("|",$_REQUEST['rquest']);
            $page = $check[0];
            $key = $check[1];
            $Token = $check[2]; // nnnn
            
         if($key === $key_check)
            {
            	$func = strtolower(trim(str_replace("/","",$page)));
            	if((int)method_exists($this,$func) > 0)
                	$this->$func();
            	else
                	$this->response('',404);
            	// If the method not exist with in this class, response would be "Page not found".
            }
        
            else
            {
            	$this->response('',404);
            }
        }
        
        private function projects()
        {
            // Cross validation if the request method is GET else it will return "Not Acceptable" status
            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            // Get DateTime
        $timezone = new DateTimeZone("Asia/Kolkata" );
        $date = new DateTime();
        $date->setTimezone($timezone );
        $l_PR_Date = $date->format( 'Ymd' );
            
	$sql = mysql_query("SELECT PR.PR_id, PR.PR_Name,PR.PR_Desc,MO.MO_Amount as PR_Price ,ID.IN_Name FROM Projects as PR,Model as MO,Industry as ID where PR.IN_id=ID.IN_id AND PR.Org_id='ALL' AND PR.MO_id=MO.MO_id AND PR.PR_Status='C' and PR.PR_ExpiryDate >=".$l_PR_Date."", $this->db);

            if(mysql_num_rows($sql) > 0)
            {
                $result = array();
                $i=0;
                while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
                {
                $result[$i]['Project_id']=$rlt['PR_id'];
                $result[$i]['Project_Name']=$rlt['PR_Name'];
                $result[$i]['Project_Desc']=$rlt['PR_Desc'];
                $result[$i]['Project_Price']=$rlt['PR_Price'];
                $result[$i]['Project_Industry']=$rlt['IN_Name'];
                
                  
                  $sql2 =mysql_query("SELECT SD.SD_Name FROM Project_SubDomains AS PS, SubDomain AS SD WHERE PS.SD_id = SD.SD_id AND PS.PR_id =".$rlt['PR_id']."", $this->db);
                // $technologies="";
                 $j=0;
			while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
                	{
                	$result[$i]['Project_Technology'][$j]=$rlt2['SD_Name'];
                		         //       $technologies=$technologies.",".$rlt2[0];
                      $j++;
                	}
  				$sql2 =mysql_query("SELECT PG.PG_Name FROM PG_Projects AS PGP, Programs AS PG WHERE PG.PG_id = PGP.PG_id AND PGP.PR_id=".$rlt['PR_id']."",  $this->db);
                // $technologies="";
                 $k=0;
			while($rlt3 = mysql_fetch_array($sql2,MYSQL_ASSOC))
                	{
                	$result[$i]['Project_Stream'][$k]=$rlt3['PG_Name'];
                		         //       $technologies=$technologies.",".$rlt2[0];
                      $k++;
                	}
                	$l=0;
                	$sql4=mysql_query('SELECT SO.SO_Name FROM Project_Solution  as PS,Solution as SO WHERE SO.SO_id=PS.SO_id AND PS.PR_id ='.$rlt['PR_id'].'');
                 while($rlt4 = mysql_fetch_array($sql4,MYSQL_ASSOC))
                	{
                	$result[$i]['Project_Solution'][$l]=$rlt4['SO_Name'];
                	
                      $l++;
                	}

                   $i++; 
                }
               // print_r($result)   ;  
                // If success everythig is good send header as "OK" and return list of users in JSON format
                $this->response($this->json($result), 200);
            }
            $this->response('',204); // If no records "No Content" status
        }
        
      
        
        private function mentors(){
      if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }
            // Get DateTime
        $timezone = new DateTimeZone("Asia/Kolkata" );
        $date = new DateTime();
        $date->setTimezone($timezone );
        $l_PR_Date = $date->format( 'Ymd' );
        $sql = mysql_query("SELECT UR.UR_id,UR.UR_FirstName,UR.UR_ProfileInfo FROM Users as UR WHERE UR.Org_id='ZP' AND UR.UR_Type='M' AND UR.UR_RegistrationStatus='C'", $this->db);
        if(mysql_num_rows($sql) > 0)
            {
             $result = array();
                $i=0;
                while($rlt1 = mysql_fetch_array($sql,MYSQL_ASSOC))
                	{
                	$result[$i]['Mentor']=$rlt1['UR_FirstName'];
                	$result[$i]['MentorProfile']=$rlt1['UR_ProfileInfo'];
                         $sql2 =mysql_query("SELECT SD.SD_Name FROM SubDomain as SD,UR_Subdomains as URS WHERE SD.SD_id=URS.SD_id AND `UR_id`='".$rlt1['UR_id']."'", $this->db);
                // $technologies="";
                 $j=0;
			while($rlt2 = mysql_fetch_array($sql2,MYSQL_ASSOC))
                	{
                	$result[$i]['Mentor_Technology'][$j]=$rlt2['SD_Name'];
                		         //       $technologies=$technologies.",".$rlt2[0];
                      $j++;
                	}
                      $i++;
                	}
                        $this->response($this->json($result), 200);
            }
        $this->response('',204); 

 }
        public function json($data)
        {
            /*print_r($data);
            echo "<br/><br/>";
            $encoded = json_encode($data);
            print_r($encoded);
            
            $decoded = json_decode($encoded,true);
                        echo "<br/><br/>";
            print_r($decoded);
            return $data;*/
            
            if(is_array($data))
            {
                return json_encode($data);
            }
        }
    }
    
    // Initiiate Library
    $api = new API;
    $api->processApi();
   // print_r($result)   ; 
    ?>