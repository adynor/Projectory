<style>
.form-control1::-webkit-input-value { color: green; }
.form-control1:-moz-value { color: red; }
.form-control1::-moz-placeholder { color: blue; }
.form-control1:-ms-input-placeholder { color: white; }
p{color: black !important;}
</style>

<script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
include ('db_config.php');
include ('header.php');

?>
<br><br>
   <div class="container" >
    <div class="row " style="padding:20px 0px">
    <div class="ady-row">
    
 <?php


 $l_UR_Type= $_SESSION['g_UR_Type'];
 $l_UR_id = $_SESSION['g_UR_id'];

if(is_null($l_UR_id)||($l_UR_Type !='G' && $l_UR_Type !='M' && $l_UR_Type !='C'))
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}

$l_PR_id	=$_REQUEST['g_PR_id'];

$l_query_display = 'Select PR_Name, PR_Desc, PR_ReleaseDate, PR_ExpiryDate, UR_Owner,PR_SynopsisURL,PR_Objective,PR_Background,PR_Functional_Requirement,PR_Non_Functional_Requirement,PR_Duration,PR_No_Students,PR_Short_Desc from Projects where PR_id = "'.$l_PR_id.'" and Org_id="'.$_SESSION['g_Org_id'].'"';

$l_result_display = mysql_query($l_query_display);


