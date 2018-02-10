<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); 

if(test_right($_SESSION['user'],"edit_users")!="true")
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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;"><a href="user_admin_users.php">User anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="user_admin_groups.php">Gruppen anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">User zu Gruppen zuordnen</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="user_admin_sites_assign.php">Sites zu Gruppen zuordnen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;"><a href="user_admin_sites_pool_assign.php">Usergruppen Site-Pools zuordnen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="user_admin_right_assign.php">Rechte zu Gruppen zuordnen</a></div>
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
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

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
    <td><? if($usergroup and $usergroup!="unselected") {echo "Verfügbare User:";} else {echo "Zuerst Usergruppe auswählen";}?> </td>
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


<? if($usergroup and $usergroup!="unselected") {?>


<? #### hier sind die beiden List-boxen. 
if($usergroup){?>

<? ### zuerst beide Listen abfragen
$users_avail=mysql_query("SELECT username FROM user_users where ID not in (select users_ID from user_users_x_groups where groups_ID ='$usergroup')") or die (mysql_error());
$totalRows_groups_recordset_avail = mysql_num_rows($users_avail);

$users_assign=mysql_query("SELECT username FROM user_users where ID in (select users_ID from user_users_x_groups where groups_ID ='$usergroup')") or die (mysql_error());
$totalRows_groups_recordset_assign = mysql_num_rows($users_assign);
?>
    </td>
    
</tr>

<tr>
<form>
	<td>
	<select style="width:200px;" name="list1" multiple size=10 ondblclick="opt.transferRight()">
		<? if($totalRows_groups_recordset_avail > 0)
          {while($row = mysql_fetch_assoc($users_avail))
     	echo "<option value=\"$row[username]\">$row[username]</option>";} 
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
          {while($row = mysql_fetch_assoc($users_assign))
     	echo "<option value=\"$row[username]\">$row[username]</option>";} 
		?>
	</select>
	</td>
    </form>
</tr>

</table>



<!--<p>These options are configurable in the source:<br>
   Delimiter: <input type="text" name="delimiter" value="," size=2 maxlength=1 onchange="opt.setDelimiter(this.value);opt.update()"><br>
   AutoSort: 
   <select name="autosort" onchange="opt.setAutoSort(this.selectedIndex==0?true:false);opt.update()">
      <option value="Y">Yes
         <option value="N">No
         </select>
   <br>
   Options that Match this regular expression cannot be moved: <input type="text" name="regex" size="15" value="^(Bill|Bob|Matt)$" onchange="opt.setStaticOptionRegex(this.value);opt.update()">
   <br><br>
   The fields below show the status of the list boxes as items are passed back and forth. Normally these would be hidden fields which you would then use to process the changes on the server-side. Your form doesn't have to include all the fields below - you can choose to store only the items added to the right list, for example.
   <br><br>
   Removed from Left: <input type="text" name="removedLeft" value="" size=70><br>
   Removed from Right: <input type="text" name="removedRight" value="" size=70><br>
   
   Added to Left: <input type="text" name="addedLeft" value="" size=70><br>
   Added to Right: <input type="text" name="addedRight" value="" size=70><br>
   Left list contents: <input type="text" name="newLeft" value="" size=70><br>
   Right list contents: <input type="text" name="newRight" value="" size=70><br>
</p>-->


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
opt.taskMoveRight="add_user";
opt.taskMoveLeft="delete_user";
opt.usergroup="<? echo $usergroup; ?>";
opt.init(document.forms[1]);
</script>


<? } } ?>

</body>
</html>
