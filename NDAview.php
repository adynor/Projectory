<?php

session_start();

$link = $_SESSION['g_view_Nda'];

print('<iframe style = "position:absolute; left: 0; right: 0; bottom: 0; top:50px; " src="'.$link.'" frameborder="0" height="100%" width="100%"> </iframe>');


?>