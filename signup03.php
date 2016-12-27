<?php
ob_start();
session_start();
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

$l_filehomepath= url(); 

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="https://zaireprojects.com/assets/images/favicon.ico" type="image/x-icon" />
        <title>Zaire Projectory</title>
        <link href="<?php echo  $l_filehomepath; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo  $l_filehomepath; ?>/assets/css/master.css" rel="stylesheet">
        <link href="<?php echo  $l_filehomepath; ?>/assets/css/master1.css" rel="stylesheet">
         <script src="<?php echo  $l_filehomepath; ?>/assets/js/jquery-2.2.0.min.js"></script>
    </head>
    <body> 
    
<?php  include ('db_config.php');
$path=$_GET[path];?>

<div class="container">
<?php if(isset($path)){?>
<h3 style="
    text-align: center;
    color: lightseagreen;">Last Step of Registration</h3>
<div class="alert alert-success"><h5>After completing this step Please check your mail and click on the verification link sent to you. The mail might take a few minutes to reach you. If you do not receive any mail please check your spam folder.Meanwhile add few more information</h5></div>
<?php } else{?><h3 style="
    text-align: center;
    color: lightseagreen;">Please add few more details before login</h3> <?php } ?>
<div class=" col-md-offset-3 col-md-6">
<?php 
$data=$_GET;
$l_URPR_Type=$data['user_type'];
?>
<?php
if($l_URPR_Type =="C" ){
echo '<script>window.top.location.href="https://www.zaireprojects.com"</script>';
}
else if(isset($_POST['user_submit'])){
if($l_URPR_Type =="S" ){ 
if( $_POST['user_it_id']==""){
echo " Please choose your institute .";
} else if($_POST['user_semester'] =="" ){
echo " Please choose your semester .";
} else {
$query=mysql_query("UPDATE Users SET UR_Semester='".$_POST['user_semester']."',IT_id='".$_POST['user_it_id']."',UR_USN='".$_POST_['UR_usn']."',PG_id='".$_POST['user_PG_id']."' WHERE UR_id='".$_GET['user']."' AND Org_id ='".$_GET['org']."'");
echo '<script>window.top.location.href="https://www.zaireprojects.com"</script>';
}
}
else if($l_URPR_Type =="G" || $l_URPR_Type =="A"){ if( $_POST['user_it_id'] ==""){ echo " Please choose your Institute .";} 
else{ 
$query=mysql_query("UPDATE Users SET IT_id='".$_POST['user_it_id']."',UR_USN='".$_POST_['UR_usn']."',PG_id='".$_POST['user_PG_id']."' WHERE UR_id='".$_GET['user']."' AND Org_id ='".$_GET['org']."'");
echo '<script>window.top.location.href="https://www.zaireprojects.com"</script>';
}
}
else if($l_URPR_Type =="M" ){ if( $_POST['user_company_id'] ==""){ echo " Please choose your company name ."; } else if($_POST['user_company_info'] =="" ){ echo " Please choose enter your profile info ."; }
else{ 
$query=mysql_query("UPDATE Users SET UR_CompanyName='".$_POST['user_company_id']."',UR_USN='".$_POST_['UR_usn']."',UR_ProfileInfo='".$_POST['user_company_info']."' WHERE UR_id='".$_GET['user']."' AND Org_id ='".$_GET['org']."'");
echo '<script>window.top.location.href="https://www.zaireprojects.com"</script>';}
}
else{
echo "Apologies!! Some error has occured. Please try again.";
}
}
?>
 <form class="form-horizontal" action="" method="POST">
 <?php if($l_URPR_Type=='G'|| $l_URPR_Type=='S' ||$l_URPR_Type=='M'){
 if($l_URPR_Type =='G'){
 $usntitle="Guide Registration Number";
 }
 else if($l_URPR_Type =='M'){
 $usntitle="Mentor Registration Number";
 }
 else{
  $usntitle="University Registration Number";
 }
 ?>
 
  <div class="control-group" id="">
                         <label class="control-label" for="Institutes"><?php echo $usntitle; ?></label>
                        
                         <input type="text"  class=" form-control input-lg"  name="UR_usn"> 
                    </div>
 <?php } ?>
<?php if($l_URPR_Type =='S'){?>
                    <div class="control-group"  >
                            <label class="control-label" for="User Semester">Semester<span style="color:red">*</span></label>
                            <select   id="user_semester" name="user_semester" class="form-control input-lg">
                                <option value="">----</option>
                                 <?php for($i=1;$i<9;$i++) {?>
                                <option id="user_semester_<?php echo $i ?>" value="<?php echo $i ?>" ><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                    </div>

                    <?php
                    }
                    $l_institutes= array();
                    if($l_URPR_Type=='S'||$l_URPR_Type=='G' ||$l_URPR_Type=='A' )
                    {    
                    $l_sql      ='SELECT IT_id, IT_Name FROM  Institutes ORDER BY IT_Name';
                    $l_result =mysql_query($l_sql);
                    while($l_row_results=mysql_fetch_row($l_result)){
                    array_push($l_institutes,$l_row_results);
                    }
                    ?>
                        <?php if($l_URPR_Type=='G'|| $l_URPR_Type=='S' ||$l_URPR_Type=='A'){?>
                    <div class="control-group" id="">
                         <label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
                        
                         <select class=" form-control input-lg" onchange="InstituteChange()" id="user_it_id" name="user_it_id" style="overflow-y: auto;">
                                <option value="">------</option>
                                <?php foreach ($l_institutes as $l_institute  ){?>
                                <option id="institute_change_<?php echo $l_institute[0]; ?>"  value="<?php echo $l_institute[0]; ?>">
                                       <?php echo $l_institute[1] ?>
                                </option>
                                <?php } ?>   
                            </select>
                       
                    </div>
                        <?php if($l_URPR_Type=='G'|| $l_URPR_Type=='S'){?>
                    <div class="control-group"  id="user_program">
                        <label class="control-label" for="Programs">Select Your Program<span style="color:red">*</span></label>
                        <select  id="user_PG_id" class=" form-control input-lg"  name="user_PG_id"  >
                              <option value="" > ------ </option>
                              
                        </select>
                    </div>
                        <?php } }

}
?>
<?php
if($l_URPR_Type=='M')
                    {  
                         $l_companys=array();
                    $l_sql1 ='Select UR.UR_id, UR.UR_FirstName,UR.UR_MiddleName,UR.UR_LastName from Users as UR where UR.UR_Type ="C" and UR.UR_RegistrationStatus="C"';
                        $l_result1 =mysql_query($l_sql1);
                        while($l_row_results1=mysql_fetch_row($l_result1)){
                            array_push($l_companys,$l_row_results1);
                        }
                    
                    ?>
                    <div class="control-group" >
                         <label class="control-label" for="CompanyName">Select Your Company Name<span style="color:red">*</span></label>

                            <select class="form-control input-lg" id="user_company_id" name="user_company_id" >
                                <option value="">----</option>
                                <?php foreach ($l_companys as $l_company  ){?>
                                
                                <option value="<?php echo $l_company[0]; ?>">
                                       <?php echo $l_company[1]." ".$l_company[2]." ".$l_company[3]; ?>
                                </option>>
                                <?php } ?>   
                            </select>

                    </div>
                    <?php } if($l_URPR_Type=='M'){?>
                        
                        <div class="control-group" id="">
                            <label class="control-label" for="CompanyInfo"> Profile Information<span style="color:red">*</span></label>
                         <textarea class="form-control" rows="5" id="profile_info" name="user_company_info"id="comment"></textarea>
                         <p class="help-block"></p>
                        </div>
                    <?php } ?>
                    <input type="submit" style="margin-top: 10px;" onclick="return Validation()" name="user_submit" value="Create an Account" id="create_an_acc" class="btn btn-success  pull-right">
                     </from> 
                    </div>
                    </div>
      
                    <script>
                    function InstituteChange(){
                    var institute_id = $('#user_it_id').val();
 $('#loading').show();
 if(institute_id=='0'){
 //$('#loading').show();
 $("#user_it_id").parent().append('<br class="Other_Institute"><div class="Other_Institute" class="control-group"><div class="controls"><input type="text" id="Other_Institute" name="Other_Institute" placeholder="Enter Your Institute" class="form-control input-lg"><p class="help-block"></p></div></div>');
  $("#user_PG_id").parent().append('<br class="Other_Institute"><div class="Other_Institute" class="control-group"><div class="controls"><input type="text" id="Other_program" name="Other_program" placeholder="Enter Your Stream" class="form-control input-lg"><p class="help-block"></p></div></div>');
 }
 else{
 $('.Other_Institute').remove();
 }
 //var institute_id = $('#user_it_id').val();
 //alert(institute_id);
 var data2={user_institute_id:institute_id};
$select = $('#user_PG_id');
    $.ajax({
        type: "GET",
         dataType: "json",
        data:data2,
        url: "signup_programs.php",
        async: false,
        success : function(data) {
          //  alert(data);
    //clear the current content of the select
       $select.html('');
       //iterate over the data and append a select option
       $.each(data, function(key, val){
         $select.append('<option value="' + val[0] + '">' + val[1] + '</option>');
       });
        }
     });
 
 }

                    </script>
<?php include('footer.php'); ?>