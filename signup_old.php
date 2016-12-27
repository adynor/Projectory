<?php include('header_signup.php'); ?>
<?php  include ('db_config.php');?>
<div class="container cus-top">
  <div class="row">
        <div class="col-md-3" ></div>
        <div class="col-md-6 " >  
            <div class="bs-example" data-example-id="contextual-panels"> 
              <div class="panel panel-primary">
                  <div class="panel-heading" id="signup-panel-heading" style="text-align: center">Sign Up</div>
                <div class="panel-body "> 
<?php
if(isset($_POST['user_submit']) ){
    echo '<div class="alert alert-info" style="text-align:center" >';
    $timezone = new DateTimeZone("Asia/Kolkata" );
    $date = new DateTime();
    $date->setTimezone($timezone );
    $l_Insert_Datetime = $date->format( 'YmdHi' );
    
    $l_UR_Type=$_POST['user_type'];
    $l_UR_Salutation=$_POST['user_Salutation'];
    $l_Name=$_POST['user_name'];
    $l_UR_id=$_POST['user_id'];
    $l_pass=$_POST['user_password'];
    $l_cpass=$_POST['user_password_confirm'];

    $l_UR_USN=$_POST['user_urn'];   
    $l_UR_ProfileInfo = $_POST['user_company_info'];
    $l_UR_Company = $_POST['user_company_id'];
    $l_company_id=$_POST['user_company_id'];
   if(isset($_POST['user_it_id'])){
    $l_IT_id=$_POST['user_it_id'];
    } else{
    $l_IT_id=NULL;
    }
    if(isset($_POST['user_PG_id'])){
    $l_PG_id=$_POST['user_PG_id'];
    } else{
    $l_PG_id=NULL;
    }
    $l_Company_Name=$_POST['user_company_id'];
    if(isset($_POST['user_semester'])){
    $l_Semester=$_POST['user_semester'];
    }
    else{
  echo   $l_Semester=NULL;
    }

   $l_Emailid=$_POST['user_email'];
    $array_Email=explode('@',$l_Emailid);
    $l_UR_Emailid =$array_Email[0];
    $l_UR_EmailidDomain = $array_Email[1];
    
 
// this is to check the user-id already in record
$l_query="select UR_id from Users where UR_id='".$l_UR_id."'";
$l_query_result=mysql_query($l_query) or die(mysql_error());
$l_UR_idCount=mysql_num_rows($l_query_result);

// this is to check the mail id already in record
$l_query="select UR_id from Users where CONCAT(UR_Emailid,UR_EmailidDomain)='".$l_UR_Emailid.$l_UR_EmailidDomain."'";
$l_query_result=mysql_query($l_query) or die(mysql_error());
$l_UR_EmailidCount=mysql_num_rows($l_query_result);

// this is to check the USN already in record
$l_query="select UR_id from Users where UR_USN='".$l_UR_USN."'";
$l_query_result=mysql_query($l_query) or die(mysql_error());
$l_UR_USNCount=mysql_num_rows($l_query_result);




$array_Name=explode(' ',$l_Name);
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
     

if (empty($l_pass) || empty($l_UR_id)) {
         echo "<font color=red>User id or password is missing.</font>";
     } 
     else if ($l_pass != $l_cpass) {
         // error matching passwords
         

echo '<font color=red>Your passwords do not match. Please type carefully.</font>';
     }

else if(strlen($l_pass)>15 || strlen($l_pass)<4)
{
echo"<font color=red>Password must be between 4 and 15 characters</font>";
}
     else if($l_UR_idCount==1)
{ 
echo "<font color=red>The <b>User-ID</b> you entered already exist. Please try again with different ID.</font>";
}
else if((empty($l_Name)||empty($l_UR_USN)) && ($l_UR_Type==M||$l_UR_Type==G||$l_UR_Type==S)) 
{
echo"<font color=red>All fields must be filled.Please check !</font>";
}
else if(empty($l_Name) && ($l_UR_Type==C)) 
{
echo"<font color=red>All fields must be filled.Please check !</font>";
}
else if(empty($l_UR_Emailid) ||empty($l_UR_EmailidDomain))
{
echo"<font color=red>Please enter a valid email id</font>";

}
else if($l_UR_EmailidCount>=1)
{ 
echo "<font color=red>The <b>Email-ID</b> you entered already exist. Please try again with different ID.</font >";
}

else if($l_UR_USNCount==1)
{ 
echo "<font color=red>The <b>User Registration Number</b> you entered already exist. Please try again with different ID.</font>";
}else {
        $l_webMaster                 = 'support@zaireprojects.com';
        $l_random_number = rand(100000,999999);
        $l_random_str = strval( $l_random_number) ;                     ///convert the random number to alfa (string)
        print('<input type=hidden name=l_random_str  value="' . $l_random_str . '">  ');
        
       // $l_message = "Thank you for registering with us. <br>Your Verification Code is:".$l_random_str." <br><br>Sincerely, <br>Zaireprojects Support Team";
    $l_message ='<a href="http://zaireprojects.com/test/verify.php?uverify='.$l_random_str.'&&uid='.$l_UR_id.'&&utype='.$l_UR_Type.'">http://zaireprojects.com/test/verify.php</a>';
       
       
        $l_subject = "Confirm Registration";
        $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
       
/*
        $_SESSION['g_UR_Salutation']              = $l_UR_Salutation;
        $_SESSION['g_UR_FirstName']              = $l_UR_FirstName;
        $_SESSION['g_UR_MiddleName']           = $l_UR_MiddleName;
        $_SESSION['g_UR_LastName']               = $l_UR_LastName;
        $_SESSION['g_UR_signup_id']                  = $l_UR_id;
        $_SESSION['g_company_id']                = $l_company_id;
        $_SESSION['g_UR_USN']                        = $l_UR_USN;
        $_SESSION['g_UR_Khufiya']                    = $l_pass;

	$_SESSION['g_UR_Semester']  = $l_UR_Semester;

       $_SESSION['g_UR_Emailid']        = $l_UR_Emailid;
        $_SESSION['g_UR_EmailidDomain']       = $l_UR_EmailidDomain;
        $_SESSION['g_UR_signup_Type']                        = $l_UR_Type;
        $_SESSION['g_UR_ProfileInfo']              = $l_UR_ProfileInfo;
        $_SESSION['g_PG_id']                             = $l_PG_id[0];
        $_SESSION['g_IT_id']                             = $l_IT_id[0];
        $_SESSION['g_random_str']                   = $l_random_str;
        $_SESSION['g_Insert_Datetime']            =  $l_Insert_Datetime;
        $_SESSION['g_IT_Name']                    =  $l_IT_Name;
        $_SESSION['g_PG_Name']                   =  $l_PG_Name;
          $_SESSION['g_IT_id']                    =  $l_IT_Name;
         $_SESSION['g_PG_id']                   =  $l_PG_Name;
        $_SESSION['g_Company_Name']               =  $l_Company_Name;
*/
$l_query = "insert into Users (UR_id, UR_Khufiya, UR_Emailid, UR_EmailidDomain, UR_Type, UR_USN, UR_Salutation,UR_FirstName, UR_MiddleName,UR_LastName,UR_CompanyName,UR_ProfileInfo,UR_InsertDate,UR_RegistrationStatus,UR_VerifyCode,UR_Semester,IT_id,PG_id) values
 ('".$l_UR_id."', '".md5($l_pass)."', '".$l_UR_Emailid."', '".$l_UR_EmailidDomain."' , '".$l_UR_Type."','".$l_UR_USN."','".$l_UR_Salutation."','".$l_UR_FirstName."',
'".$l_UR_MiddleName."','".$l_UR_LastName."','".$l_company_id."','".$l_UR_ProfileInfo."','". $l_Insert_Datetime ."','E','".$l_random_str."','".$l_Semester."','".$l_IT_id."','".$l_PG_id."')";
                    $success=mysql_query($l_query);
if($success){ 
 mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);
print('<div class="alert alert-success"><h3>Please check your mail and click on the verification link sent to you.</h3></div>');}

         //echo "<script> window.location.href = 'signup_verify.php'</script>"; 
} 
echo '</div>';
}
?>

          
                    
                    <form class="form-horizontal" action="" method="POST">
                    
                    <label class="control-label" for="Institutes">Select Your User Type<span style="color:red">*</span></label>
                      <a class="btn btn-success btn-select  btn-select-light">
                            <input type="hidden" id="user_type" name="user_type" value="" />
                            <span class="btn-select-value ">Select Your User Type </span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul >
                                <li class="user_change" id="user_change_1" user_data_type="S" >Student</li>
                                <li class="user_change" id="user_change_2" user_data_type="G">Guide</li>
                                <li class="user_change" id="user_change_3" user_data_type="C" >Company</li>
                                <li class="user_change" id="user_change_4" user_data_type="M">Mentor</li>
                                <li class="user_change" id="user_change_5" user_data_type="A">College Admin</li>
                            </ul>
                        </a>
                        <!--<select name="user_type">
                        <option class="user_change" id="user_change_1" user_data_type="S" >Student</option>
                                <option class="user_change" id="user_change_2" user_data_type="G">Guide</option>
                                <option class="user_change" id="user_change_3" user_data_type="C" >Company</option>
                                <option class="user_change" id="user_change_4" user_data_type="M">Mentor</option>
                                <option class="user_change" id="user_change_5" user_data_type="A">College Admin</option>
                        </select>-->
                        <div id="user_com_data">
                     <div class="control-group" id="user_Salutation_div">
                            <label class="control-label" for="Institutes">Salutation<span style="color:red">*</span></label>
                            <a class="btn btn-success btn-select btn-select-light">
                                <input type="hidden" class="btn-select-input" id="UserSalutation" name="user_Salutation" value="Mr" />
                                <span class="btn-select-value">Mr</span>
                                <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                  <ul >
                                <li   user-data-value="Mr">Mr</li>
                                <li  user-data-value="Ms">Ms</li>
                                <li  user-data-value="Dr">Dr</li>
                                </ul>
                            </a>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="username" id="user_name_label">Name<span style="color:red">*</span></label>
                        <div class="controls">
                        <input type="text" id="user_name" name="user_name" placeholder="Enter Your Name" class="form-control input-lg">
                        <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="userid">User id<span style="color:red">*</span></label>
                        <div class="controls">
                        <input type="text" id="user_id" name="user_id" placeholder="Enter Your User Id" class="form-control input-lg">
                        <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">E-mail<span style="color:red">*</span></label>
                        <div class="controls">
                        <input type="email" id="user_email" name="user_email" placeholder="Enter Your E-mail" class="form-control input-lg">
                        <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="password">Password<span style="color:red">*</span></label>
                        <div class="controls">
                        <input type="password" id="user_password" name="user_password" placeholder="Enter Your Password" class="form-control input-lg">
                        <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group" >
                        <label class="control-label" for="password_confirm">Password (Confirm)<span style="color:red">*</span></label>
                        <div class="controls">
                        <input type="password" id="user_password_confirm" name="user_password_confirm" placeholder="Confirm password" class="form-control input-lg">
                        <p class="help-block"></p>
                        </div>
                    </div>
                    </div>
                        <div id="user_add_fields"></div>
                        

                    <div class="control-group">
                    <!-- Button -->
                        <div class="controls">
                        <a class="btn btn-primary" href="login.php">Back</a>
                        <!-- <button   class="btn btn-primary" onclick="window.location.href ='login.php'"  >Back</button>-->
                            <input type="submit" style="float:right" name="user_submit" value="Create an Account"id="create_an_acc" class="btn btn-success ">
                           
                        </div>
                       
                    </div>
                    </form>
                </div> 
              </div> 
          </div>
       </div>
        <div class="col-md-3 ">  </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script>

