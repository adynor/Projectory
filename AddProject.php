<?php
    include ('db_config.php');
    include ('header.php');
   
   ?>

<style>
.ady-text-area
{    height: 213px !important;}
</style>
<script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>
<div class="container" >
<div class="row" style="padding:20px 0px">
<div class="col-md-12  ady-row">
<?php
    ////////////////////////////////////////////////////////////////
    //// Name :   Add-project
    //// Purpose: Interface for Guide and mentor to Add New Project in the Projectory.
    //// Called BY : Ghome,Mhome
    //// Calls :
    //// MOd History :
    /////////////////////////////////////////////////////////////
    /* javascript for NDA functionality..............*/
    print('<script type="text/javascript">
          function ShowNdaRadio(){
          if(document.getElementById("AcceptNda").checked == true){
          document.getElementById("Ndatr").style.display="block";
          document.getElementById("errnda").innerHTML = "";
          }else{
          document.getElementById("Ndatr").style.display="none";
          document.getElementById("NdaR1").checked = false;
          document.getElementById("NdaR2").checked = false;
          document.getElementById("thenda").style.display = "none";
          document.getElementById("thenda").value = "";
          document.getElementById("errnda").innerHTML = "";
          }
          }
          function myFunctionshow(){
         
          document.getElementById("thenda").style.display = "block";
          document.getElementById("errnda").innerHTML = "";
          document.getElementById("thenda").style.borderColor = "grey";
          document.getElementById("thenda").value();
          var thendaval  = document.getElementById("thenda").value();
          
          return thendaval;
           }
          function myFunctionhide(){
          document.getElementById("thenda").style.display = "none";
          document.getElementById("thenda").value = "";
          }
          </script>');
          
          /*javascript for NDA functionality till here.........*/
          
          
          $timezone = new DateTimeZone("Asia/Kolkata" );
          $date = new DateTime();
          $date->setTimezone($timezone );
          $l_PR_InsertDateTime = $date->format('YmdHi');  /* getting date and time while project is adding */
          
          
          
          $l_UR_Type = $_SESSION['g_UR_Type'];
          $l_UR_id = $_SESSION['g_UR_id'];
          
          // checking if user-id is null or user-type is not( guide or mentor or company).....
          if(is_null($l_UR_id) || ($l_UR_Type!='G' && $l_UR_Type!='M' && $l_UR_Type!='C'))
          {
          $l_alert_statement =  ' <script type="text/javascript">
          window.alert("You have not logged in as an authorised person to add projects. Please login correctly")
          window.location.href="login.php"; </script> ';
          
          print($l_alert_statement );
          }
          else
          {
          
          print('<br><br>');
          
          
          print('<div style="clear:left">');
          if(isset($_POST['SaveRec'])) // the button name is also same
          {
          
          $l_sql   = 'select max(PR_id) from Projects ';
          $l_result = mysql_query($l_sql);
          $l_data   = mysql_fetch_row($l_result);
          $l_PR_id= $l_data[0]+1;
          $l_PR_Name    = $_POST['l_PR_Name'];
          $l_PR_Desc    = $_POST['l_PR_Desc'];
         $l_PR_Short_Desc    = $_POST['l_PR_Short_Desc'];
          $l_PR_Objective    = $_POST['l_PR_Objective'];
          $l_PR_Background    = $_POST['l_PR_Background'];
          $l_PR_Functional_req    = $_POST['l_PR_Functional_req'];
          $l_Non_PR_Functional_req   = $_POST['l_PR_N_req'];
          /*
          Modified Date :8th Sep 2016*/
          $l_PR_Prerequisite  = $_POST['l_PR_Prerequisite'];
          $allowed_synopsis=$_POST['allowed_synopsis'];
            $allowed_mentors=$_POST['allowed_mentors'];
          /*-- ---*/

          $l_PR_No_Students  = $_POST['l_PR_No_Students'];
          $l_PR_System_Req = $_POST['l_PR_System_req'];
          $l_PR_Industry = $_POST['l_industry'];
          $l_PR_Solution = $_POST['l_solution'];
          
          $_SESSION['l_PR_Name_fill']=$l_PR_Name;
          $_SESSION['l_PR_Desc_fill']=$l_PR_Desc;

          
           $_SESSION['l_PR_Short_Desc_fill']=$l_PR_Short_Desc;
          $_SESSION['l_PR_Objective_fill']=$l_PR_Objective;
          $_SESSION['l_PR_Background_fill']=$l_PR_Background;
          $_SESSION['l_PR_Functional_req_fill']=$l_PR_Functional_req;
          $_SESSION['l_Non_PR_Functional_req_fill']=$l_Non_PR_Functional_req;
          $_SESSION['l_PR_System_Req_fill']=$l_PR_System_Req;  
          $_SESSION['l_PR_Prerequisite']=$l_PR_Prerequisite;
          
      /* Assigning project models on the basis of compexity levels*/
          $l_PR_level = $_POST['l_PR_level'];
          $l_SD_sel_id_arr = $_POST['l_SD_sel'];
          $l_SD_prf=$_POST['l_SD_prf'];
          

         if($l_PR_level == 1 || $l_PR_level == 2 ||$l_PR_level == 3)
          {
          $l_PR_model=1;
          }
          else if($l_PR_level == 4 || $l_PR_level == 5){
          $l_PR_model=2;
          }
          else if($l_PR_level == 6 || $l_PR_level == 7 || $l_PR_level == 8 )
          {
          $l_PR_model=3;
          } else if($l_PR_level == 9 || $l_PR_level == 10  ){
          $l_PR_model=4;
          }
          /* Assigning project models on the basis of compexity levels*/
          
          $l_PR_Duration2  = $_POST['l_PR_Duration2'];   // selected week or month by user in dropdown
          $l_PR_Duration1  = $_POST['l_PR_Duration1'];   //  number enered in text field by user
          
          if($l_PR_Duration2==Weeks)
          {
          $l_PR_Duration=($l_PR_Duration1*7);  // get Duration in Days from weeks
          }
          else if($l_PR_Duration2==Months)
          {
          $l_PR_Duration=($l_PR_Duration1*30);  // Duration in Days from months
          }
          
          
          $l_Z_NDA=$_POST['Z_NDA'];   // for file upload of NDA
          
          // Get project Release date......................
          $l_SYear=$_POST['SYear'];
          $l_SMonth=$_POST['SMonth'];
          $l_SDate=$_POST['SDate'];
          $l_PR_ReleaseDate =$l_SYear.$l_SMonth.$l_SDate;
          
          // Get project Expiry date.......................
          $l_EYear=$_POST['EYear'];
          $l_EMonth=$_POST['EMonth'];
          $l_EDate=$_POST['EDate'];
          $l_PR_ExpiryDate =$l_EYear.$l_EMonth.$l_EDate;
          
          $l_AL_sel_id_arr = $_POST['l_AL_sel'];       //original list of documents
          
          $l_size_AL_sel_id_arr = count($l_AL_sel_id_arr);
          $l_file_extention_numb=$l_file_extention_numb+1;
          @$l_in_TemplateName  = $_FILES['l_file_Template']['tmp_name']; //all temp files created
          @$l_in_TemplateFinalName = $_FILES['l_file_Template']['name']; //all actual file name
          
          
          @$l_in_Template_Size    =$_FILES['l_file_Template']['size'];    //new template modification line
          @$l_in_Template_Type    =$_FILES['l_file_Template']['type'];    ///new template modification line
          // code for submiting Synopsis pdf files in database 26 April 2016
          @$file_name=basename($_FILES['file']['name']);   //new synopsis modification line
          $extension = pathinfo($file_name, PATHINFO_EXTENSION);
          $rename =  $l_PR_id.'_'.$l_file_extention_numb;
          $file_Modified_Name= $rename.'.'.$extension;
          
          @$file_size=$_FILES['file']['size'];   //new  modification line
          @$file_type=$_FILES['file']['type'];   //new  modification line
          @$file_path=$_FILES['file']['tmp_name'];  //new  modification line

           @$ExtraDoc_Size=$_FILES['datafile']['size'];   //new  modification line
          @$ExtraDoc_Type=$_FILES['datafile']['type'];   //new  modification line
          @$ExtraDoc_Path=$_FILES['datafile']['tmp_name'];
          if(!empty(trim($_POST['datafile_name']))){
          $ExtraDoc_Name=$_POST['datafile_name'];
          } else{
          $ExtraDoc_Name="Data Sheet";
          }

          $l_AL_sel_id_arr_uni_temp=array_unique($l_AL_sel_id_arr);  //unique list of documents with corresponding index
          
          if(($key = array_search("NULL", $l_AL_sel_id_arr_uni_temp)) !== false)
          {
            unset($l_AL_sel_id_arr_uni_temp[$key]);
          }
          
          $index=0;
          for($i=0;$i<$l_size_AL_sel_id_arr;$i++)
          {
          if(array_key_exists($i,$l_AL_sel_id_arr_uni_temp))
          {
          $l_AL_file_arr_uni[$index] = $l_in_TemplateName[$i];
          $l_in_TemplateFinalName_uni[$index] = $l_in_TemplateFinalName[$i];  //new template modification line
          $l_in_TemplateFinalSize_uni[$index] = $l_in_Template_Size[$i];   //new template modification line
          $l_in_TemplateFinalType_uni[$index] = $l_in_Template_Type[$i];    //new template modification line
          
          $index++;
          }
          }
          
          $l_AL_sel_id_arr_uni = array_values($l_AL_sel_id_arr_uni_temp) ;   //unique list of temp path documents with correct index
          
          $l_SizeAL_sel_id_arr_uni = count($l_AL_sel_id_arr_uni);
          // template coding ends......
          
         if(count($l_AL_sel_id_arr_uni)==1 && $l_AL_sel_id_arr_uni[0]=="Null")
          {
          $_SESSION['msg']= '<div class="alert alert-danger">Please add some document type</div>';
          }
          else if(!in_array($l_SD_prf, $l_SD_sel_id_arr)){
          $_SESSION['msg']= '<div class="alert alert-danger">Please Check The Preference of Technology. The Preference should be given to the corresponding checked technology </div>';
          }
          else
          {
          
          $filename  = basename($_FILES['file']['name']);
          $extension = pathinfo($filename, PATHINFO_EXTENSION);
          
          $not_allowed = array('php','php5','exe','css','php','c','cpp','java','pl','htm','js','css','xml','jsp','ser','jsf','jse','bat','cmd','jad','json','aspx','lib','pdb','dbg','php3','pmp','pm','bml','p','j','hta','com','lnk','pif','scr','vb','vbs','wsh','html');
          
          $allowed="pdf";
          
          // NDA file code starts
          if($l_Z_NDA== "N")  // checking if User wants to upload its own NDA.
          {
          
          $l_NDA_FileName  = $_FILES['NDAfile']['tmp_name']; //all temp files created
          $l_NDA_FinalName = $_FILES['NDAfile']['name']; //all actual file name
          
          $filename_NDA  = basename($_FILES['NDAfile']['name']);
          $extension = pathinfo($filename_NDA, PATHINFO_EXTENSION);
          
          $rename =  "NDA_".$l_PR_id;
          $l_PR_NDA   = $rename.'.'.$extension;
          
          $tempfolderNDA= 'Projectory/ProjectNDA'; // for linux
          move_uploaded_file( $l_NDA_FileName,$tempfolderNDA.'/'.$l_PR_NDA);
          
          $l_Z_NDA_URL=$l_filehomepath."/Projectory/ProjectNDA/".$l_PR_NDA;
          
          }
          else if($l_Z_NDA== "Y")   // Go with Zaire NDA
          {
          $l_Z_NDA_URL="Y";
          }
          else
          {
          $l_Z_NDA_URL="NA";   // NDA Not applicable
          }
          
          // NDA file code ends
          if(empty($_FILES["file"]["name"]))
          {
          $_SESSION['msg']= '<div class="alert alert-danger">Please choose file for Project synopsis.</div>';
          }
          else if($extension != $allowed)
          {
          $_SESSION['msg']= '<div class="alert alert-danger">Please change your file to Pdf and try uploading again</div>';
          
          }
          
          else
          {
         
          if (empty( $_FILES["file"]["name"]))
          {
          $_FILES["file"]["name"] . "<font color=red> Please choose file for projects synopsis. </font>";
          }
          else
          {
         
          $l_sql_validate = 'select PR_id from Projects where PR_id ='.$l_PR_id.' and Org_id="'.$_SESSION['g_Org_id'].'"';
          $l_result_validate = mysql_query($l_sql_validate);
          $l_count_validate = mysql_num_rows($l_result_validate);
          
          
          // Insert new project if project-ID not exist already.....
          if ( $l_count_validate == 0 )
          {
          
         
           $l_query = "insert into Projects  (PR_id, PR_Name,PR_Desc,PR_Short_Desc,PR_Objective,PR_Background,PR_Functional_Requirement,PR_Non_Functional_Requirement,PR_System_Requirements, PR_ReleaseDate , PR_ExpiryDate, PR_SynopsisURL,UR_Owner,PR_InsertDateTime,PR_Duration,PR_ComplexityLevel,PR_ip,MO_id,PR_Synopsis_Original_Name,Org_id,PR_No_Students,IN_id,PR_Prerequisites,PR_AllowedSynopsis,PR_MentorAllowed) values (".$l_PR_id.", \"".$l_PR_Name."\",\"".htmlspecialchars($l_PR_Desc)."\",\"".htmlspecialchars($l_PR_Short_Desc)."\", \"".htmlspecialchars($l_PR_Objective)."\",\"".htmlspecialchars($l_PR_Background)."\",\"".htmlspecialchars($l_PR_Functional_req)."\",\"".htmlspecialchars($l_Non_PR_Functional_req)."\",\"".htmlspecialchars($l_PR_System_Req)."\",".$l_PR_ReleaseDate.",".$l_PR_ExpiryDate.", \"".$l_PR_Synopsis_URL."\", \"".$l_UR_id."\",".$l_PR_InsertDateTime.",".$l_PR_Duration.",".$l_PR_level.",\"".$l_Z_NDA_URL."\",".$l_PR_model.",\"".$l_synopsis_original_name."\",\"".$_SESSION['g_Org_id']."\",\"".$l_PR_No_Students."\",".$l_PR_Industry.",\"".$l_PR_Prerequisite."\",\"".$allowed_synopsis."\",\"".$allowed_mentors."\")";
          $result = mysql_query($l_query);
          /*------   -----*/
          $l_insert_solution = "insert into Project_Solution (PR_id,SO_id) values (".$l_PR_id.",".$l_PR_Solution.")";
          mysql_query($l_insert_solution) or die(mysql_error);

          $data=addslashes(file_get_contents($file_path));
          $ExtraDoc=file_get_contents($ExtraDoc_Path);
          mysql_query("INSERT INTO Project_Synopsis (PR_id,PR_Synopsis_Data,PR_Synopsis_Original_Name,PR_Synopsis_Size,PR_Synopsis_Type,Org_id,PR_Synopsis_Name,PR_ExtraDoc,PR_ExtraDoc_Name,PR_ExtraDoc_Size,PR_ExtraDoc_Type) values(".$l_PR_id.",'".mysql_real_escape_string( $data)."','".$file_name."','".$file_size."','".$file_type."','".$_SESSION['g_Org_id']."','".$file_Modified_Name."','".mysql_real_escape_string($ExtraDoc)."','".$ExtraDoc_Name."','".$ExtraDoc_Size."','".$ExtraDoc_Type."')");

          
          
          if($result)
          {
          $_SESSION['msg'] ='<div class="alert alert-success"><strong>'.$l_PR_Name.'</strong> Project added successfully !!</div>';

                unset($_SESSION['l_PR_Name_fill']);
                unset($_SESSION['l_PR_Short_Desc_fill']);
                unset($_SESSION['l_PR_Desc_fill']);
                unset($_SESSION['l_PR_Objective_fill']);
                unset( $_SESSION['l_PR_Background_fill']);
                unset($_SESSION['l_PR_Functional_req_fill']);
                unset( $_SESSION['l_Non_PR_Functional_req_fill']);
                unset( $_SESSION['l_PR_System_Req_fill']);
                unset( $_SESSION['l_PR_Prerequisite']);
          }
          
          }/// if ( $l_row_validate[0] == 0 )
          else
          {
          $l_alert_statement =  ' <script type="text/javascript">
          var x=window.alert("Sorry! The Id is already existing - must have been added earlier. Please change the Id and try again")
          </script> ';
          
          print($l_alert_statement );
          
          }
          
          mysql_free_result($l_result_validate);
          
          //////////////////////checkbox for sub domains ////////////////////
          
          $l_size_SD_sel_id_arr = count(  $l_SD_sel_id_arr);
          $l_SD_id_arr_index =0;
          
          while ($l_SD_id_arr_index < $l_size_SD_sel_id_arr)
          {
          if($l_SD_prf == $l_SD_sel_id_arr[$l_SD_id_arr_index]){
          $l_query = "insert into Project_SubDomains  (PR_id, SD_id,Org_id,SD_Preference) values (".$l_PR_id . ",".$l_SD_sel_id_arr[$l_SD_id_arr_index].",'".$_SESSION['g_Org_id']."','R')";
          }else{
          $l_query = "insert into Project_SubDomains  (PR_id, SD_id,Org_id,SD_Preference) values (".$l_PR_id . ",".$l_SD_sel_id_arr[$l_SD_id_arr_index].",'".$_SESSION['g_Org_id']."','N')";
          }
          $l_mysql_query = mysql_query($l_query);    // run the actual SQL
          
          $l_SD_id_arr_index = $l_SD_id_arr_index + 1;
          
          }
          //print_r($l_SD_sel_id_arr[$l_SD_id_arr_index]);
          
          ////////////////////////checkbox for sub domains ////////////////////
          
          $l_PG_sel_id_arr = $_POST['l_PG_sel'];
          $l_size_PG_sel_id_arr = count(  $l_PG_sel_id_arr);
          $l_PG_id_arr_index =0;
          
          while ($l_PG_id_arr_index < $l_size_PG_sel_id_arr)
          {
          $l_insert_sql = "insert into PG_Projects (PG_id, PR_id,Org_id) values (" .$l_PG_sel_id_arr[$l_PG_id_arr_index] .", ".$l_PR_id .",'".$_SESSION['g_Org_id']."')";
          mysql_query($l_insert_sql);    // run the actual SQL
          
          $l_PG_id_arr_index = $l_PG_id_arr_index + 1;
          
          }
          //for max PS_id
          $l_sql    = 'select max(PS_id) from ProjectDocument_Sequence ';
          $l_result = mysql_query($l_sql);
          $l_data   = mysql_fetch_row($l_result);
          $l_PS_id= $l_data[0];
          
          if($l_PS_id==NULL)
          {
          $l_PS_id=1;
          }
          else
          {
          $l_PS_id=$l_PS_id+1;
          }
          
          // Get DateTime
          $timezone = new DateTimeZone("Asia/Kolkata" );
          $date = new DateTime();
          $date->setTimezone($timezone );
          $l_AL_DateTime = $date->format( 'YmdHi' );
          
          
          $l_AL_id_arr_index =0;
          $l_fileTeamplate_arr_index=0;
          $l_PS_Seq_No=1;
          
          while ($l_AL_id_arr_index < $l_SizeAL_sel_id_arr_uni)
          {
          if(!empty($l_AL_file_arr_uni[$l_fileTeamplate_arr_index]))  // added lines from here
          
          {
          
          $filename  = $l_in_TemplateFinalName_uni[$l_fileTeamplate_arr_index];  // new modification  start
          $filesize  = $l_in_TemplateFinalSize_uni[$l_fileTeamplate_arr_index];
          $filetype  = $l_in_TemplateFinalType_uni[$l_fileTeamplate_arr_index];
          // new modification ends
          
          
          $extension = pathinfo($filename, PATHINFO_EXTENSION);
          $rename =  $l_PR_id.'_'.$l_AL_sel_id_arr_uni[$l_AL_id_arr_index];
          $l_Template_Name = $rename.'.'.$extension;
          
          
          //$tempTemplatefolder = 'Projectory/ProjectTemplates'; // for linux
          // move_uploaded_file($l_AL_file_arr_uni[$l_fileTeamplate_arr_index],$tempTemplatefolder.'/'.$l_Template_Name);
          //$l_Template_URL=$l_filehomepath."/Projectory/ProjectTemplates/".$l_Template_Name ;
          
          // code for uploading BLOB template pdf files to datdabase ...........26 April 2016
          $Templatedata=$l_AL_file_arr_uni[$l_fileTeamplate_arr_index];
          
          //code ends.........................
          }
          else
          {
          $Templatedata= "NULL";
          $filename    = "NULL";
          $filesize    = "NULL";
          $filetype    = "NULL";
          }
          
          
          //$l_insert_sql = "insert into ProjectDocument_Sequence (AL_id,PS_id, PR_id,PS_Seq_No,PS_InsertDate,PS_DocTemplate,Org_id) values (" .$l_AL_sel_id_arr_uni[$l_AL_id_arr_index] .",".$l_PS_id .",".$l_PR_id.",".$l_PS_Seq_No.",".$l_AL_DateTime.",\"".$l_Template_URL."\",\"".$_SESSION['g_Org_id']."\")";
          $l_insert_sql = "insert into ProjectDocument_Sequence (AL_id,PS_id, PR_id,PS_Seq_No,PS_InsertDate,PS_DocTemplate,PS_Doc_Original_Name,PS_Doc_Size,PS_Doc_Type,Org_id,PS_Doc_Name) values (" .$l_AL_sel_id_arr_uni[$l_AL_id_arr_index] .",".$l_PS_id .",".$l_PR_id.",".$l_PS_Seq_No.",".$l_AL_DateTime.",\"".$Templatedata."\",\"".$filename."\",\"".$filesize."\",\"".$filetype."\",\"".$_SESSION['g_Org_id']."\",\"".$l_Template_Name."\")";
          mysql_query($l_insert_sql);    // run the actual SQL
          $l_PS_Seq_No= $l_PS_Seq_No + 1;
          $l_PS_id=     $l_PS_id+1;
          
          $l_AL_id_arr_index = $l_AL_id_arr_index + 1;
          $l_fileTeamplate_arr_index=$l_fileTeamplate_arr_index+1;
          
          
          }
          }
          
          }
          
          }
 
          echo "<script>window.location.href='AddProject.php'</script>";
          }
          
          //HTML form
          
          ?>
<?php
    echo $_SESSION['msg'];
    // $_SESSION['msg']="";
    
    ?>
<div class="panel panel-primary">
<div class="panel-heading" >
<h4 style="    text-align: center;
font-size: 23px;
padding: 0px;
margin: 2px 0px;
font-family: monospace;">
Add Your Project
</h4>
</div>
<div style=align:center; class="panel-body table-responsive table">

<form  method = "POST" action = "" enctype="multipart/form-data">
<br>
<table style="width:100%;" class="ady-table-content "

<tr>
<td>Project Name <a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Name of the project to be shown to the student">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><span id="errprname"></span></td>
<td colspan=3>
<input id="prname" class="form-control ady-form" value="<?php echo $_SESSION['l_PR_Name_fill']?>" type=text name=l_PR_Name>
</td>
</tr>

<tr>
<td >
Project Short Description<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a short description which will be shown to the student before he applies for it.">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><span id="errprshortdisc"></span></td>
<td colspan=3>
<textarea  class=" form-control ady-form"  name="l_PR_Short_Desc" ><?php echo $_SESSION['l_PR_Short_Desc_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace('l_PR_Short_Desc', {
    on: {

        key: function() {
        $('#errprshortdisc').text('');
        }
    }
}
);
CKEDITOR.add

</script>
</td>
</tr>
<tr>
<td >
Project Description<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a description of a project which will be shown to the student after he applies for it.">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a> <span id="errprdiscrip"></span></td>
<td colspan=3>
<textarea  class=" form-control ady-form"  name="l_PR_Desc" ><?php echo $_SESSION['l_PR_Desc_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace('l_PR_Desc', {
    on: {

        key: function() {
        $('#errprdiscrip').text('');
        }
    }
});
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td > Project Objective<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="What is the objective of the project for the student to achieve?">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a>  <span id="errprobjective"></span></td>
<td colspan=3>
<textarea  class="ady-text-area form-control ady-form"  name="l_PR_Objective" ><?php echo $_SESSION['l_PR_Objective_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace('l_PR_Objective', {
    on: {

        key: function() {
        $('#errprobjective').text('');
        }
    }
});
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td > Project Background<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="A brief background on how the project idea was initiated">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
<td colspan=3>
<textarea class="ady-text-area form-control ady-form"  name="l_PR_Background" ><?php echo $_SESSION['l_PR_Background_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace( 'l_PR_Background' );
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td > Functional Requirement<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content=" This is the functional requirements that will help allow the students to refer for him to finish the project.">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a> <span id="errprfunctionreq"></span></td>
<td colspan=3>
<textarea  class="ady-text-area form-control ady-form"  name="l_PR_Functional_req" ><?php echo $_SESSION['l_PR_Functional_req_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace( 'l_PR_Functional_req' , {
    on: {

        key: function() {
        $('#errprfunctionreq').text('');
        }
    }
});
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td >Non Functional Requirement<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content=" This is the Non-functional requirements that will help allow the students to refer for him to finish the project.">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a> <span id="errprnonfunctionreq"></span></td>
<td colspan=3>
<textarea  class="ady-text-area form-control ady-form" name="l_PR_N_req"><?php echo $_SESSION['l_Non_PR_Functional_req_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace('l_PR_N_req', {
    on: {

        key: function() {
        $('#errprnonfunctionreq').text('');
        }
    }
});
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td >System Requirements<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Are there any specific system requirements or softwares needed for the student to perform this project?">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
<td colspan=3>
<textarea class="ady-text-area form-control ady-form"  name="l_PR_System_req"><?php echo $_SESSION['l_PR_System_Req_fill'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace( 'l_PR_System_req' );
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td >Skills  Required<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Are there any pre-requisites or prior skills knowledge needed for the students to perform this project">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
<td colspan=3>
<textarea class="ady-text-area form-control ady-form"  name="l_PR_Prerequisite"><?php echo $_SESSION['l_PR_Prerequisite'] ?></textarea>
<script type="text/javascript">
CKEDITOR.replace( 'l_PR_Prerequisite' );
CKEDITOR.add
</script>
</td>
</tr>
<tr>
<td>Maximum No of Students<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="How many number of students can perform this project per team?">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
<td> <select class="form-control" name=l_PR_No_Students >

<?php for($i=1; $i<8; $i++){ ?>
<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
<?php  } ?>
</select>

</tr>

<!-- Level-->
<tr>
<td>Complexity Level<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="How complex is the project for an average student to perform this project?">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
<td> <select class="form-control" name=l_PR_level value="">

<?php
    
    for($lev=1;$lev<=10;$lev++)
    
    {
        print('<option value='.$lev.'>Level '.$lev.'</option>');
    }
    print('</select></td></tr>');
    
    /*level End*/
    ?>
    <tr>
    	<td>Project Duration<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="How long will an average team of 3 students will take to finish this project?">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td><td>
       		 <select class="form-control" name="l_PR_Duration1" value="">
	       		 <?php for($pr=1;$pr<=12;$pr++){?>
		            <option value="<?php echo $pr;?>" ><?php echo $pr;?></option>
		         <?php }?>  
	          </select>
    	</td>
      <td colspan=2>
          <select class="form-control" name=l_PR_Duration2 value="">
          <option value="Weeks" >Weeks</option>
          <option value="Months" >Months</option>
          </select>
      </td>
    </tr>
          <?php
          /*Project will be visible from specified start date  */
          print('<tr><td>Project Start Date<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This indicates from what time the project will be shown in projectory to the students.

">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
                <td>Month<select id="SMonth" class="form-control" name=SMonth value="">Select Month</option>
                <option value=01>January</option>
                <option value=02>February</option>
                <option value=03>March</option>
                <option value=04>April</option>
                <option value=05>May</option>
                <option value=06>June</option>
                <option value=07>July</option>
                <option value=08>August</option>
                <option value=09>September</option>
                <option value=10>October</option>
                <option value=11>November</option>
                <option value=12>December</option>
                </select></td>
                
                <td>Date<select id="SDate" class="form-control" name=SDate >
                <option value=01>01</option>
                <option value=02>02</option>
                <option value=03>03</option>
                <option value=04>04</option>
                <option value=05>05</option>
                <option value=06>06</option>
                <option value=07>07</option>
                <option value=08>08</option>
                <option value=09>09</option>
                <option value=10>10</option>
                <option value=11>11</option>
                <option value=12>12</option>
                <option value=13>13</option>
                <option value=14>14</option>
                <option value=15>15</option>
                <option value=16>16</option>
                <option value=17>17</option>
                <option value=18>18</option>
                <option value=19>19</option>
                <option value=20>20</option>
                <option value=21>21</option>
                <option value=22>22</option>
                <option value=23>23</option>
                <option value=24>24</option>
                <option value=25>25</option>
                <option value=26>26</option>
                <option value=27>27</option>
                <option value=28>28</option>
                <option value=29>29</option>
                <option value=30>30</option>
                <option value=31>31</option>
                </select></td>');
                
                print('<td>Year<select id="SYear" class="form-control" name="SYear">');
                for($i =date('Y'); $i< 2025; $i++)
                {
                print('<option>'.$i.'</option>');
                
                }
                print('</select>');
                print('</td></tr>');
                
                /*Project will not be visible after this date  */
                print('<tr><td>Project ExpiryDate<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This indicates till what time the project will be shown in projectors to the students.
">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><span id="errdate" style="font-size: 12px; color:red;"></span></td>
                      <td>Month<select class="form-control "  id="EMonth" name=EMonth value="">Select Month</option>
                      <option value=01>January</option>
                      <option value=02>February</option>
                      <option value=03>March</option>
                      <option value=04>April</option>
                      <option value=05>May</option>
                      <option value=06>June</option>
                      <option value=07>July</option>
                      <option value=08>August</option>
                      <option value=09>September</option>
                      <option value=10>October</option>
                      <option value=11>November</option>
                      <option value=12>December</option>
                      </select></td>
                      
                      <td>Date<select class="form-control" id="EDate" name=EDate >
                      <option value=01>01</option>
                      <option value=02>02</option>
                      <option value=03>03</option>
                      <option value=04>04</option>
                      <option value=05>05</option>
                      <option value=06>06</option>
                      <option value=07>07</option>
                      <option value=08>08</option>
                      <option value=09>09</option>
                      <option value=10>10</option>
                      <option value=11>11</option>
                      <option value=12>12</option>
                      <option value=13>13</option>
                      <option value=14>14</option>
                      <option value=15>15</option>
                      <option value=16>16</option>
                      <option value=17>17</option>
                      <option value=18>18</option>
                      <option value=19>19</option>
                      <option value=20>20</option>
                      <option value=21>21</option>
                      <option value=22>22</option>
                      <option value=23>23</option>
                      <option value=24>24</option>
                      <option value=25>25</option>
                      <option value=26>26</option>
                      <option value=27>27</option>
                      <option value=28>28</option>
                      <option value=29>29</option>
                      <option value=30>30</option>
                      <option value=31>31</option>
                      </select> </td>');
                      
                      print('<td>Year<select class="form-control" id="EYear" name="EYear">');
                      for($i =date('Y'); $i<2025; $i++)
                      {
                      print('<option>'.$i.'</option>');
                      }
                      print('</select>');
                      print('</td></tr></table>');
                      /*Project Synopsis*/
                      print('<br>');
                      print('<table class="ady-table-content" style="width:100%;"><tr style="background-color:rgba(11, 14, 95, 0.22);"><td>Attach Project Synopsis :<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This is a document form of the information provided above in pdf format.
">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><font color=red>*<span id="errsynopsis"></span></font></td><td><input  id="attachsynopsis" type="file" name="file" id="file"></td></tr></table>');
                      
                      print('<br>');
                      print('<table class="ady-table-content" style="width:100%;"><tr style="    background-color:rgba(11, 14, 95, 0.22);"><td style="width:35%">Allow Synopsis View as Pdf:<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content=" This indicates whether to allow the student to view it in the pdf format or allow only HTML format view of the synopsis as provided above.
">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><font color=red>*</font></td><td><input  type="radio" name="allowed_synopsis" id="allowed_synopsis" value="Y"> Yes&nbsp&nbsp&nbsp&nbsp&nbsp<input  type="radio" name="allowed_synopsis" checked id="allowed_synopsis" value="N">  No</td></tr></table>');
                      print('<br>');
                     
                      print('<table class="ady-table-content" style="width:100%;"><tr style="    background-color:rgba(11, 14, 95, 0.22);"><td style="width:35%">Allow Only Company Mentors<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This indicates whether to allow only your company mentors or allow any mentor of any company to mentor this project.
">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a><font color=red>*</font></td><td><input  type="radio" name="allowed_mentors" id="allowed_mentors" value="Y"> Yes&nbsp&nbsp&nbsp&nbsp&nbsp<input  type="radio" name="allowed_mentors" checked id="allowed_mentors" value="N">  No</td></tr></table>');
                      print('<br>');
                      ?>
                       <table class="ady-table-content" style="width:100%;">
                         <tr style="    background-color:rgba(11, 14, 95, 0.22);">
                         	<td>Attach Extra document<a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="This allows you to add another supplement documents for the students to view after they have signed up for it.
">
  
  
  <span class="glyphicon glyphicon-info-sign" ></span></a></td>
                         	<td> Name of Document:<input  type="text" name="datafile_name" id="datafile_name"></td>
                         	<td><input  type="file" name="datafile" id="datafile"></td>
                         </tr>
                       </table>
                      
                      <?php
                      $l_SO_sql = 'select SO_id, SO_Name from Solution ';
                      $l_SO_result = mysql_query($l_SO_sql);
                      
                      print('<br>');
                      print('<table class="ady-table-content" style="width:100%;"><tr style="background-color:rgba(11, 14, 95, 0.22);"><td>Solution <a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Please enter one of the Solution which is applicable to the project.
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a>:<font color=red>*<span id="errsolution"></span></font></td><td><select id="selectsolution" class="form-control" name="l_solution"><option value="NULL">Select...</option>');

                      while($l_SO_row = mysql_fetch_row($l_SO_result))
                      {
                            $l_SO_id  =  $l_SO_row[0];
                            $l_SO_Name = $l_SO_row[1];
                            print('<option value='.$l_SO_id.'>'.$l_SO_Name.'</option>');

                      }
                      print('</select></td></tr></table>');
                      print('<br>');

                      
                      
                      $l_IN_sql = 'select IN_id, IN_Name from Industry ';
                      $l_IN_result = mysql_query($l_IN_sql);
                      
                     
                      print('<table class="ady-table-content" style="width:100%;"><tr style="background-color:rgba(11, 14, 95, 0.22);"><td>Industry <a  title="" data-toggle="popover" data-trigger="hover" data-html="true" data-content="Please enter one of the Industry which is applicable to the project.
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a>:<font color=red>*<span id="errindustry"></span></font></td><td><select id="industry" class="form-control" name="l_industry"><option value="NULL">Select...</option>');
                      
                      while($l_IN_row = mysql_fetch_row($l_IN_result))
                      {
                      $l_IN_id  =  $l_IN_row[0];
                      $l_IN_Name = $l_IN_row[1];
                      print('<option value='.$l_IN_id.'>'.$l_IN_Name.'</option>');
                      
                      }
                      print('</select></td></tr></table>');
                     $l_AL_sql = 'select AL_id, AL_Desc from Access_Level WHERE AL_Type = "PV" order by AL_id asc';
                      $l_AL_result = mysql_query($l_AL_sql);
                      $l_AL_count = mysql_num_rows($l_AL_result);
                      
                      $l_AL_array= array();
                      
                      $row = 0;
                      while($l_AL_row = mysql_fetch_row($l_AL_result))
                      {
                      $l_AL_array[$row]=array($l_AL_row[0], $l_AL_row[1]);
                      $row++;
                      }
                      
                      /* Preference of documents to be submitted by students during the project */
                      print('<table class="ady-table-content" style="width:100%;">
                      
                      
                      <tr style="font-weight:bold"><th  colspan=2>Project Process Documents<a  style="color: hsl(180, 100%, 99%);" title="Please add the types of documents the student should deliver
" data-toggle="popover" data-trigger="hover" data-html="true" data-content="
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a></th></tr>
                      <tr><td>
                            
                            Your First Document</td>
                            <td><select id="firstdoc" class="form-control" name="l_AL_sel[]">
                            <option value="NULL">Select...</option>');
                            
                            //$l_AL_array[0][1]=Design;
                            //$l_AL_array[1][1]=Code;
                            
                            foreach ($l_AL_array as $row)
                            {
                            print('<option value="'.$row[0].'">'.$row[1].'</option>');
                            }
                            
                            print('</select><input   type="file" name="l_file_Template[]" multiple="multiple"></td></tr>'); // choose First doc templeate
                            
                            print('<tr><td>
                                  Your Second Document</td>
                                  <td><select id="seconddoc" class="form-control" name="l_AL_sel[]">
                                  <option value="NULL">Select...</option>');
                                  foreach ($l_AL_array as $row)
                                  {
                                  print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                  }
                                  print('</select><input  type="file" name="l_file_Template[]" multiple="multiple"></td></tr></td></tr>');  // choose Second doc templeate
                                  
                                  
                                  print('<tr><td>
                                        Your Third Document</td>
                                        <td><select id="thirddoc" class="form-control" name="l_AL_sel[]">
                                        <option value="NULL">Select...</option>');
                                        
                                        foreach ($l_AL_array as $row)
                                        {
                                        print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                        }
                                        
                                        print('</select><input  type="file" name="l_file_Template[]" multiple="multiple"></td></tr>'); // choose Third doc templeate
                                        
                                        print('<tr><td>Your Fourth Document</td><td><select  id="fourthdoc" class="form-control" name="l_AL_sel[]"><option value="NULL">Select...</option>');
                                        
                                        foreach ($l_AL_array as $row)
                                        {
                                        print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                        }
                                        
                                        print('</select><input  type="file" name="l_file_Template[]" multiple="multiple"></td></tr>'); // choose Fourth doc templeate
                                        
                                        print('<tr><td>
                                              Your Fifth Document</td>
                                              <td><select class="form-control" name="l_AL_sel[]">
                                              <option value="NULL">Select...</option>');
                                              
                                              foreach ($l_AL_array as $row)
                                              {
                                              print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                              }
                                              print('</select><input  type="file" name="l_file_Template[]" multiple="multiple"></td></tr>'); // choose Fifth doc templeate
                                              
                                              print('<tr><td>
                                                    Your Sixth Document</td>
                                                    <td><select class="form-control" name="l_AL_sel[]">
                                                    <option value="NULL">Select...</option>');
                                                    
                                                    foreach ($l_AL_array as $row)
                                                    {
                                                    print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                                    }
                                                    print('</select><input  type="file" name="l_file_Template[]" multiple="multiple"></td></tr>'); // choose Sixth doc templeate
                                                    
                                                    print('<tr><td>
                                                          Your Seventh Document</td>
                                                          <td><select class="form-control" name="l_AL_sel[]">
                                                          <option value="NULL">Select...</option>');
                                                          
                                                          foreach ($l_AL_array as $row)
                                                          {
                                                          print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                                          }
                                                          
                                                          print('</select><input  type="file" name="l_file_Template[]" multiple=""></td></tr>'); // choose Seventh doc templeate
                                                          
                                                          print('<tr><td>
                                                                Your Eighth Document</td>
                                                                <td><select class="form-control" name="l_AL_sel[]">
                                                                <option value="NULL">Select...</option>');
                                                                
                                                                foreach ($l_AL_array as $row)
                                                                {
                                                                print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                                                }
                                                                
                                                                print('</select><input  type="file" name="l_file_Template[]" multiple=""></td></tr>'); // choose Eighth doc templeate
                                                                
                                                                print('<tr><td>
                                                                      Your Ninth Document</td>
                                                                      <td><select class="form-control" name="l_AL_sel[]">
                                                                      <option value="NULL">Select...</option>');
                                                                      
                                                                      foreach ($l_AL_array as $row)
                                                                      {
                                                                      print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                                                      }
                                                                      print('</select><input  type="file" name="l_file_Template[]" multiple=""></td></tr>'); // ninth doc tenplate
                                                                      
                                                                      print('<tr><td>
                                                                            Your Tenth Document</td>
                                                                            <td><select class="form-control" name="l_AL_sel[]">
                                                                            <option value="NULL">Select...</option>');
                                                                            
                                                                            foreach ($l_AL_array as $row)
                                                                            {
                                                                            print('<option value="'.$row[0].'">'.$row[1].'</option>');
                                                                            }
                                                                            print('</select><input type="file" name="l_file_Template[]" multiple=""></td></tr>'); // ten doc template
                                                                            
                                                                            print('</table><br>');
                                                                            print('<table style="width:100%;" class="ady-table-content">');
                                                                            print('<tr><th style="font-weight:bold" colspan=2>Select Streams to which the project is targeted<a  style="color: hsl(180, 100%, 99%);" title="Please select the target streams you would like this project to be performed by.
" data-toggle="popover" data-trigger="hover" data-html="true" data-content="
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a> </th></tr>');
                                                                            
                                                                            
                                                                            /*Select and Display All Branches Names*/

                                                                            $l_select_sql = 'select PG_id , PG_Name  from Programs where Org_id = "ALL"';

                                                                            $l_result_sql = mysql_query($l_select_sql);
                                                                            
                                                                            while($l_row = mysql_fetch_row($l_result_sql))
                                                                            {
                                                                            print ('<tr>');
                                                                            $l_PG_id       = $l_row[0];
                                                                            $l_PG_Name= $l_row[1];
                                                                            
                                                                            print( '<td>'.$l_PG_Name.'</td>');
                                                                            
                                                                            print('<td>');
                                                                            print('<center><input  type="checkbox" class="checkbox-inline" value="'.$l_PG_id.'" name="l_PG_sel[]"></center></td>');
                                                                            
                                                                            print('</tr>');
                                                                            }
                                                                            mysql_free_result($l_result_sql);
                                                                            print('</table><br>');
                                                            
                                                                           
                                                                           
                                                                           
                                                                           /* Select and Display All Technologies Name that can be use while performing project */
    $l_select_sql = 'SELECT DO.DO_Name,DO.DO_id FROM Domain as DO';
    $l_result_sql = mysql_query($l_select_sql);
    ?>
   <div class="row primary" style="  background-color: #337ab7; padding: 10px; margin: 0px; color: white; ">
                        <div class="col-md-4">
                            Domains
                                </div>
                        <div class="col-md-4">
                            Select Technologies used for the Project<a  style="color: hsl(180, 100%, 99%);" title="Please select the technologies the students should use to perform this project. For instance, the technologies to be used for a PHP project could be - PHP, HTML, CSS, etc.
" data-toggle="popover" data-trigger="hover" data-html="true" data-content="
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a>
                                </div>
                        <div class="col-md-4">
                            Most Prefered Technology<a  style="color: hsl(180, 100%, 99%);" title="Please select the one core technology from the list of the technologies which is required in the project. For instance, if it is a PHP project, the most preferred project is PHP. 
" data-toggle="popover" data-trigger="hover" data-html="true" data-content="
">
 
  <span class="glyphicon glyphicon-info-sign" ></span></a>
                                </div>
    </div>
   <p id="errprefertech" style="text-align:center"></p> 
 <div class="panel-group" style="margin-bottom: 0px;" id="accordion">            

                                            <?php
                                            while ($l_row = mysql_fetch_row($l_result_sql)) {


                                                print ('<tr>');
                                                ?> 
                                                    <div class="panel panel-info" style="margin-bottom: 1px;">
                                                       <a  data-toggle="collapse" data-parent="#accordion" href="#<?php echo $l_row[1]; ?>">
                                                           <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                
                                                <?php echo $l_row[0]; ?>
                                                            </h4>
                                                        </div></a>

                                                <?php
                                                $l_select_sql1 = 'SELECT SD.SD_id, SD.SD_Name FROM SubDomain as SD where SD.DO_id=' . $l_row[1];
                                                $l_result_sql1 = mysql_query($l_select_sql1);
                                                ?>
                                                        <div id="<?php echo $l_row[1]; ?>" class="panel-collapse collapse <?php if($l_row[1]==2){ echo "in" ;} ?>">
                                                            <div class="panel-body">
                                                <?php
                                                while ($l_row1 = mysql_fetch_row($l_result_sql1)) {
                                                    $l_SD_id = $l_row1[0];
                                                    $l_SD_Name = $l_row1[1];
                                                    ?> 


                                                                <div class="row"><div class="col-md-4"><label> <?php echo $l_SD_Name; ?>: </label>
                                </div>
                                <div class="col-md-4">
                               <input  type="checkbox" class="g_checkbox_select_DM checkbox" value="<?php echo $l_SD_id; ?>" name="l_SD_sel[]"> 
                              </div>
                                <div class="col-md-4">
                               <input  type="radio" class="g_checkbox_select_DM checkradio" value="<?php echo $l_SD_id; ?>" name="l_SD_prf">
 </div>
     </div>                                                             
                                                <?php } ?> </div>
                                                        </div>

                                                    </div> 

                                                <?php
                                                
                                            }
                                            ?>
                                            </div>                                                                      


<?php
///  Tearms and Conditions for NDA

print('<table style="width:100%;" class="ady-table-content">');
print('<tr><th colspan=2>NDA</th></tr>');

print('<tr><td style="text-align:left">Do You Want to Add NDA?</td><td style="width:13%;"><input class=" ady-form" type="checkbox" id="AcceptNda" onclick="ShowNdaRadio()"></td></tr>');

print('<tr id="Ndatr" style="display:none"><td>');
print('<input  type="Radio" onclick="myFunctionshow()" id="NdaR1" class="g_checkbox_select_DM" value="N" name="Z_NDA">Custom <a>NDA</a>');
print('<input class="form-control ady-form" type="file" name="NDAfile" id="thenda" style="display:none" /><span id="errnda"></span></td>');
print('<td><input type="Radio" class="" value="Y" id="NdaR2" onclick="myFunctionhide()" name="Z_NDA">Go with Zaireprojects <a>NDA</a>
                                      </td></tr>
                                      ');
mysql_free_result($l_result_sql);
print('</table>');
print('<table style="width:100%">');
print('<tr><td style ="text-align:center" colspan=2><br><input id="addproject" class=" ady-req-btn btn-primary" type="submit" name=SaveRec  accesskey=Alt-S value="Add Project" ></td></tr>');
print('</table>');

}
//print('</div></div></div></div>');
?>
</form>
 </div></div></div>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 
<script>
$(document).ready(function(){


$('.checkradio').on('click',function(){
 $('#checkpref').prop('checked', false);
  $('#checkpref').removeAttr( "id" );
 $(this).parent().parent().find('input[type=checkbox]').attr("id","checkpref")
 $(this).parent().parent().find('input[type=checkbox]').prop('checked', true);
$('#errprefertech').html("");
});

$('#thenda').on('change',function(){
var fileExtension = ['pdf'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        
                        this.value = ''; // Clean field
                       $("#thenda").css( "border-color","red" );     
                       $("#errnda").html( "<font color=red>Only PDF Allowed...</font>" );     
                         e.preventDefault();
                    }
                    else{
                    $('#thenda').css('border-color','green');
                     $("#errnda").html( "<font color=green>Valid file format.</font>" );
                    e.preventDefault();
                    }
                
});

$('#attachsynopsis').on('change', function() {
		$("#errsynopsis").hide().html("");
	});
	$('#selectsolution').on('change', function() {
		$("#errsolution").hide().html("");
	});
	$('#industry').on('change', function() {
		$("#errindustry").hide().html("");  
	});
	$('#prname').on("keyup",function() {
		$("#errprname").hide().html("");  
	}); 
 	
 
 	
 	$('#EYear,#EMonth,#EDate').on('change', function() {
		var Releasedate=$("#SYear").val()+$("#SMonth").val()+$("#SDate").val();
 		var Expirydate=$("#EYear").val()+$("#EMonth").val()+$("#EDate").val();
	   if(Expirydate > Releasedate){
		$("#errdate").hide().html(" [Expiry-Date should be greater than Start-Date.]");
     	  }   
	});
	$('#firstdoc').on('change', function() {
		$("#firstdoc").css('border-color','green');  
	});
	$('#seconddoc').on('change', function() {
		$("#seconddoc").css('border-color','green');  
	});
        $("form").submit( function(e) {
		var flag = true;
		
		var synopsis=$("#attachsynopsis").val();
		var solution=$("#selectsolution").val();
		var firstdoc=$("#firstdoc").val();
		var seconddoc=$("#seconddoc").val();
		
		var industry=$("#industry").val();
		var Expirydate=$("#EYear").val()+$("#EMonth").val()+$("#EDate").val();
		var Releasedate=$("#SYear").val()+$("#SMonth").val()+$("#SDate").val();
		
		var prname=$("#prname").val();
		var messageLength0 = CKEDITOR.instances['l_PR_Short_Desc'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength1 = CKEDITOR.instances['l_PR_Desc'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength2 = CKEDITOR.instances['l_PR_Objective'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength3 = CKEDITOR.instances['l_PR_Functional_req'].getData().replace(/<[^>]*>/gi, '').length;
		var messageLength4 = CKEDITOR.instances['l_PR_N_req'].getData().replace(/<[^>]*>/gi, '').length;
	    
	       var ndafile=$("#thenda").val();
	        if(ndafile!=""){
	$('#thenda').css('border-color','green');
	
	    }else{
	    $('#thenda').css('border-color','red');
	    }
	       
	    
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
                $("#errprobjective").show().html("Objective can't be empty].");
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
		$("#errdate").show().html(" [Expiry-Date should be greater than Start-Date.]");
		e.preventDefault();
	    } 
	    if(synopsis==""){
		flag = false;
		$("#errsynopsis").show().html("[Please Select Synopsis].");
		e.preventDefault();
	    }
	    if(solution=='NULL'){
		flag = false;
		$("#errsolution").show().html("[Please Select Solution.]");
		e.preventDefault();
	    }
	    if(industry=='NULL'){
		flag = false;
		$("#errindustry").show().html("[Please Select Industry.]");
		e.preventDefault();
	    }
	    if(firstdoc=='NULL'){
		flag = false;
		$("#firstdoc").css("border-color", "red");
		e.preventDefault();
	    }
	    if(seconddoc=='NULL'){
		flag = false;
		$("#seconddoc").css("border-color", "red");
		e.preventDefault();
	    }
	    if($('input[name=l_SD_prf]:checked').length<=0) {
		$('#errprefertech').html('<font color="red" >Please Select the Most Prefered Technology and check the corresponding boxes</font>');
	    }
	    if(myFunctionshow()==""){
		flag=false;
	    } else{
	    $('#thenda').css('border-color','green');
	    }
	    if(flag == true){
		return true;
	    } else{
	    	return false;
	    }  
       });
});
</script>
      
        
 <?php include('footer.php') ?>