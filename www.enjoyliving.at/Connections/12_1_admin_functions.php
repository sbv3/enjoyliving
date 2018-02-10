<?
session_start();

if(!$_SESSION['user']){
	if(test_login($user,$password,$site_id)!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/Login.php?wrong_longin=1\">";
		exit;
	}
}

if($_SESSION['autoupdate']){
	?><script>user_config_autoupdate=<? echo $_SESSION['autoupdate'];?></script>
<? }else{
	$user_autoupdate_q=mysql_query("select auto_update_menu_hierarchy from user_users where username='$user'");
	$user_autoupdate_r=mysql_fetch_assoc($user_autoupdate_q);
	$_SESSION['autoupdate']=$user_autoupdate_r[auto_update_menu_hierarchy];
	?><script>user_config_autoupdate=<? echo $_SESSION['autoupdate'];?></script>
<?	}
?>
<?
function test_right($logged_user,$request){
	$site_id=$_SESSION['site_id'];
	if(!$password){$logged_password=$_SESSION['password'];} else{$logged_password=$password;}
	$users_rights=mysql_query("
	select user_users.username, user_groups.description, user_rights.description
	from user_rights, user_groups_x_rights, user_groups, user_users_x_groups, user_users,user_sites_x_groups
	where user_rights.description ='$request'
	and user_users.username='$logged_user'
	and user_users.password='$logged_password'
	and user_sites_x_groups.sites_id=$site_id
	and user_rights.id=user_groups_x_rights.rights_id
	and user_groups_x_rights.groups_id=user_groups.id
	and user_groups.id=user_users_x_groups.groups_id
	and user_users_x_groups.users_id=user_users.id
	and user_sites_x_groups.groups_ID=user_groups.id") or die(mysql_error());  
	
	if(mysql_num_rows($users_rights)>0)
	{$result = "true";}
	else {$result = "false";}
return $result;}
?>
<?
function find_master_user_id($menu_id){
	$master_user_query=mysql_query("select master_user_id from menu where id='$menu_id'") or die ("master_user_id failed");
	$result=mysql_fetch_assoc($master_user_query);
	$result=$result[master_user_id];
	if($result===NULL or $result==""){$result=$_SESSION[user_id];}
	return $result;
	}
?>
<?
function find_master_site_id($menu_id){
	$master_user_query=mysql_query("select master_site_id from menu where id='$menu_id'") or die ("master_site_id failed");
	$result=mysql_fetch_assoc($master_user_query);
	$result=$result[master_site_id];
	return $result;
	}
?>
<?
function empty_caches()
{
	mysql_query("TRUNCATE 'menu_select_cache';");
}
?>
<? //diese Funktion updated die Felder "Pfad" und "Level" in der Tabelle Menu_hierarchy
function rebuild_hierarchy_paths(){
	global $site_id;
	mysql_query("SET @@SESSION.max_sp_recursion_depth=25;");
	mysql_query("set @absolute_sort_order=0;");
	mysql_query("CALL menu_hierarchy_make_paths(0,0,0,$site_id,1,1);");
	//empty_caches();
}
?>
<? ///die Funktion NewMenu legt einen neuen Menüpunkt, inkl. Google-URL. Es werden doppelte Google-URLs vermieden. Benötigt werden Menü-hierarchy, sort, parent_id, description,display (0/1), active (Y/N),startdatum, enddatum und seitentyp. Die Funktion ruft danach die Element-Anlage auf.

function newmenu($menu_ordering2,$parent_id,$titel2,$display,$active,$active_startdate,$active_enddate,$seitentyp,$search_type) {
	global $site_id;
	$titel3=GetSQLValueString($titel2,"text");
	$datum_heute = date("Y-m-d H:i");
	mysql_query("INSERT INTO menu (description,metatag_title,up_date,pagetype,search_type,master_site_id,master_user_id) VALUES ($titel3,$titel3,'$datum_heute','$seitentyp','$search_type','$site_id','$_SESSION[user_id]')")or die("xxx1".mysql_error());
	$menuid_q=mysql_query("select last_insert_id() as menuid");
	$menuid_r=mysql_fetch_assoc($menuid_q);
	$menuid=$menuid_r[menuid];
	
	mysql_query("insert into menu_hierarchy (menu_id,parent_id,site_id,sort,display,active_startdate,active_enddate,active) values ('$menuid','$parent_id','$site_id','$menu_ordering2','$display','$active_startdate','$active_enddate','$active')") or die("yyy");
	
	$menuid_hier_q=mysql_query("select last_insert_id() as menuid_hier");
	$menuid_hier_r=mysql_fetch_assoc($menuid_hier_q);
	$menuid_hier=$menuid_hier_r[menuid_hier];
	
	//absolute_sort,is_menu_hierarchy,is_active_hierarchy,pfad,level
	$rebuild_paths_sort_q1=mysql_query("SELECT absolute_sort FROM menu_hierarchy WHERE parent_id='$parent_id' and site_id='$site_id' AND sort>'$menu_ordering2' ORDER BY sort asc LIMIT 1");
	if(mysql_numrows($rebuild_paths_sort_q1)==0)
	{
		$rebuild_paths_sort_q2=mysql_query("select max(absolute_sort) as absolute_sort from menu_hierarchy,(SELECT menu_id FROM menu_hierarchy WHERE parent_id='$parent_id' and site_id='$site_id' AND sort<'$menu_ordering2' ORDER BY sort desc limit 1) as limiter where limiter.menu_id = menu_hierarchy.parent_id and site_id=$site_id");
		$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q2);

		if($rebuild_paths_sort_r[absolute_sort] == NULL)
		{
			$rebuild_paths_sort_q3=mysql_query("SELECT absolute_sort FROM menu_hierarchy WHERE parent_id='$parent_id' and site_id='$site_id' order by absolute_sort desc limit 1");
			$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q3);
			$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort]+1;
		}
		else
		{
			$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort]+1;
		}
	}
	else
	{
		$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q1);
		$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort];
	}

	$rebuild_paths_q=mysql_query("SELECT is_menu_hierarchy, is_active_hierarchy, pfad, level FROM menu_hierarchy WHERE menu_id='$parent_id' and site_id='$site_id' LIMIT 1");
	$rebuild_paths_r=mysql_fetch_assoc($rebuild_paths_q);
	
	$rebuild_paths_id=$menuid_hier;
	if($rebuild_paths_r[is_menu_hierarchy]==1 and $display==1){$rebuild_paths_is_menu_hierarchy=1;}else{$rebuild_paths_is_menu_hierarchy=0;}
	if($rebuild_paths_r[is_active_hierarchy]==1 and $active=="A"){$rebuild_paths_is_active_hierarchy=1;}else{$rebuild_paths_is_active_hierarchy=0;}
	$rebuild_paths_pfad=$rebuild_paths_r[pfad]."/".$menuid;
	$rebuild_paths_level=$rebuild_paths_r[level]+1;
		
	mysql_query("update menu_hierarchy set absolute_sort=absolute_sort+1 where absolute_sort >= $rebuild_paths_absolute_sort");
	mysql_query("update menu_hierarchy set 
			 absolute_sort=$rebuild_paths_absolute_sort,
			 is_menu_hierarchy=$rebuild_paths_is_menu_hierarchy, 
			 is_active_hierarchy=$rebuild_paths_is_active_hierarchy, 
			 pfad='$rebuild_paths_pfad', 
			 level=$rebuild_paths_level 
			 
			 where id=$rebuild_paths_id limit 1");
	
	create_googleurl($titel2,$menuid);

	empty_caches();
	
	$result = mysql_query("SELECT * FROM pagetype WHERE description='$seitentyp' and (available_to like '%,$site_id,%' or available_to is null) order by sort")or die("stop");
	while ($show=mysql_fetch_object($result))
	{
		new_element($menuid,$show->element_layout_id,$show->sort);
	}
	return;} //ende funktion
