<?php
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2.php");
//header("content-type:text/plain"); 

$keys = array("DOCUMENT_ROOT",
    "PATH_INFO",
    "PATH_TRANSLATED",
    "PHP_SELF",
    "REQUEST_URI",
    "SCRIPT_FILENAME",
    "SCRIPT_NAME",
    "QUERY_STRING"
);

$info_row = "<tr><td>$_SERVER[SERVER_SOFTWARE]</td><td></td><td></td>\n";
print "Path Information for $_SERVER[SERVER_SOFTWARE]\n\n";

foreach($keys as $key) {
    print '$_SERVER["'.$key.'"] = '.$_SERVER[$key]."\n";
    $info_row .= "<td>$_SERVER[$key]</td>\n";
}

print '__FILE__ = '. __FILE__;
$info_row .= "<td>".__FILE__."</td>\n</tr>";

print "\n\n\n" . $info_row;

?>
<br>
<br>
<br>
<br>

<?
$test=menu_select(7639,'down','1','1','','0');
print_r($test[id]);

//phpinfo();
?>
<? /*
$no_urls=mysql_query("select * from 
(select menu_id, site_id from menu_hierarchy where site_id=6) as test
left join (select menu_id as g_mid, site_id as g_sid from googleurl where site_id=6) as google on google.menu_id=test.menu_id 
where google.menu_id is null");

while($no_urls_r=mysql_fetch_assoc($no_urls))
{
	create_googleurl($titel_neu,$menuid);
}*/
?>
<?
$test2=unserialize(base64_decode($test2));
print_r($test2);
?>
<form target="_self" method="post">
	<input type="hidden" value="<? echo base64_encode(serialize($test)); ?>" name="test2" />
	<input type="submit" />
</form>