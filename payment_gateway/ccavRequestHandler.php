<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php 
//print_r($_POST);
//exit();
include('Crypto.php')?>
<?php 
<<<<<<< HEAD

	error_reporting(0);
	
=======
error_reporting(0);
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
	$merchant_data='';
	//$working_key='4770546A6784D9CF8115713CBE2A4089';//Shared by CCAVENUES
	//$access_code='AVXP63DA41AJ26PXJA';//Shared by CCAVENUES
	$working_key='4770546A6784D9CF8115713CBE2A4089';//Shared by CCAVENUES
	$access_code='AVXP63DA41AJ26PXJA';
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<<<<<<< HEAD
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
=======
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>