if ($l_row_display = mysql_fetch_row($l_result_display))
{
     $l_Project_name = $l_row_display[0];
     $l_PR_Desc = $l_row_display[1];

   $l_PR_Short_Desc = $l_row_display[12];
     $l_PR_Objective=$l_row_display[6];
     $l_PR_Background=$l_row_display[7];
     $l_Functional_Requirement=$l_row_display[8];
     $l_PR_Non_Functional_Requirement=$l_row_display[9];
     $l_PR_Duration=$l_row_display[10];
     $l_PR_maxstudents=$l_row_display[11];
     $l_PR_ReleaseDate_display =date('d-M-Y',strtotime($l_row_display[2]));
     //$l_PR_ExpiryDate_display = $l_row_display[3];
$l_PR_ExpiryYear = date('Y',strtotime($l_row_display[3]));
$l_PR_ExpiryMonth = date('F',strtotime($l_row_display[3]));  // for showing month
 $l_PR_ExpiryDate = date('d',strtotime($l_row_display[3]));

     $l_PR_Ownerid = $l_row_display[4];
     $l_SynopsisURL_display = $l_row_display[5];
}
if(isset($_POST['submit']) )
{
    $l_PR_maxstudents=$_POST['l_PR_maxstudents'];
  $l_PR_Duration=$_POST['l_PR_duration'];
  $l_Project_name  = $_POST['l_Project_name'];  
 $l_PR_Desc = $_POST['l_PR_Desc'];    
  $l_PR_Short_Desc = $_POST['l_PR_Short_Desc'];    
 
   $l_PR_Objective = $_POST['l_PR_Objective'];   
   $l_PR_Background = $_POST['l_PR_Background'];   
   $l_Functional_Requirement = $_POST['l_Functional_Requirement'];   
   $l_PR_Non_Functional_Requirement= $_POST['l_PR_Non_Functional_Requirement'];   
  

   $l_PR_ExpiryDateFinal =$_POST['Year'].$_POST['Month'].$_POST['Date'];
   $l_PR_ExpiryYear=date('Y',strtotime($l_PR_ExpiryDateFinal));
  $l_PR_ExpiryMonth=date('F',strtotime($l_PR_ExpiryDateFinal));
  $l_PR_ExpiryDate=date('d',strtotime($l_PR_ExpiryDateFinal));

  // code for submiting Synopsis pdf files in database 26 April 2016
  $l_file_extention_numb=1;
@$file_name=basename($_FILES['file']['name']);   //new synopsis modification line
$extension = pathinfo($file_name, PATHINFO_EXTENSION);
$rename =  $l_PR_id.'_'.$l_file_extention_numb;
$file_Modified_Name= $rename.'.'.$extension;
          
@$file_size=$_FILES['file']['size'];   //new  modification line
@$file_type=$_FILES['file']['type'];   //new  modification line
@$file_path=$_FILES['file']['tmp_name'];  //new  modification line

$not_allowed = array('php','php5','exe','css','php','c','cpp','java','pl','htm','js','css','xml','jsp','ser','jsf','jse','bat','cmd','jad','json','aspx','lib','pdb','dbg','php3','pmp','pm','bml','p','j','hta','com','lnk','pif','scr','vb','vbs','wsh','html');
$allowed="pdf";
          
if(!empty($file_path)){
    
    if($extension!=$allowed)
        {
        echo '<div class="alert alert-danger">Please change your file to Pdf and try uploading again</div>';
        
        }else{
    $Synopsisdata =file_get_contents($file_path);
    $synopsisquery= 'UPDATE Project_Synopsis SET PR_Synopsis_Data="'.mysql_real_escape_string($Synopsisdata).'",PR_Synopsis_Name="'.$file_Modified_Name.'",PR_Synopsis_Original_Name="'.$file_name.'",PR_Synopsis_Size="'.$file_size.'",PR_Synopsis_Type="'.$file_type.'" WHERE PR_id='.$l_PR_id.' and Org_id="'.$_SESSION['g_Org_id'].'"';
    if(mysql_query($synopsisquery)){echo '<div class="alert alert-success">Synopsis File Updated Successfully!!</div>';}
        }
}       
if(!empty($l_Project_name ))
{
 $sql='UPDATE Projects SET PR_Name="'.htmlspecialchars($l_Project_name).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
 mysql_query($sql);

} 
if(!empty( $l_PR_Objective ))
{
 $sql='UPDATE Projects SET PR_Objective="'.htmlspecialchars($l_PR_Objective).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
 mysql_query($sql);

} 
if(!empty($l_PR_Background ))
{
 $sql='UPDATE Projects SET PR_Background="'.htmlspecialchars($l_PR_Background).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql);

} 
if(!empty($l_Functional_Requirement ))
{
 $sql='UPDATE Projects SET PR_Functional_Requirement="'.htmlspecialchars($l_Functional_Requirement).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
 mysql_query($sql);

}
if(!empty($l_PR_Non_Functional_Requirement ))
{


    $sql='UPDATE Projects SET PR_Non_Functional_Requirement="'.htmlspecialchars($l_PR_Non_Functional_Requirement).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql);

} 
if(!empty($l_PR_Short_Desc ))
{
     $sql='UPDATE Projects SET PR_Short_Desc ="'.htmlspecialchars($l_PR_Short_Desc).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql);

} 
if(!empty($l_PR_Desc ))
{
     $sql='UPDATE Projects SET PR_desc="'.htmlspecialchars($l_PR_Desc).'" WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql);

} 
if(!empty($l_PR_Duration)){
   
    $sql5='UPDATE Projects SET PR_Duration='.$l_PR_Duration.' WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql5);
}
if(!empty($l_PR_maxstudents)){
   
    $sql5='UPDATE Projects SET PR_No_Students='.$l_PR_maxstudents.' WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql5);
}
if(!empty($l_PR_ExpiryDateFinal))
{   

if($l_PR_ExpiryDateFinal>$l_row_display[2])
{
   $sql='UPDATE Projects SET PR_ExpiryDate='.$l_PR_ExpiryDateFinal.' WHERE Org_id="'.$_SESSION['g_Org_id'].'" and PR_id='.$l_PR_id ;  
    mysql_query($sql);
//print('<div class="alert alert-success">Updated Successfully!!</div>');
}else
print('<div class="alert alert-danger">Expiry date should be Greater than Release date</div>');

} 

}

$l_MentorName= 'Select UR_FirstName, UR_MiddleName, UR_LastName from Users where UR_id = "'.$l_PR_Ownerid.'" and Org_id="'.$_SESSION['g_Org_id'].'"';
$l_result = mysql_query($l_MentorName);
$l_row = mysql_fetch_row($l_result);
?>
 <a href="MProjList01.php">Back</a>                   
<div class="panel panel-primary" style="width:100%;">
<div class="panel-heading" style="width:100%;"> Edit Project</div>
<div class="panel-body table-responsive table" style="width:100%;">
 
