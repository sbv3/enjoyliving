<?php session_start();?>
<?
echo $_POST["value"];
$css_is_included=1;
?>
<script>
function jQuery(){}
</script>
<?
ini_set("include_path",ini_get("include_path").":/home/enjftfxb/www.enjoyliving.at/"); 
require_once("Connections/usrdb_enjftfxb2_12_1.php");
?>
<?
if($task=="update_task_prop")
{
	$prop=$_POST["name"];
	$pk=$_POST["pk"];$task_id=GetSQLValueString($pk,"int");
	$value=$_POST["value"];
	if(is_array($value)){$value=implode(",",$value);}
	$value=GetSQLValueString($value,"text");
	echo $value;
	
	if($prop!="" and $task_id!="" and $value!="")
	{mysql_query("update wfl_tasks_templates set $prop=$value where id=$task_id limit 1");}
}
?>
