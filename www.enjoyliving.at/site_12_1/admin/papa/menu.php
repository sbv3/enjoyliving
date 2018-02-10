<?php     
session_start(); 
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); # function von cvs
?>

<html>
<head>
<title>Menuverwaltung</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">				
</head>

<script>
function add_share(site_add,menu_add) {
	var url="Admin_table_result.php";
	url=url+"?task=add_share&site_add="+site_add+"&menu_add="+menu_add;
	display_data(url,'false');
	name=site_add+"|"+menu_add;
	if(document.getElementById(name))
	{document.getElementById(name).onclick = new Function("remove_share("+site_add+","+menu_add+")");}
}

function add_share_multi(site_add,menu_add_multi,site_desc) {
	var site_desc=site_desc;
	var menu_add=menu_add_multi.split("|");
	var menu_add_string=menu_add.join(", ");
	var r=confirm("Es werden die Artikel mit den IDs: \n"+menu_add_string+"\n\nfür das Magazin "+site_desc+" frei gegeben.\n\nDieser Befehl ist nicht wiederrufbar!");
	if (r==true)
	{
		for (var i = 0; i < menu_add.length; i++) {
			add_share(site_add,menu_add[i]);
		}
	}
}

function remove_share(site_rem,menu_rem) {
	var url="Admin_table_result.php";
	url=url+"?task=remove_share&site_rem="+site_rem+"&menu_rem="+menu_rem;
	display_data(url,'false');
	name=site_rem+"|"+menu_rem;
	if(document.getElementById(name))
	{document.getElementById(name).onclick = new Function("add_share("+site_rem+","+menu_rem+")");}
}

function remove_share_multi(site_rem,menu_rem_multi,site_desc) {
	var site_desc=site_desc;
	var menu_rem=menu_rem_multi.split("|");
	var menu_rem_string=menu_rem.join(", ");
	var r=confirm("Es werden etwaige Freigaben der Artikel mit den IDs: \n"+menu_rem_string+"\n\nfür das Magazin "+site_desc+" widerrufen. Das passiert nur, wenn der betroffene Artikel nicht in dem Magazin verwendet wird.\n\nDieser Befehl ist nicht wiederrufbar!");
	if (r==true)
	{
		for (var i = 0; i < menu_rem.length; i++) {
			remove_share(site_rem,menu_rem[i]);
		}
	}
}

function mark_update_need()
{
	$(document).ready(function () {
		$("#update_warning").remove();
		var $new = $("body").append("<div id='update_warning' style='width:117px; position:absolute;top:80px;left:42px;z-index:3000;background-color:#ff0000;color:#ffffff;padding: 8px;text-align: center;font-weight: bold'></div>");
		changecssproperty(document.getElementById("update_warning"), shadowprop, '3px 3px 3px rgba(0,0,0,.5)');
		$("#update_warning").append("ACHTUNG: Die Seite muß neu indiziert werden!<br><br><input id='aktualisieren_button' type='button' value='Jetzt indizieren' onMouseup='rebuild_menu_data()'>");
	})
}

function rebuild_menu_data()
{	
		$('#aktualisieren_button').remove();
	//	document.getElementById("body").appendChild("<div id='block' style='position:absolute;top:0px;left:0px;width:100%;height:100%;background-color:#444444;opacity:0.5;z-index:2000;'></div>");
	//	$('body').append("<div id='block' style='position:absolute;top:0px;left:0px;width:100%;height:100%;background-color:#444444;opacity:0.5;z-index:2000;'></div>");
		$("#update_warning").html("Bitte warten. <br><br>Die Seite wird aktualisiert...");
			
		var oNewDIV = document.createElement("div");
		document.body.appendChild(oNewDIV);	
		oNewDIV.style.position="absolute";
		oNewDIV.style.top="0px";
		oNewDIV.style.left="0px";
		oNewDIV.style.height="100%";
		oNewDIV.style.width="100%";
		oNewDIV.style.backgroundColor="#444444";
		oNewDIV.style.opacity="0.5";
		oNewDIV.style.zIndex="2000";
		oNewDIV.id="block";
	
		$('#block').ready(reindex());
		
	///	$(document).ready(reindex());
		$("#update_warning").remove();
		$('#block').remove();
}

function reindex()
{
		//alert("hjh");
		display_data("Admin_table_result.php?task=rebuild_hierarchy_paths",'false');
		display_data("Admin_table_result.php?task=update&tabelle=sites&id="+<? echo $site_id?>+"&field=menu_hierarchy_update_needed&value=0",'false');
}

function update_menu_data(what,script,rebuild_hierarchy_paths)
//Funktion zum aktualisieren der Tabelle mit Textfeld
{
	var tabelle=what.name;
	var field=what.title;
	var recordid=what.id;
	var value=what.value;

	if(tabelle==""){return};
	if(field==""){return};
	if(recordid==""){return};
	
	var url="Admin_table_result.php";
	url=url+"?task=update&tabelle="+tabelle+"&id="+recordid+"&field="+field+"&value="+URLencode(value,script);
	display_data(url,false); 

	if(rebuild_hierarchy_paths==1)
	{
		if(user_config_autoupdate==1)
		{
			display_data("Admin_table_result.php?task=rebuild_hierarchy_paths",false);
		}
		else 
		{
			mark_update_need();	
			display_data("Admin_table_result.php?task=update&tabelle=sites&id="+<? echo $site_id?>+"&field=menu_hierarchy_update_needed&value=1",false);
		}
	}
}

</script>

<body class="admin_body">
<div id="table_result_error_messages"></div>
<?
///////////////////////POST Tasks
###user/pwd checken

if(!$_SESSION['user']){
	if(test_login($user,$password,$site_id)!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/Login.php?wrong_longin=1\">";
		exit;
	}
}
if(test_right($_SESSION['user'],"enter_admin")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/Login.php?wrong_longin=2\">";
		exit;
	}

if(!$men_id){$men_id=$home_menu_id;}



####change mother - hier auch neue url eintragen

if ($donewmother=="1" and test_right($_SESSION['user'],"enter_changemother")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or $_SESSION[user_id]==find_master_user_id($changemother_id)) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($changemother_id)==$site_id)){
	//1. parent id vom betroffenen menu ändern
	$aendern = "UPDATE menu_hierarchy SET parent_id='$newmother' WHERE menu_id='$changemother_id' and site_id=$site_id";
	$update = mysql_query($aendern);
	rebuild_hierarchy_paths();
	$aufruffunktion1 = create_googleurl($mothertitel,$changemother_id);
	$aufruffunktion2 = update_googleurl($changemother_id);
}
####change multi mother - hier auch neue url eintragen
if ($donewmultimother=="1" and test_right($_SESSION['user'],"enter_changemother")=="true"){
	$test_changemother_menu_id_rights=explode(",",$changemother_ids);
	foreach($test_changemother_menu_id_rights as $change_mother_test_menu_id)
	{
		if (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or $_SESSION[user_id]==find_master_user_id($change_mother_test_menu_id) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($change_mother_test_menu_id)==$site_id))
		{}else{$breach=$breach+1;}
	}
	
	if($breach==0)
	{
		$aendern = "UPDATE menu_hierarchy SET parent_id='$newmultimother' WHERE menu_id in ($changemother_ids) and site_id=$site_id";
		$update = mysql_query($aendern);
		rebuild_hierarchy_paths();
		$changemother_ids=explode(",",$changemother_ids);
		$changemother_descriptions=explode("|~|",$changemother_descriptions);
		for($iii=0;$iii<count($changemother_ids);$iii++)
		{
		create_googleurl($changemother_descriptions[$iii],$changemother_ids[$iii]);
		update_googleurl($changemother_ids[$iii]);
		}
	}
}
####update metatags	
if ($metaupdate=="1"  and ((test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or $_SESSION[user_id]==find_master_user_id($meta_id)) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($meta_id)==$site_id)) and test_right($_SESSION['user'],"enter_metatags")=="true"){
	$aendern = "UPDATE menu set metatag_title = '$metatitle',metatag_keywords='$metakeywords',metatag_description='$metadescription' where id = '$meta_id' ";
	$update = mysql_query($aendern);
}

####Update eines Menüpunktes
if ($formsok=="1" and test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or $_SESSION[user_id]==find_master_user_id($upd_id)) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($upd_id)==$site_id))
	{
		//mysql_query("update sites set menu_hierarchy_update_needed=1 where id=$site_id");
		//$menu_hierarchy_update_needed=1;

		if($titel_curr!=$titel){
			$act_date = date("Y-m-d H:i:s"); 
			mysql_query("update menu set `description` = '$titel' where `id` = '$upd_id' ") or die ("xx1".mysql_error());
			$aufruffunktion1 = create_googleurl($titel,$upd_id);
			$aufruffunktion2 = update_googleurl($upd_id);
		}
}



