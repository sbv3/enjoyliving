<?php     
session_start();                        								# database_link
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); # function von cvs
?>

<html>
<head>
 <title>Google-URL</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">				

</head>
<body bgcolor="#FFFFFF" text="#000000">

<?
  $erf_date = date("Y-m-d");
//  include ("kopf.php");
///		   echo "task: $task / formsok = $formsok ";
///   echo "urlid : $urlid / id = $id  menu : $sel_menu url : $f_googleurl";

   $act_date = date("d.m.Y H:i:s"); 	
   $dbtable= "googleurl"; 
   
    if ($task =="save"){ 
///        					update der Tabelle googleurl
      mysql_query("update  $dbtable 
                set `menu_id` = '$sel_menu',  `googleurl` = '$f_googleurl'     
					where    `id` = '$urlid'  
		       ")
	    or die ("Datenbank-Fehler beim update auf die Tabelle  --> $dbtable <-- ...")   ;
   }
   if ($task =="del"){
///        					löschen aus der Tabelle googleurl
      mysql_query("delete from  $dbtable 
  					where    `id` = '$id'  
		       ")
	    or die ("Datenbank-Fehler beim update auf die Tabelle  --> $dbtable <-- ...")   ;
   }   
?>                
<table border="0" width="1082">
	<tr border="1" bordercolor="#00008B" bgcolor="#FFCC33">
		<td width="132" align="left"><img src="/papa/admin_neu/img/logo_admin.gif" width="132" height="31"></td>
		<td width="381" align="center" style="color:#000000; font-size:20px">Administrationsbereich</td>
		<td width="128" align="left"><? echo "user: ".$user;?></td>
		<? if(test_right($_SESSION['user'],"edit_users")=="true"){?>
		<td width="116" align="right"><a href="/site_12_1/admin/user_admin_users.php">
			<input type="button" value="Userverwaltung">
		</a></td>
		<? }?>
		<td width="59" align="right"><a href="menu.php?men_id=230">
			<input type="button" value="Home">
		</a></td>
		<td width="78" align="right"><input type="submit" name="Abmelden" value="Abmelden"></td>
		<td width="158"><a href="upd_googleurl.php">
			<input type="button" value="Googleurls ohne Men&uuml;"></a></td>
	</tr>
</table>	
<br>
<br>
<table width="64%" border="0">
	<tr style = "" border="1" bordercolor="#00008B" > 
		<td>     
			<div align="center"><font face="Arial, Helvetica, sans-serif" size="4pt"> 
				<strong>Google-URLs ohne Men&uuml;zuordnung</strong></font><br>
				<br>
			</div>
		</td>
	</tr>
</table>
  <table width="64%" border="0">
    <tr style = "" border="1" bordercolor="#00008B"> 
      <td width="300" height="40" bgcolor="#FFFFFF" class="feldrahmen_normal" type="text"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Google-URL</font></div>
      	</td>
      <td width="37%" type="text" class="feldrahmen_normal" height="40"> 
      	<div align="center"> <font face="Arial, Helvetica, sans-serif" size="2">neue 
      		Men&uuml;zuordnung <br>
      		Hierarchy / Titel / Sortierung</font> </div>
      	</td>
      <td width="8%" type="text" class="feldrahmen_normal" bgcolor="#FFFFFF" height="40"><font face="Arial, Helvetica, sans-serif" size="2" > 
        </font>
      <td width="13%" type="text" class="feldrahmen_normal" bgcolor="#FFFFFF" height="40"><font face="Arial, Helvetica, sans-serif" size="2" > 
        </font> 

    </tr>
    <tr border="1" bordercolor="#00008B" >
    	<td colspan="4" bgcolor="#FFFFFF" type="text"><?
/// 								Select von der Tabelle  
 	 $dbtable="googleurl";                          		/// LOV f&uuml;r Ausgabe der Menu
     $result = mysql_query("SELECT * FROM $dbtable  where menu_id not in (select id from menu)"  )
	                       or   die("Es ist ein Datenbankfehler beim Leser der Tabelle $dbtable im Module page_attribute   aufgetreten ! ");
 	 while ($ergebnis=mysql_fetch_object($result))
	 {
?></td>
    	</tr><form name="anzeige" method="post" action="upd_googleurl.php">
    <tr border="1" bordercolor="#00008B" >
    	<td height="40" bgcolor="#FFFFFF" type="text"><? echo "$ergebnis->googleurl"; ?></td>
    	<td height="40" bgcolor="#FFFFFF">
    		<select name="sel_menu" size="1" style="width:200px">
    			<?
		 echo "<option value=''>  </option>";
         $cmd_sql = "SELECT * FROM menu   where active = 'A' ORDER BY hierarchy_level " ;
         $recs = mysql_query($cmd_sql);
         $row_anz = mysql_num_rows($recs);
         for ($i=0; $i<$row_anz; $i++)
	     {	  
	      $r = mysql_fetch_array($recs);
	
         ///if ($ergebnis->element_layout_id=="$r[id]"){$xselect="selected";}else{$xselect="";}
          echo "<option value='$r[id]'>$r[hierarchy_level]&nbsp; /  &nbsp;$r[description]&nbsp;&nbsp; / &nbsp;&nbsp; $r[sort]</option>";
         }
        ?>
    			</select>
    		<span class="feldrahmen_normal">
    		<input type="hidden" name="task" value="save">
    		<input type="hidden" name="urlid"       value="<?echo "$ergebnis->id";?>">
    		<input type="hidden" name="f_googleurl" value="<?echo "$ergebnis->googleurl";?>">
    		</span></td>
    	<td type="text"bgcolor="#FFFFFF" height="40"> <a href="upd_googleurl.php?task=del&id=<?echo"$ergebnis->id";?>">
    		<input type="button" value="Delete">
    	</a>
    	<td type="text" bgcolor="#FFFFFF" height="40"><span class="feldrahmen_normal">
    	<input type="submit" value="Speichern" name="submit2">
    	</span>	
    	</tr></form>
    <tr border="1" bordercolor="#00008B" >
    	<td colspan="4" bgcolor="#FFFFFF" type="text"><?
	}
?></td>
    	</tr>
 	</table>
</body>
</html>
