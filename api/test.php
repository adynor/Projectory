<?php
echo md5('zprojects');

$URid_encode=md5(162).'=='.base64_encode('TNT00001');
$ORGid_encode=md5(162).'=='.base64_encode('TNT');
echo "https://zaireprojects.com/test/loginOrganization.php?UR_id=".$URid_encode."&ORG_id=".$ORGid_encode."";

echo url();

?>