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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">Workflow anlegen</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="wf_mgt_group_assign.php">Workflow zu Usergroup zuordnen</a></div>
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


<body>
<?php
$table="wfl_workflows_templates";
if($add==1)
{
$add=0;
mysql_query("INSERT INTO $table (title, description, site_id) VALUES('new', 'new', '$site_id') ") or die(mysql_error());  
}

    $query="select id, title, description from $table where site_id='$site_id'";
    $result=mysql_query($query);
    $row_Recordset1 = mysql_fetch_assoc($result);
?>
<br />
<table id="<? echo $table; ?>" width="600px" border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>

<?php
 do { ?>
        <tr>
        <form id="selector" name="selector" method="post" target="_self">
			
           <td style="width:150px"><div id="idi_<?php echo $row_Recordset1['id']; ?>_div"><?php echo $row_Recordset1['id']; ?></div></td>

           <td style="width:400px"><div id="title_<?php echo $row_Recordset1['id']; ?>_div" onClick="editField(this,'<?php echo urlencode($row_Recordset1['title']); ?>')"><?php echo $row_Recordset1['title']; ?></div>
           <textarea name="title" class="hiddenField" id="title_<?php echo $row_Recordset1['id']; ?>" onBlur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['title']; ?>" /></textarea></td>

           <td style="width:600px"><div id="description_<?php echo $row_Recordset1['id']; ?>_div" onClick="editField(this,'<?php echo urlencode($row_Recordset1['description']); ?>')"><?php echo $row_Recordset1['description']; ?></div>
           <textarea name="description" class="hiddenField" id="description_<?php echo $row_Recordset1['id']; ?>" onBlur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['description']; ?>" /></textarea></td>

		   <td style="width:150px"><input name="delete" type="button" onClick="deleteRow(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="delete"/></td> 
  		 </form>
        </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($result)); ?>
</table>

      <?  mysql_free_result($result);?>
<div id="table_result_error_messages"></div>
<br />
      <table id="add" width="600px" border="0"bgcolor="#FFFFFF" rules=ROWS frame=BOX>
      <tr>
      <form name="addRecord" method="post" target="_self">
      	<td width="150px"></td>
      	<td style="width:400px"></td>
      	<td style="width:600px"></td>
       	<td style="width:150px"></td>
     	<td style="width:150px">
             <input name="add" type="submit" id="add" value="add">
             <input type="hidden" name="add" value="1">
         </td>
      </form>
      </table>
</body>
</html>