$("#user_com_data").hide();
 $("#create_an_acc").hide()
$( ".user_change" ).on('click',function () {

  var str= $(this).attr('user_data_type');
  $("#user_type").val(str);
  if(str === ""){
      $("#user_com_data").hide();
  }else{
  $("#user_com_data").show();
    if(str === "S"){
        $("#signup-panel-heading").html("Sign Up as Student");
    } else if(str === "C"){
        $("#signup-panel-heading").html("Sign Up as Company");
    } else if(str === "M"){
        $("#signup-panel-heading").html("Sign Up as Mentor");
     } else if(str === "G"){
        $("#signup-panel-heading").html("Sign Up as Guide");
     } else if(str === "A"){
    $("#signup-panel-heading").html("Sign Up as College Admin");
    }
  if(str === "C"){
       $("#user_Salutation_div").hide();
       $("#user_name_label").html("Company Name<span style='color:red'>*</span>");
       $("#user_add_fields").html("");
       $("#create_an_acc").show();
  }
  else{
   $("#user_Salutation_div").show();
   $("#user_name_label").html("Name<span style='color:red>*</span>");
var dataString={user_type:str};
$.ajax({
    type:'POST',
    data:dataString,
    url:"signup_user.php",
    success:function(data) {
       $("#user_add_fields").replaceWith(data);
    }
  });
   $("#create_an_acc").show();
  }
  }
  });
  

</script>