<?php
include('header.php');
include ('db_config.php');

print('<div class="row" style="padding:10px"></div><div class="container" >'); 


$l_TM_id=$_SESSION['g_TM_id'];
$l_UR_Type = $_SESSION['g_UR_Type'];
$l_UR_id = $_SESSION['g_UR_id'];
$l_PR_id_current=$_SESSION['g_PR_id'];
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_currentDate = $date->format( 'Ymd' );

    $l_sql=$_REQUEST['g_MO_id'];
    $l_sql=str_replace("\\","",$l_sql);
    $l_arry = explode("|",$l_sql);
    $l_MO_id= $l_arry[0];
    $l_MO_amount= $l_arry[1];

 $l_PR_id_ended= array();
 
  
 $l_UR_FName=$_SESSION['UR_FirstName'];
 
                            $l_query_PR_ended='select ST.PR_id from Student_Results as ST where ST.UR_student ="'.$l_UR_id.'" and ST.Org_id="'.$_SESSION['g_Org_id'].'"';
                            $_result_PR_ended=mysql_query($l_query_PR_ended) or die(mysql_error());
                            if($result_PR_ended=== FALSE)
                            {
                                die(mysql_error()); // TODO: better error handling
                            }
                            $i=0;
                            while($l_row_PR_ended = mysql_fetch_row($_result_PR_ended))
                            {
                                $l_PR_id_ended[$i]=$l_row_PR_ended[0];
                                $i++;
                            }


print('<br><br><h2><b> Welcome to Projectory : '.$l_UR_FName.'</b></h2>');


