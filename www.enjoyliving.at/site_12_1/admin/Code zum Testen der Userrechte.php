<? session_start();?>
<?php
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right("helmut","edit_menu")=="true")
{echo "ja, Du darfst!";}
?>