#### Create Sponsorbanner
if(test_right($_SESSION['user'],"edit_sponsorbanner")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($menu_id)))and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($menu_id)==$site_id))
{
	if($sponsortask=="create_sponsorbanner"){
		if($menu_id!=""){
			$sponsorbanner_element_layout_id_query=mysql_query("select id from element_layout where type like '%sponsorbanner%'");
			$sponsorbanner_element_layout_id_result=mysql_fetch_assoc($sponsorbanner_element_layout_id_query);
			$sponsorbanner_element_layout_id=$sponsorbanner_element_layout_id_result[id];
	
			$test_sponsorbanner_q=mysql_query("select count(1) as Anz, text, exklusiver_sponsorbanner, menu_details.id as new_sponsorbanner_id from element_content_text,(select id,menu_id,exklusiver_sponsorbanner from menu_hierarchy where menu_id='$menu_id' and site_id=$site_id) as menu_details,(select element.id, menu_id from element where element.element_layout_id=$sponsorbanner_element_layout_id) as elements where element_id = elements.id and elements.menu_id=menu_details.menu_id and text=menu_details.id")or die(mysql_error());
			$test_sponsorbanner_r=mysql_fetch_assoc($test_sponsorbanner_q);
			if($test_sponsorbanner_r[Anz] == 0){
				$new_sponsorbanner_id=$test_sponsorbanner_r[new_sponsorbanner_id];
				mysql_query("INSERT INTO element(menu_id, element_layout_id, sort,site_id) VALUES('$menu_id','$sponsorbanner_element_layout_id','10','$site_id')") or die(mysql_error());
				$sponsortask='edit_sposorbanner';
			}
		}
	}
	
	
	#### Delete Sponsorbanner
	if($sponsortask=="delete_sponsorbanner"){
		if($menu_id!=""){
			$sponsorbanner_element_layout_id_query=mysql_query("select id from element_layout where type like '%sponsorbanner%'");
			$sponsorbanner_element_layout_id_result=mysql_fetch_assoc($sponsorbanner_element_layout_id_query);
			$sponsorbanner_element_layout_id=$sponsorbanner_element_layout_id_result[id];
	
			mysql_query("delete from element where menu_id='$menu_id' and element_layout_id = '$sponsorbanner_element_layout_id' and site_id=$site_id") or die(mysql_error());
		}
	}
}

 
if (!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp)
{
	####Neuen Menupunkt anlegen
	if ($eintrag=="1" and test_right($_SESSION['user'],"create_menu")=="true"){
		if($search_type=="" && substr_count($seitentyp,"Subcontent")>0){$search_type="Subseiten";}
		
		$pagetype_searchtype_query=mysql_query("select pagetype.description,pagetype.search_type from pagetype, (select pagetype.description,pagetype.search_type from pagetype where search_type!='' group by description,search_type) as page where pagetype.description = page.description group by pagetype.description") or die ("Pagetype_searchtype query failed: ".mysql_error());
		while($pagetype_searchtype=mysql_fetch_assoc($pagetype_searchtype_query))
		{
			if($pagetype_searchtype[description]==$seitentyp){$search_type=$pagetype_searchtype[search_type];}
		}
		$aufruffunktion = newmenu($menu_ordering2,$parent_id,$titel2,$display,$active,$active_startdate,$active_enddate,$seitentyp,$search_type);
	}

	////////////Menüeintrag löschen
	if($task=="menu_del" and test_right($_SESSION['user'],"delete_menu")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($del_id))) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($del_id)==$site_id))
	{//zuerst testen, ob Submenüpunkte existieren.
		$submenus_exist_query=mysql_query("SELECT menu_id FROM menu_hierarchy where site_id=$site_id and parent_id = '$del_id'") or die("Es ist ein Datenbankfehler im Module menu_del aufgetreten!");		
		$submenus_exist_num_rows=mysql_num_rows($submenus_exist_query);
		if($submenus_exist_num_rows > 0)
		{?> <script> alert("Für diesen Menüpunkt gibt es noch Submenüs, die zuerst gelöscht werden müssen")</script> <? }
		else
		{
			$delete_sql = mysql_query("delete FROM menu where id = '$del_id'") or die("Fehler beim Löschen von der Tabelle menu im Module menu_del ! ");
			$delete_sql2 = mysql_query("delete FROM menu_hierarchy where menu_id = '$del_id'") or die("Fehler beim Löschen von der Tabelle menu im Module menu_del ! ");
		}
	}

	////////////Sharing eines Menüeintrags stoppen.
	if($task=="rem_share" and test_right($_SESSION['user'],"share_menu_ids")=="true")
	{//zuerst testen, ob Submenüpunkte existieren.
		$submenus_exist_query=mysql_query("SELECT menu_id FROM menu_hierarchy where site_id=$site_id and parent_id = '$rem_id'") or die("Es ist ein Datenbankfehler im Module rem_share aufgetreten!");		
		$submenus_exist_num_rows=mysql_num_rows($submenus_exist_query);
		if($submenus_exist_num_rows > 0)
		{?> <script> alert("Für diesen Menüpunkt gibt es noch Submenüs, die zuerst entfernt werden müssen")</script> <? }
		else
		{
			$delete_sql2 = mysql_query("delete FROM menu_hierarchy where site_id=$site_id and menu_id = '$rem_id' and parent_id='$men_id'") or die("Fehler beim Löschen von der Tabelle menu im Module rem_share ! ");
		}
	}
$_SESSION['microtime'] = $timestamp;
}


///////////Hier wird die Warnbox eingeblendet, wenn nötig.
if($menu_hierarchy_update_needed==1){?><script>mark_update_need();</script><? }



//////////////////////Vorbereitende Abfragen
if($task!="suche"){
	$parent_id=$men_id;
	$back_id=find_parent($men_id);
//	echo "select parent_id from menu_hierarchy where menu_id='$menu_id' and site_id='$site_id'";
	//das ist die Frage, ob ich bereits auf der Top-Ebene bin.
	$parent_desc=find_description($men_id);
	$target_ids=menu_select($men_id,"down",1,"","","");
	//echo $men_id;	
	if(count($target_ids['id'])>0){$target_ids=implode(",",$target_ids['id']);}else {$target_ids="blank";}

	if($target_ids!="blank"){
		$result = mysql_query("SELECT menu.id, menu.master_site_id, menu.description, menu.page_finished, menu.pagetype, menu.search_type, menu.metatag_title, menu.metatag_keywords, menu.metatag_description, menu.up_date, menu.createdate,max_sort, menu_hierarchy.id as menu_hierarchy_id, menu_hierarchy.parent_id, menu_hierarchy.sort, menu_hierarchy.display,menu_hierarchy.display,menu_hierarchy.exklusiver_seitencontent, menu_hierarchy.exklusiver_sponsorbanner, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active FROM menu,menu_hierarchy, (select max(sort) as max_sort from menu_hierarchy where menu_id in ($target_ids) and site_id=$site_id) as max_sort where menu_id=menu.id and menu_hierarchy.parent_id=$men_id and site_id=$site_id and menu.id in ($target_ids) order by find_in_set(menu.id,'$target_ids') desc") or die("Es ist ein Datenbankfehler im Module menu aufgetreten1 ! ".mysql_error());
		$result_num_rows=mysql_num_rows($result);
	
		if($result_num_rows > 0)
		{
			$result_hierarchy_result=mysql_fetch_assoc($result);	
			$maxsort=$result_hierarchy_result[max_sort];
		}
	}
	$Seitentitel="Menü >> ".$parent_desc." (ID: ".$men_id.") <<";
	$Seitenfarbe=$color_button_bg;
	$navstring="&men_id=$men_id";
}

elseif($task=="suche"){
	if($subcontent_flag==TRUE){$subcontent_searchstring=" and menu.search_type!='Subseiten'";}else{$subcontent_searchstring="";}
	if($metatag_missing==TRUE){$subcontent_searchstring=$subcontent_searchstring." and (menu.metatag_title='' or menu.metatag_keywords='' or menu.metatag_description='') and search_type!='Subseiten'";}
	if($date_from != ""){
		$date_from=GetSQLValueString($date_from,"date");
		$subcontent_searchstring=$subcontent_searchstring."and menu.createdate >= $date_from";
	}
	if($date_to != ""){
		$date_to=GetSQLValueString($date_to,"date");
		$subcontent_searchstring=$subcontent_searchstring."and menu.createdate <= $date_to";
	}
	if($active_only==TRUE){$subcontent_searchstring=$subcontent_searchstring." and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A'";}
	if($number_last_created>0){$subcontent_searchstring=$subcontent_searchstring." order by createdate desc limit $number_last_created";}
	
	if($page_finished=="1"){
		$result = mysql_query("SELECT menu.id, menu.master_site_id, menu.description, menu.page_finished, menu.pagetype, menu.search_type, menu.metatag_title, menu.metatag_keywords, menu.metatag_description, menu.up_date, menu.createdate, menu_hierarchy.id as menu_hierarchy_id, menu_hierarchy.parent_id, menu_hierarchy.sort, menu_hierarchy.display,menu_hierarchy.display,menu_hierarchy.exklusiver_seitencontent, menu_hierarchy.exklusiver_sponsorbanner, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active FROM menu,menu_hierarchy where site_id=$site_id and menu_hierarchy.menu_id=menu.id and menu.page_finished='0' and menu.search_type!='Subseiten' $subcontent_searchstring") or die("Es ist ein Datenbankfehler im Module menu aufgetreten3 ! ".mysql_error());
	}
	elseif($page_finished=="0" or !$page_finished){
		//echo "SELECT menu.* FROM menu,menu_hierarchy where site_id=$site_id and menu_hierarchy.menu_id=menu.id and menu.description like '%$suche%' $subcontent_searchstring";
		
		$result = mysql_query("SELECT menu.id, menu.master_site_id, menu.description, menu.page_finished, menu.pagetype, menu.search_type, menu.metatag_title, menu.metatag_keywords, menu.metatag_description, menu.up_date, menu.createdate, menu_hierarchy.id as menu_hierarchy_id, menu_hierarchy.parent_id, menu_hierarchy.sort, menu_hierarchy.display,menu_hierarchy.display,menu_hierarchy.exklusiver_seitencontent, menu_hierarchy.exklusiver_sponsorbanner, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active FROM menu,menu_hierarchy where site_id=$site_id and menu_hierarchy.menu_id=menu.id and menu.description like '%$suche%' $subcontent_searchstring") or die("Es ist ein Datenbankfehler im Module menu aufgetreten4 ! ".mysql_error());
	}
	

	$result_num_rows=mysql_num_rows($result);
	
	$result_hierarchy_result=mysql_fetch_assoc($result);

	$page_finished="0";
	$parent_id=find_parent($result_hierarchy_result[id]);
	$parent_desc=find_description($result_hierarchy_result[id]);
	$back_id=$parent_id;
	$maxsort="0";
	$Seitentitel="Suchergebnis für: ".$suche." (".$result_num_rows." gefundene Einträge)";
	$Seitenfarbe="#FF9A15";
	$navstring="&task=suche&suche=$suche";
}


$searchtype_query=mysql_query("select search_type,description from searchtype") or die (mysql_error());

$site_avail_q=mysql_query("select * from sites where id!=$site_id and id in (select site_id from user_groups_x_site_pool where user_groups_x_site_pool.group_id in (select groups_id from user_users_x_groups where user_users_x_groups.users_ID in(select id from user_users where username = '$user')) and user_groups_x_site_pool.group_id in (select groups_id from user_users_x_groups where groups_id in (select groups_ID from user_sites_x_groups where sites_id=$site_id) and users_ID in (select id from user_users where username='$user')))") or die (mysql_error());



