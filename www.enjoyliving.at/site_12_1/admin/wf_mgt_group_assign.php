<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); 

if(test_right($_SESSION['user'],"enter_workflow_admin")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>


<div>
	<div style='width:100%;background-image:url(/site_12_1/css/Element_Tops_Schatten.png);height:34px;background-repeat:repeat-x;'>
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;"><a href="wf_mgt_workflows.php">Workflow anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;font-weight:bolder; text-decoration:underline">Workflow zu Usergroup zuordnen</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="wf_mgt_tasks.php">Tasks anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="user_admin_group_assign.php">Workflow übersicht</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:34px; float:left; text-align:left; padding:3px"><a href="papa/menu.php?men_id=<? echo $home_menu_id;?>"><img src="/site_12_1/css/button_menu.png" title="Zurück zur Menüverwaltung"></a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	</div>
</div>

<div style="clear:left;"> </div>



<?

### get all groups
$groups=mysql_query("select * from user_groups") or die (mysql_error());
$totalRows_groups_recordset = mysql_num_rows($groups);
?>
</head>
<body>
<br />
<table width="100%" border="0"><tr><td width="100%" align="LEFT" valign="TOP" bgcolor="#FFFFFF">
<table border=0>
<tr>
    <td><? if($usergroup and $usergroup!="unselected") {echo "Verfügbare Workflows:";} else {echo "Zuerst Usergruppe auswählen";}?> </td>
    <td>
    </td>
    <td>
    <form method="post" name="form_usergroup">
<select style="width:200px;" name="usergroup" onChange="document.forms['form_usergroup'].submit()">
<option value="unselected">Usergruppe auswählen</option>
<? if($totalRows_groups_recordset > 0)
{while($row = mysql_fetch_assoc($groups))
	{if($row[ID]==$usergroup)
	{echo "<option selected='selected' value=\"$row[ID]\">$row[description]</option>";}
	else {echo "<option value=\"$row[ID]\">$row[description]</option>";}}} 
else {echo "<option>Kein Element vorhanden</option>";}?>
</select> 
</form>


<? if($usergroup and $usergroup!="unselected") {

### zuerst beide Listen abfragen
$wfl_avail=mysql_query("SELECT title FROM wfl_workflows_templates where ID not in (select wfl_workflows_templates_id from wfl_workflow_templates_x_user_groups where user_groups_id ='$usergroup')") or die (mysql_error());
$totalRows_groups_recordset_avail = mysql_num_rows($wfl_avail);

$wfl_assign=mysql_query("SELECT title FROM wfl_workflows_templates where ID in (select wfl_workflows_templates_id from wfl_workflow_templates_x_user_groups where user_groups_id ='$usergroup')") or die (mysql_error());
$totalRows_groups_recordset_assign = mysql_num_rows($wfl_assign);
?>
    </td>
    
</tr>

<tr>
<form>
	<td>
	<select style="width:200px;" name="list1" multiple size=10 ondblclick="opt.transferRight()">
		<? if($totalRows_groups_recordset_avail > 0)
          {while($row = mysql_fetch_assoc($wfl_avail))
     	echo "<option value=\"$row[title]\">$row[title]</option>";} 
		?>
	</select>
	</td>
	<td valign=MIDDLE align=CENTER>

		<input type="button" name="right" value="&gt;&gt;" onClick="opt.transferRight()"><br><br>
		<input type="button" name="right" value="All &gt;&gt;" onClick="opt.transferAllRight()"><br><br>
		<input type="button" name="left" value="&lt;&lt;" onClick="opt.transferLeft()"><br><br>
		<input type="button" name="left" value="All &lt;&lt;" onClick="opt.transferAllLeft()">
	</td>
	<td>
	<select style="width:200px;" name="list2" multiple size=10 ondblclick="opt.transferLeft()">
		<? if($totalRows_groups_recordset_assign > 0)
          {while($row = mysql_fetch_assoc($wfl_assign))
     	echo "<option value=\"$row[title]\">$row[title]</option>";} 
		?>
	</select>
	</td>
    </form>
</tr>

</table>

</td></tr></table>
<div id="table_result_error_messages"></div>
<script language="JavaScript" src="/site_12_1/admin/assign_scripts.js"></script>
<script>
var opt = new OptionTransfer("list1","list2");
opt.setAutoSort(true);
opt.setDelimiter(",");
opt.setStaticOptionRegex("^(Kein user vorhanden)$");
opt.saveRemovedLeftOptions("removedLeft");
opt.saveRemovedRightOptions("removedRight");
opt.saveAddedLeftOptions("addedLeft");
opt.saveAddedRightOptions("addedRight");
opt.saveNewLeftOptions("newLeft");
opt.saveNewRightOptions("newRight");
opt.taskMoveRight="add_wfl_group";
opt.taskMoveLeft="delete_wfl_group";
opt.usergroup="<? echo $usergroup; ?>";
opt.init(document.forms[1]);
</script>


<? } ?>

</body>
</html>