?>
<?
function create_googleurl($titel_neu,$menuid)
{
	global $testpfad;
	global $site_id;
	global $home_menu_id;
	$parent_id=find_parent($menuid);
	if($parent_id==0){
		$own_string = "/home";
		$own_url=$own_string.".html";
		$parent_string="";
		$parent_url="";}
	elseif($parent_id==$home_menu_id){
		$own_string="/".replace($titel_neu)."-magazin";$own_string=strtolower($own_string);
		$own_url=$own_string.".html";
		$parent_string="";
		$parent_url="";}
	elseif($parent_id!=0 and $parent_id!=$home_menu_id){
		$own_string="/".replace($titel_neu);$own_string=strtolower($own_string);
		$parent_url=find_googleurl($parent_id);
		$length=strlen($testpfad);
		$parent_url=substr($parent_url,$length);
		$parent_string=substr($parent_url,0,-5);
		$own_url=$parent_string.$own_string.".html";}

	$pre_url_sql=GetSQLValueString($own_url,"text");
	$unique_test=mysql_query("select count(1) as anz, max(appendix_counter) as max from googleurl where site_id=$site_id and googleurl like concat(left($pre_url_sql,CHAR_LENGTH($pre_url_sql)-(LEAST(1,(ifnull(CHAR_LENGTH(appendix_counter),0)*1))+ ifnull(CHAR_LENGTH(appendix_counter),0))-5),'%.html')") or die ("2".mysql_error());
	$unique_test_result=mysql_fetch_assoc($unique_test);
	if($unique_test_result['anz']>0)
	{
		$appendix_counter=$unique_test_result['max']+1;
		$final_url=$parent_string.$own_string."-".$appendix_counter.".html";
	}
	else{$final_url=$own_url;}
		
	if($appendix_counter=="" or $appendix_counter==0){$appendix_counter="NULL";}
	$final_url_sql=GetSQLValueString($final_url,"text");
	mysql_query("insert into googleurl (menu_id, googleurl, appendix_counter, site_id) values ('$menuid',$final_url_sql,$appendix_counter,$site_id)") or die (mysql_error());}
?>
<?
function update_googleurl($menuid)//Funktion zum aktualisieren einer Googleurl + allen anderen darunter in der Hierarchie.
{
	$upd_siblings_arr=menu_select($menuid,"down",99,'','','');
	if(count($upd_siblings_arr[id])==0){return;}
	$i=0;
	do{
		create_googleurl($upd_siblings_arr['description'][$i],$upd_siblings_arr['id'][$i]);
		$i=$i+1;
	} while ($i<count($upd_siblings_arr['id']));}
?>
<? ///new_element erstellt ein neues element und auch die entsprechenden element_content einträge (text, image und code). Benötigt werden nur die menu_id, die element_layout_id, und die sort_order.
function new_element ($f_menu_id,$f_element_layout_id,$f_sort,$site_specific=NULL){
	global $site_id;
	$site_specific_q = mysql_query("SELECT site_specific FROM element_layout WHERE id='$f_element_layout_id'")or die("stop");
	$site_specific_r=mysql_fetch_assoc($site_specific_q);
	if($site_specific_r[site_specific]==1 or $site_specific)
	{mysql_query("INSERT INTO element (menu_id,element_layout_id, sort,site_id) VALUES ('$f_menu_id','$f_element_layout_id','$f_sort','$site_id')")or die("xxx2");}
	else 
	{mysql_query("INSERT INTO element (menu_id,element_layout_id, sort) VALUES ('$f_menu_id','$f_element_layout_id','$f_sort')")or die("xxx");}
	
	###abfrage der erstellten element id
	$element_id="";
	$result1 = mysql_query("SELECT * FROM element order by id desc limit 1")or die("stop");
	while ($show1=mysql_fetch_object($result1))
	{
		###die element_layout mit der layout_id von pagetype abfragen
		$result2 = mysql_query("SELECT * FROM element_layout WHERE id='$f_element_layout_id'")or die("stop");
		while ($show2=mysql_fetch_object($result2))
		{
			//schleife für text
			### wenn text=0 dann nichts tun, sonst schleife durchlaufen, dabei sort immer um +10 erhöhen und damit die pagetype_default_style_tag_text abfragen (sort und element_layout_id) und danach in die element_content_text eintragen
			if ($show2->nr_content_text!="0")
			{$sortx=0;$count="";
				for($count = 1; $count <= $show2->nr_content_text; $count++)
				{
					$sortx=$sortx+10;
					$result3 = mysql_query("SELECT * FROM pagetype_default_style_tag_text WHERE element_layout_ID='$f_element_layout_id' and sort='$sortx'")or die("stop");
					while ($show3=mysql_fetch_object($result3))
					{$default_style_tag="$show3->default_style_tag";$editor="$show3->editor";}
					mysql_query("INSERT INTO element_content_text(element_id,editor,style_tag, sort) VALUES ('$show1->id','$editor','$default_style_tag','$sortx')")or die("xxx3");	
				} // ende for
			} // ende if text !=0
			//schleife für code
			if ($show2->nr_content_code!="0")
			{$sortx=0;$count="";
				for($count = 1; $count <= $show2->nr_content_code; $count++)
				{
					$sortx=$sortx+10;
					$result3 = mysql_query("SELECT * FROM pagetype_default_code_snippets WHERE element_layout_ID='$f_element_layout_id' and sort='$sortx'")or die("stop");
					while ($show3=mysql_fetch_object($result3))
					{$urlxxx="$show3->default_element_content_code_url";$admin_urlxxx="$show3->default_element_content_code_admin_url";}
					mysql_query("INSERT INTO element_content_code(element_id,url,admin_url, sort) VALUES ('$show1->id','$urlxxx','$admin_urlxxx','$sortx')")or die("xxx4");	
				} // ende for
			} // ende if code !=0
			//schleife für img
			if ($show2->nr_content_img!="0")
			{$sortx=0;$count="";
				for($count = 1; $count <= $show2->nr_content_img; $count++)
				{
					$sortx=$sortx+10;
					$result3 = mysql_query("SELECT * FROM pagetype_default_style_tag_img WHERE element_layout_ID='$f_element_layout_id' and sort='$sortx'")or die("stop");
					while ($show3=mysql_fetch_object($result3))
					{$default_type="$show3->default_type";}
					//////GEHT NICHTTTTTTTT
					mysql_query("INSERT INTO element_content_img(element_id,assets_ID,type, sort) VALUES ('$show1->id','0','$default_type','$sortx')")or die("xxx2");	
				} // ende for
			} // ende if img !=0
			
		} // ende result2
	} // end result 1
	return($show1->id);} //ende Funktion
