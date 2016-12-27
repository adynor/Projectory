<html>
<head>
    <style>
 
.btn-file {
    position: relative;
    overflow: hidden;
}

.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}   
  </style>  
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>

<body>
    <br><br><br>
    <div class="container">
        
        <div class="row" >
            <div class="col-md-3"> </div>
    <div class="col-md-5">
<?php  

include('db_config.php');
include('header.php');
if(isset($_POST["submit"])) 
 {
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

            $l_in_filename = $_FILES['fileToUpload']['tmp_name'];    
           $filesize  = $_FILES['fileToUpload']['size'];
            $filetype  = $_FILES['fileToUpload']['type'];
            $filedata= addslashes(file_get_contents($l_in_filename));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
 $access_level=$_POST['Access_level'];



 if(empty($_FILES["fileToUpload"]["name"])) 
 {
   ?>
        <div class="alert alert-danger">
  <strong></strong> <?php echo " No file choosen"; ?>
</div>
   <?php   
  }
else  
if($imageFileType!="pdf" && $imageFileType!=".pdf")
{
    ?>
        <div class="alert alert-danger">
  <strong></strong> <?php echo "Please Change File Format to pdf"; ?>
</div>
   <?php 
}
else 
{
 $query= 'update Access_Level set AL_Template="'.$filedata.'" where AL_id='.$access_level.'';
    $QuerySuccess=mysql_query($query);
   if ($QuerySuccess)
{
   ?>
<div class="alert alert-success">
    <strong><span style="font-size: large;" class="glyphicon glyphicon-ok-circle"></span>&nbsp;Success!</strong> <?php echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."; ?>
</div>
 
<?php } 

}
}
?>
      
  <div class="panel panel-primary">
  <div class="panel-heading"><div class="alert alert-info"> Please Select the File only in Pdf format</div></div>
  <div class="panel-body"><form action="" method="post" enctype="multipart/form-data">
    
   <select class=" form-control " name="Access_level" >
   <?php 
   $query=mysql_query('select AL_id,AL_Desc from Access_Level'); 
   while($l_data=mysql_fetch_row($query)) 
       {
       ?>
       <option  value = "<?php echo $l_data[0] ?>" ><?php echo $l_data[1] ?></option>
       <?php 
       }
       ?>
       </select>
   
  <input class=" form-control btn btn-default btn-file " type="file" name="fileToUpload" id="fileToUpload"><br>
    <input class="form  form-control btn btn-primary" type="submit" value="Upload File" name="submit">
</form>
</div>
</div>



</div>

<div class="col-md-3"></div></body>
</html>