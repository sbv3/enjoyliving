<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"enter_page_content")!="true")
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
<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];

?>

<body>
<?

if ($eintrag=="1"){
$aendern = "UPDATE assets SET channel='$channel', alt_tag='$alt_tag',keywords='$keywords'  WHERE ID='$ID_imagedetail'";
$update = mysql_query($aendern);
echo"<b>Die Änderungen wurden gespeichert.</b><br><br>";
	}
?>
<? 
$channels=mysql_query("select description from menu where id in (select menu_id from menu_hierarchy where parent_id = $home_menu_id and site_id=$master_site_id)") or die (mysql_error());
?>
<?


$result = mysql_query("SELECT * FROM assets WHERE ID='$ID_imagedetail'")or die("x");
while ($show=mysql_fetch_object($result))
{ $channel=$show->channel;

	?>
     <form target="_self" method="post" name="formx" id="formx">
  <table width="100%" border="0">
   <tr>
      <td>Bildpfad:</td>
      <td><? echo"$show->path$show->filename";?></td>
   </tr>
   <tr>
      <td width="100">Breite:</td>
      <td><? echo"$show->breite";?></td>
   </tr>
   <tr>
      <td>H&ouml;he:</td>
      <td><? echo"$show->hoehe";?></td>
   </tr>
   <tr>
      <td>Typ:</td>
      <td><? echo"$show->type";?></td>
   </tr>
   <tr>
      <td>Jahr:</td>
      <td><? echo"$show->jahr";?></td>
   </tr>
   <tr>
      <td>Erstell-Datum:</td>
      <td><? echo"$show->erstelldatum";?></td>
   </tr>
   <tr>
      <td>Channel:</td>
      <td>
         <select name="channel" id="channel" style="width:200px">
			<option value="">Channel auswählen</option>

			<?	while($channels_result=mysql_fetch_assoc($channels))
				 {?>
					<option value="<? echo $channels_result['description']?>" <? if ($channel==$channels_result['description']){echo "selected";}?>><? echo $channels_result['description']?></option>
			<? 	}?> 
     </select>
      </td>
   </tr>
   <tr>
      <td>Alt-Tag:</td>
      <td><input name="alt_tag" type="text" id="alt_tag" style="width:200px" value="<? echo"$show->alt_tag";?>" /></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td>Bildbezeichung</td>
   </tr>
   <tr>
      <td>Keywords:</td>
      <td><input name="keywords" type="text" id="keywords" style="width:200px" value="<? echo"$show->keywords";?>" />
         <br /></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td>mehrere Keywords bitte mit Komma trennen</td>
   </tr>
  </table>
  <input name="eintrag" type="hidden" id="eintrag" value="1" />
        <input name="ID_imagedetail" type="hidden" id="ID_imagedetail" value="<? echo"$ID_imagedetail";?>" />
        <input type="submit" name="Submit3" class="butti"  value="&Auml;nderungen speichern" />
      
     </form>
<? }?>
</body>
</html>