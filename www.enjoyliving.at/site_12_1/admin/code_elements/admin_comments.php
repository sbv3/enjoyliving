<?
##hier werden die comments angezeigt!
echo"<b style='font-size:13px;color:#73ACE1;'>Kommentare (Magazin-spezifisch)</b><br>";

$table="comments";
$query="select ID,nickname,comment from comments where element_id='$elem_id' and site_id=$site_id order by timestamp";
$result=mysql_query($query);
$row_Recordset1 = mysql_fetch_assoc($result);
$comments_row_count=mysql_num_rows($result);

##wenn es commentare gibt...
if($comments_row_count > 0){

?>
<table id="<? echo $table; ?>" bordercolor="#ccc" rules="rows">

<?php
 do { 
 ?>
        <tr>
		<td width="100%">
			<form id="selector" name="selector" method="post">
			<div class="commentautor" style="width:100%; height:auto" id="nickname_<?php echo $row_Recordset1['ID']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['nickname']); ?>')"><?php echo $row_Recordset1['nickname']; ?></div>
			<input name="nickname" type="text" class="hiddenField" style="width:100%;" id="nickname_<?php echo $row_Recordset1['ID']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['ID']; ?>)" value="<?php echo $row_Recordset1['nickname']; ?>" />
			<br>
			<div class="artikeltext" style="width:100%;" id="comment_<?php echo $row_Recordset1['ID']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['comment']); ?>')"><?php echo $row_Recordset1['comment']; ?></div>
			<input name="comment" type="text" class="hiddenField" style="width:100%;" id="comment_<?php echo $row_Recordset1['ID']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['ID']; ?>)" value="<?php echo $row_Recordset1['comment']; ?>" />
			</form>
		</td>
		<td>
			<input name="delete" type="button" onclick="deleteRow(this,'<? echo $table; ?>',<?php echo $row_Recordset1['ID']; ?>)" value="delete"/> 
		</td>
        </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($result)); ?>
</table>

<?  mysql_free_result($result);?>
<div id="table_result_error_messages"></div>
<? }?>