?>
<?
function teaser_setup($elem_id,$teaser_setup,$teaser_setup_id,$teaser_menus,$auto_manual,$skipped,$duplicate)
{ ?>
	<div id="config_box_<? echo $elem_id;?>" style="position: relative; top: 0;	left: 0; width: 620px; background-color: #ffffff;">
		<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">
	
		function update_setup(element_text_id, value)
		{
			var url="Admin_table_result.php";
			url=url+"?task=update&field=text&tabelle=element_content_text&id="+element_text_id+"&value="+value;
			display_data(url,'false');
		}
		
		function elementchange(element_text_id,elem_id,counter,element_nr,img_pos_elem_text_id)
		{
			if(document.getElementById("elementsetup_"+elem_id+"_"+counter).checked==true){var value=1;}else{var value=0;}
			update_setup(element_text_id, value);
			
			if(element_nr==1 && value==0){$("#img_pos_"+elem_id).hide();}//Bildsetting deaktivieren
			if(element_nr==1 && value==1){$("#img_pos_"+elem_id).show();}//Bildsetting deaktivieren
			
			//img_pos_sel NICHT auf "unter Text" lassen wenn kein Bild angezeigt wird. ACHTUNG: wird nicht gespeichert, sondern hart gecoded! Das ist deshalb so, weil bei späterer Änderung wieder das alte Setting aktiv sein soll.
			if(typeof option_selected=="undefined"){option_selected=new Array();}
			if(typeof option_selected[elem_id]=="undefined"){option_selected[elem_id]=$("#img_pos_sel_"+elem_id).val();}
			if(element_nr==1 && value==0 && option_selected[elem_id]==3){option_selected[elem_id]=2;update_setup(img_pos_elem_text_id, option_selected[elem_id]);}
			
			//Wenn "unter Text" ausgewählt ist, werden die truncate Elemente ausgeblendet
			if(element_nr==3 && value==0){$("#truncate_"+elem_id).hide();}//Kurztext -> Truncating deaktivieren
			if(element_nr==3 && value==1){$("#truncate_"+elem_id).show();}//Kurztext -> Truncating deaktivieren
		}
		
		function truncatechange(element_text_id,elem_id)
		{
			if($("#tuncate_yn_"+elem_id).val()==1){var value=1;}else{var value=0;}
			update_setup(element_text_id, value);
			
			if(value==0){$("#truncate_settings_"+elem_id).hide();}//Truncating deaktivieren
			if(value==1){$("#truncate_settings_"+elem_id).show();}//Truncating deaktivieren
		}
		
		function select_method_change(element_text_id,elem_id)
		{
			update_setup(element_text_id,$('#select_method_sel_'+elem_id).val());
		
			var manual_limitors=$('#select_method_sel_'+elem_id+' option:selected').attr("manual_limitors");
			if(manual_limitors==0){$("#such_tiefe_"+elem_id).hide();$("#max_treffer_"+elem_id).hide();}
			if(manual_limitors==1){$("#such_tiefe_"+elem_id).hide();$("#max_treffer_"+elem_id).show();}
			if(manual_limitors==2){$("#such_tiefe_"+elem_id).show();$("#max_treffer_"+elem_id).show();}
		
			if($('#select_method_sel_'+elem_id+' option:selected').attr("auto_manual")=="manual"){var value=1;}else{var value=0;}
			if(value==0){$("#manual_select_box_"+elem_id).hide();}//sibling select text -> deaktivieren
			if(value==1){$("#manual_select_box_"+elem_id).show();}//sibling select text -> deaktivieren

			if($('#select_method_sel_'+elem_id+' option:selected').attr("auto_manual")=="manual" || $('#select_method_sel_'+elem_id+' option:selected').attr("sibling_selection")=="recent"){var value=1;}else{var value=0;}
			if(value==1){$("#sort_method_"+elem_id).hide();}//sorting -> deaktivieren
			if(value==0){$("#sort_method_"+elem_id).show();}//sorting -> deaktivieren

			if($('#select_method_sel_'+elem_id+' option:selected').attr("manual_start_point")=="1"){var value=1;}else{var value=0;}
			if(value==1){$("#manual_start_point_setting_"+elem_id).show();}//sorting -> deaktivieren
			if(value==0){$("#manual_start_point_setting_"+elem_id).hide();}//sorting -> deaktivieren
		}
		
		function rowsetupchange(element_text_id,elem_id,options_allowed_rowsetup_id,options_description,options_help,options_id,img_pos_elem_text_id)
		{
			var options_allowed_rowsetup_id = options_allowed_rowsetup_id.split('~');	
			var options_description = options_description.split('~');
			var options_help = options_help.split('~');
			var options_id = options_id.split('~');
			
			var options_iterations=options_id.length;
			
			var rowsetup_id=$("#spalten_"+elem_id).val();
		
			if(typeof option_selected=="undefined"){option_selected=new Array();}
			if(typeof option_selected[elem_id]=="undefined"){option_selected[elem_id]=$("#img_pos_sel_"+elem_id).val();}
			
			$("#img_pos_sel_"+elem_id).children().remove();
			
			for(var i=0;i<options_iterations;i++)
			{
				if(options_allowed_rowsetup_id[i].search(rowsetup_id) == -1)
				{
					options_allowed_rowsetup_id.splice(i,1);
					options_description.splice(i,1);
					options_help.splice(i,1);
					options_id.splice(i,1);
					i=i-1;
					options_iterations=options_iterations-1;
				}
			}
			
			function append_img_pos_option(elem_id,options_description,options_help,options_id,option_selected_text)
			{$("#img_pos_sel_"+elem_id).append("<option value="+options_id+" title="+options_help+" "+option_selected_text+">"+options_description+"</options");}
			
			for(var i=0;i<options_iterations;i++)
			{
				if(options_id[i]==option_selected[elem_id])
				{var option_selected_text="selected";}else{var option_selected_text="";}
				append_img_pos_option(elem_id,options_description[i],options_help[i],options_id[i],option_selected_text)
			}
			
			update_setup(element_text_id, rowsetup_id);
			update_setup(img_pos_elem_text_id,$("#img_pos_sel_"+elem_id).val());
		}
		
		function img_pos_change(element_text_id,elem_id,img_setting,read_setting,kurztext_setting,parent_setting)
		{
			update_setup(element_text_id,$('#img_pos_sel_'+elem_id).val());
			if(typeof option_selected=="undefined"){option_selected=new Array();}
			option_selected[elem_id]=$("#img_pos_sel_"+elem_id).val();
		
			if(option_selected[elem_id]!=1 && option_selected[elem_id]!=4){$("#textwrap_"+elem_id).hide();}
			if(option_selected[elem_id]==1 || option_selected[elem_id]==4){$("#textwrap_"+elem_id).show();}
		
			if(option_selected[elem_id]==3 || option_selected[elem_id]==6)
			{
				$('#elementsetup_'+elem_id+"_2").attr('checked',true).attr("disabled", false);//Bild soll gezeigt werden
				$('#elementsetup_'+elem_id+"_3").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Read wird nicht ermöglicht
				$('#elementsetup_'+elem_id+"_4").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Kurztext auch nicht
				$('#elementsetup_'+elem_id+"_5").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Parent auch nicht
			}
			if(option_selected[elem_id]!=3 && option_selected[elem_id]!=6)
			{
				$('#elementsetup_'+elem_id+"_2").attr('checked',1==img_setting).attr("disabled", false).next().css("color","#000000");//Bild soll gezeigt werden
				$('#elementsetup_'+elem_id+"_3").attr('checked',1==read_setting).attr("disabled", false).next().css("color","#000000");//Read nicht
				$('#elementsetup_'+elem_id+"_4").attr('checked',1==kurztext_setting).attr("disabled", false).next().css("color","#000000");//Kurztext auch nicht
				$('#elementsetup_'+elem_id+"_5").attr('checked',1==parent_setting).attr("disabled", false).next().css("color","#000000");//Parent auch nicht
			}
		}
		
		</script>
		<?
		global $site_id,$scope;
		if($scope=="seitencontent"){$query_addon="where scope='seitencontent'";}
		if($scope=="main" or $scope=="subcontent"){$query_addon="where scope='main'";}
		
		//load available settings
		$menu_teaser_config_elements_q=mysql_query("select * from menu_teaser_config_elements order by sort");
		$menu_teaser_config_rowsetup_q=mysql_query("select * from menu_teaser_config_rowsetup $query_addon and site_id like '%,$site_id,%' order by sort");
		$menu_teaser_config_select_methods_q=mysql_query("select * from menu_teaser_config_select_methods order by sort");
		$menu_teaser_config_sort_methods_q=mysql_query("select * from menu_teaser_config_sort_methods order by sort");
		$menu_teaser_config_layout_q=mysql_query("select * from menu_teaser_config_layout $query_addon order by sort");
		
		//Es muss noch die Möglichkeit geschaffen werden, das Format im Fall von gesharten Seiten mit Teaser-Element anzupassen...
		//select element_content_text.* from menu_hierarchy, element, element_content_text
		//where menu_hierarchy.site_id=5
		//and element_layout_id=51 
		//and element_content_text.sort=10
		//and menu_hierarchy.menu_id=element.menu_id and element.id=element_content_text.element_id
		
		//rowsetup
		$teaser_rowsetup_q=mysql_query("select * from menu_teaser_config_rowsetup where id=$teaser_setup[1] order by sort") or die ("rowsetup".mysql_error());
		$teaser_rowsetup_r=mysql_fetch_assoc($teaser_rowsetup_q);
		$teaser_rowsetup_id=$teaser_rowsetup_r[id];
	
		///Gestaltet den Pfad f. den manual select button
		$menu_pfad_ids=array();
		if($teaser_menus[1]!=""){
			$menu_parents=(menu_select($teaser_menus[1],"up",99,0,0,0));
				if($teaser_menus[1]==0){break;}
				elseif($teaser_menus[1]==$home_menu_id){array_push($menu_pfad_ids,$home_menu_id);}
				else{$menu_pfad_ids=$menu_parents[id];
				array_shift($menu_pfad_ids);}
		}
		array_push($menu_pfad_ids,"");
		$menu_pfad_ids=array_reverse($menu_pfad_ids);
		
		if(is_array($teaser_menus)){}else{$teaser_menus[0]="";}
		$admin_menu_id_selector="admin_menu_id_selector.php?target=element_content_menu&selected_menu_ids_in_imploded=".implode("|",$teaser_menus)."&menu_pfad_ids_imploded=".implode("|",$menu_pfad_ids)."&element_id=".$elem_id;
	
		##image_pos_config_load
		unset($menu_teaser_config_img_pos_r);
		$menu_teaser_config_img_pos_q=mysql_query("select * from menu_teaser_config_img_pos $query_addon and site_id like '%,$site_id,%' order by sort");
		while(($menu_teaser_config_img_pos_r[] = mysql_fetch_assoc($menu_teaser_config_img_pos_q)) || array_pop($menu_teaser_config_img_pos_r));
		$img_pos_counter=0;
		$img_pos_lines=count($menu_teaser_config_img_pos_r);
	
		do
		{
			?>
			<script>
				if(!options_allowed_rowsetup_id_<? echo $elem_id;?>){var options_allowed_rowsetup_id_<? echo $elem_id;?>="<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][allowed_rowsetup_id];?>";}else{var options_allowed_rowsetup_id_<? echo $elem_id;?>=options_allowed_rowsetup_id_<? echo $elem_id;?>+"~"+"<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][allowed_rowsetup_id];?>";}
				if(!options_description_<? echo $elem_id;?>){var options_description_<? echo $elem_id;?>="<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][description];?>";}else{var options_description_<? echo $elem_id;?>=options_description_<? echo $elem_id;?>+"~"+"<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][description];?>";}
				if(!options_help_<? echo $elem_id;?>){var options_help_<? echo $elem_id;?>="<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][help];?>";}else{var options_help_<? echo $elem_id;?>=options_help_<? echo $elem_id;?>+"~"+"<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][help];?>";}
				if(!options_id_<? echo $elem_id;?>){var options_id_<? echo $elem_id;?>="<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][id];?>";}else{var options_id_<? echo $elem_id;?>=options_id_<? echo $elem_id;?>+"~"+"<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][id];?>";}
			</script>
			<?
			
			if(strpos($menu_teaser_config_img_pos_r[$img_pos_counter][allowed_rowsetup_id],$teaser_rowsetup_id)===false){unset($menu_teaser_config_img_pos_r[$img_pos_counter]);}
			$img_pos_counter=$img_pos_counter+1;
		} while ($img_pos_counter<$img_pos_lines);
		$menu_teaser_config_img_pos_r=array_values($menu_teaser_config_img_pos_r);
		?>
		<div>
			<form method="post" target="_self" name="rowsetup_<? echo $elem_id?>">
				<div id="layoutsetup_<? echo $elem_id?>" style="float:left; margin-top:8px;width:85px;" >
					Layout<br />
					<select id="layout_<? echo $elem_id;?>" name="layout_<? echo $elem_id?>" onchange="update_setup('<? echo $teaser_setup_id[17]?>',$('#layout_<? echo $elem_id;?>').val());">
						<? while($menu_teaser_config_layout_r=mysql_fetch_assoc($menu_teaser_config_layout_q))
						{?>
							<option <? if ($menu_teaser_config_layout_r['id']==$teaser_setup[17]){echo "selected";}?> value='<? echo $menu_teaser_config_layout_r[id];?>' title='<? echo $menu_teaser_config_layout_r[help];?>'><? echo $menu_teaser_config_layout_r[description];?></option>
						 <? }?>
					</select>
					<div id="rollup_check_<? echo $elem_id?>" style="float:none; margin-top:8px;width:85px;" >
						<input id="rollup_checkbox_<? echo $elem_id;?>" type="checkbox" name="rollup_checkbox_<? echo $elem_id?>" <? if ($teaser_setup[18]=="true"){echo "checked";}?> title='Elemente werden ausgeblendet und es erscheint eine Rollup box.' onclick="update_setup('<? echo $teaser_setup_id[18];?>',$('#rollup_checkbox_<? echo $elem_id;?>').attr('checked')=='checked')">Rollup</input>
					</div>
					<div id="thin_sep_<? echo $elem_id?>" style="float:none; margin-top:8px;width:85px;" >
						<input id="thin_seperator_checkbox_<? echo $elem_id;?>" type="checkbox" name="thin_seperator_checkbox_<? echo $elem_id?>" <? if ($teaser_setup[19]=="true"){echo "checked";}?> title='Die separator werden mit geringerem Margin ausgegeben.' onclick="update_setup('<? echo $teaser_setup_id[19];?>',$('#thin_seperator_checkbox_<? echo $elem_id;?>').attr('checked')=='checked')">Schmale Trenner</input>
					</div>
				</div>
				<div id="rowsetup_<? echo $elem_id?>" style="float:left; margin-top:8px;width:65px;" >
					Spalten-<br />
					anzahl
					<select id="spalten_<? echo $elem_id;?>" name="spalten_<? echo $elem_id?>" onchange="rowsetupchange('<? echo $teaser_setup_id[1];?>','<? echo $elem_id?>',options_allowed_rowsetup_id_<? echo $elem_id;?>,options_description_<? echo $elem_id;?>,options_help_<? echo $elem_id;?>,options_id_<? echo $elem_id;?>,'<? echo $teaser_setup_id[6];?>')">
						<? while($menu_teaser_config_rowsetup_r=mysql_fetch_assoc($menu_teaser_config_rowsetup_q))
						{?>
							<option <? if ($menu_teaser_config_rowsetup_r['id']==$teaser_setup[1]){echo "selected";}?> value='<? echo $menu_teaser_config_rowsetup_r[id];?>' title='<? echo $menu_teaser_config_rowsetup_r[help];?>'><? echo $menu_teaser_config_rowsetup_r[description];?></option>
						 <? }?>
					</select>
					<div id="textwrap_<? echo $elem_id?>" style="float:none; margin-top:8px;width:75px;" >
						<input id="textwrap_checkbox_<? echo $elem_id;?>" type="checkbox" name="textwrap_checkbox_<? echo $elem_id?>" <? if ($teaser_setup[16]=="true"){echo "checked";}?> title='Anclicken, wenn der Text um das Bild fließen soll.' onclick="update_setup('<? echo $teaser_setup_id[16];?>',$('#textwrap_checkbox_<? echo $elem_id;?>').attr('checked')=='checked')">Text umfließen</input>
					</div>
				</div>
				<div id="elementsetup_<? echo $elem_id?>" style="float:left; margin-top:8px;width:85px;" >
					Elemente<br />
					<? 
					$i=2;//das ist der Zähler f. d. 4 Elemente.
					while($menu_teaser_config_elements_r=mysql_fetch_assoc($menu_teaser_config_elements_q))
					{?>
						<input id="elementsetup_<? echo $elem_id."_".$i;?>" type="checkbox" name="elementsetup_<? echo $elem_id?>" <? if ($teaser_setup[$i]==1){echo "checked";}?> title='<? echo $menu_teaser_config_elements_r[help];?>' onclick="elementchange('<? echo $teaser_setup_id[$i];?>','<? echo $elem_id; ?>','<? echo $i;?>','<? echo $menu_teaser_config_elements_r[id];?>','<? echo $teaser_setup_id[6];?>')" /><label for="elementsetup_<? echo $elem_id."_".$i;?>"><? echo $menu_teaser_config_elements_r[description];?></label>
						<br />
						<? 
						$i=$i+1;
					}?>
				</div>
				<script>
					if(typeof option_selected=="undefined"){option_selected=new Array();}
					if(typeof option_selected[<? echo $elem_id;?>]=="undefined"){option_selected[<? echo $elem_id;?>]=<? echo $teaser_setup[6];?>;}
		
					if(option_selected[<? echo $elem_id;?>]==3 || option_selected[<? echo $elem_id;?>]==6)
					{
						$('#elementsetup_'+<? echo $elem_id;?>+"_2").attr('checked',true).attr("disabled", false);//Bild soll gezeigt werden
						$('#elementsetup_'+<? echo $elem_id;?>+"_3").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Read nicht
						$('#elementsetup_'+<? echo $elem_id;?>+"_4").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Kurztext auch nicht
						$('#elementsetup_'+<? echo $elem_id;?>+"_5").attr('checked',false).attr("disabled", true).next().css("color","#999999");//Parent auch nicht
					}
				</script>
				<div id="select_method_<? echo $elem_id?>" style="float:left; margin-top:8px;width:145px;" >
					<div>
						Auswahl-<br />
						methode
						<select id="select_method_sel_<? echo $elem_id?>" onchange="select_method_change('<? echo $teaser_setup_id[7];?>','<? echo $elem_id;?>');">
								<? while($menu_teaser_config_select_methods_r=mysql_fetch_assoc($menu_teaser_config_select_methods_q))
								{?>
									<option <? if ($menu_teaser_config_select_methods_r['id']==$teaser_setup[7]){echo "selected";}?> 
										auto_manual="<? echo $menu_teaser_config_select_methods_r[auto_manual]?>" 
										manual_limitors="<? echo $menu_teaser_config_select_methods_r[manual_limitors];?>" 
										sibling_selection="<? echo $menu_teaser_config_select_methods_r[sibling_selection];?>" 
										manual_start_point="<? echo $menu_teaser_config_select_methods_r[manual_start_point];?>"
										value='<? echo $menu_teaser_config_select_methods_r[id];?>' 
										title='<? echo $menu_teaser_config_select_methods_r[help];?>'><? echo $menu_teaser_config_select_methods_r[description];?>
									</option>
								 <? }?>
						</select>
					</div>
					<div id="manual_start_point_setting_<? echo $elem_id;?>">
						Startpunkt:<br />
						<input id="manual_start_point_<? echo $elem_id;?>" value="<? echo $teaser_setup[20];?>" title="Die Menu-ID von der aus die Artikelsuche beginnen soll." style="width:125px;" onchange="update_setup('<? echo $teaser_setup_id[20];?>',$('#manual_start_point_<? echo $elem_id;?>').val());")/>
					</div>
					<script>
					if($('#select_method_sel_<? echo $elem_id;?> option:selected').attr("manual_start_point")!="1"){$("#manual_start_point_setting_"+<? echo $elem_id;?>).hide();}
					</script>
				</div>
				<div id="sort_method_<? echo $elem_id?>" style="float:left; margin-top:8px;width:130px;" >
					Reihung
					<select id="sort1_<? echo $elem_id?>" onchange="update_setup('<? echo $teaser_setup_id[11]?>',$('#sort1_<? echo $elem_id;?>').val());">
						<? 
						mysql_data_seek($menu_teaser_config_sort_methods_q,0);
						while($menu_teaser_config_sort_methods_r=mysql_fetch_assoc($menu_teaser_config_sort_methods_q))
						{?>
							<option <? if ($menu_teaser_config_sort_methods_r['id']==$teaser_setup[11]){echo "selected";}?> value='<? echo $menu_teaser_config_sort_methods_r[id];?>' title='<? echo $menu_teaser_config_sort_methods_r[help];?>'><? echo $menu_teaser_config_sort_methods_r[description];?></option>
						 <? }?>
					</select>
					<select id="sort2_<? echo $elem_id?>" onchange="update_setup('<? echo $teaser_setup_id[12]?>',$('#sort2_<? echo $elem_id;?>').val());">
						<? 
						mysql_data_seek($menu_teaser_config_sort_methods_q,0);
						while($menu_teaser_config_sort_methods_r=mysql_fetch_assoc($menu_teaser_config_sort_methods_q))
						{?>
							<option <? if ($menu_teaser_config_sort_methods_r['id']==$teaser_setup[12]){echo "selected";}?> value='<? echo $menu_teaser_config_sort_methods_r[id];?>' title='<? echo $menu_teaser_config_sort_methods_r[help];?>'><? echo $menu_teaser_config_sort_methods_r[description];?></option>
						 <? }?>
					</select>
					<select id="sort3_<? echo $elem_id?>" onchange="update_setup('<? echo $teaser_setup_id[13]?>',$('#sort3_<? echo $elem_id;?>').val());">
						<? 
						mysql_data_seek($menu_teaser_config_sort_methods_q,0);
						while($menu_teaser_config_sort_methods_r=mysql_fetch_assoc($menu_teaser_config_sort_methods_q))
						{?>
							<option <? if ($menu_teaser_config_sort_methods_r['id']==$teaser_setup[13]){echo "selected";}?> value='<? echo $menu_teaser_config_sort_methods_r[id];?>' title='<? echo $menu_teaser_config_sort_methods_r[help];?>'><? echo $menu_teaser_config_sort_methods_r[description];?></option>
						 <? }?>
					</select>
				</div>
				<script>
					if($('#select_method_sel_<? echo $elem_id;?> option:selected').attr("auto_manual")=="manual" || $('#select_method_sel_<? echo $elem_id;?> option:selected').attr("sibling_selection")=="recent"){$("#sort_method_"+<? echo $elem_id;?>).hide();}					
				</script>
		
				<div style="clear:both; width:100%;height:5px;"></div>
				<div style="clear:both; width:100%;height:1px;" class="trenner"></div>
				<div id="img_pos_<? echo $elem_id?>" style="float:left; margin-top:8px;width:103px;" >
					Bild Position
					<select id="img_pos_sel_<? echo $elem_id?>" onchange="img_pos_change('<? echo $teaser_setup_id[6]?>','<? echo $elem_id;?>','<? echo $teaser_setup[2];?>','<? echo $teaser_setup[3];?>','<? echo $teaser_setup[4];?>','<? echo $teaser_setup[5];?>');">
						<? $img_pos_counter=0;
						do 
						{?> 
							<option <? if ($menu_teaser_config_img_pos_r[$img_pos_counter]['id']==$teaser_setup[6]){echo "selected";}?> value='<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][id];?>' title='<? echo $menu_teaser_config_img_pos_r[$img_pos_counter][help];?>'><? echo $menu_teaser_config_img_pos_r[$img_pos_counter][description];?></option>
						 <? $img_pos_counter=$img_pos_counter+1;} while($img_pos_counter<count($menu_teaser_config_img_pos_r))?>
					</select>
				</div>
				<script>
					if(document.getElementById("elementsetup_<? echo $elem_id."_2";?>").checked==false){$("#img_pos_"+<? echo $elem_id;?>).hide();}
					if($("#img_pos_sel_"+<? echo $elem_id;?>).val()!=1 && $("#img_pos_sel_"+<? echo $elem_id;?>).val()!=4){$("#textwrap_"+<? echo $elem_id;?>).hide();}
					if($("#img_pos_sel_"+<? echo $elem_id;?>).val()==1 || $("#img_pos_sel_"+<? echo $elem_id;?>).val()==4){$("#textwrap_"+<? echo $elem_id;?>).show();}
				</script>
				
				<div id="truncate_<? echo $elem_id;?>" style="float:left; margin-top:8px;width:133px; text-align:right;" >
					Truncating
					<select id="tuncate_yn_<? echo $elem_id;?>" onchange="truncatechange('<? echo $teaser_setup_id[8]?>','<? echo $elem_id;?>');">
						<option <? if ($teaser_setup[8]==0){echo "selected";} ?> value="0">no</option>
						<option <? if ($teaser_setup[8]==1){echo "selected";} ?> value="1">yes</option>
					</select>
					<div id="truncate_settings_<? echo $elem_id;?>">
						Textl&auml;nge: <input id="truncate_length_<? echo $elem_id;?>" type="text" size="2" value="<? echo $teaser_setup[9];?>" onchange="update_setup('<? echo $teaser_setup_id[9]?>',$('#truncate_length_<? echo $elem_id;?>').val());">
						Erzwungen:
						<select id="forced_yn_<? echo $elem_id;?>" onchange="update_setup('<? echo $teaser_setup_id[10]?>',$('#forced_yn_<? echo $elem_id;?>').val());" title="Dann werden auch manuell erstellte Texte abgeschnitten.">
							<option <? if ($teaser_setup[10]==0){echo "selected";} ?> value="0">no</option>
							<option <? if ($teaser_setup[10]==1){echo "selected";} ?> value="1">yes</option>
						</select>
					</div>
				</div>
				<script>
					if(document.getElementById("elementsetup_<? echo $elem_id."_4";?>").checked==false){$("#truncate_"+<? echo $elem_id;?>).hide();}
					if($("#tuncate_yn_<? echo $elem_id;?>").val()==0){$("#truncate_settings_"+<? echo $elem_id;?>).hide();}
				</script>
				<div style="float:left; margin-top:8px;width:140px;">
					<div id="such_tiefe_<? echo $elem_id;?>" style="width:140px;text-align:right;" >
						Such-Tiefe: <input id="manual_depth_<? echo $elem_id;?>" type="text" size="2" value="<? echo $teaser_setup[14];?>" onchange="update_setup('<? echo $teaser_setup_id[14]?>',$('#manual_depth_<? echo $elem_id;?>').val());" style="text-align:right">
					</div>
					<script>
						if($('#select_method_sel_<? echo $elem_id;?> option:selected').attr("manual_limitors") < 2){$("#such_tiefe_"+<? echo $elem_id;?>).hide();}
					</script>
					<div id="max_treffer_<? echo $elem_id;?>" style="width:140px;text-align:right;" >
						Max Treffer: <input id="manual_max_len_<? echo $elem_id;?>" type="text" size="2" value="<? echo $teaser_setup[15];?>" onchange="update_setup('<? echo $teaser_setup_id[15]?>',$('#manual_max_len_<? echo $elem_id;?>').val());" style="text-align:right">
					</div>
					<script>
						if($('#select_method_sel_<? echo $elem_id;?> option:selected').attr("manual_limitors") == 0){$("#max_treffer_"+<? echo $elem_id;?>).hide();}
					</script>
				</div>

				<div style="text-align:right"><input type="submit" value="show current setup"/></div>
			</form>
			<div id="manual_select_box_<? echo $elem_id;?>">
				<div id="manual_select_<? echo $elem_id;?>" style='width:100%;height:10px;'></div>
				<div style="height:42px;width:28px;float:right"></div>
				<div style="background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:4px;height:38px;float:right"></div>
				<div style="background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px; float:right;">
					 <div style="height:38px; float:left;">
						<? if(test_right($_SESSION['user'],"call_menu_id_selector")=="true"){?>
							  <input type="image" onclick="fenster=window.open('<? echo $admin_menu_id_selector; ?>','popUpWindow','width=1200,height=900,left=400,top=50,scrollbars=yes,statusbar=no,personalbar=no,locationbar=no,menubar=no,location=no')" src="/site_12_1/css/button_next.png">
						<? } else{?><img border="0" src="/site_12_1/css/button_next_disabled.png" title="Sie haben nicht die erforderlichen Rechte um Menü-IDs auszuwählen."><? }?>
					 </div><!--,status=no,scrollbars=yes,toolbar=no,location=no,menubar=no,titlebar=no-->
				</div>
				<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
				<div style="clear:right"></div>
				<div id="table_result_error_messages"></div>
			</div>
			<script>
				if($('#select_method_sel_<? echo $elem_id;?> option:selected').attr("auto_manual")=="auto"){$("#manual_select_box_"+<? echo $elem_id;?>).hide();}
			</script>
			<div style="clear:both; width:100%;height:5px;"></div>
			<div style="clear:both; width:100%;height:1px;" class="trenner"></div>
		</div>
		<a style="font-size:9px; color:#999999;">
			Bei Autoelementen gilt folgende Reihenfolge bei der Aufbereitung der Inhalte:
			<br>1) Manuell erstellter Teaser f. dieses Element. 
			<br>2) Manuell erstellter Teaser f. ein anderes Element. 
			<br>3) Manuell erstellter default Teaser. 
			<br>4) Elemente des Typs 'Titel', 'Einleitung' oder irgendein Bild, egal in welchem Element. 
			<br>5a) Metatag-Titel f Titel. 
			<br>5b) Metatag-Description f Einleitung genutzt.  
		</a>
		<div style="clear:both; width:100%;height:1px;" class="trenner"></div>
		<div style="clear: both"></div>
		<?
		if ($auto_manual=="auto" && count($skipped)>0)
		{?>
			<div title="<? echo "Folgende Artikel werden nicht angezeigt: "; echo implode(',',$skipped);?>">
				<img src="/site_12_1/css/Attention_small.png" height="16px" style="margin-bottom:-2px;" />
				<? echo count($skipped)." Einträge werden nicht gezeigt, weil sie die nötigen Elemente (Texte, Bild) nicht aufweisen, oder weil die Seiten nicht aktiv sind.";?>
			</div>
			<div style='width:100%;height:1px;'class='trenner'></div>
			<div style="clear:both"></div>
		<? }
		if (count($duplicate)>0)
		{?>
			<div title="<? echo "Folgende Artikel werden nicht angezeigt: "; echo implode(',',$duplicate);?>"><img src="/site_12_1/css/Attention_small.png" height="16px" style="margin-bottom:-2px;" /> <? echo count($duplicate)." Einträge werden nicht gezeigt, weil sie von einem anderen Teaser schon gezeigt werden.";?></div>
			<div style='width:100%;height:1px;'class='trenner'></div>
			<div style="clear:both"></div>
		<? }?>
		
		<div style="clear:both"></div>
		
	</div>
	<? if($scope=="seitencontent"){echo"<script>changecssproperty(document.getElementById('config_box_$elem_id'), shadowprop, '15px 15px 15px rgba(0,0,0,.5)');$('#config_box_$elem_id').css('margin','10px').css('padding','5px').css('border','thin solid rgb(170, 170, 170)'); $('#config_box_40336').find('.trenner').last().remove();</script>";}
}
?>
<?
function create_menu_teaser($teaser_menu_id,$elem_id){
	global $site_id;
	$teaser_menu_teaser_q=mysql_query("select id from menu_teaser where menu_id='$teaser_menu_id' and element_id='$elem_id' and site_id=$site_id") or die ("2".mysql_error());
	$teaser_menu_teaser_num_rows = mysql_num_rows($teaser_menu_teaser_q);

	if($teaser_menu_teaser_num_rows==0) //hier wird gecheckt, ob schon ein Eintrag da ist. Wenn ja, bleibt er unverändert.
	{ 
		$default_prep_exists_query=mysql_query("select id from menu_teaser where menu_id='$teaser_menu_id' and element_id=0 and site_id=$site_id") or die ("2.1".mysql_error());
		if(mysql_num_rows($default_prep_exists_query)==0) // wenn kein default Eintrag da ist, wird ein neuer Eintrag (nicht default, sondern spezifisch) angelegt und Werten befüllt. 
		{
			mysql_query("INSERT INTO menu_teaser(menu_id,element_id,site_id,editor,asset_h_offset,asset_v_offset,asset_h_offset_percent,asset_v_offset_percent) VALUES('$teaser_menu_id','$elem_id','$site_id','TXT','0','0','0','0')") or die(mysql_error());
			$teaser_head_arr=teaser_text($teaser_menu_id,"Titel",0);$teaser_head=GetSQLValueString($teaser_head_arr[text],"text");
			if($teaser_head!=""){mysql_query("update menu_teaser set teaser_head=$teaser_head where id=last_insert_id()");}
			$teaser_copy_arr=teaser_text($teaser_menu_id,"Copy",0);$teaser_copy=GetSQLValueString($teaser_copy_arr[text],"text");
			if($teaser_head!=""){mysql_query("update menu_teaser set teaser_copy=$teaser_copy where id=last_insert_id()");}
			$teaser_asset_arr=teaser_bild($teaser_menu_id,150,$elem_id);$teaser_asset_id=$teaser_asset_arr[asset_id];
			if($teaser_asset_id>0){mysql_query("update menu_teaser set teaser_asset_id=$teaser_asset_id where id=last_insert_id()");}
		}
		else // Wenn ein default Eintrag da ist, wird dieser kopiert. 
		{
			mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset,asset_h_offset_percent,asset_v_offset_percent, editor, site_id) select '$teaser_menu_id', '$elem_id', teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset,asset_h_offset_percent,asset_v_offset_percent, editor,'$site_id' from menu_teaser where menu_id='$teaser_menu_id' and element_id=0 and site_id=$site_id") or die ("2.2".mysql_error());
		}
	}}