////////////////////Seiteninhalt
?>
	<table border="0" width="1660">
	<tr border="1" bordercolor="#00008B" bgcolor="<? echo $color_botton_highlight_bg;?>"> 
		<td width="132" align="center" bgcolor="#FFFFFF"><img border="0"  src="<? echo $logo_url?>" max-width="132" height="45"></td>
		<td align="center" style="color:#000000; font-size:20px">Admin</td>
		<td align="center">
			<? echo $act_date;echo "user: ".$user."<br>site: ".$site_description;?>
			<br><div style="margin-top:5px">Autoupdate:</div>
			<div style="overflow:hidden;height: 20px;margin-top: 5px;">
				<? if($_SESSION['autoupdate']==1){?>
					<img id="autoupdate" style="position:relative;top:-0px"border="0" width="57" src="/site_12_1/css/schiebregler.png" title="Die Menühierarhie wird automatisch bei jeder Veränderung aufgebaut (langsamer)." onClick="update_auto_update_flag('<? echo $_SESSION['user'];?>',0)">
					<? } else {?>
					<img id="autoupdate" style="position:relative;top:-20px"border="0" width="57" src="/site_12_1/css/schiebregler.png" title="Die Menühierarhie muss manuell nach allen Veränderungen aufgebaut werden (schneller)." onClick="update_auto_update_flag('<? echo $_SESSION['user'];?>',1)">
				<? }?>
			</div>
		</td> 
		<td align="center" width="100px">
			<? if(test_right($_SESSION['user'],"edit_users")=="true"){?><p><input type="button" value="Userverwaltung" onClick="parent.location=('/site_12_1/admin/user_admin_users.php')"></p><? }?>
			<? if(test_right($_SESSION['user'],"edit_kampagnen")=="true"){?><p><input type="button" value="Kamgnenadmin" onClick="parent.location=('/site_12_1/admin/kampagnen_admin.php')"></p><? }?>
			<? if(test_right($_SESSION['user'],"edit_kopf_fuss")=="true"){?><p><input type="button" value="Kopf- & Fusszeile" onClick="parent.location=('/site_12_1/admin/kopf_fuss_admin.php')"></p><? }?>
		</td>
		<td align="center" width="100px">
			<? if(test_right($_SESSION['user'],"enter_newsletter/gewinnspiele")=="true"){?><p><input type="button" value="Newsletter/Gewinnspiele" onClick="parent.location=('/site_12_1/admin/newsletter_admin.php')"></p><? }?>
			<? if(test_right($_SESSION['user'],"enter_verwaiste_google_URL")=="true"){?><p><input type="button" value="verwaiste Googleurls" onClick="parent.location=('/site_12_1/admin/updgoogleurl.php')"></p><? }?>
			<? if(test_right($_SESSION['user'],"enter_workflow_admin")=="true"){?><p><input type="button" value="Workflow admin" onClick="parent.location=('/site_12_1/admin/wf_mgt_workflows.php')"></p><? }?>
		</td> 
		<td align="center" style="width:390px;">
			<form method="get" name="suche" target="_self" style="margin-bottom:-1px;">
				<div>
					<input type="text" name="suche" style="width:300px" value="<? echo $suche;?>" title="Durchsucht wird das Feld 'Description'.">
					<input name="parent_id" type="hidden" id="parent_id" value="<? echo $parent_id;?>">
					<input type="hidden" name="task" value="suche">
					<input name="Submit" type="submit" value="suche">
				</div>
				<div style="float:none;"></div>
				<div style="float:left;">
					<div style="float:left; width:130px">excl. Subseiten<input type="checkbox" name="subcontent_flag" title="Wenn angeclickt, wird nur nach Seiten gesucht die NICHT vom search_tpye 'subcontent' sind." <? if($subcontent_flag==TRUE){echo "checked";} ?>></div>
					<div style="float:left; width:130px">missing meta<input type="checkbox" name="metatag_missing" title="Wenn angeclickt, wird nur nach Seiten gesucht deren Metatags NICHT vollständig ausgefüllt sind." <? if($metatag_missing==TRUE){echo "checked";} ?>></div>
					<div style="float:left; width:130px">active only<input type="checkbox" name="active_only" title="Wenn angeclickt, wird nur nach aktiven Seiten gesuch." <? if($active_only==TRUE){echo "checked";} ?>></div>
				</div>
				<div style="float:none;"></div>
				<div style="float:left;">
					Createdate
					<input type="date" name="date_from" title="Datum von (YYYY-MM-TT)">
					<input type="date" name="date_to" title="Datum bis (YYYY-MM-TT)">	
				</div>				
			</form>
			</td>
		<td align="center">
				<form method="post" name="suche2" target="_self" style="margin-bottom:-1px;">
					<input type="hidden" name="page_finished" value="1">
					<input type="hidden" name="task" value="suche">
					<input name="parent_id" type="hidden" id="parent_id" value="<? echo $parent_id;?>">
					<input type="image" src="/site_12_1/css/Seitencontent_fehlt.png" width="23" height="23" title="Nach allen Seiten suchen, die noch in Arbeit sind. Das Subcontent-flag ist ohne Effekt" onClick="document.forms['suche2'].submit()">
				</form>
			</td>
		<td align="center">
			<form method="post" name="navigation" style="margin-bottom:-1px">
				<select name="men_id" style="width:200px;" onChange="if(this.value == 'auswählen'){} else {document.forms['navigation'].submit()}">
					<option value="">auswählen</option> 
					<? 
					$resultx_ids=menu_select($home_menu_id,"down",3,1,1,1);
					for($i=0;$i<count($resultx_ids['id']);$i++)
					{
						echo"<option value=".$resultx_ids['id'][$i].">".str_repeat("&nbsp;",$resultx_ids['level_down'][$i]*2)."-".$resultx_ids['description'][$i]."</option>";
					}?>
				</select>
			</form>
			<br>
			<form method="post" name="suche3" target="_self" style="margin-bottom:-1px;">
				<input type="hidden" name="task" value="suche">
				<input name="parent_id" type="hidden" id="parent_id" value="<? echo $parent_id;?>">
				<select name="number_last_created" title="Suchergebnis auf die jüngsten 10/20/30 Artikel einschränken"onChange="if(this.value == 'edit'){} else {document.forms['suche3'].submit()}">
					<option value='edit'>Die letzten n Artikeln</option>
					<option <? if($number_last_created==10){echo "selected";}?> value="10">Die letzten 10 Artikeln</option>
					<option <? if($number_last_created==20){echo "selected";}?> value="20">Die letzten 20 Artikeln</option>
					<option <? if($number_last_created==30){echo "selected";}?> value="30">Die letzten 30 Artikeln</option>
				</select>
			</form>
		</td>
		<td align="center">
			<p><input type="button" value="Home" onClick="parent.location=('menu.php?men_id=<? echo $home_menu_id;?>')">
			</p><p>
			<input type="button" value="Abmelden" onClick="parent.location=('/site_12_1/admin/Login.php?kill_session=1')">
			</p>
		</td>
	</tr>
