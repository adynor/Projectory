<?php include('header.php');?>
<div style="width: 852px; border: 3px solid #CCCCCC; margin: -45 auto;">
<?php
echo '<iframe id="fred" style="border:1px solid #FFFFFF;" title="PDF in an i-Frame" src="https://zaireprojects.com/ViewBlobFiles.php?prid='.$_GET['prid'].'" frameborder="1" scrolling="auto" height="1100" width="850" ></iframe></div>';
include('footer.php')?>