?>


<script src="/Connections/tablesorter/js/jquery.tablesorter.min.js"></script>
<script src="/Connections/tablesorter/js/jquery.tablesorter.widgets.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">

//AJAX Funktion, die das backend aufruft. 
function display_data(url,wait) 

	//test if AJAX is supported	
{url="/site_12_1/admin/"+url;
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null) {alert ("Your browser does not support AJAX!");return;} 

	xmlhttp.onreadystatechange=function() 
	{if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") 
		{document.getElementById('table_result_error_messages').innerHTML=xmlhttp.responseText;}   
	}
	
	if((wait=="true" || !wait) && url.length<500)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
	else if (wait=="false" && url.length<500)
	{
		xmlhttp.open("GET",url,false);
		xmlhttp.send(null);
	}
	else if (url.length>499)
	{
		var lange = url.indexOf("Admin_table_result.php?")+23;
		var params = url.substring(lange);
		var http = new XMLHttpRequest();
		var url = "Admin_table_result.php";
		http.open("POST", url, true);
		
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");
		
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {document.getElementById('table_result_error_messages').innerHTML=xmlhttp.responseText;}
		}
		http.send(params);

	}
}


//Funktion zum Zeichenencodieren von Werten, damit sie in einer URL übergeben werden können.
function URLencode(str,script)
{	
	str = escape(str);
	str = str.replace(/[*+\/@&€]/g,
	function (s) {
		switch (s) {
			case "*": s = "%2A"; break;
			case "+": s = "%2B"; break;
			case "/": s = "%2F"; break;
			case "@": s = "%40"; break;
			case "&": s = "%26"; break;
			case "€": s = "%80"; break;
			}
		return s;
		}
	);
str=str.replace(/\%u201E/g,"%84");
str=str.replace(/\%u201C/g,"%93");
str=str.replace(/\%u2013/g,"%96");
str=str.replace(/\%u2019/g,"´");
str=str.replace(/\%u20AC/g,"%80");
str=secure_code(str,script);
return str;
}


