<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); 

if(test_right($_SESSION['user'],"edit_kopf_fuss")!="true")
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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;font-weight:bolder; text-decoration:underline">Edit Kopf / Fusszeile</div>
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
$table="site_menu_ids";
$table_width=600;
$URL= $_SERVER['PHP_SELF'];

#hier frage ich die Tabellenstruktur ab.
$query_table = mysql_query("describe $table") or die(mysql_error());
$totalRows_table_desc = mysql_num_rows($query_table);
$culumn_width=$table_width/($totalRows_table_desc+1);


## hier ist die "add" record funktion, die bei einem refresh aufgreufen wird.
if($add==1)
{
	$add=0;
	mysql_data_seek($query_table, 1); 
	$row_table_desc=mysql_fetch_row($query_table); 
	mysql_query("INSERT INTO $table (site_id,menu_id,kopf_fuss) VALUES('$site_id','$home_menu_id','kopf') ") or die(mysql_error());  
}

##hier frage ich die eigentlichen Daten der Tabelle ab. 
$query=mysql_query("select * from $table where site_id=$site_id");
$totalRows_value = mysql_num_rows($query);

?>
<div id="table_result_error_messages"></div>
<br />
<table id=<? echo $table;?> width=<? echo $table_width; ?> border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>

<?php
if($totalRows_value>0)
{
	$i=0; ##set the row counter to zero
	 do { ?>
			<tr>
			<form id='$table' method="post">
			  <? $ii=0; ## set culumn counter to zero
			do { ?>
			   <td width=<? echo $culumn_width;?> >
			   <? mysql_data_seek($query_table, $ii); ## points to the description-query of the table and takes row $ii
			 $row_table_desc=mysql_fetch_row($query_table); 
			 $Field = $row_table_desc[0]; ## takes the first field of the description table and of the row pointed to.
			 
			 mysql_data_seek($query, $i); ## points to the value-query and gets the row.
			 $row_value = mysql_fetch_row($query);?>
			   <!--create a div with a readonly element which has "_div" at the end-->
			   <div id="<? echo $Field;?>_<?php echo $row_value[0]; ?>_div" 
			   <? if($Field != "id" and $Field != "site_id"){?>
				   onClick="editField(this,'<?php echo urlencode($row_value[$ii]); ?>')"<? }?>><?php echo $row_value[$ii]; ?></div>
			   <? if($Field != "id" and $Field != "site_id"){?>
				   <!--create a field and call it the same as above-->
				   <input name="<? echo $Field;?>" 
				   type="text" 
				   class="hiddenField" 
				   id="<? echo $Field;?>_<?php echo $row_value[0]; ?>" 
				   onBlur="updateField(this,'<? echo $table; ?>',<?php echo $row_value[0]; ?>)" 
				   value="<?php echo $row_value[$ii]; ?>" />
			   <? }?>
			   </td>
			<? $ii=$ii+1;} while ($ii<$totalRows_table_desc); ##increase the counter of the culumn to the next one?>  
	
			<td width=<? echo $culumn_width;?>>
	
			  <input name="delete" 
			  type="button" 
			  onClick="deleteRow(this,'<? echo $table;?>',<? echo $row_value[0]; ?>)" 
			  value="delete"/></td> 
	 
		   </form>
		   </tr>
	  <? $i=$i+1; ## increase the counter to the next row.
	  } while ($i<$totalRows_value); 
}?>
</table>

      <?  mysql_free_result($query);?>
<div id="table_result_error_messages" style="height:5px";></div>
<br />
      <table id="add" width="600px" border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>
      <tr>
      <form name="addRecord" method="post" action="<? echo $URL; ?>">
      	<td width="150px"></td>
      	<td width="150px"></td>
      	<td width="150px"></td>
      	<td width="150px">
             <input name="add" type="submit" id="add" value="add">
             <input type="hidden" name="add" value="1">
         </td>
      </form>
      </table>
</body>
</html>