//////////////////////filter starts

 $l_PR_Name = 'Dummyname';
        $l_SD_Name = 'Dummyname';
        
        print('<form action="" method="POST">');
        if(isset($_POST['SaveRec']))
        {
            $l_PR_Name   = $_POST['l_PR_Name'];
            $l_SD_Name   = $_POST['l_SD_Name'];
            if($l_SD_Name==-99)
                $l_SD_Name='Dummyname';
            if($l_PR_Name=='')
                $l_PR_Name='Dummyname';
            
          
        }
        
        if ($l_PR_Name == 'Dummyname' && $l_SD_Name=='Dummyname')/////// filter
        {
           $l_query_project='select  PR.PR_id, PR.PR_Name, PR.PR_Short_Desc, PR.PR_SynopsisURL,PR.PR_Duration from Projects as PR where PR.MO_id='.$l_MO_id.'  and  PR.PR_Status="C" and  PR.PR_ReleaseDate<='.$l_currentDate.' and PR.PR_ExpiryDate >='.$l_currentDate.'';

        }       // if ($l_PR_Name != null)
        
        else if ($l_PR_Name == 'Dummyname' && $l_SD_Name!='Dummyname')
        {
         $l_query_project='select  PR.PR_id, PR.PR_Name, PR.PR_Short_Desc, PR.PR_SynopsisURL,PR.PR_Duration from Projects  as PR,SubDomain as SD,Project_SubDomains as PS
           where PR.MO_id='.$l_MO_id.' 
           and  PR.PR_Status="C" 
           and PR.PR_ReleaseDate<='.$l_currentDate.'
            and PR.PR_ExpiryDate >='.$l_currentDate.'
            and PR.PR_id=PS.PR_id 
            and PS.SD_id=SD.SD_id
            and SD.SD_Name="'.$l_SD_Name.'"
            ';
            
        }       // if ($l_PR_Name != null)
        
        
        else if ($l_PR_Name != 'Dummyname' and $l_SD_Name=='Dummyname')///////// n o filters
        {
             $l_query_project='select  PR.PR_id, PR.PR_Name, PR.PR_Short_Desc, PR.PR_SynopsisURL,PR.PR_Duration from Projects 
            as PR where PR.MO_id='.$l_MO_id.' and  PR.PR_Status="C"  and PR.PR_ReleaseDate<='.$l_currentDate.' and PR.PR_ExpiryDate >='.$l_currentDate.'  and PR.PR_Name like "%'.$l_PR_Name.'%"';

            // get the current applications and past applications
            // current applications will be known from
        }      // if ($l_PR_Name != null)
        
        else if ($l_PR_Name != 'Dummyname' && $l_SD_Name!='Dummyname')
        {
              $l_query_project='select  PR.PR_id, PR.PR_Name, PR.PR_Short_Desc, PR.PR_SynopsisURL,PR.PR_Duration from Projects  as PR,SubDomain as SD,Project_SubDomains as PS
           where PR.MO_id='.$l_MO_id.' 
           and  PR.PR_Status="C" 
           and PR.PR_ReleaseDate<='.$l_currentDate.'
            and PR.PR_ExpiryDate >='.$l_currentDate.'
            and PR.PR_id=PS.PR_id 
            and PS.SD_id=SD.SD_id
         
            and SD.SD_Name="'.$l_SD_Name.'" and PR.PR_Name like "%'.$l_PR_Name.'%"';
            
        }     
        
        $l_result=mysql_query($l_query);    // run the actual SQL
        
    print('<br><br><br><div class="alert alert-info"><table  class="ady-table-content" style="width:100%" cellpadding=1px  cellspacing=1px ');
        
        print ('<tr><td>Search by Project Name  <input class="form-control"  type=text name=l_PR_Name ></td>');
        
        print ('<td> Filter by Technology <select  class="form-control" name="l_SD_Name" align="right">');
        
        $l_sql_SD      ='SELECT SD_Name, SD_id FROM SubDomain WHERE  Org_id="ALL"';
        $l_result_SD =mysql_query($l_sql_SD);
        $l_row = 'Dummyname';
        while ($l_data=mysql_fetch_row($l_result_SD))
        {
            if($l_row == 'Dummyname')
            {
                print ('<option value="-99">--</option> ' );
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
        
        print ('<td style ="text-align:center" colspan=4> <input onclick="myFunction()" class="btn btn-primary" type=submit name="SaveRec"  accesskey=Alt-S value="Search Project" ></td>');
        print('</tr>');
        print('</table></div>');
        
        
        /////////////////////////////////////////////////////////filter ends

/*$l_PR_count_sql = 'select PR_id from Users where PR_id='.$l_PR_id.'';
   $l_PR_count_res = mysql_query($l_PR_count_sql);
   $l_PR_count= mysql_num_rows($l_PR_count_res); */
 

                            $l_result_project=mysql_query($l_query_project) or die(mysql_error());
                            $l_count_project = mysql_num_rows($l_result_project);
echo "<h5>Total Projects: ".$l_count_project."</h5><br>";
                           print('<table  class="ady-table-content table-fixed" border=1 style="width:100%">');
                                                       
                                                      print('  <thead>');
    print('  <tr>');
                                                        print('<th>');
                           print("Project Name");
                           print('</th>');
                           print('<th>');
                           print("Project Description");
                           print('</th>');
                           print('<th>');
                           print("Project Duration");  // naveen u add this line 20november
                           print('</th>');
                           print('<th>');
                           print("No. of people Performing");  // naveen u add this line 20november
                           print('</th>');
                           print('<th>');
                           print('</th>');
                           
                           print(' </tr>');
 print(' </thead>');
                           
                           if($l_count_project==0)
                            {
                                 print('<tr><td colspan=5>There are no projects under this domain</td></tr>');
                            }
                            else
                            {
                              while ($l_row_project = mysql_fetch_row($l_result_project))
                              {
                                $l_PR_id=$l_row_project[0];
                                $l_PR_count_sql = 'select PR_id from Users where PR_id='.$l_PR_id.' ';
$l_PR_count_res = mysql_query($l_PR_count_sql);
  
  if($l_PR_count_res!=Null)
{
 $l_PR_count= mysql_num_rows($l_PR_count_res);    
 }


                                $l_PR_Name=$l_row_project[1];
                                $l_PR_Desc=htmlspecialchars_decode($l_row_project[2]);
                                $l_PR_Duration=round(($l_row_project[4]/7));
                                                                               print('<tr>');
                               print('<td>');
                                
                                print ($l_PR_Name);
                                print('</td>');
                                print('<td>');
                                print ($l_PR_Desc);
                                print('</td>');
                                print('<td>');
                                print($l_PR_Duration. ' Weeks');
                                print('</td>');
                                                          print( '<td>'.$l_PR_count.' Students</td>');
 


print('<td>');
                                if($l_PR_id==$l_PR_id_current)
                                {
                                    print('<input class="btn btn-primary" type="button" value="Continue Project" onClick="javascript:window.location.href=\''.$l_filehomepath.'/SHome.php\'"></input>');
                                }
                                else if(in_array($l_PR_id, $l_PR_id_ended))
                                {
                                    print('<input class="btn btn-primary" type="button" value="View Project" onClick="javascript:window.location.href=\''.$l_filehomepath.'/blank/\'"></input>');
                                }
                                else
                                {
                                    if($l_PR_id_current==NULL)
                                    {
                                        print ('<input class="btn btn-primary" name="performproject"  id='.$l_PR_id.' type="button" value="Perform Project" onClick="javascript:window.location.href=\''.$l_filehomepath.'/ProjectDetails.php?PR_id='.$l_PR_id.'|'.$l_MO_amount.'\'"></input><br/>');
                                    }
                                    else
                                    {
                                        print('<h5> You can perform only one project at a time</h5>');
                                        
                                    }
                                    
                                    
                                }
                                print('</td>');
                                print('</tr>');
                                
                              }
                            }
                            print('</table>');
                            
                       


?>
</div>

<div class="current_project"> Current Projects</div>
<div class="current_project_details"></div>

      <?php include('footer.php');?>