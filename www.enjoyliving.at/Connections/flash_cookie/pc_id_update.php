<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
$googleurl=$_POST[googleurl];$googleurl_sql=GetSQLValueString($googleurl, "text"); 
$menu_id=$_POST[menu_id];$menu_id_sql=GetSQLValueString($menu_id, "int");
$pc_id=$_POST[pc_id];$pc_id_sql=GetSQLValueString($pc_id, "int");

if($googleurl!="" && $menu_id!="" && $site_id!="" && $pc_id!=""){
	$pc_id_exist_q=mysql_query("select id, visits from statistik_pc_id where googleurl=$googleurl_sql and menu_id=$menu_id_sql and site_id=$site_id and pc_id=$pc_id_sql and date=date(now()) limit 1");
	if(mysql_num_rows($pc_id_exist_q)>0)
	{
		$pc_id_exist_r=mysql_fetch_assoc($pc_id_exist_q);
		$pc_id_update_id=$pc_id_exist_r[id];
		$pc_id_update_visits=$pc_id_exist_r[visits]+1;
		$pc_id_update_q=mysql_query("update statistik_pc_id set visits=$pc_id_update_visits where id=$pc_id_update_id limit 1");
	}
	else
	{
		$pc_id_insert_q=mysql_query("insert into statistik_pc_id (googleurl, menu_id, site_id,pc_id,visits) values ($googleurl_sql, $menu_id_sql, $site_id,$pc_id_sql,1)");
	}
}
?>