</table>
<table border="0" width="1660">
	<tr border="1" bordercolor="#00008B" bgcolor="<? echo $Seitenfarbe;?>" style="height:36px;" > 
		<? if($back_id!=$home_menu_parent and $task!="suche"){///////////Wenn es eine höhere Ebene gibt, aber nicht in der Suche?>
			<td colspan="18">
				<div align="center" style="font:Arial, Helvetica, sans-serif; font-size:14pt; color:#ffffff; height:22px"><? echo $Seitentitel;?>
				<? if(test_right($_SESSION['user'],"share_menu_ids")=="true" and $task!="suche" and mysql_num_rows($site_avail_q)>0){?><a href='menu.php?sharing_id_add_all=<? echo $men_id.$navstring;?>'><img title="Das Sharing für alle Seiten und Subseiten von <? echo "'".$parent_desc."'";?> managen." style="width:15px;position:relative; top:2px" src="/site_12_1/css/share-this-icon.png"></a><? }?></div>
			</td>	
		<? }
		if($task=="suche"){///////////Suchergebnisse?>
			<td colspan="19">
				<div align="center" style="font:Arial, Helvetica, sans-serif; font-size:14pt; color:#ffffff; height:22px"><? echo $Seitentitel;?></div>
			</td>	
		<? }?>
		<? if($back_id==$home_menu_parent and $task!="suche"){?>
			<td colspan="14">
				<div align="center" style="font:Arial, Helvetica, sans-serif; font-size:14pt; color:#ffffff; height:22px"><? echo $Seitentitel;?></div>
			</td>
			
			<td width="50" style="background-color:#FFFFFF; text-align:center">
				<? if(test_right($_SESSION['user'],"enter_page_content")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($home_menu_id)))and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($home_menu_id)==$site_id)){
					?>
					<a href='/site_12_1/admin/admin_V1.php?menu_id=<? echo $home_menu_id;?>'>
						<img border="0"src="/site_12_1/css/edit_page2.png" title="Startseite zum Bearbeiten aufrufen">
					</a>
				<? } else {?><img border="0" src="/site_12_1/css/edit_page2_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten der Seite."><? }?>	
			</td>
			
			<td width="50" style="background-color:#FFFFFF; text-align:center">
				<? if(test_right($_SESSION['user'],"edit_seitencontent")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($home_menu_id)))and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($home_menu_id)==$site_id)){?>
					<?
					$seitencontent_exist_query=mysql_query("select count(1) as Anz, exklusiver_seitencontent from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id='$home_menu_id' and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob seitencontentelemente bestehen
					$elements_anzahl=mysql_fetch_row($seitencontent_exist_query);
					if ($elements_anzahl[0] == 0){/////Keine rechte Spalte gefunden?>
						<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo $home_menu_id;?>'>
						<img border="0" src="/site_12_1/css/Seitencontent_fehlt.png" title="Rechten Spalte anlegen">
						</a>
					<? }
					elseif($elements_anzahl[0] > 0){//////Rechte Spalte existiert?>
						<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo $home_menu_id;?>'>
						<img border="0" src="/site_12_1/css/edit_page2_seitencontent.png" title="Seite zum Bearbeiten der rechten Spalte aufrufen">
						</a>
					<? }
				} else {?><img border="0" src="/site_12_1/css/edit_page2_seitencontent_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten der rechten Spalte."><? }?>
			</td>
			
			<td width="100" style="background-color:#FFFFFF; text-align:center">
				<? if(test_right($_SESSION['user'],"edit_sponsorbanner")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($home_menu_id)))and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($home_menu_id)==$site_id)){?>
					<?
					$elements_exist_query=mysql_query("select count(1) as Anz, exklusiver_sponsorbanner from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$home_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob sponsorbannerelemente bestehen
					$elements_anzahl=mysql_fetch_assoc($elements_exist_query);
					if ($elements_anzahl[Anz] == 0){/////Keine Sponsorenbanner gefunden?>
						<a href='menu.php?sponsortask=create_sponsorbanner&menu_id=<? echo $home_menu_id;?><? echo $navstring;?>' style="text-decoration:none">
						<img border="0" src="/site_12_1/css/Seitencontent_fehlt.png" title="Sponsorbanner anlegen">
						</a>
					<? }
					elseif($elements_anzahl[Anz] > 0){//////Sponsorenbanner existiert?>
						<div style="height:18px; overflow:hidden; "><a href='menu.php?sponsortask=edit_sposorbanner&menu_id=<? echo $home_menu_id;?><? echo $navstring;?>' style="text-decoration:none">
						<img border="0" src="/site_12_1/css/Sponsorbanner_edit.png" title="Sponsorbanner Einstellungen aufrufen">
						</a></div>
						<div style="height:18px; overflow:hidden; "><a href='menu.php?sponsortask=delete_sponsorbanner&menu_id=<? echo $home_menu_id;?><? echo $navstring;?>' style="text-decoration:none" >
						<img border="0" src="/site_12_1/css/Sponsorbanner_del.png" title="Sponsorbanner löschen">
						</a></div>
	
					<? }
				}  else {?><img border="0" src="/site_12_1/css/Sponsorbanner_edit_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten des Sponsorbanners."><? }?>	
			</td>
			<td colspan="2"></td>
		<? }?>
		<? if($back_id!=$home_menu_parent and $task!="suche" and test_right($_SESSION['user'],"enter_changemother")=="true" and ((test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($men_id))) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($men_id)==$site_id))){?>
			<td align="center" style="height:36px; background-color:#FFFFFF">
				<a href='menu.php?changemultimother_id=<? echo "$men_id".$navstring;?>'>Change mother multi</a>
			</td>
		<? }?>
		<? if($back_id!=$home_menu_parent and $task!="suche" and $changemultimother_id!="" and test_right($_SESSION['user'],"enter_changemother")=="true" and ((test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($men_id))) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($men_id)==$site_id))){?>
			<td align="center" style="height:36px; background-color:#FFFFFF">
					<td  colspan="19">
						<table width="100%" border="0" class="no_border">
							<tr>
								<td width="700" height="16"><strong>Change Mother</strong><br><br>Die Zuordnung aller hier gezeigten Men&uuml;s wird ge&auml;ndert. <br>
						Davon betroffen sind nicht nur die ausgew&auml;hlte sondern auch alle darunterliegenden Men&uuml;s. <br>
						<br><strong>Aktuelle Mother:</strong><br>
								<? echo find_description($men_id);
								echo "(".$men_id.")";
								?>
								<br>
								<br>
								<strong>Neue Mother: </strong>
								<form name="form1" method="post" action="menu.php?men_id=<? echo $men_id.$navstring;?>">
									<select name="newmultimother" id="newmultimother">
										<option value="">bitte auswählen....</option>
										<option value="<? echo $home_menu_id;?>">home</option>
										<?
										$resultx_ids=menu_select($home_menu_id,"down",4,0,1,1);
										for($i=0;$i<count($resultx_ids['id']);$i++)
										{
											echo"<option value=".$resultx_ids['id'][$i];
											if($resultx_ids['level_down'][$i]==0){echo " style='font-weight:bold;color:#F00;'";}
											if($resultx_ids['level_down'][$i]==1){echo " style='font-weight:bold'";}
											if($resultx_ids['level_down'][$i]==3){echo " style='font-style:italic'";}
											echo ">".str_repeat("&nbsp;",$resultx_ids['level_down'][$i]*2)."-".$resultx_ids['description'][$i]."</option>";
										}?>
									</select>
									<input type="submit" value="Speichern" name="submit">
									<input name="changemother_ids" type="hidden" value="<? 
										mysql_data_seek($result, 0);
										while ($changemother_ids_r=mysql_fetch_assoc($result))
										{
											$changemother_ids[]=$changemother_ids_r[id];
											$changemother_description[]=$changemother_ids_r[description];
										}
										$changemother_ids=implode(",",$changemother_ids);
										$changemother_descriptions=implode("|~|",$changemother_description);
										echo $changemother_ids;										
										?>">
									<input name="donewmultimother" type="hidden" id="donewmultimother" value="1">
									<input name="changemother_descriptions" type="hidden" id="changemother_descriptions" value="<? echo $changemother_descriptions;?>">
								</form>
								<br><br>
								</td>
								<td valign="top"><a href='menu.php?<? echo $navstring;?>'>CLOSE Change Mother Anzeige</a></td>
							</tr>
						</table>
					</td>
			</td>
			<? }?>
		<? if($back_id!=$home_menu_parent and $task!="suche"){?><td align="center" style="height:36px; background-color:#FFFFFF"><a href="menu.php?men_id=<? echo $back_id;?>"><img border="0" src="/site_12_1/css/button_menu.png" title="Eine Ebene höher"></a></td><? }?>
	</tr>
		<? if($sponsortask=='edit_sposorbanner' and $menu_id==$home_menu_id and $task!="suche" and test_right($_SESSION['user'],"edit_sponsorbanner")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($home_menu_id)))and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($home_menu_id)==$site_id))   /////////////Sponsorenbanner edit f Hauptseite
		{?>
			<tr>
				<td colspan="19"><strong>Edit Sponsorbanner</strong><br><a href='menu.php?<? echo $navstring;?>'>CLOSE Sponsorbanner</a><br>
					<?php 
					if($menu_id!=""){
						$sponsorbanner_element_layout_id_query=mysql_query("select id, php_admin_snippet from element_layout where type like '%sponsorbanner%'");
						$sponsorbanner_element_layout_id_result=mysql_fetch_assoc($sponsorbanner_element_layout_id_query);
						$sponsorbanner_element_layout_id=$sponsorbanner_element_layout_id_result[id];
						$sponsorbanner_element_layout_path=$sponsorbanner_element_layout_id_result[php_admin_snippet];
						
						$sponsorbanner_query=mysql_query("select element.id from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id")or die(mysql_error());
						$sponsorbanner_num_rows=mysql_num_rows($sponsorbanner_query);
						if($sponsorbanner_num_rows > 0){
							$sponsorbanner=mysql_fetch_assoc($sponsorbanner_query);
							$kampagne_element_id=$sponsorbanner[id];
							$element_layout_id[$kampagne_element_id]=$sponsorbanner_element_layout_id;
							//echo $kampagne_element_id."<br>";
							//echo $element_content_id[$kampagne_element_id]."<br>";
							
							include"site_12_1/$sponsorbanner_element_layout_path";					
						}
					}?>				
				</td>
			</tr>
		<? }//Ende Edit Sponsorbanner
		if (($sharing_id_add_multi=="$men_id" or $sharing_id_add_all=="$men_id") and $task!="suche" and test_right($_SESSION['user'],"share_menu_ids")=="true")
		{
		?>
			<tr>
				<td colspan="19"><strong>Manage multi sharing</strong><br><a href='menu.php?<? echo $navstring;?>'>CLOSE multi sharing<br></a><br>
						<form method="post" target="_self" name="menu_pool_config">
							<? 
							if($sharing_id_add_all=="$men_id")
							{$zeilenids=menu_select($men_id,"down",99,"","","");}
							else
							{$zeilenids=menu_select($men_id,"down",1,"","","");}
							$zeilenids_count=count($zeilenids[id]);
							if($zeilenids_count>0)
							{
								for($ii=0;$ii<$zeilenids_count;$ii++)
								{
									$test_zeilenid=$zeilenids[id][$ii];
									$block_sharing_q=mysql_query("select Sum(block_sharing) as Anz from sites, element, element_layout,menu where sites.id=menu.master_site_id and menu.id=element.menu_id and menu_id=$test_zeilenid and element.element_layout_id=element_layout.id") or die (mysql_error());
									$block_sharing_r=mysql_fetch_assoc($block_sharing_q);
									if($block_sharing_r[Anz]>0)
									{unset($zeilenids[id][$ii]);}
								}
								$zeilenids_count=count($zeilenids[id]);
								if($zeilenids_count>0)
								{$zeilenids=implode("|",$zeilenids['id']);}else {$zeilenids="blank";}
							}
							?>
							<table>
							<tr>
							<?
							while($site_avail_r=mysql_fetch_assoc($site_avail_q))
							{?>
								<td>
								<input type="button" <? $site_avail=$site_avail_r[id];?>
									onclick="add_share_multi(<? echo $site_avail.",'".$zeilenids."','".$site_avail_r[description]."'";?>)"
									id="share_multi" value='<? echo "add ".$site_avail_r[description];?>' style="width:100%"/>
								</td>
								<td>
								<input type="button" <? $site_avail=$site_avail_r[id];?>
									onclick="remove_share_multi(<? echo $site_avail.",'".$zeilenids."','".$site_avail_r[description]."'";?>)"
									id="share_multi" value='<? echo "remove ".$site_avail_r[description];?>' style="width:100%"/>
								</td>
							<? echo "</tr>"; }?>
							</table>
						</form>
						<? 
						if(mysql_num_rows($site_avail_q)>0){mysql_data_seek($site_avail_q,0);}
						//unset($menu_pool_avail_keys);
						$i=0;?>
				</td>
			</tr>
		<?
		} //Ende Sharing ID ?>
