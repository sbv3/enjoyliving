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
<link rel="stylesheet" type="text/css" href="/Connections/jquery-editable/jquery-editable/css/jquery-editable.css">
<link rel="stylesheet" type="text/css" href="/Connections/poshytip-master/src/tip-yellowsimple/tip-yellowsimple.css">
<script type="text/javascript" src="/Connections/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/Connections/poshytip-master/src/jquery.poshytip.js"></script>
<script type="text/javascript" src="/Connections/jquery-editable/jquery-editable/js/jquery-editable-poshytip.js">
 $.fn.editable.defaults.mode = 'popup';
</script>
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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="wf_mgt_group_assign.php">Workflow zu Usergroup zuordnen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;font-weight:bolder; text-decoration:underline">Tasks anlegen</div>
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
$wfl_tasks_q=mysql_query("select * from wfl_workflows_templates where site_id=$site_id") or die (mysql_error());
$totalRows_wfl_tasks_q = mysql_num_rows($wfl_tasks_q);
?>
</head>
<body>
<br />
<table border="0">
	<tr>
		<td><? if($wfl and $wfl!="unselected") {echo "Tasks zu Workflow:";} else {echo "Zuerst Workflow auswählen";}?> </td>
		<td>
			<form method="post" name="form_workflow">
				<select style="width:200px;" name="wfl" onChange="document.forms['form_workflow'].submit()">
					<option value="unselected">Workflow auswählen</option>
					<? if($totalRows_wfl_tasks_q > 0)
					{while($row = mysql_fetch_assoc($wfl_tasks_q))
					{if($row['id']==$wfl)
					{echo "<option selected='selected' value=\"$row[id]\">$row[title]</option>";}
					else {echo "<option value=\"$row[id]\">$row[title]</option>";}}} 
					else {echo "<option>Kein Workflow vorhanden</option>";}?>
				</select> 
			</form>
		</td>
	</tr>
</table>

