<?php 
include ('db_config.php');
 $l_IT_id=$_GET['user_institute_id'];
unset($l_programs);
 $l_programs= array();
  
 $l_programs_sql ='Select IT.PG_id, PG.PG_Name from Institutes_Program as IT, Programs as PG
        where IT.IT_id ='.$l_IT_id.'
        and IT.PG_id = PG.PG_id ';
    $l_programs_result =mysql_query($l_programs_sql);
    while($l_row__program_results=mysql_fetch_row($l_programs_result)){
        array_push($l_programs,$l_row__program_results);
    }
?>
<div class="control-group"  id="user_program">
     <label class="control-label" for="Programs">Select Your Program<span style="color:red">*</span></label>
    <a class="btn btn-success btn-select btn-select-light">
        <input type="hidden" id="user_PG_id" name="user_PG_id" value="" required="required" />
        <span class="btn-select-value">Select Your Program</span>
        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
        <ul >
            <?php foreach ($l_programs as $l_program  ){?>
                <li class="program_change" onclick="ProgramChange('<?php echo $l_program[0]; ?>')" user-data-value="<?php echo $l_program[0]; ?>">
                   <?php echo $l_program[1]; ?>
                </li>
            <?php } ?>   
        </ul>
    </a>
</div>
<script>
    function ProgramChange(program_id) {
         //alert(program_id);
         $("#user_PG_id").val(program_id);
    /* var program_id = $(this).attr('user-data-value');
     alert(program_id);
     */
 }
</script>
