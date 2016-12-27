<?php
    
if(!session_id()) 
{
   session_start();
}
    
include ('db_config.php');
include ('header.php');
?>

<br><br>
   <div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12 ady-row">

<?php
    $l_UR_Type= $_SESSION['g_UR_Type'];
    $l_UR_id = $_SESSION['g_UR_id'];

if(is_null($l_UR_id))
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in. Please login correctly");
        window.location.href="'.$l_filehomepath.'/login"; </script> ';

        print($l_alert_statement );
}

if(isset($_POST['submit']) )
{
  $l_UR_FirstName= $_POST['l_UR_FirstName'];
  $l_UR_MiddleName= $_POST['l_UR_MiddleName'];
  $l_UR_LastName= $_POST['l_UR_LastName'];
  
  $l_pass = $_POST['l_pass '];
  $l_cpass = $_POST['l_cpass '];   
  $l_UR_AlterEmailid = $_POST['l_UR_AlterEmailid'];   

  $l_UR_Semester = $_POST['l_UR_Semester'];   
  $l_UR_Phno = $_POST['l_UR_Phno'];
  $l_UR_Address  =$_POST['l_UR_Address'];
  $l_UR_City  =$_POST['l_UR_City'] ;
  $l_UR_State =$_POST['l_UR_State'] ;
  $l_UR_Country  =$_POST['l_UR_Country'] ;
  $l_UR_Zipcode = $_POST['l_UR_Zipcode'];

 $l_Year=$_POST['Year'];
  $l_Month=$_POST['Month'];
  $l_Date=$_POST['Date'];
  $l_UR_DOB=$l_Year.$l_Month.$l_Date;

$l_Name=$_POST['l_Name'];
$array_Name=explode(' ',$l_Name);
$l_count=count($array_Name);
if (preg_match("/[^A-Za-z'-]/",$_POST['l_Name'])) 
          {
        print("<div class='alert alert-danger'>invalid name and name should be alpha</div>");
      }
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


 $sql='UPDATE Users SET UR_AlterEmailid ="'.$l_UR_AlterEmailid.'",UR_Semester="'.$l_UR_Semester.'",UR_Phno ="'.$l_UR_Phno.'",UR_Address ="'.$l_UR_Address.'",UR_City="'.$l_UR_City.'",UR_State="'.$l_UR_State.'",UR_Country="'.$l_UR_Country.'",UR_Zipcode="'.$l_UR_Zipcode.'",UR_DOB ="'.$l_UR_DOB.'",UR_FirstName ="'.$l_UR_FirstName.'",UR_MiddleName ="'.$l_UR_MiddleName.'",UR_LastName ="'.$l_UR_LastName.'" WHERE UR_id="'.$l_UR_id.'" and Org_id="'.$_SESSION['g_Org_id'].'"' ; 
       mysql_query($sql); 
}

$l_query_display ='Select UR_FirstName, UR_MiddleName, UR_LastName, UR_AlterEmailid,UR_PhNo,UR_Semester,UR_Address, UR_City, UR_State, UR_Country, UR_Zipcode,UR_DOB from Users where UR_id = "'.$l_UR_id.'" and Org_id="'.$_SESSION['g_Org_id'].'"';
$l_result_display = mysql_query($l_query_display);
if ($l_row_display = mysql_fetch_row($l_result_display))
{
     $l_name_display = $l_row_display[0].' '.$l_row_display[1].' '.$l_row_display[2];
     $l_UR_AlterEmail_display = $l_row_display[3];
     $l_UR_contact_display = $l_row_display[4];
     $l_UR_address_display = $l_row_display[6];
     $l_UR_City_display = $l_row_display[7];
     $l_UR_State_display = $l_row_display[8];
     $l_UR_zip_display = $l_row_display[10];
     $l_UR_DOB_Y = date('Y',strtotime($l_row_display[11]));
     $l_UR_DOB_MonthName = date('F',strtotime($l_row_display[11]));  // for showing month
     $l_UR_DOB_D = date('d',strtotime($l_row_display[11]));
}

print('<div class="panel panel-primary" style="width:100%;">');
print('<div class="panel-heading" style="width:100%;"> Edit Profile</div>');
print('<div class="panel-body table-responsive table" style="width:100%;">');
print('<table class="ady-table-content table" style="width:100%;">');
    
print('<form  action="" method=POST>');

print('<tr><td>Your Full Name  </td><td colspan=4"><input class="form-control ady-form" type=text name=l_Name  value = "'.$l_name_display.'"></td></tr>');

