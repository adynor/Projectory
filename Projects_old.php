<?php

include('header_signup.php');

?>

<style>

li:hover {font-size: 15px; padding-left: 23px; }

.panel 
{
    border: 1px solid #f4511e;
    border-radius: 0 !important;
    transition: box-shadow 0.5s;
}
.panel-heading {
   color: #fff !important;
    /*background-color: #728C00 !important;  */
    padding: 25px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
}
.panel-footer .btn {
    margin: 15px 0;
    /*background-color: #728C00;*/
    color: #fff;
}
.panel-footer .btn:hover {
    border: 1px solid #728C00;
    background-color: #fff !important;
    color: #f4511e;
}
</style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 <?php  
    include ('db_config.php');
    ?>
<div class="container" >
    <?php
    $l_TM_id=$_SESSION['g_TM_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_PR_id_current=$_SESSION['g_PR_id'];
    
    $timezone = new DateTimeZone("Asia/Kolkata" );
    $date = new DateTime();
    $date->setTimezone($timezone );
    $l_currentDate = $date->format( 'Ymd' );
    
    $l_UR_Details_query = 'select UR_RegistrationStatus, UR_FirstName from Users where UR_id = "'.$l_UR_id.'" AND Org_id ="'.$_SESSION['g_Org_id'].'" ';
    $l_UR_Details_result = mysql_query($l_UR_Details_query);
    $l_UR_Name_row = mysql_fetch_row($l_UR_Details_result);
    $l_UR_RegistrationStatus = $l_UR_Name_row[0];
    $l_UR_FName = $l_UR_Name_row[1];
    $_SESSION['UR_FirstName']=$l_UR_FName;






    
    if(isset($_SESSION['g_UR_id']))
    {
    print('<h2><b> Welcome to Projectory: '.$l_UR_FName.'</b></h2>'); 
 if($l_UR_Type==='S')
        {
          $msg=1;
          $msg_view=1;
        }
        else if($_SESSION['g_UR_Type']=='G'){
     // print('<input type="button" clavalue="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/GHome.php\'"></input>');
     	print('<a class="btn btn-primary" href="GHome.php">Enter the Portal</a>');
     	$msg=0;
 	}

        else if($_SESSION['g_UR_Type']=='M')
        {
            //print('<input type="button" value="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/MHome/\'"></input>');
        print('<a class="btn btn-primary" href="MHome.php">Enter the Portal</a>');
        $msg=0;
        }
        else if($_SESSION['g_UR_Type']=='C')
        {
         $msg=0;
            //print('<input type="button" value="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/CHome/\'"></input>');
        print('<a class="btn btn-primary" href="CHome.php">Enter the Portal</a>');
	}
        else if($_SESSION['g_UR_Type']=='T')
        {
        // print('<input type="button" value="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/THome/\'"></input>');
          print('<a class="btn btn-primary" href="THome.php">Enter the Portal</a>');
          $msg=0;
	}
        else if($_SESSION['g_UR_Type']=='A')
        {
         $msg=0;
         //print('<input type="button" value="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/AHome/\'"></input>');
          print('<a class="btn btn-primary" href="AHome.php">Enter the Portal</a>');
 	}
 	else if($_SESSION['g_UR_Type']=='PA')
        {
         $msg=0;
         //print('<input type="button" value="Enter the Portal" onClick="javascript:window.location.href=\''.$l_filehomepath.'/AHome/\'"></input>');
          print('<a class="btn btn-primary" href="PAHome.php">Enter the Portal</a>');
 	}
    }
    else
    {  print('<br><h2><b> Welcome to Projectory</b></h2>'); 
 	print('<p><font color="003366">You need to <a href = "'.$l_filehomepath.'/login.php">Login </a>to view the projects</font></p><br/><br/>');
    $msg=1;
    $msg_view=0;
    }
  ?>
      </div>
<?php if($msg ===1){?> 
<!-- Container (Pricing Section) -->
<div id="pricing" class="container-fluid">
  <div class="text-center">
    <h3 style="color:rgba(66, 169, 156, 0.84)">Pricing</h3>
    <h4 style="color:rgba(66, 169, 156, 0.84)">Choose a payment plan that works for you</h4>
  </div>
  <div class="row slideanim">
    <?php
    $l_MO_Details_query ='select MO_id, MO_Name,MO_Amount from Model where Org_id ="ALL"';
    $l_MO_Details_result = mysql_query($l_MO_Details_query);
    while($l_MO_row =mysql_fetch_row($l_MO_Details_result))
            {
            
               $l_MO_id = $l_MO_row[0];
                $l_MO_Name = $l_MO_row[1];
                $l_MO_Amount = $l_MO_row[2];
                
                if($l_MO_Amount==0)
                {
                    $l_MO_Amount="Free";
                }
                if($l_MO_id==1){ $BG_color= "#CD7F32;"; $domian1='Web Technologies'; $domian2='Web Application'; }
                else
                if($l_MO_id==2){ $BG_color= "#989898;"; $domian1='Cloud Computing'; $domian2='Mobile Computing ';}
                else
                if($l_MO_id==3){$BG_color= "#DAA520;"; $domian1='Mobile Applications'; $domian2='Cloud Computing';}
                else
                if($l_MO_id==4){$BG_color= "#666666;"; $domian1='Mobile Computing'; $domian2='Big Data Analytics';}    
 ?>
     <div class="col-sm-3 col-xs-12" >
      <div class="panel panel-default text-center" style="border:1px solid'<?=$BG_color?>; background-color:<?=$BG_color?>">    
       <div class="panel-heading" style="background-color:<?=$BG_color?>"> 
   <h3><?php echo $l_MO_Name ;?> </h3>
        </div>
        <div class="panel-footer">
          <h3><i class="fa fa-inr"></i> <?php echo $l_MO_Amount; ?></h3>
          <?php if($msg_view ===1){?>
          <a class="btn btn-lg" style="background-color:<?php echo $BG_color ?>" href="ProjectModel01.php?g_MO_id=<?php echo $l_MO_id.'|'.$l_MO_Amount ;?>" >View </a>
          <?php }else{ ?>
          <a class="btn btn-lg" style="background-color:<?php echo $BG_color ?>" href="login.php" >Login </a>
          <?php } 
         
          
 print('
 <ul class="list-group" id="my-list">
 <li class="list-group-item " ><span ></span>Available Domains</li>
    <li class="list-group-item " style=
    "color: steelblue;"><span class="glyphicon glyphicon-play "    style=" color: dodgerblue;"></span> '.$domian1.'</li>
    </li><li class="list-group-item" style=
    "color: steelblue;"><span class="glyphicon glyphicon-play "    style=" color: dodgerblue;"></span> '.$domian2.'</li>
    </li>
    
  </ul>')
          ?>
        </div>
      </div>      
    </div>     
            <?php } ?>
  </div>
    <div class="col-md-12" >
        <div class="col-md-4 col-md-offset-4"><a class="btn btn-warning btn-lg btn-block" href="<?php echo $l_filehomepath; ?>/ProjectList.php"> SHOW ALL PROJECTS</a></div>
    </div>
</div>
<?php if(isset($_SESSION['g_UR_id'])){?>
<div class="current_project"> Current Projects</div>
<div class="current_project_details"></div>
<?php }?>
<?php } ?>



      <?php include('footer.php');?>