function secure_code(str,script)
{
	if(script!='script' || !script ||script==''){
		str=str.replace(/</g,"&lt;");
		str=str.replace(/>/g,"&gt;");
		//str = str.replace(/'%20'/g,'+');
	}
	else {
		str=str.replace(/%3C/g,"...tagopen...");
		str=str.replace(/%3E/g,"...tagclose...");
		str=str.replace(/</g,"...tagopen...");
		str=str.replace(/>/g,"...tagclose...");
	}
	return str;
}



///FUnktion zum Zeichendecodieren - quasi der reverse-Teil von URLencode
function URLdecode(str) {
str = str.replace(/\+/g, ' ');
str = unescape(str);
return str;
}



//Funktion zum Anzeigen der Eingabefelder
function editField(what,texts){
	//	texts=decodeURIComponent(texts);
	texts=URLdecode(texts);
	var targetWidth=document.getElementById(what.id).offsetWidth; 
	var targetHeight=document.getElementById(what.id).offsetHeight;
	var targetX=$(what).position().left-3; 
	var targetY=$(what).position().top-3; 
	//set all read-only fields to invisible
	//what.style.display="none";
	//set all edit fields to visible
	var objclass=what.className;
	var objid=what.id.substring(0,what.id.indexOf("_div")); 
	if($("#"+what.id).css("color")=="rgb(255, 255, 255)"){document.getElementById(objid).style.color="#aaaaaa"}
	document.getElementById(objid).className=objclass; 
	document.getElementById(objid).style.display="inline";
	document.getElementById(objid).style.width=targetWidth+"px";
	document.getElementById(objid).style.height=targetHeight+"px";
	document.getElementById(objid).style.top=targetY+"px";
	document.getElementById(objid).style.left=targetX+"px";
	document.getElementById(objid).style.position="absolute";
	
	if(texts =="")
	{document.getElementById(objid).value="hier eingeben";document.getElementById(objid).select();}
	//   else {document.getElementById(objid).value=what.innerHTML;}     
	else {document.getElementById(objid).value=texts;}     
	//put curser into the clicked field & select all
	document.getElementById(objid).focus();
}