print('<tr><td>Date of Birth  </td><td>
Month<select class="form-control" name=Month>');

for ($m=1; $m<=12; $m++) 
{
  if(date('F', mktime(0,0,0,$m))==$l_UR_DOB_MonthName)
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

print('<td>Date<select class="form-control" name=Date >');
for($i=1; $i< 31; $i++)
{
if($i== $l_UR_DOB_D)
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

print('<td>Year<select class="form-control" name="Year">');
for($i = 1950; $i< date('Y'); $i++)
{
if($i== $l_UR_DOB_Y)
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

print('<tr><td>Alter Email id</td>   <td colspan=3><input class="form-control ady-form"type=text  name=l_UR_AlterEmailid  value = "'.$l_UR_AlterEmail_display.'"></td></tr>');
if($_SESSION['g_UR_Type'] == 'S')
{
        print('<tr><td >Semester</td><td colspan=4><select class="form-control" name="l_UR_Semester" align="right">');
        print('<option>1</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> </select></td></tr>');
}

print('<tr><td >Contact</td><td colspan=3><input class="form-control ady-form" type=text name=l_UR_Phno  value = "'.$l_UR_contact_display.'"></td></tr>');

print('<tr><td >Address</td><td colspan=3><textarea class="form-control ady-form" name="l_UR_Address" '.$l_UR_address_display.'>'.$l_UR_address_display.'</textarea></td></tr>');

print('<tr><td >Country</td><td colspan=3><input class="form-control ady-form" type=text name=l_UR_Country value="India"></td></tr>');
    
    print('<tr><td >State</td><td colspan=3>');
    print('<select class="form-control" id="s3" name="l_UR_State" >');

    

    $l_States_arr           = array();
    $l_Cities_arr   = array();
    $l_state_sql      ='SELECT stateID, stateName FROM States WHERE countryID = "IND" and Org_id="'.$_SESSION['g_Org_id'].'"';
    $l_state_result =mysql_query($l_state_sql);
    while ($l_data=mysql_fetch_row($l_state_result))
    {
        $l_State_id   = $l_data[0];
        $l_State_name = $l_data[1];
        $l_States_arr[] = $l_State_name;
        
        $l_city_sql = 'SELECT cityID, cityName FROM Cities where stateID ='.$l_State_id.' and countryId = "IND" and Org_id="'.$_SESSION['g_Org_id'].'"';
        
        $l_city_res = mysql_query($l_city_sql);
        while ($l_city_row = mysql_fetch_row($l_city_res))
        {
            $l_Cities_arr[$l_State_name][] = $l_city_row[1];
        }
        mysql_free_result($l_city_res);
    }
    mysql_free_result($l_state_result);
    
    foreach($l_States_arr as $sa)
    {
    	if($sa==$l_UR_State_display)
        	print('<option selected>'.$sa.'</option>');
        else
                print('<option>'.$sa.'</option>');
    }
    
    
    
    print(' </select> ');
    print(' </td></tr>');
    
    print('<tr><td>City</td><td  colspan=3> <select class="form-control" id="s4" name="l_UR_City" > </select> ');

    print(' <script type="text/javascript"> ');
    print('var s3= document.getElementById("s3"); var s4 = document.getElementById("s4"); onchange1(); s3.onchange = onchange1;');
    print('function onchange1() {');
    foreach ($l_States_arr as $sa)
    {
        print('if (s3.value == "'.$sa.'") {');
        print('var option_html = "";');
        if (isset($l_Cities_arr[$sa]))
        {
            foreach ($l_Cities_arr[$sa] as $value)
            {
            	if($value==$l_UR_City_display)
                	print('option_html += "<option value = '.$value.' selected>'.$value.'</option>";');
                else	                	
                	print('option_html += "<option value = '.$value.'>'.$value.'</option>";');
            }
        }
        print('s4.innerHTML = option_html;');
        print('}');
    }
    print('} ');
    print('</script>');
    
    
    
    print('</td></tr>');

print('<tr><td >Zipcode</td><td><input class="form-control ady-form" type=text name=l_UR_Zipcode value = "'.$l_UR_zip_display.'"></td></tr>');

print('<tr><td><font size="2" color="red">Note : All fields with * are mandatory. </font></td>   <td colspan=4><input class="btn-primary ady-req-btn" type=submit name=submit value="Update" ></td></tr>');
    
    print('</table>');
    print('</form>');
?>
               </div></div>
</div>
<?php include('footer.php')?>