<form action="" method="POST" enctype="multipart/form-data">
<table class="ady-table-content" border=1 style="width:100%"> 
<tr><th>Mentor</th><th colspan=3><?php echo $l_row[0] ?></th></tr>

<tr>
    <td>Project Name<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Name of the project to be shown to the student"><span class="glyphicon glyphicon-info-sign" ></span></a><span id="errprname"></span> </td>  
    <td colspan=3 >
        <input id="prname" class="form-control form-control1 ady-form" type=text name="l_Project_name"  value = '<?php echo htmlspecialchars_decode($l_Project_name); ?>'>
    </td></tr>


<tr>
    <td>Project Short Description<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a short description which will be shown to the student before he applies for it."><span class="glyphicon glyphicon-info-sign" ></span></a>
  <span id="errprshortdisc"></span></td></td>
    <td colspan=3>
        <textarea style="height: 83px;"class="form-control ady-form" name="l_PR_Short_Desc" >
            <?php echo $l_PR_Short_Desc ;?>
        </textarea>
        <script type="text/javascript">
     // CKEDITOR.replace( 'l_PR_Short_Desc' );
      CKEDITOR.replace('l_PR_Short_Desc', {
    on: {

        key: function() {
        $('#errprshortdisc').text('');
        }
    }
});         
   </script>
    </td>
</tr>

<tr>
    <td>Project Description<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a description of a project which will be shown to the student after he applies for it."><span class="glyphicon glyphicon-info-sign" ></span></a><span id="errprdiscrip"></span></td></td>
    <td colspan=3>
        <textarea style="height: 83px;"class="form-control ady-form" name="l_PR_Desc" >
            <?php echo $l_PR_Desc ;?>
        </textarea>
        <script type="text/javascript">
     // CKEDITOR.replace( 'l_PR_Desc' );
     CKEDITOR.replace('l_PR_Desc', {
    on: {

        key: function() {
        $('#errprdiscrip').text('');
        }
    }
});         
   </script>
    </td>
</tr>

<tr>
    <td>Project Objective<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="What is the objective of the project for the student to achieve?"><span id="errprobjective"><span class="glyphicon glyphicon-info-sign" ></span></a></span></td></td>
    <td colspan=3>
        <textarea class="textarea" style="height: 83px;"class="form-control ady-form" name="l_PR_Objective" >
            <?php echo $l_PR_Objective ;?>
        </textarea>
        <script type="text/javascript">
      //CKEDITOR.replace( 'l_PR_Objective' );
      CKEDITOR.replace('l_PR_Objective', {
    on: {

        key: function() {
        $('#errprobjective').text('');
        }
    }
});          
   </script>
    </td>
</tr>
<tr>
    <td>Project Background<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="A brief background on how the project idea was initiated"><span class="glyphicon glyphicon-info-sign" ></span></a></td>
    <td colspan=3>
        <textarea style="height: 83px;"class="form-control ady-form" name="l_PR_Background" >
           <?php echo $l_PR_Background ;?>

        </textarea>
   <script type="text/javascript">
     // CKEDITOR.replace( 'l_PR_Background' );
     CKEDITOR.replace('l_PR_Background', {
    on: {

        key: function() {
       //$('#errprobjective').text('');
        }
    }
});         
   </script>
    </td>
</tr>


<tr>
    <td>Project Functional Requirements<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content=" This is the functional requirements that will help allow the students to refer for him to finish the project."><span class="glyphicon glyphicon-info-sign" ></span></a>
  <span id="errprfunctionreq"></span></td></td>
    <td colspan=3><textarea style="height: 83px;"class="form-control ady-form" name="l_Functional_Requirement" >
         <?php echo $l_Functional_Requirement ;?>
    </textarea>
   <script type="text/javascript">
     // CKEDITOR.replace( 'l_Functional_Requirement' );
      CKEDITOR.replace('l_Functional_Requirement', {
    on: {

        key: function() {
        $('#errprfunctionreq').text('');
        }
    }
});          
   </script>
    </td>
