<?php include('Crypto.php')?>
<?php

	error_reporting(0);
	
	//$workingKey='4770546A6784D9CF8115713CBE2A4089'//Working Key should be provided here.
	$workingKey='4770546A6784D9CF8115713CBE2A4089';
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}
	
	/* Database Connection */
	$o_connection = mysql_connect('localhost','zairepro_dbuser','4dyn0rtech!');
	mysql_select_db('zairepro_Projectory');
	$l_PR_id=0;
	$l_PR_name="";
	$l_UR_id="";
	$l_UR_amount=0;
	
	for($i = 0; $i < $dataSize; $i++) 
	{
	//print_r($information);	
		$information=explode('=',$decryptValues[$i]);
	    	//echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	    	if($information[0]=="merchant_param2"){
	    	    $l_PR_id = $information[1];
	    	    }
	    	else if($information[0]=="merchant_param1"){
	    	   $l_PR_name= $information[1];
	    	    }
	    	  else if($information[0]=="merchant_param3"){
	    	    $l_UR_id= $information[1];
	    	    }
	    	else if($information[0]=="amount"){
	    	  $l_UR_amount = $information[1];
	    	    }
	    	 else if($information[0]=="order_id"){
	    	   $l_order_id = $information[1];
	    	    }
	    	 
	}
	echo "<center>"	;
	if($order_status==="Success")
	{
$timezone = new DateTimeZone("Asia/Kolkata");
$date = new DateTime();
$date->setTimezone($timezone);
$l_Datetime = $date->format('YmdHi');

	echo "<br ><span style='color:green;font-size:18px;'> Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.</span>";
	
$l_query_update_PR_id="UPDATE Users SET  PR_id =".$l_PR_id." WHERE  UR_id ='".$l_UR_id."'";

mysql_query($l_query_update_PR_id);
echo "<br>";
$l_query_insert_PR_id='insert into Project_Applications(UR_id,PR_id,PP_ApplicationDate) values ("'.$l_UR_id.'",'.$l_PR_id.','.$l_Datetime.')';

mysql_query($l_query_insert_PR_id);
echo "<br>";
 $l_query_insert_PR_Pay='insert into Payment_Access(UR_id,PR_id,PA_Date, PA_Amount,PA_OrderNo) values ("'.$l_UR_id.'",'.$l_PR_id.','.$l_Datetime.','.$l_UR_amount.',"'.$l_order_id.'")';

mysql_query($l_query_insert_PR_Pay);
	session_start();
	$_SESSION['g_PR_id']=$l_PR_id ;
 
	//print_r($_SESSION);
      $url= 'https://www.zaireprojects.com/SHome.php?project='.$l_PR_id.'';
       }
	else if($order_status==="Aborted")
	{
		echo "<br ><span style='color:orange;font-size:18px;'>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail</span>";
	$url= 'https://www.zaireprojects.com/projects';
	}
	else if($order_status==="Failure")
	{
		echo "<br><span style='color:red;font-size:18px;'>Thank you for shopping with us.However,the transaction has been declined.</span>";
	$url= 'https://www.zaireprojects.com/projects';
	}
	else
	{
		echo "<br><span style='color:red;font-size:18px;'>Security Error. Illegal access detected</span>";
	$url= 'https://www.zaireprojects.com/projects';
	}


	
?>
<br /><br /><br /><br /><br />

	<table cellpadding="10" style="background: menu;border: 1px solid blue;color: #2000FF;padding: 10px;">
	<tr><td>Order Id</td><td><?php echo $l_order_id;?></td></tr>
	<tr><td>User Id</td><td><?php echo $l_UR_id ;?></td></tr>
	<tr><td>Project Name</td><td><?php echo $l_PR_name ;?></td></tr>
	<tr><td>Price</td><td><?php echo $l_UR_amount; ?></td></tr>
	<tr><td>Oder Status</td><td><?php echo $order_status; ?></td></tr>
	</table>
	<a href="<?php echo $url; ?>">Back To Home </a>
        </center>