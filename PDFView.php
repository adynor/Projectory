<style>
viewer-pdf-toolbar{
display:none ;
}
</style>

<?php

include ('header.php');


 $link = $_SESSION['g_pdf_view'];

print('<iframe style = "cursor: text; position:absolute; left: 0; right: 0; bottom: 0; top: 20px; " src="'.$link.'#toolbar=0&navpanes=0" height="100%" width="100%"></iframe>');
    include ('footer.php');

?>

