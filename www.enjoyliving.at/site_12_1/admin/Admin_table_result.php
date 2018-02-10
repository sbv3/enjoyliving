<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if($_GET[task]==""){$task=$_POST[task];} else {$task=$_GET[task];}


if($task=="update")
{
	if($_GET[id]==""){$id=$_POST[id];} else {$id=$_GET[id];}
	if($_GET[field]==""){$field=$_POST[field];} else {$field=$_GET[field];}
	if($_GET[tabelle]==""){$tabelle=$_POST[tabelle];} else {$tabelle=$_GET[tabelle];}
	if($_GET[value]==""){$value=$_POST[value];} else {$value=$_GET[value];}

if($field!="" && $tabelle!=""){
	$updateSQL=sprintf("update $tabelle SET `$field`=%s where ID=%s limit 1",
		GetSQLValueString($value,"text"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
}}

if($task=="update_jq_editable")
{
	if($_GET[pk]==""){$id=$_POST[pk];} else {$id=$_GET[pk];}
	if($_GET[name]==""){$field=$_POST[name];} else {$field=$_GET[name];}
	if($_GET[tabelle]==""){$tabelle=$_POST[tabelle];} else {$tabelle=$_GET[tabelle];}
	if($_GET[value]==""){$value=$_POST[value];} else {$value=$_GET[value];}

if($field!="" && $tabelle!=""){
	$updateSQL=sprintf("update $tabelle SET `$field`=%s where ID=%s limit 1",
		GetSQLValueString($value,"text"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
}}


elseif($task=="add_element_content_menu")
{
	$element_id=$_GET[element_id];
	$menu_id=$_GET[menu_id];
	$element_id=GetSQLValueString($element_id,"int");
	$menu_id=GetSQLValueString($menu_id,"int");	
	
if($element_id!="" && $menu_id!=""){
	$test_element_content_menu_sort=mysql_query("select max(sort) as max_sort from element_content_menu where element_id='$element_id'")or die(mysql_error());
	$test_element_content_menu_sort_result=mysql_fetch_row($test_element_content_menu_sort);
	$max_sort=$test_element_content_menu_sort_result[0];
	$sort=$max_sort+10;
	
	mysql_query("INSERT INTO element_content_menu(element_id, menu_id, sort) VALUES('$element_id', '$menu_id', '$sort')") or die(mysql_error());
}}


elseif($task=="remove_element_content_menu")
{
	$element_id=$_GET[element_id];
	$menu_id=$_GET[menu_id];
	$element_id=GetSQLValueString($element_id,"int");
	$menu_id=GetSQLValueString($menu_id,"int");	
	
	if($element_id!="" && $menu_id!=""){
	$deleteSQL=mysql_query("delete from element_content_menu where element_id='$element_id' and menu_id='$menu_id'") or die(mysql_error());
}}


elseif($task=="add_menu_teaser")
{
	$menu_id=$_GET[menu_id];
	$element_id=$_GET[element_id];
	$menu_id=GetSQLValueString($menu_id,"int");	
	$element_id=GetSQLValueString($element_id,"int");	
	
	if($menu_id!=""){
		$test_menu_teaser=mysql_query("select menu_id from menu_teaser where menu_id='$menu_id' and element_id='$element_id' and site_id=$site_id")or die(mysql_error());
		$test_menu_teaser_num_rows=mysql_num_rows($test_menu_teaser);
		if($test_menu_teaser_num_rows == 0){
			mysql_query("INSERT INTO menu_teaser(menu_id,element_id) VALUES('$menu_id','$element_id')") or die(mysql_error());
		}
	}
}


if($task=="update_menu_teaser")
{
	$menu_teaser_id=$_GET[menu_teaser_id];
	$field=$_GET[field];
	$value=$_GET[value];
	$value=urldecode($value);
	$value=GetSQLValueString($value,"text");

	if($field!="" && $value!=""){
	$updateSQL=sprintf("update menu_teaser SET $field=$value where id=%s",
		GetSQLValueString($menu_teaser_id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
}}



elseif($task=="delete")
{
	$id=$_GET[id];
	$id=GetSQLValueString($id,"int");
	$table=$_GET[tabelle];
	$deleteSQL=mysql_query("delete from $table where id=$id") or die (mysql_error());
}


elseif($task=="add_user")
{
	$name=GetSQLValueString($_GET[value],"text");
	$id=GetSQLValueString($usergroupid,"int");
	$user_id_query=mysql_query("select ID from user_users where username=$name") or die (mysql_error());
	$totalRows_user_id_query = mysql_num_rows($user_id_query);
	if($totalRows_user_id_query == 1)
          {while($row = mysql_fetch_assoc($user_id_query))
     		{$user_id=$row[ID];}
		}
	if($user_id!=""){
		$test_user_users_x_groups_query=mysql_query("select * from user_users_x_groups where users_ID='$user_id' and groups_ID='$id'")or die(mysql_error());
		$totalRows_test_user_users_x_groups_query = mysql_num_rows($test_user_users_x_groups_query);
		if($totalRows_test_user_users_x_groups_query){echo "existiert schon";} else
		{mysql_query("INSERT INTO user_users_x_groups (users_id, groups_ID) VALUES('$user_id', '$id') ") or die(mysql_error());} 	
	}
}


elseif($task=="delete_user")
{
	$name=GetSQLValueString($_GET[value],"text");
	$id=GetSQLValueString($usergroupid,"int");
	$user_id_query=mysql_query("select ID from user_users where username=$name") or die (mysql_error());
	$totalRows_user_id_query = mysql_num_rows($user_id_query);
	if($totalRows_user_id_query == 1)
          {while($row = mysql_fetch_assoc($user_id_query))
     		{$user_id=$row[ID];}
		}
	if($user_id!=""){
		$test_user_users_x_groups_query=mysql_query("select * from user_users_x_groups where users_ID='$user_id' and groups_ID='$id'")or die(mysql_error());
		$totalRows_test_user_users_x_groups_query = mysql_num_rows($test_user_users_x_groups_query);
		if($totalRows_test_user_users_x_groups_query)
		{mysql_query("delete from user_users_x_groups where users_id='$user_id' and groups_ID='$id'") or die(mysql_error());} 
		else {echo "existiert nicht";} 	
	}
}



elseif($task=="add_right")
{
	$right=GetSQLValueString($_GET[value],"text");
	$id=GetSQLValueString($usergroupid,"int");
	$rights_id_query=mysql_query("select ID from user_rights where description=$right") or die (mysql_error());
	$totalRows_rights_id_query = mysql_num_rows($rights_id_query);
	if($totalRows_rights_id_query == 1)
          {while($row = mysql_fetch_assoc($rights_id_query))
     		{$rights_id=$row[ID];}
		}
	if($rights_id!=""){
		$test_user_groups_x_rights=mysql_query("select * from user_groups_x_rights where rights_ID='$rights_id' and groups_ID='$id'")or die(mysql_error());
		$totalRows_test_user_groups_x_rights = mysql_num_rows($test_user_groups_x_rights);
		if($totalRows_test_user_groups_x_rights){echo "existiert schon";} else
		{mysql_query("INSERT INTO user_groups_x_rights (rights_ID, groups_ID) VALUES('$rights_id', '$id') ") or die(mysql_error());} 	
	}
}


elseif($task=="delete_right")
{
	$right=GetSQLValueString($_GET[value],"text");
	$id=GetSQLValueString($usergroupid,"int");
	$rights_id_query=mysql_query("select ID from user_rights where description=$right") or die (mysql_error());
	$totalRows_rights_id_query = mysql_num_rows($rights_id_query);
	if($totalRows_rights_id_query == 1)
          {while($row = mysql_fetch_assoc($rights_id_query))
     		{$rights_id=$row[ID];}
		}
	if($rights_id!=""){
		$test_user_groups_x_rights=mysql_query("select * from user_groups_x_rights where rights_ID='$rights_id' and groups_ID='$id'")or die(mysql_error());
		$totalRows_test_user_groups_x_rights = mysql_num_rows($test_user_groups_x_rights);
		if($totalRows_test_user_groups_x_rights)
		{mysql_query("delete from user_groups_x_rights where rights_ID='$rights_id' and groups_ID='$id'") or die(mysql_error());} 
		else {echo "existiert nicht";} 	
	}
}


elseif($task=="add_site")
{
	$site_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$site_id_query=mysql_query("select ID from sites where description=$site_sql") or die (mysql_error());
	$totalRows_site_id_query = mysql_num_rows($site_id_query);
	if($totalRows_site_id_query == 1)
          {while($row = mysql_fetch_assoc($site_id_query))
     		{$site_id_r=$row[ID];}
		}
	if($site_id_r!=""){
		$test_user_site_x_group=mysql_query("select * from user_sites_x_groups where sites_ID='$site_id_r' and groups_ID='$id_sql'")or die(mysql_error());
		$totalRows_test_user_site_x_group = mysql_num_rows($test_user_site_x_group);
		if($totalRows_test_user_site_x_group){echo "existiert schon";} else
		{mysql_query("INSERT INTO user_sites_x_groups (sites_ID, groups_ID) VALUES('$site_id_r', '$id_sql') ") or die(mysql_error());} 	
	}
}


elseif($task=="delete_site")
{
	$site_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$site_id_query=mysql_query("select ID from sites where description=$site_sql") or die (mysql_error());
	$totalRows_site_id_query = mysql_num_rows($site_id_query);
	if($totalRows_site_id_query == 1)
          {while($row = mysql_fetch_assoc($site_id_query))
     		{$site_id_r=$row[ID];}
		}
	if($site_id_r!=""){
		$test_user_site_x_group=mysql_query("select * from user_sites_x_groups where sites_ID='$site_id_r' and groups_ID='$id_sql'")or die(mysql_error());
		$totalRows_test_user_site_x_group = mysql_num_rows($test_user_site_x_group);
		if($totalRows_test_user_site_x_group)
		{mysql_query("delete from user_sites_x_groups where sites_ID='$site_id_r' and groups_ID='$id_sql'") or die(mysql_error());} 
		else {echo "existiert nicht";} 	
	}
}


elseif($task=="add_wfl_group")
{
	$wfl_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$wfl_id_query=mysql_query("select id from wfl_workflows_templates where title=$wfl_sql") or die (mysql_error());
	$totalRows_wfl_id_query = mysql_num_rows($wfl_id_query);
	if($totalRows_wfl_id_query == 1)
          {while($row = mysql_fetch_assoc($wfl_id_query))
     		{$wfl_id=$row[id];}
		}
	if($wfl_id!=""){
		$test_wfl_x_group=mysql_query("select * from wfl_workflow_templates_x_user_groups where wfl_workflows_templates_id='$wfl_id' and user_groups_id='$id_sql'")or die(mysql_error());
		$totalRows_test_wfl_x_group = mysql_num_rows($test_wfl_x_group);
		if($totalRows_test_wfl_x_group>0){echo "existiert schon";} else
		{mysql_query("INSERT INTO wfl_workflow_templates_x_user_groups (wfl_workflows_templates_id, user_groups_id) VALUES('$wfl_id', '$id_sql') ") or die(mysql_error());} 	
	}
}


elseif($task=="delete_wfl_group")
{
	$wfl_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$wfl_id_query=mysql_query("select id from wfl_workflows_templates where title=$wfl_sql") or die (mysql_error());
	$totalRows_wfl_id_query = mysql_num_rows($wfl_id_query);
	if($totalRows_wfl_id_query == 1)
          {while($row = mysql_fetch_assoc($wfl_id_query))
     		{$wfl_id=$row[id];}
		}
	if($wfl_id!=""){
		$test_wfl_x_group=mysql_query("select * from wfl_workflow_templates_x_user_groups where wfl_workflows_templates_id='$wfl_id' and user_groups_id='$id_sql'")or die(mysql_error());
		$totalRows_test_wfl_x_group = mysql_num_rows($test_wfl_x_group);
		if($totalRows_test_wfl_x_group>0)
		{mysql_query("delete from wfl_workflow_templates_x_user_groups where wfl_workflows_templates_id='$wfl_id' and user_groups_id='$id_sql'") or die(mysql_error());} 
		else {echo "existiert nicht";} 	
	}
}


elseif($task=="add_site_pool")
{
	$site_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$site_id_query=mysql_query("select ID from sites where description=$site_sql") or die (mysql_error());
	$totalRows_site_id_query = mysql_num_rows($site_id_query);
	if($totalRows_site_id_query == 1)
          {while($row = mysql_fetch_assoc($site_id_query))
     		{$site_id_r=$row[ID];}
		}
	if($site_id_r!=""){
		$test_user_site_x_group=mysql_query("select * from user_groups_x_site_pool where site_id='$site_id_r' and group_id='$id_sql'")or die(mysql_error());
		$totalRows_test_user_site_x_group = mysql_num_rows($test_user_site_x_group);
		if($totalRows_test_user_site_x_group){echo "existiert schon";} else
		{mysql_query("INSERT INTO user_groups_x_site_pool (site_id, group_id) VALUES('$site_id_r', '$id_sql') ") or die(mysql_error());} 	
	}
}


elseif($task=="delete_site_pool")
{
	$site_sql=GetSQLValueString($_GET[value],"text");
	$id_sql=GetSQLValueString($usergroupid,"int");
	$site_id_query=mysql_query("select ID from sites where description=$site_sql") or die (mysql_error());
	$totalRows_site_id_query = mysql_num_rows($site_id_query);
	if($totalRows_site_id_query == 1)
          {while($row = mysql_fetch_assoc($site_id_query))
     		{$site_id_r=$row[ID];}
		}
	if($site_id_r!=""){
		$test_user_site_x_group=mysql_query("select * from user_groups_x_site_pool where site_id='$site_id_r' and group_id='$id_sql'")or die(mysql_error());
		$totalRows_test_user_site_x_group = mysql_num_rows($test_user_site_x_group);
		if($totalRows_test_user_site_x_group)
		{mysql_query("delete from user_groups_x_site_pool where site_id='$site_id_r' and group_id='$id_sql'") or die(mysql_error());} 
		else {echo "existiert nicht";} 	
	}
}



elseif($task=="update_img")
{
	if($id!="" && $asset_id!=""){
	$updateSQL=sprintf("update element_content_img SET assets_ID=%s where id=%s",
		GetSQLValueString($asset_id,"int"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
}

elseif($task=="update_exklusiver_seitencontent")
{
	if($id!="" && $value!=""){
	$updateSQL=sprintf("update menu_hierarchy SET exklusiver_seitencontent='%s' where site_id=$site_id and menu_id=%s",
		GetSQLValueString($value,"int"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
}

elseif($task=="update_exklusiver_sponsorbanner")
{
	if($id!="" && $value!=""){
	$updateSQL=sprintf("update menu_hierarchy SET exklusiver_sponsorbanner='%s' where site_id=$site_id and menu_id=%s",
		GetSQLValueString($value,"int"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
}

elseif($task=="update_auto_update_flag")
{
	if($user!="" && $value!=""){
	$updateSQL=sprintf("update user_users SET auto_update_menu_hierarchy='%s' where username=%s",
		GetSQLValueString($value,"int"),
		GetSQLValueString($user,"text"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	$_SESSION['autoupdate'] = $value;
	}
}

elseif($task=="update_page_finished")
{
	if($id!="" && $value!=""){
	$updateSQL=sprintf("update menu SET page_finished='%s' where id=%s",
		GetSQLValueString($value,"int"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
}

elseif($task=="update_code_active")
{
	if($id!="" && $value!=""){
	$updateSQL=sprintf("update element_content_code SET active='%s' where id=%s",
		GetSQLValueString($value,"int"),
		GetSQLValueString($id,"int"));
	$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
}

elseif($task=="add_share")
{
	$site=GetSQLValueString($_GET['site_add'],"int");
	$menu=GetSQLValueString($_GET['menu_add'],"int");
	if($site!="" && $menu!=""){
		$test_q=mysql_query("select id from menu_pool where menu_id='$menu' and site_id='$site'");
		if(mysql_num_rows($test_q)==0){
			$updateSQL=sprintf("insert into menu_pool (menu_id,site_id) values ('$menu','$site')");
			$Result1=mysql_query($updateSQL) or die (mysql_error());
		}
	}
}

elseif($task=="remove_share")
{
	$site=GetSQLValueString($_GET['site_rem'],"int");
	$menu=GetSQLValueString($_GET['menu_rem'],"int");
	if($site!="" && $menu!=""){
		$test_q=mysql_query("select ID from menu_hierarchy where menu_id='$menu' and site_id='$site'");
		if(mysql_num_rows($test_q)==0){
			$deleteSQL=sprintf("delete from menu_pool where menu_id='$menu' and site_id='$site'");
			$Result1=mysql_query($deleteSQL) or die (mysql_error());
		}
	}
}

elseif($task=="add_menu_pool")
{
	$parent_id=$_GET[element_id];
	$menu_id=$_GET[menu_id];
	$parent_id=GetSQLValueString($parent_id,"int");
	$menu_id=GetSQLValueString($menu_id,"int");	
	$site=GetSQLValueString($site_id_in,"int");
	
	if($parent_id!="" && $menu_id!=""){
		$test_menu_hierarchy_q=mysql_query("select id, display, active_startdate, active_enddate,active, exklusiver_sponsorbanner, exklusiver_seitencontent from menu_hierarchy where site_id=$site_id and menu_id=$menu_id and parent_id=$parent_id")or die(mysql_error());
		if(mysql_num_rows($test_menu_hierarchy_q)==0){
			$test_menu_hierarchy_sort_q=mysql_query("select max(sort) as max_sort from menu_hierarchy where parent_id=$parent_id and site_id=$site_id")or die(mysql_error());
			$test_menu_hierarchy_sort_r=mysql_fetch_row($test_menu_hierarchy_sort_q);
			$max_sort=$test_menu_hierarchy_sort_r[0];
			$sort=$max_sort+10;
			mysql_query("INSERT INTO menu_hierarchy(menu_id, parent_id, site_id, sort, display, active_startdate, active_enddate,active, exklusiver_sponsorbanner, exklusiver_seitencontent) select menu_id, $parent_id, $site_id, $sort, display, active_startdate, active_enddate,active, exklusiver_sponsorbanner, exklusiver_seitencontent from menu_hierarchy where site_id=$site and menu_id=$menu_id") or die(mysql_error());

			$menuid_hier_q=mysql_query("select last_insert_id() as menuid_hier, display, active from menu_hierarchy where id=last_insert_id()");
			$menuid_hier_r=mysql_fetch_assoc($menuid_hier_q);
			$menuid_hier=$menuid_hier_r[menuid_hier];
			$menuid_display=$menuid_hier_r[display];
			$menuid_active=$menuid_hier_r[active];
			
			//absolute_sort,is_menu_hierarchy,is_active_hierarchy,pfad,level
			if($sort == 10)
			{
				$rebuild_paths_sort_q1=mysql_query("SELECT absolute_sort FROM menu_hierarchy WHERE menu_id='$parent_id' and site_id='$site_id'");
				$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q1);
				$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort]+1;
			}
			else
			{
				$rebuild_paths_sort_q2=mysql_query("SELECT absolute_sort FROM menu_hierarchy WHERE parent_id='$parent_id' and site_id='$site_id' AND sort>'$sort' ORDER BY sort asc LIMIT 1");
				if(mysql_numrows($rebuild_paths_sort_q2)==0)
				{
					$rebuild_paths_sort_q3=mysql_query("select max(absolute_sort) as absolute_sort from menu_hierarchy,
(SELECT menu_id FROM menu_hierarchy WHERE parent_id='$parent_id' and site_id='$site_id' AND sort<'$sort' ORDER BY sort desc limit 1) as limiter where limiter.menu_id = menu_hierarchy.parent_id and site_id=$site_id");
					$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q3);
					$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort]+1;
					}
				else
				{
					$rebuild_paths_sort_r=mysql_fetch_assoc($rebuild_paths_sort_q2);
					$rebuild_paths_absolute_sort=$rebuild_paths_sort_r[absolute_sort]+1;
				}
			}


			$rebuild_paths_q=mysql_query("SELECT is_menu_hierarchy, is_active_hierarchy, pfad, level FROM menu_hierarchy WHERE menu_id='$parent_id' and site_id='$site_id' LIMIT 1");
			$rebuild_paths_r=mysql_fetch_assoc($rebuild_paths_q);
			
			$rebuild_paths_id=$menuid_hier;
			if($rebuild_paths_r[is_menu_hierarchy]==1 and $menuid_display==1){$rebuild_paths_is_menu_hierarchy=1;}else{$rebuild_paths_is_menu_hierarchy=0;}
			if($rebuild_paths_r[is_active_hierarchy]==1 and $menuid_active=="A"){$rebuild_paths_is_active_hierarchy=1;}else{$rebuild_paths_is_active_hierarchy=0;}
			$rebuild_paths_pfad=$rebuild_paths_r[pfad]."/".$menu_id;
			$rebuild_paths_level=$rebuild_paths_r[level]+1;
			
			mysql_query("update menu_hierarchy set absolute_sort=absolute_sort+1 where absolute_sort >= $rebuild_paths_absolute_sort");
			mysql_query("update menu_hierarchy set 
					 absolute_sort=$rebuild_paths_absolute_sort,
					 is_menu_hierarchy=$rebuild_paths_is_menu_hierarchy, 
					 is_active_hierarchy=$rebuild_paths_is_active_hierarchy, 
					 pfad='$rebuild_paths_pfad', 
					 level=$rebuild_paths_level 
					 
					 where id=$rebuild_paths_id limit 1");

			$titel_neu=find_description($menu_id);
			create_googleurl($titel_neu, $menu_id);
		}
	}
}


elseif($task=="remove_menu_pool")
{
	$parent_id=$_GET[element_id];
	$menu_id=$_GET[menu_id];
	$parent_id=GetSQLValueString($parent_id,"int");
	$menu_id=GetSQLValueString($menu_id,"int");	
	$site=GetSQLValueString($site_id_in,"int");	

	if($parent_id!="" && $menu_id!=""){
		$deleteSQL=mysql_query("delete from menu_hierarchy where site_id=$site and menu_id='$menu_id'") or die(mysql_error());
	}
}

elseif($task=="rebuild_hierarchy_paths")
{rebuild_hierarchy_paths();}
?>