</tr>

               <tr>
                   <td>
                       Project Non Functional requirements<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content=" This is the Non-functional requirements that will help allow the students to refer for him to finish the project."><span class="glyphicon glyphicon-info-sign" ></span></a>
  <span id="errprnonfunctionreq"></span></td>
                   </td>
                   <td colspan=3>
                       <textarea style="height: 83px;"class="form-control ady-form" name="l_PR_Non_Functional_Requirement" >

                           <?php echo $l_PR_Non_Functional_Requirement ?>
                       </textarea>
                      <script type="text/javascript">
     // CKEDITOR.replace( 'l_PR_Non_Functional_Requirement' );
       CKEDITOR.replace('l_PR_Non_Functional_Requirement', {
    on: {

        key: function() {
        $('#errprnonfunctionreq').text('');
        }
    }
});                
   </script>
                   </td>
               </tr>

 <tr>
    <td>Edit Project Synopsis<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a document form of the information provided above in pdf format.
"><span class="glyphicon glyphicon-info-sign" ></span></a></td>
    <td colspan=3>
         <div class="form-group">
                <div class="input-group input-group-md">
                    <div class="icon-addon addon-md">
                      <input  id="filedata" type="file" name="file" id="file">
                    </div>
<!--                    <span class="input-group-btn">
                        <input class="btn btn-success" type="submit" value="Update Synopsis"></input>
                    </span>-->
                </div>
        </div>
  </td> 
</tr> 
  
<tr>
    <td>Project Duration<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="How long will an average team of 3 students will take to finish this project?"><span class="glyphicon glyphicon-info-sign" ></span></a></td>
    <td colspan=3>
         <div class="form-group">
             <div class="input-group input-group-md">
                    <div class="icon-addon addon-md">
                      <input type="number" class="form-control" name="l_PR_duration" min="0" value="<?php echo $l_PR_Duration;?>">
                    </div>
                    <span class="input-group-btn">
                        <button class="btn " type="button">days</button>
                    </span>
             </div>
        </div>
  </td>
</tr>
<tr>
    <td>Maximum No of Students<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="How many number of students can perform this project per team?"><span class="glyphicon glyphicon-info-sign" ></span></a></td>
    <td colspan=3>
         <div class="form-group">
                <div class="input-group input-group-md">
                    <div class="icon-addon addon-md">
                      <input type="number" class="form-control" name="l_PR_maxstudents" min="0" max="7" value="<?php echo $l_PR_maxstudents;?>">
                    </div>
                   
                </div>
        </div>
   </td>
</tr>
<tr>
    <td>Project Release Date</td>
    <td colspan=3><?php  echo $l_PR_ReleaseDate_display; ?></td>
</tr>
<tr><td>Project Expiry Date<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This indicates till what time the project will be shown in projectors to the students.
"><span class="glyphicon glyphicon-info-sign" ></span></a><span id="errdate"></span></td></td><td>Month<select id="EMonth" class="form-control" name=Month>
  <?php
for ($m=1; $m<=12; $m++) 
{
  if(date('F', mktime(0,0,0,$m))==$l_PR_ExpiryMonth)
   {
      if($m<10)
         {
    print(' <option value="0'.$m.'" selected>'.date('F', mktime(0,0,0,$m)).'</option>') ;
 
        }
      else
        {
    print(' <option value="'.$m.'" selected>'.date('F', mktime(0,0,0,$m)).'</option>') ;
        }
  }
   else
    {
     if($m<10)
         {
    print(' <option value="0'.$m.'">'.date('F', mktime(0,0,0,$m)).'</option>') ;
 
        }
      else
        {
    print(' <option value="'.$m.'" >'.date('F', mktime(0,0,0,$m)).'</option>') ;
        }
     }
}
print('</select></td>');

print('<td>Date<select id="EDate"  class="form-control" name=Date >');
for($i=1; $i< 31; $i++)
{
if($i== $l_PR_ExpiryDate)
{
  if($i<10)
  {    
    print('<option value="0'.$i.'" selected>'.$i.'</option>');
  }
  else
  {    
    print('<option value="'.$i.'" selected>'.$i.'</option>');
  }
} 
else
{
  if($i<10)
  {    
    print('<option value="0'.$i.'">'.$i.'</option>');
  }
  else
  {    
    print('<option value="'.$i.'">'.$i.'</option>');
  }

}
}
print('</select> </td>');

