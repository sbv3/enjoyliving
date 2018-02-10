<?
foreach($_POST as $field => $value)
{
	global $$field;
	$$field=$value;
}
foreach($_GET as $field => $value)
{
	global $$field;
	$$field=$value;
}
?>