<? if($wfl and $wfl!="unselected") {?>

<script>
Array.prototype.in_array = function(needle) {
	for(var i=0; i < this.length; i++) if(this[ i] === needle) return true;
	return false;
}

function update_task_db(task_id,prop,value)
{
	if(prop_avail.in_array(prop))
	{
	$('#table_result_error_messages').load("/site_12_1/admin/wf_mgt_tasks_backend.php",{
		task:'update_task_prop',
		task_id:task_id,
		prop:prop,
		value:value
		});
	}
}

function update_task_type(task_id,value)
{
	if(value=="Start")
	{
		update_decisions(task_id,0);
		update_next(task_id,1);
	
		var all_task_types=$("[id='task_type']");
		for(var i=0; i < all_task_types.length; i++)
		{
			if(all_task_types.eq(i).data().value== "Start" && all_task_types.eq(i).data().pk!=task_id)
			{
				return "Sie können maximal einen Start-Task haben.";
			}
		}
	}
	
	if(value=="Aktion")
	{
		update_decisions(task_id,0);
		update_next(task_id,1);
	}

	if(value=="Entscheidung")
	{
		update_decisions(task_id,1);
		update_next(task_id,0);
	}

	if(value=="Ende")
	{
		update_decisions(task_id,0);
		update_next(task_id,0);
	}
}

function update_decisions(task_id,value)
{
	var obj=$('[id="'+task_id+'"]').find('#decision_a_task');
	var obj=obj.add($('[id="'+task_id+'"]').find('#decision_b_task'));
	if(value==0){obj.hide();}else{obj.show();}
}

function update_next(task_id,value)
{
	var obj=$('[id="'+task_id+'"]').find('#next_task_id');
	if(value==0){obj.hide();}else{obj.show();}
}

function change_prop(task_id,prop,value)
{
	if(typeof(window["update_" + prop])== "function")
	{
		return(window["update_" + prop](task_id,value));
	}
	else{return false;}
}



</script>

<?
class workflow_def
{
	private $wfl_id;
	
	function __construct()
	{
		global $wfl;
		$this->wfl_id=$wfl;
	}
	private $start_task_id;
	
	function add_task()
	{
		mysql_query("INSERT INTO $table 
		(title, description, due_date_distance, task_type, decision_a_task, decision_b_task, menu_id_link, trigger_wfl, money_value, money_to/from, wfl_templates_id) VALUES
		('new', 'new', '7', 'activity', '', '', '', '',0,'','$this->wfl_id') ") or die(mysql_error());  
	}
	
	function set_starttask($task_id)
	{
		$this->start_task_id=$task_id;
	}
}


/*	`decision_a_task` INT(11) NOT NULL,
	`decision_b_task` INT(11) NOT NULL,
	`menu_id_link` INT(11) NOT NULL,
	`trigger_wfl` INT(11) NOT NULL,
	`money_value` DECIMAL(2) NOT NULL,
	`money_to/from` CHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM
AUTO_INCREMENT=2;
*/
class task_def extends workflow_def
{
	private $task_id;
	private $title;
	private $description;
	private $due_date_distance;
	private $task_type;
	
	function load_task_properties($task_id)
	{
		$task_prop_q=mysql_query("select * from wfl_tasks_templates where id=$task_id");
		while ($task_prop_r=mysql_fetch_assoc($task_prop_q))
		{
			$task_prop[]=$task_prop_r;
			$this->task_id=$task_prop['id'];
			$this->title=$task_group['title'];
			$this->description=$task_group['description'];
			$this->due_date_distance=$task_prop['due_date_distance'];
			$this->task_type=$task_prop['task_type'];
			$this->next_task_id=$task_prop['next_task_id'];		
		}	
	}
}


$table="wfl_tasks_templates";
if($add==1)
{
$add=0;
}

    $query="select * from $table where wfl_id=$wfl order by id";
    $result=mysql_query($query);
    $row = mysql_fetch_assoc($result);
?>
<br />
<table id="<? echo $table; ?>" width="600px" border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>

<?php
 $row_counter=1;
 do { ?>
        <tr id="<? echo $row['id'];?>" name="<? echo $row_counter;$row_counter=$row_counter+1;?>">
			<td style="width:150px"><div><?php echo $row['id']; ?></div></td>
			
			<td style="width:150px"><div style="width:150px;" class="editable-click" id="title" data-pk="<? echo $row['id']?>" data-type="textarea" data-mode="inline"><?php echo $row['title']; ?></div></td>
			<td style="width:200px"><div style="width:200px;" class="editable-click" id="description" data-pk="<? echo $row['id']?>" data-type="textarea" data-mode="inline"><?php echo $row['description']; ?></div></td>
			<td style="width:140px"><div style="width:140px;" class="editable-click" id="user_group_id" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline"
				data-source=
				<? echo "'[";
					$usr_grp_q=mysql_query("select ID, description from user_groups");
					while($usr_grp_r=mysql_fetch_assoc($usr_grp_q))
					{
						echo '{value:'.$usr_grp_r[ID].', text:"'.$usr_grp_r[description].'"},';
					}
					echo "]'";
				?> data-value="<?php echo $row['user_group_id']; ?>"></div>
			</td>
			
			<td style="width:150px"><div style="width:150px;" class="editable-click" id="task_type" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline" 
			data-source='[{Start: "Start"}, {Aktion: "Aktion"},{Entscheidung: "Entscheidung"},{Ende: "Ende"}]' data-value="<?php echo $row['task_type']; ?>"><?php echo $row['task_type']; ?></div></td>

			<td style="width:78px"><div style="width:78px;" class="editable-click" id="decision_a_task" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline"
				data-source=
				<? echo "'[";
					$a_branch_q=mysql_query("select id, title from $table where wfl_id=$wfl and id != ".$row['id']);
					while($a_branch_r=mysql_fetch_assoc($a_branch_q))
					{
						echo '{value:'.$a_branch_r[id].', text:"'.$a_branch_r[id].': '.$a_branch_r[title].'"},';
					}
					echo "]'";
				?> data-value="<?php echo $row['decision_a_task']; ?>"></div>
			</td>
			<td style="width:78px"><div style="width:78px;" class="editable-click" id="decision_b_task" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline"
				data-source=
				<? echo "'[";
					mysql_data_seek($a_branch_q,0);
					while($a_branch_r=mysql_fetch_assoc($a_branch_q))
					{
						echo '{value:'.$a_branch_r[id].', text:"'.$a_branch_r[id].': '.$a_branch_r[title].'"},';
					}
					echo "]'";
				?> data-value="<?php echo $row['decision_b_task']; ?>"></div>
			</td>
			
			<td style="width:78px"><div style="width:78px;" class="editable-click" id="is_menu_id" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline" data-placement="left"
			data-source='[{value: 0, text: "ohne link"},{value: 1, text: "mit link"}]' data-value="<?php echo $row['is_menu_id']; ?>"><?php if ($row['is_menu_id']==1){echo "mit link";} else {echo "ohne link";} ?></div></td>
			
			<td style="width:100px"><div style="width:100px;" class="editable-click" id="money_value" data-pk="<? echo $row['id']?>" data-type="text" data-mode="inline"><?php echo $row['money_value'];?></div></td>
			
			<td style="width:78px"><div style="width:78px;" class="editable-click" id="comment_type" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline" data-placement="left"
			data-source='[{value: 0, text: "ohne Anmerkung"},{value: 1, text: "Anmerkung möglich"},{value: 2, text: "Anmerkung erzwingen"}]' data-value="<?php echo $row['comment_type']; ?>"><?php if ($row['comment_type']==1){echo "ohne Anmerkung";} elseif ($row['comment_type']==1) {echo "Anmerkung möglich";} elseif ($row['comment_type']==2) {echo "Anmerkung erzwingen";} ?></div></td>
			
			<td style="width:78px"><div style="width:78px;" class="editable-click" id="next_task_id" data-pk="<? echo $row['id']?>" data-type="select" data-mode="inline"
				data-source=
				<? echo "'[";
					mysql_data_seek($a_branch_q,0);
					while($a_branch_r=mysql_fetch_assoc($a_branch_q))
					{
						echo '{value:'.$a_branch_r[id].', text:"'.$a_branch_r[id].': '.$a_branch_r[title].'"},';
					}
					echo "]'";
				?> data-value="<?php echo $row['next_task_id']; ?>"></div>
			</td>
			
			<td style="width:150px"><input name="delete" type="button" onClick="deleteRow(this,'<? echo $table; ?>',<? echo $row['id']; ?>)" value="delete"/></td> 
        </tr>
	</div>
	<script>
		update_decisions(<? echo $row['id']; ?>,<? if($row['task_type']=="Entscheidung"){echo "1";}else{echo "0";} ?>);
		update_next(<? echo $row['id']; ?>,<? if($row['task_type']=="Entscheidung" || $row['task_type']=="Ende"){echo "0";}else{echo "1";} ?>);
	</script>
  <?php } while ($row = mysql_fetch_assoc($result)); ?>
</table>
 
<script>
$('.editable-click').editable({
	url:"wf_mgt_tasks_backend.php",
	emptytext:"hier eingeben",
	onblur:"submit",
	showbuttons: false,
	anim:0,
	validate: function(value) {
		var result=change_prop(this.attributes['data-pk'].value,this.id,value);//(task_id,prop,value)
		return result;
	},
	params: function(params) {
  		params.pk = params.pk;
  		params.task = "update_task_prop";
		params.value = URLdecode(URLencode(params.value));
  		params.name = params.name;
		return params;
	}
});
$('.editable-click').on('shown', function() {  
        var editable = $(this).data('editable'),
            $input = editable.input.$input;                                    
        $input.width($(this).width());
        $input.height($(this).height());
});  
</script>


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
			 <input type="hidden" name="wfl" value="<? echo $wfl;?>">
         </td>
      </form>
      </table>
</body>
</html>
<? } ?>