</table>
<table <? if($task!="suche"){?>id="menutable" class="tablesorter-ice" <? }?> border="0" width="1660" >
	<thead>
		<tr style="background-color: <? echo $color_button_bg;?>; color:#ffffff; height:36px;margin-left:10px; text-align:center; vertical-align:middle;"> 
			<th width="50">ID</th>
			<th width="350">Men&uuml;-Titel</th>
			<th style="max-width:190px" width="190">
				Master
				<? if(test_right($_SESSION['user'],"share_menu_ids")=="true" and $task!="suche" and mysql_num_rows($site_avail_q)>0){?><a href='menu.php?sharing_id_add_multi=<? echo $men_id.$navstring;?>'><img title="Das sharing für alle hier gezeigten Seiten verwalten." style="width:15px;padding-right:15px; float:right;" src="/site_12_1/css/share-this-icon.png"></a><? }?>
			</th>
			<th width="85">Sort</th>
			<th width="85">Menü?</th>
			<th width="85">Aktiv</th>
			<th width="85">Start</th>
			<th width="85">Ende</th>
			<th width="85">Search Group</th>
			<th width="50">Meta Tags</th>
			<th width="50">Google URLs</th>
			<th width="50">Change Mother</th>
			<th width="50">Level down</th> 
			<th width="50">View</th>
			<th width="50">Edit<br>Site</th>
			<th width="75">Rechte Spalte</th> 
			<th width="75">Sponsor-banner</th> 
			<th width="50">L&ouml;schen</th> 
			<th width="50">Dupl.</th> 
		</tr>
	</thead>
	<tbody>
	<?
	/// Einlesen der Menu-Daten mit der vorgegebenen Parent-Id
	if($result_num_rows>0 and $target_ids!="blank")
	{
		mysql_data_seek($result, 0);
		while ($ergebnis=mysql_fetch_object($result))
		{
			$master_site_q=mysql_query("select sites.id, sites.description, Sum(block_sharing) as Anz from sites, element, element_layout where sites.id=$ergebnis->master_site_id and menu_id=$ergebnis->id and element.element_layout_id=element_layout.id") or die (mysql_error());
			$master_site_r=mysql_fetch_assoc($master_site_q);

			$zeilenid=$ergebnis->id;
			$menu_hierarchy_id=$ergebnis->menu_hierarchy_id;
			$edit_page=((test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($ergebnis->id))) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or $master_site_r[id]==$site_id));
			if($task=="suche"){?>
				<tr>
					<td colspan=19 style="height:18px;">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="19" style="padding-top:5px; padding-bottom:4px; background-color:<? echo $color_breadcrums_bg?>;">
						<? echo whereami("admin",$ergebnis->id);?>
					</td>
				</tr>
			<? }
			?>
			<tr border="1" bordercolor="#00008B" bgcolor="#ffffff" align="center" valign="middle" cellspacing="0" cellpadding="0" > 
				<form name="menuliste_<? echo $zeilenid;?>" method="post" action="menu.php?<? echo $navstring?>">
					<td>
						<? echo "$ergebnis->id";///Zeigt die ID an.?>
						<div style="width: 40px; margin-left:5px; margin-right: 5px">
							<? ///Hier beinnen die Markierungen der ID. 
							////Das "Ist nicht Aktiv-Warndreieck"
							if($ergebnis->active=="A" and (($ergebnis->active_startdate<$date or $ergebnis->active_startdate=="0000-00-00") and ($ergebnis->active_enddate>$date or $ergebnis->active_enddate=="0000-00-00"))){} 
							else {?> <div style="height:17px; float:left; padding-top:1px;" title="ACHTUNG: Dieser Eintrag ist nicht aktiv, oder nicht im freigeschaltenen Datumsbereich."><img border="0" src="/site_12_1/css/Attention_small.png" height="16px"/></div><? }
							
							////"Ist Teil einer Übersichtsseite"-Flag
							$onteaser=mysql_query("select count(1) from menu_hierarchy where site_id=$site_id and menu_hierarchy.menu_id in (select menu_id from element, (select element_id from element_content_menu where menu_id=$zeilenid) as menu_teaser where menu_teaser.element_id=element.id) and menu_hierarchy.active='A' and ((menu_hierarchy.active_startdate<now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>now() or menu_hierarchy.active_enddate='0000-00-00'))")or die("Übersichtsseiten-icon: ".mysql_error());
							$onteaser_result=mysql_fetch_row($onteaser);
							if($onteaser_result[0]>0)
							{
								if($onteaser_result[0]==1){$onteaser_text="Dieser Eintrag wird auf einer aktiven Übersichtsseite angezeigt.";}
								if($onteaser_result[0]>1){$onteaser_text="Dieser Eintrag wird auf ".$onteaser_result[0]." aktiven Übersichtsseiten angezeigt.";}					
								?> <div style="height:17px; float:right; padding-top:1px;" title="<?php echo $onteaser_text;?>"><img border="0" src="/site_12_1/css/megafon.png" height="16px"/></div><? }			
	
							////Hier ist das "missing meta"-Flag
							if(($ergebnis->metatag_title=="" or $ergebnis->metatag_keywords=="" or $ergebnis->metatag_description=="") and $ergebnis->search_type!='Subseiten')
							{?> <div style="height:17px; float:right; padding-top:1px;" title="ACHTUNG: Dieser Eintrag hat nicht vollständig ausgefüllte Metatags."><img border="0" src="/site_12_1/css/Meta.jpg" height="17px"/></div><? }?>
	
	
						</div>
					</td>
					<td style="width:350px; text-align:left;">
							<input style="width:295px;" name = "titel" title="description" id="<? echo $zeilenid; ?>"type="text" align="left" value="<? echo "$ergebnis->description";?>" onBlur="document.forms['menuliste_<? echo $zeilenid;?>'].submit()" <? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_description")=="true" ){}else{echo "disabled";}?>> 
							<input name = "titel_curr" type="hidden" value="<? echo "$ergebnis->description";?>">
							<? 
						if($ergebnis->page_finished==1){ /////Hier kommen die "Seite in Bearbeitung Flags"?>
							<a style="width:23px; overflow:hidden; float:right"><img border="0" id="<? echo 'page_finished'.$ergebnis->id ?>" src="/site_12_1/css/Seitencontent_OK.png" width="23" title="Die Seite ist fertiggestellt." <? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and $edit_page){echo "onClick='update_page_finished($ergebnis->id,0)'";}?>></a>
							<? }?>
							<? 
						if($ergebnis->page_finished==0){ /////Hier kommen die "Seite in Bearbeitung Flags"?>
							<a style="width:23px; overflow:hidden; float:right"><img border="0" id="<? echo 'page_finished'.$ergebnis->id ?>" src="/site_12_1/css/Seitencontent_fehlt.png" width="23" title="Die Seite ist noch in Arbeit." <? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and $edit_page){echo "onClick='update_page_finished($ergebnis->id,1)'";}?>></a>
						<? }?>					
				<div style="font-size:9px; color:#999999; padding-left:1px;"><? echo"$ergebnis->pagetype";?></div>
					</td>
					<td style="max-width:200px; t">
						<?
						echo $master_site_r[description];
						if (test_right($_SESSION['user'],"share_menu_ids")=="true" and $master_site_r[id]!=$site_id) // Der Artikel ist von einem anderen Magazin.
						{?><img title="Sie sind nicht der Herausgeber dieses Artikels." style="width:15px;float:right;" src="/site_12_1/css/share-this-icon_disabled.png"><? }
						else{
							if(test_right($_SESSION['user'],"share_menu_ids")=="true" and $master_site_r[Anz]>0){?><img title="Dieser Artikel kann nicht geshared werden, weil ein verwendeted Element un-shareable ist." style="width:15px;float:right;" src="/site_12_1/css/share-this-icon_disabled.png"><? }//use of an block_sharing element.
							else{
								if (test_right($_SESSION['user'],"share_menu_ids")=="true" and $master_site_r[id]==$site_id and mysql_num_rows($site_avail_q)==0) //keine sharing site assoziiert.
								{?><img title="Es gibt kein Magazin mit dem Artikel geshared werden können." style="width:15px;float:right;" src="/site_12_1/css/share-this-icon_disabled.png"><? }
								else{
									if (test_right($_SESSION['user'],"share_menu_ids")=="true" and $master_site_r[id]==$site_id and mysql_num_rows($site_avail_q)>0)//es wird geshared.
									{?><a href='menu.php?sharing_id=<? echo "$ergebnis->id".$navstring;?>'><img title="Angeben, mit welchen Magazinen dieser Artikel geshared werden darf." style="width:15px;float:right;" src="/site_12_1/css/share-this-icon.png"></a><? }
								}
							}
						}?>
					</td>
					<td>
						<input name="menu_hierarchy" title="sort" id="<? echo $menu_hierarchy_id; ?>" type="text" size="5" style="text-align:center" value="<? echo "$ergebnis->sort";?>" onBlur="update_menu_data(this,'',1)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_sort")=="true"){}else{echo "disabled";}?>> 
					</td>
					<td align="center"> 
						<select name="menu_hierarchy" title="display" id="<? echo $menu_hierarchy_id; ?>" style="text-align:center" onChange="update_menu_data(this,'',1)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_display_status")=="true"){}else{echo "disabled";}?>>
							<option value="0" <? if ($ergebnis->display=="0"){echo "selected";}?>>Nein</option>
							<option value="1" <? if ($ergebnis->display=="1"){echo "selected";}?>>Ja</option>
						</select>
					</td>
					<td align="center"> 
						<select name="menu_hierarchy" title="active" id="<? echo $menu_hierarchy_id; ?>" style="text-align:center" onChange="update_menu_data(this,'',1)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_active_status")=="true"){}else{echo "disabled";}?>>
							<option value="A" <? if ($ergebnis->active=="A"){echo "selected";}?>>Aktiv</option>
							<option value="D" <? if ($ergebnis->active=="D"){echo "selected";}?>>Deaktiv</option>
						</select>
					</td>
					<td><input name="menu_hierarchy" title="active_startdate" id="<? echo $menu_hierarchy_id; ?>" type="text" size="10" style="text-align:center" value="<? echo "$ergebnis->active_startdate";?>" onBlur="update_menu_data(this,'',1)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_active_dates")=="true"){}else{echo "disabled";}?>></td>
					<td><input name="menu_hierarchy" title="active_enddate" id="<? echo $menu_hierarchy_id; ?>" type="text" size="10" style="text-align:center" value="<? echo "$ergebnis->active_enddate";?>" onBlur="update_menu_data(this,'',1)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_active_dates")=="true"){}else{echo "disabled";}?>></td>
					<td>
						<select name="menu" title="search_type" <? if ($ergebnis->search_type == "" or !$ergebnis->search_type or $ergebnis->search_type =="Gruppe ausw."){echo "style='border-color:#F00;border-width:2px;text-align:left;'";} else {if($ergebnis->search_type =="Artikel" or $ergebnis->search_type =="Subseiten"){echo "style='text-align:left'";}else{echo "style='text-align:left; font-weight:bold;'";}}?> id="<? echo $zeilenid; ?>" onChange="update_menu_data(this)"<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"edit_searchgroup")=="true"){}else{echo "disabled";}?>>
							<option value="">Gruppe ausw.</option>
							<? while($searchtype_result=mysql_fetch_row($searchtype_query))
							{
								if ($searchtype_result[0]==$ergebnis->search_type)
								{echo "<option selected value='$searchtype_result[0]'>$searchtype_result[0]</option>";}
								else {echo "<option value='$searchtype_result[0]'>$searchtype_result[0]</option>";}
							}
							?>
						</select>
						<? mysql_data_seek($searchtype_query,0)?>
					</td>
					<td><? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"enter_metatags")=="true"){?><a href='menu.php?meta_id=<? echo "$ergebnis->id".$navstring;?>'>Meta</a><? }else {echo "<a style='color:gray'>Meta</a>";}?></td>
					<td><? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"enter_googleurls")=="true"){?><a href='menu.php?googleurl_id=<? echo "$ergebnis->id".$navstring;?>'>URLs</a><? }else {echo "<a style='color:gray'>URLs</a>";}?></td>
					<td><? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page) and test_right($_SESSION['user'],"enter_changemother")=="true"){?><a href='menu.php?changemother_id=<? echo "$ergebnis->id".$navstring;?>'>Mother</a><? }else {echo "<a style='color:gray'>Mother</a>";}?></td>
					<td><a href="menu.php?men_id=<? echo $ergebnis->id;?>"><img border="0" src="/site_12_1/css/button_detail.png" title="Nächste Ebene"></a></td>
					<td><a href="<? echo find_googleurl($ergebnis->id);?>"><img border="0" src="/site_12_1/css/preview.gif" title="Seite ansehen"></a></td>
					<td align="right">
						<? if(test_right($_SESSION['user'],"enter_page_content")=="true" and ($edit_page)){?>
							<a href='/site_12_1/admin/admin_V1.php?menu_id=<? echo"$ergebnis->id";?>'>
								<img border="0" src="/site_12_1/css/edit_page2.png" title="Seite zum Bearbeiten aufrufen">
							</a>
						<? }
						else{?><img border="0" src="/site_12_1/css/edit_page2_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten der Seite."><? }?>
					</td>
					<td>			
						<? if(test_right($_SESSION['user'],"edit_seitencontent")=="true" and ($edit_page)){?>
							<? /////////Seitencontent
							$test_menu_id=$ergebnis->id;
								do{
									$elements_exist_query=mysql_query("select count(1) as Anz, exklusiver_seitencontent from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id=$test_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob seitencontentelemente bestehen
									$elements_anzahl=mysql_fetch_assoc($elements_exist_query);
									$test_menu_id_parent = find_parent($test_menu_id);
									if ($elements_anzahl[Anz] == 0 or ($elements_anzahl[exklusiver_seitencontent]==1 and $test_menu_id!=$ergebnis->id))
									{$test_menu_id = $test_menu_id_parent;}
									else {$used_menu_id=$test_menu_id;break;}								
								} while ($test_menu_id > 0);
							?>
						
							<? if($used_menu_id==""){ /////Keine rechte Spalte gefunden?>
								<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo"$ergebnis->id";?>' style="text-decoration:none">
								<img border="0"  src="/site_12_1/css/Seitencontent_fehlt.png" title="Rechten Spalte anlegen">
								</a>
							<? }
							elseif($used_menu_id==$ergebnis->id){//////Rechte Spalte ist direkt auf der Menu ID (nicht geerbt)?>
								<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo"$ergebnis->id";?>' style="text-decoration:none">
								<img style="width:34px; float:left;" border="0"  src="/site_12_1/css/edit_page2_seitencontent.png" title="Seite zum Bearbeiten der rechten Spalte aufrufen">
								</a>
							<? }
							else{?>
								<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo $used_menu_id;?>' style="text-decoration:none" >
								<img border="0"  src="/site_12_1/css/edit_page2_seitencontent_halb.png" title="Seite zum Bearbeiten der rechten Spalte aufrufen">
								</a>
								<a href='/site_12_1/admin/seitencontent_admin_V1.php?menu_id=<? echo "$ergebnis->id";?>' style="text-decoration:none" >
								<img border="0"  src="/site_12_1/css/edit_page2_seitencontent_add_halb.png" title="Eigene rechte Spalte anlegen">
								</a>
							<? }?>
							
							<? 
							if($used_menu_id==$ergebnis->id){
								if($ergebnis->exklusiver_seitencontent==1){ /////Hier kommen die PINs: Wenn die Menu ID auch selbst einen Inhalt hat (also nicht vererbt wurde).?>
									<img style="float:right;" border="0"  id="<? echo 'exkl_seitenc'.$ergebnis->id ?>" src="/site_12_1/ss/Pin_unten.jpg" title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Seitencontent wieder vererbt." onClick="update_exklusiver_seitencontent(<? echo "$ergebnis->id";?>,0);">
								<? }
								   if($ergebnis->exklusiver_seitencontent==0){ /////Hier kommen die PINs: Wenn die Menu ID NICHT selbst einen Inhalt hat (also wenn der Inhalt vererbt wurde).?>
									<img style="float:right;" border="0"  id="<? echo 'exkl_seitenc'.$ergebnis->id ?>" src="/site_12_1/css/Pin_oben.jpg" title="Der Inhalt wird weitervererbt. Bei clicken wird der Seitencontent exklusiv f. diese eine Seite." onClick="update_exklusiver_seitencontent(<? echo "$ergebnis->id";?>,1);">
								<? }
							}
							$used_menu_id="";
						}
						else
						{?><img border="0" src="/site_12_1/css/edit_page2_seitencontent_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten der rechten Spalte."><? }?>
					</td>
					<td>
						<? if(test_right($_SESSION['user'],"edit_sponsorbanner")=="true" and ($edit_page)){?>
							<? /////////Sponsorenbanner
							$test_menu_id=$ergebnis->id;
								do{
									$elements_exist_query=mysql_query("select count(1) as Anz, exklusiver_sponsorbanner from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$test_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob sponsorbannerelemente bestehen
									$elements_anzahl=mysql_fetch_assoc($elements_exist_query);
									$test_menu_id_parent = find_parent($test_menu_id);
									if ($elements_anzahl[Anz] == 0 or ($elements_anzahl[exklusiver_sponsorbanner]==1 and $test_menu_id!=$ergebnis->id))
									{$test_menu_id = $test_menu_id_parent;}
									else {$used_menu_id=$test_menu_id;break;}								
								} while ($test_menu_id > 0);
							?>
						
							<? if($used_menu_id==""){ /////Keinen Sponsorbanner gefunden?>
								<a href='menu.php?sponsortask=create_sponsorbanner&menu_id=<? echo"$ergebnis->id".$navstring;?>' style="text-decoration:none">
								<img border="0"  src="/site_12_1/css/Seitencontent_fehlt.png" title="Sponsorbanner anlegen">
								</a>
							<? }
							elseif($used_menu_id==$ergebnis->id){//////Sponsorbanner ist direkt auf der Menu ID (nicht geerbt)?>			
								<div style="height:18px; overflow:hidden; float:left; padding-left:5px;"><a href='menu.php?sponsortask=edit_sposorbanner&menu_id=<? echo"$ergebnis->id".$navstring;?>' style="text-decoration:none">
								<img border="0"  src="/site_12_1/css/Sponsorbanner_edit.png" title="Sponsorbanner Einstellungen aufrufen">
								</a></div>
								<? 
								if($ergebnis->exklusiver_sponsorbanner==1){ /////Hier kommen die PINs: Wenn die Menu ID auch selbst einen Inhalt hat (also nicht vererbt wurde).?>
									<div style="overflow:hidden; float:right"><img border="0"  id="<? echo 'exkl_sponsor'.$ergebnis->id ?>" src="/site_12_1/css/Pin_unten.jpg" title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Sponsorbanner wieder vererbt." onClick="update_exklusiver_sponsorbanner(<? echo "$ergebnis->id";?>,0);"></div>
								<? }
								   if($ergebnis->exklusiver_sponsorbanner==0){ /////Hier kommen die PINs: Wenn die Menu ID NICHT selbst einen Inhalt hat (also wenn der Inhalt vererbt wurde).?>
									<div style="overflow:hidden; float:right"><img border="0"  id="<? echo 'exkl_sponsor'.$ergebnis->id ?>" src="/site_12_1/css/Pin_oben.jpg" title="Der Inhalt wird weitervererbt. Bei clicken wird der Sponsorbanner exklusiv f. diese eine Seite." onClick="update_exklusiver_sponsorbanner(<? echo "$ergebnis->id";?>,1);"></div>
								<? }
								/////Und jetzt noch löschen...?>
								<div style="height:18px; overflow:hidden; float:left; padding-left:5px;"><a href='menu.php?sponsortask=delete_sponsorbanner&menu_id=<? echo"$ergebnis->id".$navstring;?>' style="text-decoration:none" >
								<img border="0"  src="/site_12_1/css/Sponsorbanner_del.png" title="Sponsorbanner löschen">
								</a></div>
							<? }
							else{?>
								<div style="height:18px; overflow:hidden; "><a href='menu.php?men_id=<?php if($test_menu_id_parent==0){echo $home_menu_id;}else{echo $test_menu_id_parent;} ?>&sponsortask=edit_sposorbanner&menu_id=<? echo"$used_menu_id";?>' style="text-decoration:none">
								<img border="0"  src="/site_12_1/css/Sponsorbanner_edit_inh.png" title="Gehe zum Eintrag, wo der Sponsorbanner erstellt wurde">
								</a></div>
								
								<div style="height:18px; overflow:hidden; "><a href='menu.php?sponsortask=create_sponsorbanner&menu_id=<? echo"$ergebnis->id".$navstring;?>' style="text-decoration:none">
								<img border="0"  src="/site_12_1/css/Sponsorbanner_add.png" title="Eigenen Sponsorbanner anlegen">
								</a></div>
							<? }$used_menu_id="";?>
						
						
						<div style="clear:both;"></div>	
						<? } else {?><img border="0" src="/site_12_1/css/Sponsorbanner_edit_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Bearbeiten des Sponsorbanners."><? }?>			
					</td>
					<td>
						<? if(test_right($_SESSION['user'],"delete_menu")=="true" and ($edit_page)){
							if($master_site_r[id]!=$site_id){?>
								<a href="menu.php?task=rem_share&rem_id=<? echo $ergebnis->id.$navstring;?>&timestamp=<? echo microtime();?>"><img border="0"  src="/site_12_1/css/stop_sharing.png" title="Der gesharte Eintrag wird entfernt (der Originaleintrag wird nicht gelöscht)"></a>
							<? }
							else{
								$count_menu_use_q=mysql_query("select count(1) as Anz from menu_hierarchy where site_id!=$site_id and menu_id=$zeilenid");
								$count_menu_use_r=mysql_fetch_assoc($count_menu_use_q);
								if($count_menu_use_r['Anz']>0)
								{?><img border="0"  src="/site_12_1/css/button_delete_disabled.png" title="Der Eintrag wird auch von einem anderen Magazin verwendet und kann nicht gelöscht werden."></a><? } 
								else
								{?><a href="menu.php?task=menu_del&del_id=<? echo $ergebnis->id.$navstring;?>&timestamp=<? echo microtime();?>"><img border="0"  src="/site_12_1/css/button_delete.png" title="Eintrag und Seiteninhalte löschen"></a><? }
							}
						} else {?><img border="0" src="/site_12_1/css/button_delete_disabled.png" title="Sie haben nicht die erforderlichen Rechte zum Löschen der Seite."><? }?>		
					</td>
					<td> 
						<? if(test_right($_SESSION['user'],"edit_menu_seitenattribute")=="true" and ($edit_page)){?>
							<input type="hidden" name="formsok" value="1">
							<input type="hidden" name="upd_id" value="<? echo "$ergebnis->id";?>">
						<? } ?>	
					</td>
				</form>
			</tr>
			<?
			if ($meta_id=="$ergebnis->id" and ($edit_page) and test_right($_SESSION['user'],"enter_metatags")=="true")
			{?>
				<tr class="tablesorter-childRow">
					<td colspan="19">
						<form method="post" target="_self">
							<table border="0" class="no_border">
								<tr>
									<td colspan="6" valign="top"><strong>Metatags</strong></td>
								</tr>
								<tr>
									<td width="150" valign="top" > Meta Title:<br><input name = "metatitle" type="text" id="metatitle" value="<? echo $ergebnis->metatag_title;?>" size="20"  align="left"></td>
									<td width="5" valign="top">&nbsp;</td>
									<td width="200" valign="top" >Meta Keywords:<textarea name="metakeywords" cols="28" rows="5" id="metakeywords" align="left"><? echo "$ergebnis->metatag_keywords";?></textarea><br>(mit Komma getrennt)</td>
									<td width="5" valign="top">&nbsp;</td>
									<td width="200" valign="top" >Meta Description:
										<input name="metaupdate" type="hidden" id="metaupdate" value="1">
										<textarea name="metadescription" cols="28" rows="5" id="metadescription" align="left"><? echo "$ergebnis->metatag_description";?></textarea>
									</td>
									<td width="450" align="center" valign="middle" >
										<input type="submit" value="Speichern" name="submit2">
										<a href='menu.php?<? echo $navstring;?>'>CLOSE META</a>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr><? }///End Metatags ?><?
			if ($googleurl_id=="$ergebnis->id" and ($edit_page) and test_right($_SESSION['user'],"enter_googleurls")=="true")
			{?>
				<tr class="tablesorter-childRow">
					<td  colspan="19"><strong>Zu dem Men&uuml; eingetragene Google URLs </strong>(<a href='menu.php?<? echo $navstring;?>'>CLOSE GoogleUrls Anzeige</a>):<br>
						<br>
						<table width="100%" border="0" class="no_border">
							<tr>
								<td width="20">&nbsp;</td>
								<td>
									<?php 
									$table="googleurl";
									$table_width=600;
									$URL= $_SERVER['PHP_SELF'];
									$Field = 'googleurl';
									
									## hier ist die "add" record funktion, die bei einem refresh aufgreufen wird.
									if($add==1)
									{
										$add=0;
										create_googleurl($ergebnis->description,$zeilenid);
										update_googleurl($zeilenid);
										//mysql_query("INSERT INTO $table (menu_id,googleurl,site_id) VALUES($menu_id_add,'new',$site_id) ") or die(mysql_error());  
									}
									
									##hier frage ich die eigentlichen Daten der Tabelle ab. 
									$query=mysql_query("select id, googleurl from $table where menu_id=$ergebnis->id and site_id=$site_id order by create_date desc");
									$totalRows_value = mysql_num_rows($query);
									if($totalRows_value>0){
										?>
										
										<table id=<? echo $table;?> width=<? echo $table_width; ?> border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>
										
										<?php
										$i=0; ##set the row counter to zero
										do { ?>
											<tr>
												<form id='$table' method="post">
													<td width=<? echo 530;?>>
														<? 
														mysql_data_seek($query, $i); ## points to the value-query and gets the row.
														$row_value = mysql_fetch_row($query);?>
														<!--create a div with a readonly element which has "_div" at the end-->
														<div id="<? echo $Field;?>_<?php echo $row_value[0]; ?>_div" 
															onClick="editField(this,'<?php echo urlencode($row_value[1]); ?>')">
															<?php echo $row_value[1]; ?>
														</div>
														<!--create a field and call it the same as above-->
														<input name="<? echo $Field;?>" type="text" class="hiddenField" style="width:600px;"id="<? echo $Field;?>_<?php echo $row_value[0]; ?>" 
														onBlur="updateField(this,'<? echo $table; ?>',<?php echo $row_value[0]; ?>)" 
														value="<?php echo $row_value[1]; ?>" />
													</td>
													<? if($totalRows_value>1)
													{?>
														<td width=<? echo 70;?>>
															<input name="delete" 
															type="button" 
															onClick="deleteRow(this,'<? echo $table;?>',<? echo $row_value[0]; ?>)" 
															value="delete"/>
														</td> 
													<? }?>
													<td><a href="<? echo $testpfad.$row_value[1]?>">Seite öffnen</a>
													</td>
											   </form>
											</tr>
											<? $i=$i+1; ## increase the counter to the next row.
										} while ($i<$totalRows_value); ?>
										</table>
									<? }?>
									<table id="add" width="600px" border="0">
										<tr>
											<form name="addRecord" method="post" action="<? echo $URL."?googleurl_id=$ergebnis->id".$navstring; ?>">
												<td width="600px">
													<input name="add" type="submit" id="add" value="add">
													<input type="hidden" name="add" value="1">
													<input type="hidden" name="menu_id_add" value="<?php echo $ergebnis->id;?>">
												</td>
											</form>
										</tr>
									</table>
									<?  mysql_free_result($query);?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<? } //ende googleurls 
			if ($changemother_id=="$ergebnis->id" and ($edit_page) and test_right($_SESSION['user'],"enter_changemother")=="true")
			{?>
				<tr class="tablesorter-childRow">
					<td  colspan="19"><strong>Change Mother</strong><br><br>Die Zuordnung des ausgew&auml;hlten Men&uuml;s wird ge&auml;ndert. Davon betroffen ist nicht nur das ausgew&auml;hlte sondern auch alle darunterliegenden Men&uuml;s. Es wird ge&auml;ndert: parentid f&uuml;r sich und darunterliegende und googleurl f&uuml;r sich und darunterliegende.<br>
						<table width="100%" border="0" class="no_border">
							<tr>
								<td width="700" height="16"><strong>Aktuelle Mother:</strong><br>
								<? $resultx = mysql_query("SELECT * FROM menu where id='$ergebnis->parent_id'") or die("Es ist ein Datenbankfehler beim Leser der Tabelle $dbtable im Module page_attribute   aufgetreten ! ");
								while ($ergebnisx=mysql_fetch_object($resultx))
								{echo"$ergebnisx->description ($ergebnisx->url)";}
								?>
								<br>
								<br>
								<strong>Neue Mother: </strong>
								<form name="form1" method="post" action="menu.php?<? echo "changemother_id=$changemother_id".$navstring;?>">
									<select name="newmother" id="newmother">
										<option value="">bitte auswählen....</option>
										<option value="<? echo $home_menu_id;?>">home</option>
										<?
										$resultx_ids=menu_select($home_menu_id,"down",4,1,1,1);
										for($i=0;$i<count($resultx_ids['id']);$i++)
										{
											echo"<option value=".$resultx_ids['id'][$i];
											if($resultx_ids['level_down'][$i]==0){echo " style='font-weight:bold;color:#F00;'";}
											if($resultx_ids['level_down'][$i]==1){echo " style='font-weight:bold'";}
											if($resultx_ids['level_down'][$i]==3){echo " style='font-style:italic'";}
											echo ">".str_repeat("&nbsp;",$resultx_ids['level_down'][$i]*2)."-".$resultx_ids['description'][$i]."</option>";
										}?>
									</select>
									<input type="submit" value="Speichern" name="submit">
									<input name="donewmother" type="hidden" id="donewmother" value="1">
									<input name="mothertitel" type="hidden" id="mothertitel" value="<? echo"$ergebnis->description";?>">
								</form>
								<br><br>
								</td>
								<td valign="top"><a href='menu.php?<? echo $navstring;?>'>CLOSE Change Mother Anzeige</a></td>
							</tr>
						</table>
					</td>
				</tr><? 
			}///ende change mother
			if($sponsortask=='edit_sposorbanner' and $menu_id=="$ergebnis->id" and ($edit_page) and test_right($_SESSION['user'],"edit_sponsorbanner")=="true")
			{?>
				<tr class="tablesorter-childRow">
					<td colspan="19"><strong>Edit Sponsorbanner</strong><br><a href='menu.php?<? echo $navstring;?>'>CLOSE Sponsorbanner</a><br>
						<?php 
						if($menu_id!=""){
							$sponsorbanner_element_layout_id_query=mysql_query("select id, php_admin_snippet from element_layout where type like '%sponsorbanner%'");
							$sponsorbanner_element_layout_id_result=mysql_fetch_assoc($sponsorbanner_element_layout_id_query);
							$sponsorbanner_element_layout_id=$sponsorbanner_element_layout_id_result[id];
							$sponsorbanner_element_layout_path=$sponsorbanner_element_layout_id_result[php_admin_snippet];

							$sponsorbanner_query=mysql_query("select element.id from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id")or die(mysql_error());
							$sponsorbanner_num_rows=mysql_num_rows($sponsorbanner_query);
							if($sponsorbanner_num_rows > 0){
								$sponsorbanner=mysql_fetch_assoc($sponsorbanner_query);
								$kampagne_element_id=$sponsorbanner[id];
								$element_layout_id[$kampagne_element_id]=$sponsorbanner_element_layout_id;
								//echo $kampagne_element_id."<br>";
								//echo $element_content_id[$kampagne_element_id]."<br>";
								
								include"site_12_1/$sponsorbanner_element_layout_path";					
							}
						}?>				
					</td>
				</tr>
			<? }//Ende Edit Sponsorbanner
			if ($sharing_id=="$ergebnis->id" and test_right($_SESSION['user'],"share_menu_ids")=="true")
			{
			?>
				<tr class="tablesorter-childRow">
					<td colspan="19"><strong>Edit Sharing</strong><br><a href='menu.php?<? echo $navstring;?>'>CLOSE Sharing<br></a><br>
							<form method="post" target="_self" name="menu_pool_config">
								<? while($site_avail_r=mysql_fetch_assoc($site_avail_q))
								{?>
									<input type="checkbox" <?
										$site_avail=$site_avail_r[id];
										$menu_pool_avail_q=mysql_query("select id,menu_id, site_id from menu_pool where site_id=$site_avail and menu_id=$zeilenid") or die (mysql_error());
										if(mysql_num_rows($menu_pool_avail_q)>0)
										{
											echo " checked ";
											$menu_pool_used_q=mysql_query("select menu_id, site_id from menu_hierarchy where site_id=$site_avail and menu_id=$zeilenid") or die (mysql_error());
											if(mysql_num_rows($menu_pool_used_q)>0){echo " disabled ";}?>
											onclick="remove_share(<? echo $site_avail.",".$zeilenid;?>)"
										<? }
										else{?>onclick="add_share(<? echo $site_avail.",".$zeilenid;?>)"<? }?>
									id="<? echo $site_avail."|".$zeilenid;?>" />
									<? echo $site_avail_r[description]."<br>";
								}?>
							</form>
							<? 
							if(mysql_num_rows($site_avail_q)>0){mysql_data_seek($site_avail_q,0);}
							//unset($menu_pool_avail_keys);
							$i=0;?>
					</td>
				</tr>
			<?
			} //Ende Sharing ID
		} //Ende Abfrage menu
	}?>
	</tbody>
