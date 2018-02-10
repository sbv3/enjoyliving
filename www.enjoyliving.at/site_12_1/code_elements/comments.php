<?php
session_start();
?>
<?
$ipadresse ="$REMOTE_ADDR"; 
////////POST actions
if ((!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp_comment) and capture()==true)
{$testresult=1;
	##hier wird ein neuer Comment angefügt
	if ((isset($_POST["add"])) && ($_POST["add"] == "1")) {
	$element_id_comment = $_POST["element_id_comment"];
	
	$nickname=str_replace("<","&lt;",$nickname);
	$nickname=str_replace(">","&gt;",$nickname);
	$email=str_replace("<","&lt;",$email);
	$email=str_replace(">","&gt;",$email);
	$comment=str_replace("<","&lt;",$comment);
	$comment=str_replace(">","&gt;",$comment);
	$comment=nl2br($comment);
	
	$insertSQL = sprintf("INSERT INTO comments (element_id, nickname, `comment`, email, IP, site_id) VALUES (%s, %s, %s, %s, %s, %s)",
	GetSQLValueString($element_id_comment, "int"),
	GetSQLValueString($nickname, "text"),
	GetSQLValueString($comment, "text"),
	GetSQLValueString($email, "text"),
	GetSQLValueString($ipadresse, "text"),
	GetSQLValueString($site_id, "text"));
	$Result1 = mysql_query($insertSQL) or die(mysql_error());
	}
	$_SESSION['microtime'] = $timestamp_comment;
}

////////vorbereitende queries
##hier werden alle comments geladen
$comments_query = mysql_query("select nickname,comment,timestamp from comments where element_id='$zeige->id' and site_id=$site_id order by timestamp")or die("subx3");
$comments_row_count=mysql_num_rows($comments_query);

##hier werden die comments angezeigt!
echo"<b style='font-size:13px;color:#73ACE1;'>Kommentare</b><br>";

##wenn es commentare gibt...
if($comments_row_count>0){
###zeige sie an!
for($i=0; $i<$comments_row_count; $i++)
{
	echo"<div class='commentbox'>";
	mysql_data_seek($comments_query, $i);
	$comment=mysql_fetch_row($comments_query);?>
	<div class='commentautor' style="float:left;"><? echo $comment[0];?></div>
	<div class='commentautor' style="float:right;"><? echo $comment[2];?></div>
	<div style="clear:both"></div>
	<div class='artikeltext'><? echo $comment[1];?></div>
	<br>
	</div>
	
<? }
	echo "<div id=1 class='trenner'></div>";
}?>

<!-- neuen Kommentar anlegen -->
<a name="commentadd" id="commentadd"></a>
<?
if($testresult!=1 and $_POST["add"] == "1")
{?>
<div class='warning' style='padding-top:14px;text-align:center;'>ACHTUNG: Bitte gib das Sicherheitswort richtig ein!</div>
<? }
$add=0;?>
		
<?php /*?><form action="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1#commentadd";?>" method="post">
	<table>
		<tr>
        	<td>Nickname</td>
            <td><input name="nickname" type="text" style="width:320px;"/></td>
        	</tr><tr><td>email</td>
            <td><input name="email" type="text" style="width:320px;"/></td>
		</tr>
        <tr>
        	<td width="100" valign="top">Comment</td>
            <td>
               <textarea name="comment" id="comment" style="width:320px;" rows="5"></textarea>
			</td>
		</tr>
		<tr>
		<td valign="top">Sicherheits-abfrage
		</td>
		<td align="left">
			<img src="<? echo "/Connections/captcha.php"?>" border="0" title="Sicherheitscode" style="vertical-align:bottom;">
			<input type="text" name="sicherheitscode" size="5">
			<input type="submit" name="button" id="button" value="absenden" />
		</td>
		</tr>
		<tr>
        	<td><td style="text-align:right;">
				<input type="hidden" name="element_id_comment" value="<? echo $zeige->id; ?>">
				<input type="hidden" name="timestamp_comment" value="<? echo $timestamp_comment = microtime();?>">
				<input type="hidden" name="add" value="1">
			</td></td>
		</tr>
	</table>
</form><?php */?>