//Funktion zum aktualisieren der Tabelle mit Textfeld
function updateField(what,tabelle,recordid,script){
value=what.value;
var field=what.name;
var objclass=what.className;
var str2=secure_code(value,script);
if(value=="hier eingeben"){value="";}
if(tabelle==""){return};
//if(value==""){return};
if(field==""){return};
var url="Admin_table_result.php";
url=url+"?task=update&tabelle="+tabelle+"&id="+recordid+"&field="+field+"&value="+URLencode(value,script);
//set all read-only fields to visible
var objid=what.id+"_div";
document.getElementById(objid).style.display="block";
document.getElementById(objid).className=objclass;
//get what is written in the fields and put it into the html
if(value=="")
   {document.getElementById(objid).innerHTML="hier eingeben";
	document.getElementById(objid).style.color="#CCCCCC";}
else{
	document.getElementById(objid).innerHTML=str2;
	document.getElementById(objid).style.color="";
	document.getElementById(objid).onclick = new Function("editField(this,'"+URLencode(value,script)+"')");
}
//set all edit fields to invisible
what.style.display="none"; 
display_data(url);
if(typeof adjust_grey_teaser_bars=="function"){adjust_grey_teaser_bars();} 
}

//Funktion zum aktualisieren der Tabelle mittels FCK Editor
function updateFieldFCK(FCK_Editor_ID,table,recordid,field){
if(table==""){return};
if(recordid==""){return};
if(field==""){return};
var oEditor = FCKeditorAPI.GetInstance(FCK_Editor_ID) ;
var value=(oEditor.GetXHTML( true )) ;
if(value=="" || value=="hier eingeben" || value =="<br />"){value="";}
var url="Admin_table_result.php";
url=url+"?task=update&tabelle="+table+"&id="+recordid+"&field="+field+"&value="+URLencode(value);
//set all read-only fields to visible
var objid=field+"_"+recordid+"_div";
   document.getElementById(objid).style.display="inline";
//get what is written in the fields and put it into the html
	if(value=="")
	   {document.getElementById(objid).innerHTML="hier eingeben";
		document.getElementById(objid).style.color="#CCCCCC";}
	else{document.getElementById(objid).innerHTML=value;
	document.getElementById(objid).style.color="";}
//set all edit fields to invisible
var objhideid=field+"_"+recordid;
   document.getElementById(objhideid).style.display="none"; 
display_data(url); 
}