</table>


<link rel="stylesheet" type="text/css" href="/Connections/tablesorter/css/theme.ice.css"/>
<script>
$(document).ready(function() 
    { 
        $("#menutable").tablesorter({
			headers: 
			{
				0:{}
				,1:{}
				,2:{}
				,3:{}
				,4:{}
				,5:{}
				,6:{}
				,7:{}
				,8:{}
				,9:{sorter:false, filter: false}
				,10:{sorter:false, filter: false}
				,11:{sorter:false, filter: false}
				,12:{sorter:false, filter: false}
				,13:{sorter:false, filter: false}
				,14:{sorter:false, filter: false}
				,15:{sorter:false, filter: false}
				,16:{sorter:false, filter: false}
				,17:{sorter:false, filter: false}
				,18:{sorter:false, filter: false}
			}
			,textExtraction: 
			{
				1:function(node1) {return node1.children[1].value;}
				,3:function(node3) {return node3.childNodes[1].value;}
				,4:function(node4) {return node4.childNodes[1].options[node4.childNodes[1].selectedIndex].text}
				,5:function(node5) {return node5.childNodes[1].options[node5.childNodes[1].selectedIndex].text}
				,6:function(node6) {return node6.childNodes[0].value;}
				,7:function(node7) {return node7.childNodes[0].value;}
				,8:function(node8) {return node8.childNodes[1].options[node8.childNodes[1].selectedIndex].text}
			}
			,widthFixed : true
			,widgets: ["filter"]
			,widgetOptions : {
			  // if true, a filter will be added to the top of each table column; 
			  // disabled by using -> headers: { 1: { filter: false } } OR add class="filter-false" 
			  // if you set this to false, make sure you perform a search using the second method below 
			  filter_columnFilters : true, 
		 
			  // css class applied to the table row containing the filters & the inputs within that row 
			  filter_cssFilter : 'tablesorter-filter', 
		 
			  // add custom filter functions using this option 
			  // see the filter widget custom demo for more specifics on how to use this option 
			  filter_functions : null, 
		 
			  // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately 
			  // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus 
			  filter_hideFilters : false, 
		 
			  // Set this option to false to make the searches case sensitive 
			  filter_ignoreCase : false, 
		 
			  // jQuery selector string of an element used to reset the filters 
			  filter_reset : 'button.reset', 
		 
			  // Delay in milliseconds before the filter widget starts searching; This option prevents searching for 
			  // every character while typing and should make searching large tables faster. 
			  filter_searchDelay : 300, 
		 
			  // Set this option to true to use the filter to find text from the start of the column 
			  // So typing in "a" will find "albert" but not "frank", both have a's; default is false 
			  filter_startsWith : true, 
		 
			  // Filter using parsed content for ALL columns 
			  // be careful on using this on date columns as the date is parsed and stored as time in seconds 
			  filter_useParsedData : true 
		 
			} 
		,sortReset   : true 
		,sortRestart : true
		,emptyTo: 'zero'
		,cssChildRow: "tablesorter-childRow"	
		,debug:false
		//,textExtraction: myTextExtraction
		})
    } 
); 
</script>