print('<td>Year<select id="EYear" class="form-control" name="Year">');
for($i = date('Y'); $i<=date('Y')+3; $i++)
{
if($i== $l_PR_ExpiryYear)
{
    print('<option value="'.$i.'"selected>'.$i.'</option>');
} 
else
{
    print('<option value="'.$i.'">'.$i.'</option>');

}

}
print('</select>');
print('</td></tr>');

print('<tr><td><font size="2" color="red">Note : All fields with * are mandatory. </font></td>   <td colspan=3>
<input  class="form-control btn-primary ady-req-btn" type="submit" name=submit value="Update" ></td></tr>');
    
    print('</table>');
    print('</form></div></div></div>');
      
?>
</div></div></div>
<?php include('footer.php'); ?>
<script>
$(document).ready(function(){

$('#prname').on("keyup",function() {
		$("#errprname").hide().html("");  
	}); 
 	
 	$('#EYear,#EMonth,#EDate').on('change', function() {
		var Releasedate='<?php  echo $l_PR_ReleaseDate_display; ?>';
 		var Expirydate=$("#EYear").val()+$("#EMonth").val()+$("#EDate").val();
	   if(Expirydate > Releasedate){
		$("#errdate").hide().html(" [Expiry-Date should be greater than Start-Date.]");
     	  }   
	});
	
        $("form").submit( function(e) {
		var flag = true;
		
		var Releasedate='<?php  echo $l_row_display[2]; ?>';
		var Expirydate=$("#EYear").val()+$("#EMonth").val()+$("#EDate").val();
		
	        var prname=$("#prname").val();
	          
		var messageLength0 = CKEDITOR.instances['l_PR_Short_Desc'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength1 = CKEDITOR.instances['l_PR_Desc'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength2 = CKEDITOR.instances['l_PR_Objective'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength3 = CKEDITOR.instances['l_Functional_Requirement'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength4 = CKEDITOR.instances['l_PR_Non_Functional_Requirement'].getData().replace(/<[^>]*>/gi, '').length;
	    
	    if(prname==""){
                $('#prname').focus();
		flag = false;
		$("#errprname").show().html("[Project Name Invalid].");
		$("#errprname").css('color', 'red');
	   
	    }
	   
            if( !messageLength0 ) {
            flag =false;
		$("#errprshortdisc").show().html("[Short Description empty].");
		$("#errprshortdisc").css('color', 'red'); 
               e.preventDefault();
            }
            if( !messageLength1 ) {
            	flag =false;
                $("#errprdiscrip").show().html("[Discription can't be empty].");
  		$("#errprdiscrip").css('color', 'red');
                e.preventDefault();
            }
            if( !messageLength2 ) {
            	flag =false;
                $("#errprobjective").show().html("[Objective can't be empty].");
		$("#errprobjective").css('color', 'red');
                e.preventDefault();
            }
            if( !messageLength3 ) {
            	flag =false; 
                $("#errprfunctionreq").show().html("[Functional req can't be empty].");
		$("#errprfunctionreq").css('color', 'red');
                e.preventDefault();
            }
            if( !messageLength3 ) {
            	flag =false;
                $("#errprnonfunctionreq").show().html("[Non-Functional req can't be empty].");
                $("#errprnonfunctionreq").css('color', 'red');
                e.preventDefault();
            }
	    if(Releasedate>=Expirydate){
		flag = false;
		$("#errdate").show().html(" [Expiry-Date should be greater than Release Date.]");
		 $("#errdate").css('color', 'red');
		e.preventDefault();
	    } 
	    
	    if(flag == true){
	      return true;
	    } else{
	    	return false;
	    }  
       });
});
</script>


<script>


function updatesynopsis()

{

var name=document.getElementById( "filedata" );
var age=document.getElementById( "age_of_user" );
var course=document.getElementById( "course_of_user" );

$.ajax({
        type: 'post',
        url: 'insertdata.php',
        data: {
        user_name:name,
        user_age:age,
        user_course:course
        },
        success: function (response) {
        $('#success__para').html("You data will be saved");
        }
    });

return false;

}

</script>