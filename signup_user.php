 <div id="user_add_fields">
<?php 
include ('db_config.php');
$l_UR_Type=$_POST['user_type'];
 $l_institutes= array();
if($l_UR_Type=='S'||$l_UR_Type=='G' ||$l_UR_Type=='A')
{    
$l_sql      ='SELECT IT_id, IT_Name FROM  Institutes ORDER BY IT_Name';
    $l_result =mysql_query($l_sql);
    while($l_row_results=mysql_fetch_row($l_result)){
        array_push($l_institutes,$l_row_results);
    }
}
$l_companys=array();
if($l_UR_Type=='M')
{    
$l_sql      ='Select UR.UR_id, UR.UR_FirstName,UR.UR_MiddleName,UR.UR_LastName from Users as UR where UR.UR_Type ="C" and UR.UR_RegistrationStatus="C"';
    $l_result =mysql_query($l_sql);
    while($l_row_results=mysql_fetch_row($l_result)){
        array_push($l_companys,$l_row_results);
    }
}
?>

<?php if($l_UR_Type=== 'S'){ ?>
<div class="control-group" id="user_add_fields">
    <label class="control-label" for="URN">University Registration Number <span style="color:red">*</span></label>
    <div class="controls">
        <input type="text" id="user_usn" name="user_urn" placeholder="Enter Your URN" class="form-control input-lg">
        <p class="help-block"></p>
    </div>
</div>
<div class="control-group" id="">
    <label class="control-label" for="User Semester">Semester<span style="color:red">*</span></label>
    <div class="controls">
        <a class="btn btn-success btn-select btn-select-light">
            <input type="hidden" class="btn-select-input" name="user_semester" value="" />
            <span class="btn-select-value">Select Your Semester</span>
            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
              <ul class="twitter_middle" style="overflow-y: auto;">
            <li   user-data-value="1">1</li>
            <li  user-data-value="2">2</li>
            <li  user-data-value="3">3</li> 
            <li   user-data-value="4">4</li>
            <li  user-data-value="5">5</li>
            <li  user-data-value="6">6</li>
            <li   user-data-value="7">7</li>
            <li  user-data-value="8">8</li>
            </ul>
        </a>
        <p class="help-block"></p>
    </div>
</div>
<div class="control-group" id="">
     <label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <input type="hidden"  id="user_it_id" name="user_it_id" value="" />
        <span class="btn-select-value">Select Your Institutes</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
        <ul class="twitter_middle" style="overflow-y: auto;">
            <?php foreach ($l_institutes as $l_institute  ){?>
                <li class="institute_change" id="institute_change_<?php echo $l_institute[0]; ?>" user-data-value="<?php echo $l_institute[0]; ?>">
                   <?php echo $l_institute[1] ?>
                </li>
            <?php } ?>   
        </ul>
    </a>
</div><!--
<div class="control-group">
<label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
<select name="user_it_id" class="form-control input-lg">
<?php foreach ($l_institutes as $l_institute  ){?>
                <option class="institute_change" value="<?php echo $l_institute[0]; ?>" user-data-value="<?php echo $l_institute[0]; ?>" >
                   <?php echo $l_institute[1] ?>
                </option>
            <?php } ?> 
</select>
</div>-->
<div class="control-group" id="user_program">
     <label class="control-label" for="program">Select Your Program<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <input type="hidden"  id="user_PGid" name="user_PGid" value="" />
        <span class="btn-select-value">Select Your Program...</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
       
    </a>
</div><!--
<div class="control-group">
<label class="control-label" for="Institutes">Select Your Program<span style="color:red">*</span></label>
<select name="user_PGid" class="form-control input-lg">

                <option>
                   Select Your Program.....
                </option>
            
</select>
</div>-->
<?php }?>
<?php if($l_UR_Type=== 'G'){ ?>
<div class="control-group" id="user_add_fields">
    <label class="control-label" for="GRN">Guide Registration Number<span style="color:red">*</span> </label>
    <div class="controls">
        <input type="text" id="user_usn" name="user_urn" placeholder="Enter Your URN" class="form-control input-lg">
        <p class="help-block"></p>
    </div>
</div>
<div class="control-group" id="">
     <label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <input type="hidden"  id="user_it_id" name="user_it_id" value="" />
        <span class="btn-select-value">Select Your Institutes</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
        <ul class="twitter_middle" style="overflow-y: auto;">
            <?php foreach ($l_institutes as $l_institute  ){?>
                <li class="institute_change"  user-data-value="<?php echo $l_institute[0]; ?>">
                   <?php echo $l_institute[1] ?>
                </li>
            <?php } ?>   
        </ul>
    </a>
</div><!--
<div class="control-group">
<label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
<select name="user_it_id" class="form-control input-lg">
<?php foreach ($l_institutes as $l_institute  ){?>
                <option class="institute_change" value="<?php echo $l_institute[0]; ?>" user-data-value="<?php echo $l_institute[0]; ?>" >
                   <?php echo $l_institute[1] ?>
                </option>
            <?php } ?> 
</select>
</div>-->
<div class="control-group" id="user_program">
     <label class="control-label" for="program">Select Your Program<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <span class="btn-select-value">Select Your Program...</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
       
    </a>
</div>
<?php }?>
<?php if($l_UR_Type=== 'M'){ ?>
<div class="control-group" id="user_add_fields">
    <label class="control-label" for="MRN">Mentor Registration Number <span style="color:red">*</span></label>
    <div class="controls">
        <input type="text" id="user_usn" name="user_urn" placeholder="Enter Your URN" class="form-control input-lg">
        <p class="help-block"></p>
    </div>
</div>
<div class="control-group" id="">
     <label class="control-label" for="CompanyName">Select Your Company Name<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <input type="hidden"  id="user_company_id" name="user_company_id" value="" />
        <span class="btn-select-value">Select Your Company Name</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
        <ul class="twitter_middle" style="overflow-y: auto;">
            <?php foreach ($l_companys as $l_company  ){?>
                <li class="company_change" onclick="CompanyChange('<?php echo $l_company[0]; ?>');" user-data-value="<?php echo $l_company[0]; ?>">
                   <?php echo $l_company[1]." ".$l_company[2]." ".$l_company[3]; ?>
                </li>
            <?php } ?>   
        </ul>
    </a>
</div><!--
<div class="control-group">
<label class="control-label" for="Institutes">Select Your Company Name<span style="color:red">*</span></label>
<select name="user_company_id" class="form-control input-lg">
<?php foreach ($l_institutes as $l_institute  ){?>
                <option class="company_change" onclick="CompanyChange('<?php echo $l_company[0]; ?>');" user-data-value="<?php echo $l_company[0]; ?>" >
                   <?php echo $l_company[1]." ".$l_company[2]." ".$l_company[3]; ?>
                </option>
            <?php } ?> 
</select>
</div>-->

<div class="control-group" id="">
     <label class="control-label" for="CompanyInfo">Company Profile Information<span style="color:red">*</span></label>
  <textarea class="form-control" rows="5" name="user_company_info"id="comment"></textarea>
  <p class="help-block"></p>
</div>

<?php }?>
<?php if($l_UR_Type=== 'A'){ ?>

<div class="control-group" id="">
     <label class="control-label" for="Institutes">Select Your Institutes<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
       <input type="hidden"  id="user_it_id" name="user_it_id" value="" />
        <span class="btn-select-value">Select Your Institutes</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
        <ul class="twitter_middle" style="overflow-y: auto;">
            <?php foreach ($l_institutes as $l_institute  ){?>
                <li class="institute_change" id="institute_change_<?php echo $l_institute[0]; ?>" user-data-value="<?php echo $l_institute[0]; ?>">
                   <?php echo $l_institute[1] ?>
                </li>
            <?php } ?>   
        </ul>
    </a>
</div>

<?php }?>

</div>
<script>
 
$(".institute_change" ).on('click',function () {
     var institute_id = $(this).attr('user-data-value');
     //alert(institute_id);
     $("#user_it_id").val(institute_id);
 var data2={user_institute_id:institute_id};

    $.ajax({
        type: "GET",
        data:data2,
        url: "signup_select_program.php",
        async: false,
        success : function(data) {
          $("#user_program").replaceWith(data);
        }
    });
 });
 </script>
 <script>
function CompanyChange(user_company_value) {
 $("#user_company_id").val(user_company_value);
 
 }
</script>