//Funktion zum Löschen von Zeilen
function deleteRow(what,tabelle,recordid){
//delete from screen
var oRow = what.parentNode.parentNode;
document.getElementById(tabelle).deleteRow(oRow.rowIndex);
//delete from database
var url="Admin_table_result.php";
url=url+"?task=delete&tabelle="+tabelle+"&id="+recordid;
display_data(url); 
if(document.getElementById(tabelle).getElementsByTagName("tr").length==1)
{$("input[name=delete]").hide();}
}


//Funktion zum updaten des DB-Entrags bei Bildern. Eintragen der neuen Asset_ID in the element_content_img
function update_img_db(element_id,asset_id){
//delete from database
var url="Admin_table_result.php";
url=url+"?task=update_img&id="+element_id+"&asset_id="+asset_id;
display_data(url,'false'); 
}


//Funktion zum updaten des exklusiver Seitencontent-pins
function update_exklusiver_seitencontent(menu_id,set){
	var url="Admin_table_result.php";
	url=url+"?task=update_exklusiver_seitencontent&id="+menu_id+"&value="+set;
	display_data(url); 
	elem_id="exkl_seitenc"+menu_id;
	if(set==1){
		document.getElementById(elem_id).src="/site_12_1/css/Pin_unten.jpg";
		document.getElementById(elem_id).onclick = new Function("update_exklusiver_seitencontent("+menu_id+",0)");
		document.getElementById(elem_id).title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Seitencontent wieder vererbt.";
	}
	else if(set==0){
		document.getElementById(elem_id).src="/site_12_1/css/Pin_oben.jpg";
		document.getElementById(elem_id).onclick = new Function("update_exklusiver_seitencontent("+menu_id+",1)");
		document.getElementById(elem_id).title="Der Inhalt wird weitervererbt. Bei clicken wird der Seitencontent exklusiv f. diese eine Seite.";
	}
}