<br>
<br>
<br>
<? 
if (test_right($_SESSION['user'],"create_menu")=="true" and $task!="suche")
{?>
	NEUE SEITE HINZUF&Uuml;GEN IM BEREICH: <? echo $parent_desc." (ID: ".$parent_id.")";?> 
	<form name="form" method="post" action="menu.php">
		<table border="0" width="1660">
			<tr class="feldrahmen_normal" style="background-color: <? echo $color_breadcrums_bg;?>; color:#000000; height:36px;text-align:center; vertical-align:middle;"> 
				<td width="350">Men&uuml;-Titel</td>
				<td width="100">Seitentyp</td>
				<td width="85">Sort</td>
				<td width="85">Menü?</td>
				<td width="85">Aktiv</td>
				<td width="85">Start-Datum</td>
				<td width="85">Ende-Datum</td>
				<td width="85">Search Group</td>
				<td width="680">Anlegen</td> 
				<? if (test_right($_SESSION['user'],"share_menu_ids")=="true"){?><td width="70">Vom Pool</td><? }?> 
			</tr>
			<tr border="1" bordercolor="#00008B" bgcolor="#ffffff" align="center" valign="middle" cellspacing="0" cellpadding="0" > 
				<td><input name = "titel2" type="text" size="67" align="left" value=""></td>
				<td  align="center"> 
					<select name="seitentyp">
						<?
						$result = mysql_query("SELECT * FROM pagetype where (available_to like '%,$site_id,%' or available_to is null) group by description")or die("Kann keine Datenbankverbindung herstellen!");
						while ($show=mysql_fetch_object($result))
						{
							echo "<option value='$show->description'>$show->description</option>";
						}
						?>
					</select>
				</td>
				<td align="center"><input name = "menu_ordering2" type="text" style="text-align:center" size=5 maxlengt=3 value=" <? echo $maxsort+10;?>"></td>
				<td align="center"> <select name="display" id="display" style="text-align:center">
					<option value="0">Nein</option>
					<option value="1">Ja</option>
					</select>
				</td>
				<td align="center"> <select name="active" id="active" style="text-align:center">
					<option value="A">Aktiv</option>
					<option value="D" selected>Deaktiv</option>
					</select>
				</td>
				<td align="center"><input name="active_startdate" type="text" id="active_startdate" value="0000-00-00" size="10" /></td>
				<td align="center"><input name="active_enddate" type="text" id="active_enddate" value="0000-00-00" size="10" /></td>
				<td>
					<select name="search_type" style="text-align:left">
						<option value="">Gruppe ausw.</option>
						<? while($searchtype_result=mysql_fetch_row($searchtype_query))
						{echo "<option title='$searchtype_result[1]' value='$searchtype_result[0]'>$searchtype_result[0]</option>";}
						?>
					</select>
				</td>
				<td align="center">
					<input type="image" src="/site_12_1/css/button_add.png" title="Anlegen">
					<input name="eintrag" type="hidden" id="eintrag" value="1">
					<input name="parent_id" type="hidden" id="parent_id" value="<? echo $parent_id;?>">
					<input name="men_id" type="hidden" id="men_id" value="<? echo $men_id;?>">
					<input name="timestamp" type="hidden" value="<? echo microtime();?>">
				</td>
				<? if (test_right($_SESSION['user'],"take_menu_ids_from_pool")=="true"){?>
					<td>
						<?
						/*$menu_pfad_ids=array();
						array_push($menu_pfad_ids,$home_menu_id);
						array_push($menu_pfad_ids,"");
						$menu_pfad_ids=array_reverse($menu_pfad_ids);*/
						$admin_menu_id_selector="/site_12_1/admin/admin_menu_id_selector.php?element_id=".$men_id."&target=menu_pool_init&siteid=$site_id";//&menu_pfad_ids_imploded=".implode("|",$menu_pfad_ids);
						?>
						<img onClick="fenster=window.open('<? echo $admin_menu_id_selector; ?>','popUpWindow','width=1200,height=900,left=400,top=50,scrollbars=yes,statusbar=no,personalbar=no,locationbar=no,menubar=no,location=no')" src="/site_12_1/css/button_next.png" class='$imgs_type' style="cursor:pointer">
						<div id="table_result_error_messages"></div>
					</td>
				<? }?>
			</tr>
		</table>
	</form>
<? }?>
</body>
</html>