//Funktion zum updaten des exklusiver Sponsorbaner-pins
function update_exklusiver_sponsorbanner(menu_id,set){
	var url="Admin_table_result.php";
	url=url+"?task=update_exklusiver_sponsorbanner&id="+menu_id+"&value="+set;
	display_data(url); 
	elem_id="exkl_sponsor"+menu_id;
	if(set==1){
		document.getElementById(elem_id).src="/site_12_1/css/Pin_unten.jpg";
		document.getElementById(elem_id).onclick = new Function("update_exklusiver_sponsorbanner("+menu_id+",0)");
		document.getElementById(elem_id).title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Sponsorbaner wieder vererbt.";
	}
	else if(set==0){
		document.getElementById(elem_id).src="/site_12_1/css/Pin_oben.jpg";
		document.getElementById(elem_id).onclick = new Function("update_exklusiver_sponsorbanner("+menu_id+",1)");
		document.getElementById(elem_id).title="Der Inhalt wird weitervererbt. Bei clicken wird der Sponsorbaner exklusiv f. diese eine Seite.";
	}
}




//Funktion zum updaten des page-finished Symbols
function update_page_finished(menu_id,set){
	var url="Admin_table_result.php";
	url=url+"?task=update_page_finished&id="+menu_id+"&value="+set;
	display_data(url); 
	elem_id="page_finished"+menu_id;
	if(set==1){
		document.getElementById(elem_id).src="/site_12_1/css/Seitencontent_OK.png";
		document.getElementById(elem_id).onclick = new Function("update_page_finished("+menu_id+",0)");
		document.getElementById(elem_id).title="Die Seite ist fertiggestellt.";
	}
	else if(set==0){
		document.getElementById(elem_id).src="/site_12_1/css/Seitencontent_fehlt.png";
		document.getElementById(elem_id).onclick = new Function("update_page_finished("+menu_id+",1)");
		document.getElementById(elem_id).title="Die Seite ist noch in Arbeit.";
	}
}




//Funktion zum updaten des code-active pins
function update_code_active(codes_id,set){
	var url="Admin_table_result.php";
	url=url+"?task=update_code_active&id="+codes_id+"&value="+set;
	display_data(url); 
	elem_id="code_active"+codes_id;
	if(set==1){
		document.getElementById(elem_id).src="/site_12_1/css/checkbox_checked.png";
		document.getElementById(elem_id).onclick = new Function("update_code_active("+codes_id+",0)");
		document.getElementById(elem_id).title="Das Element wird angezeigt.";
	}
	else if(set==0){
		document.getElementById(elem_id).src="/site_12_1/css/checkbox_unchecked.png";
		document.getElementById(elem_id).onclick = new Function("update_code_active("+codes_id+",1)");
		document.getElementById(elem_id).title="Das Element wird nicht angezeigt.";
	}
}



//Funktion zum updaten des page-finished Symbols
function update_auto_update_flag(user,set){
	var url="Admin_table_result.php";
	url=url+"?task=update_auto_update_flag&user="+user+"&value="+set;
	display_data(url); 
	elem_id="autoupdate";
	if(set==1){
		$("#autoupdate").css("top","0px");
		document.getElementById(elem_id).onclick = new Function("update_auto_update_flag('"+user+"',0)");
		document.getElementById(elem_id).title="Die Menühierarhie wird automatisch bei jeder Veränderung aufgebaut (langsamer).";
		user_config_autoupdate=1;
	}
	else if(set==0){
		$("#autoupdate").css("top","-20px");
		document.getElementById(elem_id).onclick = new Function("update_auto_update_flag('"+user+"',1)");
		document.getElementById(elem_id).title="Die Menühierarhie muss manuell nach allen Veränderungen aufgebaut werden (schneller).";
		user_config_autoupdate=0;
	}
}
</script>
<? 