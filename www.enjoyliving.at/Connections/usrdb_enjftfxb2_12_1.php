<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
ini_set("include_path",ini_get("include_path").":/home/enjftfxb/www.enjoyliving.at:".$_SERVER['DOCUMENT_ROOT']); 

//$testpfad="/neuesmag";
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once("db_link.php");
require_once("pwd.php");
//require_once("jquery-1.7.2.php");
?>
<script>
function initJQuery() {
    if (typeof(jQuery) == 'undefined') {
		document.write("<scr" + "ipt type='text/javascript' src='/Connections/jquery-1.9.1.js'></scr" + "ipt>");
    }            
}
initJQuery();

</script>
<?
$date=date("Y-m-d");
//$hostname_usrdb_enjftfxb2 = "127.0.0.1:3307";
$database_usrdb_enjftfxb2 = "usrdb_enjftfxb2";
$username_usrdb_enjftfxb2 = "enjftfxb2";
$password_usrdb_enjftfxb2 = $db_pwd;
$usrdb_enjftfxb2 = mysql_pconnect($hostname_usrdb_enjftfxb2, $username_usrdb_enjftfxb2, $password_usrdb_enjftfxb2) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_usrdb_enjftfxb2, $usrdb_enjftfxb2);
?>
<?

if(!$_GET['siteid']){}else{$site_id=$_GET['siteid'];}
//if(!$site_id or $site_id==""){$site_id=$_POST['site_id'];}
if(!$site_id or $site_id==""){
	$host_string=$_SERVER['HTTP_HOST'];
	$css_path_q=mysql_query("select id, description, css_path, favicon_url, top_menu_id,menu_hierarchy_update_needed, logo_url from sites where host_string = '$host_string'");
	if(mysql_num_rows($css_path_q)>0)
	{
		$css_path_r=mysql_fetch_assoc($css_path_q);
		$css_path=$css_path_r['css_path'];
		$site_id=$css_path_r['id'];
		$site_description=$css_path_r['description'];
		$home_menu_id=$css_path_r['top_menu_id'];
		$menu_hierarchy_update_needed=$css_path_r['menu_hierarchy_update_needed'];
		$logo_url=$css_path_r['logo_url'];
		$favicon_url=$css_path_r['favicon_url'];
	}
	else
	{
		$site_id=1;
		$load_details=1;
		$host_string="www.enjoyliving.at";
	}
}
else
{
	$load_details=1;
}
if($load_details==1)
{
	$css_path_q=mysql_query("select description, host_string, css_path, favicon_url, top_menu_id,menu_hierarchy_update_needed, logo_url from sites where id = $site_id");
	$css_path_r=mysql_fetch_assoc($css_path_q);
	$css_path=$css_path_r['css_path'];
	$host_string=$css_path_r['host_string'];
	$site_description=$css_path_r['description'];
	$home_menu_id=$css_path_r['top_menu_id'];
	$menu_hierarchy_update_needed=$css_path_r['menu_hierarchy_update_needed'];
	$logo_url=$css_path_r['logo_url'];
	$favicon_url=$css_path_r['favicon_url'];
}
//echo "<br>site_id: ".$site_id;
//echo " | site_name: ".$site_description;
//echo " | home_menu_id ".$home_menu_id;
//echo " | logo_url ".$logo_url;

$href_root="http://".$host_string;
$google_analytics_query=mysql_query("select analytics_id, google_ad_client, google_ad_slot, google_ad_contentempfehlung, google_ad_slot_seitencontent, google_ad_channel, seitencontent, banners, onsitestats, title, managing_editor from sites where id=$site_id");
$google_analytics_result=mysql_fetch_assoc($google_analytics_query);
$google_analytics=$google_analytics_result['analytics_id'];
$google_ad_client=$google_analytics_result['google_ad_client']; //adwords client id
$google_ad_channel=$google_analytics_result['google_ad_channel']; //f. adwords include
$google_ad_slot=$google_analytics_result['google_ad_slot']; //f. adwords include
$google_ad_contentempfehlung=$google_analytics_result['google_ad_contentempfehlung']; //f. adwords include
$google_ad_slot_seitencontent=$google_analytics_result['google_ad_slot_seitencontent']; //f. seitencontent-adwords include
$seitencontent=$google_analytics_result['seitencontent']; //display of seitencontent
$banners=$google_analytics_result['banners']; //display of banners
$onsitestats=$google_analytics_result['onsitestats']; //display of banners
$home_menu_parent=find_parent($home_menu_id); //display of banners
$site_title=$google_analytics_result['title']; 
$managing_editor=$google_analytics_result['managing_editor']; 

if($css_is_included==0){include ($_SERVER['DOCUMENT_ROOT'].$css_path);$css_is_included=1;}
?>
<link rel="shortcut icon" type="image/x-icon" href="<? echo $href_root.$favicon_url; ?>">
<? 

?>
<? /////Bots identifizieren
function checkBot($string) {
	$bots = array(	
	'bot','altaVista intranet','beholder','fido','gazz','scan','medicalmatrix','ultraseek','ezresult','ask jeeves/teoma','looksmart','Ask Jeeves','crawler','msnbot','Baiduspider','Mediapartners-Google','bumblebee','crescent','gigabaz','fireball','mercator','quosa','piranha','informant','libwww','url_spider_sql','TECNOSEEK','www.galaxy.com','appie','Feedfetcher-Google','Sogou web spider','java','arachnoidea','cherrypicker','emailsiphon','gulliver','link','larbin','miixpc','t-h-u-n-d-e-r-s-t-o-n-e','swisssearch','teoma','firefly','InfoSeek','Googlebot','FAST','TechnoratiSnoop','WebAlta Crawler','alexa','froogle','gigabot','girafabot','inktomi','nationaldirectory','rabaz','Rankivabot','Scooter','Slurp','Spade','WebBug','WebFindBot','ZyBorg','agentname','asterias','cosmos','crawl','emailwolf','extractorpro','hcat','hloader','incywincy','indy library','internetami','internetseer','libweb','mata hari','moget','muscatferret','openxxx','robo','search','sly','spider','spy','spyder','sqworm','trivial','webbandit','wisewire','jeeves','yandex','google','yahoo','archiver','curl','python','nambu','twitt','perl','shpere','PEAR','wordpress','radian','eventbox','monitor','mechanize','facebookexternal'
	);
	$string = strtolower($string);
	$i = 0;
	$summe = count($bots);
	
	while ($i < $summe) {
	  if (strstr($string, $bots[$i])) return true;
	  $i++;
	}
	return false;}
?>
<?
function find_googleurl($menu_id,$site_id_in=null){
	global $testpfad;
	if($site_id_in){$site_id=$site_id_in;}else{global $site_id;}
	$googleurl_query=mysql_query("select googleurl from googleurl where menu_id='$menu_id' and site_id=$site_id order by create_date desc limit 1") or die ("1".mysql_error());
	$googleurl_result=mysql_fetch_row($googleurl_query);
	$googleurl=$googleurl_result[0];
	return($testpfad.$googleurl);}
?>
<?
function find_parent($menu_id,$site_id_in=null){
	if($site_id_in){$site_id=$site_id_in;}else{global $site_id;}
	$parent_query=mysql_query("select parent_id from menu_hierarchy where menu_id='$menu_id' and site_id='$site_id'") or die ("parent_query failed");
	$result=mysql_fetch_assoc($parent_query);
	$result=$result[parent_id];
	return $result;
	}
?>
<?
function find_description($menu_id){
	$parent_query=mysql_query("select description from menu where id='$menu_id'") or die ("parent_query failed");
	$result=mysql_fetch_assoc($parent_query);
	$result=$result[description];
	return $result;
	}
?>
<?
function menu_select($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id_in=null){
	//function to select parent_ids or daughter_ids of the menu.
	//$start_id ist die ID, von der weg geprüft werden soll.
	//$direction ist entweder "up" oder "down".
	//$numer_levels ist ein numerischer Wert, der nur bei "down" relevanz hat. Er gibt an, wie viele Ebenen durchsucht werden sollen.
	//$only active ist enteder "1" oder was anderes. Nur wenn es "1" ist, werden nur die aktiven Einträge druchsucht. 
	//$menu_only ist entweder "1" oder "2" oder was anderes. Nur wenn es "1" ist, werden nur die Menüeinträge gezeigt. Wenn es "2" ist, werden nur jene Einträge wieder gegeben, die selbst kein Meunü sind.
	//$site_id_in kann gesetzt werden um die Ergebnisse einer anderen Site zu erhalten - ist f. Menu-sharing im menu_id_selektor wichtig
	//Aufrufen durch: print_r(menu_select('46','down','1','',''));
	unset($GLOBALS['menu_select_siblings']);
	unset($GLOBALS['menu_select_parent']);
	if($only_active=="1")
		{
			$search_append_string="and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A'"; 
			$search_append_string_down=" and is_active_hierarchy=1 ";
		}
	if($menu_only=="1"){$search_append_string_down.=" and is_menu_hierarchy=1 ";}
	if($exclude_subseiten=="1"){$search_append_string=$search_append_string." and search_type not like '%Subseiten%'";$search_append_string_down2=" and search_type not like '%Subseiten%'";}

/*//test ob schon eine solche Abfrage gemacht wurde
if(function_exists('test_menu_select_cache')){} else
{
	function test_menu_select_cache($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id)
	{
		if($only_active==null){$only_active=0;}
		if($menu_only==null){$menu_only=0;}
		if($exclude_subseiten==null){$exclude_subseiten=0;}
		if($number_levels==null){$number_levels=0;}

		$append_query.=" and only_active=$only_active";
		$append_query.=" and menu_only=$menu_only";
		$append_query.=" and exclude_subseiten=$exclude_subseiten";
		$append_query.=" and site_id=$site_id";
		$append_query.=" and number_levels=$number_levels";
		
		$test_q=mysql_query("select result from menu_select_cache where start_id=$start_id and direction='$direction' $append_query") or die("test_query: ".mysql_error());
	
		if(mysql_num_rows($test_q)>0)
		{
			$test_r=mysql_fetch_assoc($test_q);
			$result=$test_r[result];
			$result=unserialize($result);
		}
		else
		{
			$result=null;
		}		
		return($result);
	}
}
//test ende

//insert machen
if(function_exists('update_menu_select_cache')){} else
{
	function update_menu_select_cache($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id,$result)
	{
		static $counter;
		if($only_active==null){$only_active=0;}
		if($menu_only==null){$menu_only=0;}
		if($exclude_subseiten==null){$exclude_subseiten=0;}
		if($number_levels==null){$number_levels=0;}
		
		$result=serialize($result);
		$result=GetSQLValueString($result,"text");
//		if($_SERVER['REMOTE_ADDR']=="194.96.116.115" and $counter==0){
			$update_q=mysql_query("insert into menu_select_cache (start_id,direction,number_levels,only_active,menu_only,exclude_subseiten,site_id,result) values ($start_id,'$direction',$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id,$result)") or die ("update_query: ".mysql_error());
//		}
		return("");
	}
}
//insert machen ende*/

	$i=-1;
	if(function_exists('menu_select_siblings')){unset ($menu_select_siblings);} else
	{
		function menu_select_siblings_old($parent_id,$number_levels,$i,$search_append_string,$menu_only,$site_id_in)
		{
			$i=$i+1;
			if($i<$number_levels or $number_levels==0 or $number_levels=="")
			{
				global $menu_select_siblings;
				if($site_id_in){$site_id=$site_id_in;}else{global $site_id;}
								
				$sibling_query=mysql_query("select menu.id, menu.description, menu.display from menu, menu_hierarchy where menu_hierarchy.parent_id=$parent_id and site_id='$site_id' and menu.id=menu_hierarchy.menu_id $search_append_string order by menu_hierarchy.sort") or die ("sibling_query: ".mysql_error());
				//echo "select menu.id, menu.description, menu.display from menu, menu_hierarchy where menu_hierarchy.parent_id=$parent_id and site_id='$site_id' and menu.id=menu_hierarchy.menu_id $search_append_string order by menu_hierarchy.sort";
				while($sibling_query_result=mysql_fetch_assoc($sibling_query))
				{
					if(($menu_only==2 and $sibling_query_result['display']==0) or $menu_only!=2){//if the selector menu only is set to 2, only those items are recorded that are actually NOT menus.
						$menu_select_siblings['id'][] = $sibling_query_result['id'];
						$menu_select_siblings['description'][] = $sibling_query_result['description'];
						$menu_select_siblings['googleurl'][] = find_googleurl($sibling_query_result['id']);			
						$menu_select_siblings['level_down'][] = $i;	
					}
					if($sibling_query_result['id']!=""){menu_select_siblings($sibling_query_result['id'],$number_levels,$i,$search_append_string,$menu_only,$site_id_in);}else{break;}
				}
			}
			return($menu_select_siblings);
		}
		
		
		function menu_select_siblings($parent_id,$number_levels,$i,$search_append_string_down,$search_append_string_down2,$menu_only,$site_id_in)
		{
			global $menu_select_siblings,$elem_id,$menu_id;
			//global $search_append_string_down;echo "1:".$search_append_string_down;
			//global $search_append_string_down2;echo "2:".$search_append_string_down2;
			if($site_id_in){$site_id=$site_id_in;}else{global $site_id;}
						
			$sibling_query_prep1_q=mysql_query("select pfad, level from menu_hierarchy where menu_id=$parent_id and site_id=$site_id order by sort");
			$sibling_query_prep1_r=mysql_fetch_assoc($sibling_query_prep1_q);
			$parent_pfad=$sibling_query_prep1_r[pfad];
			$parent_level=$sibling_query_prep1_r[level];
			
			if($parent_pfad != NULL)
			{ 
				$sibling_query_prep2_q=mysql_query("select menu_id,level,pfad,parent_id,sort from menu_hierarchy where pfad like '$parent_pfad%' and site_id=$site_id and level > ($parent_level) and level<($parent_level+$number_levels+1) $search_append_string_down order by absolute_sort");
//if($site_id==3){echo "jjj";echo "select menu_id,level,pfad,parent_id,sort from menu_hierarchy where pfad like '$parent_pfad%' and site_id=$site_id and level > ($parent_level) and level<($parent_level+$number_levels+1) $search_append_string_down order by absolute_sort";}
				if(mysql_num_rows($sibling_query_prep2_q)>0)
				{
					while($siblings_resort_prep=mysql_fetch_assoc($sibling_query_prep2_q))
					{
						$siblings_resort[]=$siblings_resort_prep[menu_id];
						//$menu_select_siblings['level_down'][] = $siblings_resort_prep[level]-1;
					}
				
					$siblings=implode(",",$siblings_resort);
	
					$sibling_query=mysql_query("select menu.id, menu.description, menu_hierarchy.display, menu_hierarchy.level from menu,menu_hierarchy where site_id=$site_id and menu_id=menu.id and menu.id in($siblings) $search_append_string_down2 order by find_in_set(menu.id,'$siblings')") or die ("sibling_query: ".mysql_error());
					while($sibling_query_result=mysql_fetch_assoc($sibling_query))
					{
						if(($menu_only==2 and $sibling_query_result['display']==0) or $menu_only!=2)
						{
							//if the selector menu only is set to 2, only those items are recorded that are actually NOT menus.
							$menu_select_siblings['id'][] = $sibling_query_result['id'];
							$menu_select_siblings['description'][] = $sibling_query_result['description'];
							$menu_select_siblings['googleurl'][] = find_googleurl($sibling_query_result['id'],$site_id);			
							$menu_select_siblings['level_down'][] = $sibling_query_result['level']-1;
						}
					}
				}
				return ($menu_select_siblings);
			}
		}
	}
	
	if(function_exists('menu_select_parents')){} else
	{
		function menu_select_parents($sibling_id, $search_append_string,$menu_only)
		{
			if($sibling_id=="" or $sibling_id=="0" or !$sibling_id){} else
			{
				global $menu_select_parent;
				global $site_id;
				$parent_query=mysql_query("select menu.id, menu.description, menu_hierarchy.display from menu,menu_hierarchy where menu.id=$sibling_id and site_id='$site_id' and menu.id=menu_hierarchy.menu_id $search_append_string order by menu_hierarchy.sort") or die ("parent_query: ".mysql_error());
				while($parent_query_result=mysql_fetch_assoc($parent_query))
				{
					if(($menu_only==1 and $parent_query_result['display']==1) or ($menu_only==2 and $parent_query_result['display']==0) or ($menu_only!=1 and $menu_only!=2))
					{
						if($parent_query_result[id]==0){break;}
						$menu_select_parent['id'][] = $parent_query_result['id'];
						$menu_select_parent['description'][] = $parent_query_result['description'];
						$menu_select_parent['googleurl'][] = find_googleurl($parent_query_result['id']);			
					}
					menu_select_parents(find_parent($parent_query_result['id']),$search_append_string,$menu_only);
				}
				return($menu_select_parent);
			}
		}
	}
	
	if($direction=="up"){
		global $site_id;
		/*$test_cache_result=test_menu_select_cache($start_id,"up",$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id);

		if($test_cache_result!=null and 1==2)
		{
			$result=$test_cache_result;
			//if($_SERVER['REMOTE_ADDR']=="194.96.116.115"){echo "read";}
		}
		else
		{*/
			$result=menu_select_parents($start_id,$search_append_string,$menu_only);
/*			update_menu_select_cache($start_id,"up",$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id, $result);
			//if($_SERVER['REMOTE_ADDR']=="194.96.116.115"){echo "write";}
		}*/
	}
	elseif($direction=="down" and $start_id!="")
	{
		if($site_id_in){$site_id=$site_id_in;}else{global $site_id;}
/*		$test_cache_result=test_menu_select_cache($start_id,"down",$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id);
		
		if($test_cache_result!=null and 1==2)
		{
			$result=$test_cache_result;
			//if($_SERVER['REMOTE_ADDR']=="194.96.116.115"){echo "read";}
		}
		else
		{*/
			$result=menu_select_siblings($start_id,$number_levels,$i,$search_append_string_down,$search_append_string_down2,$menu_only,$site_id_in);
/*			update_menu_select_cache($start_id,"down",$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id, $result);
			//if($_SERVER['REMOTE_ADDR']=="194.96.116.115"){echo "write";}
		}*/

	}
return $result;
}
?>
<?
function teaser_select_similar($menu_id,$length){
	global $site_id;
	
	$keyword_query = mysql_query("SELECT metatag_keywords FROM menu WHERE id=$menu_id")or die("keyword query failed: ".mysql_error());
	$keyword_result = mysql_fetch_assoc($keyword_query);
	$keyword_array=explode(",",$keyword_result[metatag_keywords]);

	if(strlen($keyword_result[metatag_keywords])>0)
	{
		//Methode 1: Gewichtete Keywords in der eigenen Rubrik (Schwestern + Siblings)
		$own_text_q=mysql_query("select text from element_content_text where element_id in (select id from element where menu_id=$menu_id)");
		if(mysql_num_rows($own_text_q)>0)
		{
			while($own_text_r=mysql_fetch_assoc($own_text_q))
			{$own_text.=$own_text_r[text];}
			$own_text=html_entity_decode($own_text);
			$own_text=strtolower ($own_text);
			
			$iii=0;
			for($i=0,$i_limit=count($keyword_array);$i<$i_limit;$i++)
			{
				$keywords=$keyword_array[$i];
				$keywords=html_entity_decode($keywords);
				$keywords=strtolower($keywords);
				$keywords=trim($keywords);
				$keyword_array[$i]=$keywords;
				if($own_text!="" and $keywords!="")
				{
					if(substr_count($own_text,$keywords)>0)
					{
						$keyword_test[$iii]["keyword"]=$keywords;
						$keyword_test[$iii]["count"]=substr_count($own_text,$keywords);
						$iii=$iii+1;
					}
				}
			}
		
			$own_pfad_q=mysql_query("select pfad from menu_hierarchy where menu_id=$menu_id and site_id=$site_id");
			$own_pfad_r=mysql_fetch_assoc($own_pfad_q);
			$own_pfad=$own_pfad_r[pfad];
			$own_pfad=substr($own_pfad,0,-strlen($menu_id)-1);
		
			$rubriken_menus_q=mysql_query("select id, metatag_keywords from menu where id in (select menu_id from menu_hierarchy 
			where pfad like '$own_pfad%' 
			and search_type != 'Übersichtsseiten' and search_type != 'Subseiten' and search_type != 'Pressemitteilung' and search_type!= 'Allgemeine Infos' 
			and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' 
			and site_id=$site_id) and id != $menu_id");
			while($rubriken_menus_r=mysql_fetch_assoc($rubriken_menus_q))
			{
				$rubriken_menus_id[]=$rubriken_menus_r[id];
				$rubriken_menus_keyword=strtolower(html_entity_decode($rubriken_menus_r[metatag_keywords]));
				$rubriken_menus_keyword=explode(",",$rubriken_menus_keyword);
				for($ii=0;$ii<count($rubriken_menus_keyword);$ii++)
				{$rubriken_menus_keyword[$ii]=trim($rubriken_menus_keyword[$ii]);}
				$rubriken_menus_keyword=implode(",",$rubriken_menus_keyword);
				$rubriken_menus_keyword_array[][keywords]=$rubriken_menus_keyword;
				$iiii=$iiii+1;
			}
			
			
				
			for($i=0;$i<$iii;$i++)
			{
				for($ii=0;$ii<$iiii;$ii++)
				{
					$rubriken_menus_keyword_array[$ii][id]=$rubriken_menus_id[$ii];
					$hit=min(substr_count($rubriken_menus_keyword_array[$ii][keywords],$keyword_test[$i]["keyword"]),1);
					$rubriken_menus_keyword_array[$ii][rank]=$rubriken_menus_keyword_array[$ii][rank]+$hit;
				}
			}
			
			for($ii=0;$ii<$iiii and $ii<$length;$ii++)
			{
				if($rubriken_menus_keyword_array[$ii][rank]==0)
				{unset($rubriken_menus_keyword_array[$ii]);}
				else
				{$found_ids[]=$rubriken_menus_keyword_array[$ii][id];}
			}
		}
	}
	
	//Methode 2: Keywords quer über allen Artikeln
	if(count($found_ids)<$length)
	{
		$remainder_count=$length-count($found_ids);
		
		$keywords_match=implode("%' or metatag_keywords like '%",$keyword_array);
		$keywords_match="'%".$keywords_match."%'";
		if($found_ids){$found_ids_match=implode(",",$found_ids);$found_ids_match=",".$found_ids_match;}
		
		$keyword_match_query = mysql_query("SELECT menu.id,description FROM menu,menu_hierarchy WHERE (metatag_keywords like $keywords_match) and search_type != 'Übersichtsseiten' and search_type != 'Subseiten' and search_type != 'Pressemitteilung' and search_type!= 'Allgemeine Infos' and menu.id not in ($menu_id $found_ids_match) and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' and site_id=$site_id and menu.id=menu_hierarchy.menu_id limit $remainder_count");
		while($keyword_match_result=mysql_fetch_assoc($keyword_match_query))
		{
			$found_ids[]=$keyword_match_result[id];
		}
	}
	return $found_ids;}
?>
<?
function teaser_select_mru($max_count,$mru)
{
	global $site_id,$menu_id;
	if(is_array($mru) and count($mru)>0){$max_mru=$mru[0];$mru_implode=implode(",",$mru);$query_append=" and id > $max_mru and id not in ($mru_implode) ";}
	$mru_q1=mysql_query("select id, menu_id from googleurl_statistik where site_id=$site_id and bot=0 $query_append order by id desc limit 500");
	unset ($mru);
	while($mru_r=mysql_fetch_row($mru_q1))
	{
		$mru['id'][]=$mru_r[0];
		$mru['menu_id'][]=$mru_r[1];
	}
	if(is_array($mru['menu_id']))
	{
		$mru['menu_id']=array_unique($mru['menu_id']);
		$mru['id']=array_intersect_key($mru['id'],$mru['menu_id']);
		
		$mru['menu_id']=array_merge($mru['menu_id']);
		$mru['id']=array_merge($mru['id']);
		
		$result['id']=$mru['menu_id'];
		$result['mru_ids']=$mru['id'];
	}
	
	return $result;
}
?>
<?
function menu_teaser_valid($menu_id,$img_needed,$einleitung_needed)
{
	global $elem_id;
	$teaser_asset=teaser_bild($menu_id,150,$elem_id);
	$teaser_head_arr=teaser_text($menu_id,"Titel",0);$teaser_head=$teaser_head_arr[text];
	$teaser_copy_arr=teaser_text($menu_id,"Copy",0);$teaser_copy=$teaser_copy_arr[text];

	if(
		($teaser_head!="")//test_id=menu_id, test_type=element_layout_description (zB "Titel"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht
		and ($teaser_copy!="" or $einleitung_needed==0) //test_id=menu_id, test_type=element_layout_description (zB "Copy"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht
		and ($teaser_asset[asset_id]>0 or $img_needed==0)//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
	)
	{
		$active_query=mysql_query("select * from menu_hierarchy where (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' limit 1");
		if(mysql_num_rows($active_query)>0)
		{return true;}
		else {return false;}
	}	else {return false;}
}
?>
<?
function select_teaser_ids($select_methods_id,$menu_id,$teaser_menus,$siblings_depth,$count,$menu_ids_global,$img_needed,$einleitung_needed,$mru,$valid_only)
{
	global $site_id, $elem_id;
	/*//test cache
	$sort_teaser_ids_cache_test_q=mysql_query("select * from menu_teaser_select_cache where element_id=$elem_id limit 1");
	if(mysql_num_rows($sort_teaser_ids_cache_test_q)>0 and 1==2)
	{
		//if($_SERVER['REMOTE_ADDR']=="194.96.119.82"){echo "read select";}
		$result=mysql_fetch_assoc($sort_teaser_ids_cache_test_q);
		$teaser_menu_ids[$elem_id]=unserialize($result[teaser_menu_ids]);
		$teaser_skipped[$elem_id]=unserialize($result[teaser_skipped]);
		$teaser_menu_duplicate[$elem_id]=unserialize($result[teaser_menu_duplicate]);
		$menu_ids_global=unserialize($result[menu_ids_global]);
		$teaser_select_auto_manual=unserialize($result[teaser_select_auto_manual]);
		$mru=unserialize($result[mru]);
	}
	else
	{*/
		##selection method setup
		$teaser_elements_q=mysql_query("select * from menu_teaser_config_select_methods where id=$select_methods_id") or die ("selects".mysql_error());
		$teaser_elements_r=mysql_fetch_assoc($teaser_elements_q);
		$teaser_select_auto_manual=$teaser_elements_r[auto_manual];
		$teaser_select_sibling_selection=$teaser_elements_r[sibling_selection];
		$teaser_select_sibling_selection_incl_menus=$teaser_elements_r[sibling_selection_incl_menus];
		$remove_duplicates=$teaser_elements_r[remove_duplicates];
	
		if ($teaser_select_auto_manual=="auto")
		{
			if($teaser_select_sibling_selection=="direct")
			{
				$teaser_menu_select=menu_select($menu_id,'down','1','1','','1'); 
				$teaser_menu_skipped=menu_select($menu_id,'down','1','0','','1');
				if($teaser_menu_skipped and $teaser_menu_select){$teaser_skipped[$elem_id]=array_diff($teaser_menu_skipped[id],$teaser_menu_select[id]);}
				if($teaser_menu_skipped and !$teaser_menu_select){$teaser_skipped[$elem_id]=$teaser_menu_skipped[id];}
				if(!$teaser_menu_skipped and $teaser_menu_select){$teaser_skipped[$elem_id]="";}
				$count=count($teaser_menu_select[id]);
			}
			
			if($teaser_select_sibling_selection=="multi" or $teaser_select_sibling_selection=="similar" or $teaser_select_sibling_selection=="recent")
			{
				if($teaser_select_sibling_selection=="similar")
				{
					$teaser_menu_select['id']=teaser_select_similar($menu_id,$count);
				}
				elseif($teaser_select_sibling_selection=="recent")
				{
					$teaser_menu_select=teaser_select_mru($count,$mru);
					$mru="";
				}
				else //--> namely "auto"
				{
					if($teaser_select_sibling_selection_incl_menus==1)
					{$teaser_menu_select=menu_select($menu_id,'down',$siblings_depth,'1','','1');}//hier werden Artikel und andere Seiten genommen.
					
					if($teaser_select_sibling_selection_incl_menus==0)
					{$teaser_menu_select=menu_select($menu_id,'down',$siblings_depth,'1','2','1');}//hier werden nur Artikel genommen.
					
					unset($teaser_menu_select[level_down]);
					unset($teaser_menu_select[description]);
					unset($teaser_menu_select[googleurl]);
					//if($elem_id==40442){print_r($teaser_menu_select);}
					
					$teaser_menu_select_imploded=implode(",",$teaser_menu_select[id]);
					
					$teaser_menu_select_presort_elem_id_q=mysql_query("select * from 
					(select text as sort1 from element_content_text where element_id = $elem_id and sort=110) as sort1,
					(select text as sort2 from element_content_text where element_id = $elem_id and sort=120) as sort2,
					(select text as sort3 from element_content_text where element_id = $elem_id and sort=130) as sort3");
					
					$teaser_menu_select_presort_elem_id_r = mysql_fetch_assoc($teaser_menu_select_presort_elem_id_q); 
					
					$sort1=$teaser_menu_select_presort_elem_id_r[sort1];
					$sort2=$teaser_menu_select_presort_elem_id_r[sort2];
					$sort3=$teaser_menu_select_presort_elem_id_r[sort3];
					
					if($sort1==""){$sort1=3;}
					if($sort2==""){$sort2=1;}
					if($sort3==""){$sort3=2;}
					
					$teaser_sort1_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort1") or die ("sort methods1".mysql_error());
					$teaser_sort1_method_r=mysql_fetch_assoc($teaser_sort1_method_q);
					$teaser_sort1_method_table=$teaser_sort1_method_r[table];
					$teaser_sort1_method_field=$teaser_sort1_method_r[field];
				
					$teaser_sort2_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort2") or die ("sort methods2".mysql_error());
					$teaser_sort2_method_r=mysql_fetch_assoc($teaser_sort2_method_q);
					$teaser_sort2_method_table=$teaser_sort2_method_r[table];
					$teaser_sort2_method_field=$teaser_sort2_method_r[field];
					
					$teaser_sort3_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort3") or die ("sort methods3".mysql_error());
					$teaser_sort3_method_r=mysql_fetch_assoc($teaser_sort3_method_q);
					$teaser_sort3_method_table=$teaser_sort3_method_r[table];
					$teaser_sort3_method_field=$teaser_sort3_method_r[field];
	
					$sort_q=mysql_query("
					select menu_hierarchy.menu_id as menu_id
					from menu_hierarchy, menu as m1, menu as m2, menu as m3, menu_hierarchy as mh1, menu_hierarchy as mh2, menu_hierarchy as mh3 
					
					where menu_hierarchy.site_id=$site_id 
					and mh1.site_id=$site_id
					and mh2.site_id=$site_id
					and mh3.site_id=$site_id
					
					and menu_hierarchy.menu_id=m1.id 
					and menu_hierarchy.menu_id=m2.id 
					and menu_hierarchy.menu_id=m3.id 
					 
					and menu_hierarchy.menu_id=mh1.menu_id 
					and menu_hierarchy.menu_id=mh2.menu_id 
					and menu_hierarchy.menu_id=mh3.menu_id 
					
					and menu_hierarchy.menu_id in ($teaser_menu_select_imploded)
					
					order by 
					".$teaser_sort1_method_table."1.$teaser_sort1_method_field,
					".$teaser_sort2_method_table."2.$teaser_sort2_method_field,
					".$teaser_sort3_method_table."3.$teaser_sort3_method_field
					") or die (mysql_error());
					
					unset($teaser_menu_select[id]);
					
					while($teaser_menu_select_r= mysql_fetch_assoc($sort_q)){$teaser_menu_select[id][]=$teaser_menu_select_r[menu_id];} 
					//$teaser_menu_select[id]=array_reverse($teaser_menu_select[id]);
					//if($_SERVER['REMOTE_ADDR']=="194.96.119.82"){print_r($teaser_menu_select);}
	
				}
			}
			
			$counter=0;
			for($iteration=0;$iteration<$count and $counter<count($teaser_menu_select[id]);)
			{
				$teaser_test_menu_id=$teaser_menu_select['id'][$counter];
				$counter=$counter+1;
				
				if(menu_teaser_valid($teaser_test_menu_id,$img_needed,$einleitung_needed))
				{
					$mru[$iteration]=$teaser_menu_select['mru_ids'][$counter-1];
					$iteration=$iteration+1;
					$teaser_menu_ids[$elem_id][]=$teaser_test_menu_id;
				}
				else
				{
					$teaser_skipped[$elem_id][]=$teaser_test_menu_id;
				}
			}
		}
		if ($teaser_select_auto_manual=="manual")
		{
			unset($teaser_menus[0]);
			foreach ($teaser_menus as $m)
			{
				if($valid_only==1){if(menu_teaser_valid($m,$img_needed,$einleitung_needed)){$tmp[]=$m;}}
				else{$tmp[]=$m;}
			}
			$teaser_menu_ids[$elem_id]=$tmp;
		}
		//Duplikate von der gleichen Seite entfernen
		if($remove_duplicates==1)
		{
			if(!$menu_ids_global){$menu_ids_global=$teaser_menu_ids[$elem_id];}
			else
			{
				if(count($teaser_menu_ids[$elem_id])>0){
					$teaser_menu_duplicate[$elem_id]=array_intersect($teaser_menu_ids[$elem_id],$menu_ids_global);
					$teaser_menu_ids[$elem_id]=array_diff($teaser_menu_ids[$elem_id],$menu_ids_global);
					$menu_ids_global=array_merge($menu_ids_global,$teaser_menu_ids[$elem_id]);
				}
			}
		}
	/*	//write cache
		//if($_SERVER['REMOTE_ADDR']=="194.96.119.82"){echo "write select";}
		$teaser_menu_ids_cache=GetSQLValueString(serialize($teaser_menu_ids[$elem_id]),"text");
		$teaser_skipped_cache=GetSQLValueString(serialize($teaser_skipped[$elem_id]),"text");
		$teaser_menu_duplicate_cache=GetSQLValueString(serialize($teaser_menu_duplicate[$elem_id]),"text");
		$menu_ids_global_cache=GetSQLValueString(serialize($menu_ids_global),"text");
		$teaser_select_auto_manual_cache=GetSQLValueString(serialize($teaser_select_auto_manual),"text");
		$mru_cache=GetSQLValueString(serialize($mru),"text");
		$sort_teaser_ids_cache_update_q=mysql_query("insert into menu_teaser_select_cache 
		(element_id, teaser_menu_ids, teaser_skipped, teaser_menu_duplicate, menu_ids_global, teaser_select_auto_manual, mru)
		 values 
		 ($elem_id, $teaser_menu_ids_cache, $teaser_skipped_cache, $teaser_menu_duplicate_cache, $menu_ids_global_cache, $teaser_select_auto_manual_cache, $mru_cache)") or die("select_cache: ".mysql_error());
	}*/
	return array($teaser_menu_ids[$elem_id],$teaser_skipped[$elem_id],$teaser_menu_duplicate[$elem_id],$menu_ids_global,$teaser_select_auto_manual,$mru);

}
?>
<?
function sort_teaser_ids($teaser_menu_ids,$elem_id,$sort1,$sort2,$sort3,$teaser_select_auto_manual){
	
	/*//test cache
	$sort_teaser_ids_cache_test_q=mysql_query("select * from menu_teaser_sort_cache where element_id=$elem_id limit 1");
	if(mysql_num_rows($sort_teaser_ids_cache_test_q)>0)
	{
		//if($_SERVER['REMOTE_ADDR']=="194.96.119.82"){echo "read sort";}
		$result=mysql_fetch_assoc($sort_teaser_ids_cache_test_q);
		$result=unserialize($result[result]);
	}
	else
	{*/
		
		##selection sort1 setup
		$teaser_sort1_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort1") or die ("sort methods1".mysql_error());
		$teaser_sort1_method_r=mysql_fetch_assoc($teaser_sort1_method_q);
		$teaser_sort1_method_id=$teaser_sort1_method_r[id];
		$teaser_sort1_method_description=$teaser_sort1_method_r[description];
		$teaser_sort1_method_help=$teaser_sort1_method_r[help];
		$teaser_sort1_method_table=$teaser_sort1_method_r[table];
		$teaser_sort1_method_field=$teaser_sort1_method_r[field];
		
		if($teaser_sort1_method_description!="keep")
		{
			##selection sort2 setup
			$teaser_sort2_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort2") or die ("sort methods2".mysql_error());
			$teaser_sort2_method_r=mysql_fetch_assoc($teaser_sort2_method_q);
			$teaser_sort2_method_id=$teaser_sort2_method_r[id];
			$teaser_sort2_method_description=$teaser_sort2_method_r[description];
			$teaser_sort2_method_help=$teaser_sort2_method_r[help];
			$teaser_sort2_method_table=$teaser_sort2_method_r[table];
			$teaser_sort2_method_field=$teaser_sort2_method_r[field];
			
			##selection sort1 setup
			$teaser_sort3_method_q=mysql_query("select * from menu_teaser_config_sort_methods where id=$sort3") or die ("sort methods3".mysql_error());
			$teaser_sort3_method_r=mysql_fetch_assoc($teaser_sort3_method_q);
			$teaser_sort3_method_id=$teaser_sort3_method_r[id];
			$teaser_sort3_method_description=$teaser_sort3_method_r[description];
			$teaser_sort3_method_help=$teaser_sort3_method_r[help];
			$teaser_sort3_method_table=$teaser_sort3_method_r[table];
			$teaser_sort3_method_field=$teaser_sort3_method_r[field];
			
			global 	$site_id;
			
			if(count($teaser_menu_ids)>0)
			{
				$teaser_menu_ids_imploded = implode(",",$teaser_menu_ids);
				
				if($teaser_select_auto_manual=="manual")
				{
					$sort_q=mysql_query("select menu_id, sort, id as element_content_menu_id from element_content_menu where menu_id in ($teaser_menu_ids_imploded) and element_id=$elem_id order by sort") or die (mysql_error());
				}
				if($teaser_select_auto_manual=="auto")
				{
					$sort_q=mysql_query("
						select menu_hierarchy.menu_id as menu_id
						from menu_hierarchy, menu as m1, menu as m2, menu as m3, menu_hierarchy as mh1, menu_hierarchy as mh2, menu_hierarchy as mh3 
						
						where menu_hierarchy.site_id=$site_id 
						and mh1.site_id=$site_id
						and mh2.site_id=$site_id
						and mh3.site_id=$site_id
						
						and menu_hierarchy.menu_id=m1.id 
						and menu_hierarchy.menu_id=m2.id 
						and menu_hierarchy.menu_id=m3.id 
						 
						and menu_hierarchy.menu_id=mh1.menu_id 
						and menu_hierarchy.menu_id=mh2.menu_id 
						and menu_hierarchy.menu_id=mh3.menu_id 
						
						and menu_hierarchy.menu_id in ($teaser_menu_ids_imploded)
						
						order by 
						".$teaser_sort1_method_table."1.$teaser_sort1_method_field,
						".$teaser_sort2_method_table."2.$teaser_sort2_method_field,
						".$teaser_sort3_method_table."3.$teaser_sort3_method_field
						") or die (mysql_error());
				}
				$ordering=0;
	
	
				while ($sort_r=mysql_fetch_assoc($sort_q))
				{
					$result[menu_id][]=$sort_r[menu_id];
					if($sort_r[sort])
					{
						$result[order][]=$sort_r[sort];
						$result[element_content_menu_id][]=$sort_r[element_content_menu_id];
					}else
					{
					}
					$ordering=$ordering+10;
				}
			}
		}
		else
		{
			if(count($teaser_menu_ids)>0)
			{
				$ordering=0;
				foreach($teaser_menu_ids as $menu_id)
				{
					$result[menu_id][]=$menu_id;
					$result[order][]=$ordering;
					$result[element_content_menu_id][]="";
					$ordering=$ordering+10;
				}
			}
		}
		
/*		//write cache
		//if($_SERVER['REMOTE_ADDR']=="194.96.119.82"){echo "write select";}
		$cache_write=serialize($result);
		$cache_write=GetSQLValueString($cache_write,"text");
		$sort_teaser_ids_cache_update_q=mysql_query("insert into menu_teaser_sort_cache (element_id, result) values ($elem_id, $cache_write)") or die("sort_cache: ".mysql_error());
	}*/
	return array($result[menu_id],$result[order],$result[element_content_menu_id]);
}
?>
<?
function teaser_text($test_id,$test_type,$tuncate=0,$element=NULL) //test_id=menu_id, test_type=element_layout_description (zB "Titel"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht)
{
	global $site_id;
	if($element!=NULL){$append_string="and menu_teaser.element_id='$element'";}
	
	if($test_type=="Titel"){
		$test_type_element_layout_description="titel";
		$test_type_menu_teaser="teaser_head";
		$test_type_meta="metatag_title";
	}
	if($test_type=="Copy"){
		$test_type_element_layout_description="einleitung";
		$test_type_menu_teaser="teaser_copy";
		$test_type_meta="metatag_description";
	}
	
	$text_teaser_q=mysql_query("select id, $test_type_menu_teaser, editor from menu_teaser where menu_id='$test_id' and site_id=$site_id $append_string order by up_date desc") or die (mysql_error());//tested ob im menu_teaser ein Eintrag vorhanden ist (der ist immer Manuell erstellt. Entweder als default f. alle Elemente oder bei spezifischen listings).
	if(mysql_num_rows($text_teaser_q)>0)//wenn es einen Eintrag im menu_teaser gibt für das spezifische Element.
	{
		$text_teaser_r=mysql_fetch_assoc($text_teaser_q);
		$result[text]=$text_teaser_r[$test_type_menu_teaser];
		$result[source]="menu_teaser_own_element";
		$result[id]=$text_teaser_r[id];
		$result[editor]=$text_teaser_r[editor];
	}
	if($result[text]=="NULL" or $result[text]=="")
	{
		$text_teaser_q=mysql_query("select $test_type_menu_teaser from menu_teaser where menu_id='$test_id' and site_id=$site_id and menu_teaser.element_id != 0 order by up_date desc") or die (mysql_error());//tested ob im menu_teaser ein Eintrag vorhanden ist (der ist immer Manuell erstellt. Entweder als default f. alle Elemente oder bei spezifischen listings).
		if(mysql_num_rows($text_teaser_q)>0)//wenn es einen Eintrag im menu_teaser gibt, aber für ein anderes Element - nicht default!
		{
			$text_teaser_r=mysql_fetch_assoc($text_teaser_q);
			$result[text]=$text_teaser_r[$test_type_menu_teaser];
			$result[source]="menu_teaser_foreign_element";
		}
		if($result[text]=="NULL" or $result[text]=="")//wenn es gar keinen Eintrag im menu_teaser gibt.
		{
			$text_teaser_q=mysql_query("select $test_type_menu_teaser from menu_teaser where menu_id='$test_id' and site_id=$site_id and menu_teaser.element_id = 0 order by up_date desc") or die (mysql_error());//tested ob im menu_teaser ein Eintrag vorhanden ist (der ist immer Manuell erstellt. Entweder als default f. alle Elemente oder bei spezifischen listings).
			if(mysql_num_rows($text_teaser_q)>0)//wenn es einen Default-Eintrag gibt.
			{
				$text_teaser_r=mysql_fetch_assoc($text_teaser_q);
				$result[text]=$text_teaser_r[$test_type_menu_teaser];
				$result[source]="menu_teaser_default_element";
			}
			if($result[text]=="NULL" or $result[text]=="")//wenn es gar keinen Eintrag im menu_teaser gibt.
			{
				$text_query=mysql_query("SELECT avail_element.id, TEXT FROM element_content_text, (select element.id, menu_id, element_layout_id, min(sort) as sort from element, (select id from element_layout where description ='$test_type_element_layout_description') as elem_lay where element_layout_id=elem_lay.id group by menu_id) as avail_element WHERE avail_element.id=element_content_text.element_id AND avail_element.menu_id='$test_id' ORDER BY avail_element.sort, element_content_text.sort LIMIT 1") or die ("1.2".mysql_error());
				$text_result = mysql_fetch_row($text_query);
				$result[text]=$text_result[1];
				$result[source]="text";
				
				if($result[text]=="NULL" or $result[text]=="")
				{
					$text_query2=mysql_query("select $test_type_meta from menu, menu_hierarchy where menu.id='$test_id' and menu_id=menu.id and site_id=$site_id order by menu_hierarchy.sort limit 1") or die ("3.1".mysql_error());
					if(mysql_num_rows($text_query2) > 0){
						$text_result2=mysql_fetch_row($text_query2);
						$result[text]=$text_result2[0];
						$result[source]="metadata";
					}
				}
			}
		}
	}
	if($tuncate==0){}else{$result[text]=truncate_max($result[text],$tuncate);}
	return $result;}
?>
<?
function teaser_bild($test_id,$target_width,$element=NULL){
	global $site_id;
	if($element!=NULL){$append_string="and menu_teaser.element_id='$element'";}

 	$image_teaser_q=mysql_query("select menu_teaser.id, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent from menu_teaser, assets where assets.id=teaser_asset_id and menu_id='$test_id' and menu_teaser.site_id=$site_id and teaser_asset_id!=0 $append_string order by up_date desc") or die (mysql_error());//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
	
	if(mysql_num_rows($image_teaser_q)>0)//wenn es einen Eintrag im menu_teaser gibt für das Element.
	{
		$image_teaser_r=mysql_fetch_assoc($image_teaser_q);
		$result['menu_teaser_id']=$image_teaser_r['id'];
		$result['asset_id']=$image_teaser_r['teaser_asset_id'];
		$result['asset_h_offset']=$image_teaser_r['asset_h_offset'];
		$result['asset_v_offset']=$image_teaser_r['asset_v_offset'];
		$result['asset_h_offset_percent']=$image_teaser_r['asset_h_offset_percent'];
		$result['asset_v_offset_percent']=$image_teaser_r['asset_v_offset_percent'];
		$result['source']="menu_teaser_own_element";
	}
	if($result['menu_teaser_id']==0 or $result['menu_teaser_id']=="")
	{
		$image_teaser_q=mysql_query("select menu_teaser.id, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent from menu_teaser, assets where assets.id=teaser_asset_id and menu_id='$test_id' and menu_teaser.site_id=$site_id and teaser_asset_id!=0 and element_id != 0 order by up_date desc") or die (mysql_error());//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
		
		if(mysql_num_rows($image_teaser_q)>0)//wenn es einen Eintrag im menu_teaser gibt, aber für ein anderes Element, nicht default.
		{
			$image_teaser_r=mysql_fetch_assoc($image_teaser_q);
			$result['menu_teaser_id']=$image_teaser_r['id'];
			$result['asset_id']=$image_teaser_r['teaser_asset_id'];
			$result['asset_h_offset']=$image_teaser_r['asset_h_offset'];
			$result['asset_v_offset']=$image_teaser_r['asset_v_offset'];
			$result['asset_h_offset_percent']=$image_teaser_r['asset_h_offset_percent'];
			$result['asset_v_offset_percent']=$image_teaser_r['asset_v_offset_percent'];
			$result['source']="menu_teaser_foreign_element";
		}
	
		if($result['menu_teaser_id']==0 or $result['menu_teaser_id']=="")//wenn es gar keinen Eintrag im menu_teaser gibt.
		{
			$image_teaser_q=mysql_query("select menu_teaser.id, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent from menu_teaser, assets where assets.id=teaser_asset_id and menu_id='$test_id' and menu_teaser.site_id=$site_id and teaser_asset_id!=0 and element_id = 0 order by up_date desc") or die (mysql_error());//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
			
			if(mysql_num_rows($image_teaser_q)>0)//wenn es einen Default-Eintrag gibt.
			{
				$image_teaser_r=mysql_fetch_assoc($image_teaser_q);
				$result['menu_teaser_id']=$image_teaser_r['id'];
				$result['asset_id']=$image_teaser_r['teaser_asset_id'];
				$result['asset_h_offset']=$image_teaser_r['asset_h_offset'];
				$result['asset_v_offset']=$image_teaser_r['asset_v_offset'];
				$result['asset_h_offset_percent']=$image_teaser_r['asset_h_offset_percent'];
				$result['asset_v_offset_percent']=$image_teaser_r['asset_v_offset_percent'];
				$result['source']="menu_teaser_default_element";
			}
		
			if($result['menu_teaser_id']==0 or $result['menu_teaser_id']=="")//wenn es gar keinen Eintrag im menu_teaser gibt.
			{
				$image_q=mysql_query("SELECT element.id, element.menu_id, element_content_img.assets_ID FROM element_content_img, element WHERE element.id=element_content_img.element_id and assets_ID!=0 AND element.menu_id='$test_id' ORDER BY element.sort, element_content_img.sort LIMIT 1");
				if(mysql_num_rows($image_q)>0)
				{
					$image_r = mysql_fetch_assoc($image_q);
					$result['asset_id']=$image_r[assets_ID];
					$result['asset_h_offset']=0;
					$result['asset_v_offset']=0;
					$result['asset_h_offset_percent']=0.5;
					$result['asset_v_offset_percent']=0.5;
					$result['source']="image";
				}
				else//nimm default
				{
					$result['asset_id']=0;
					$result['asset_h_offset']=0;
					$result['asset_v_offset']=0;
					$result['asset_h_offset_percent']=0.5;
					$result['asset_v_offset_percent']=0.5;
					$result['source']="no_source";
				}
			}
		}
	}
	
	$imgs_details_q=mysql_query("select id,category, class, path, filename, breite, hoehe, alt_tag,type from assets where id='$result[asset_id]'") or die("img_details failed");
	$imgs_details_r=mysql_fetch_assoc($imgs_details_q);
	
	$result['category']=$imgs_details_r['category'];//category
	$result['class']=$imgs_details_r['class'];//class
	$result['path']=$imgs_details_r['path'];//path
	
	if($target_width >= 200){$result['filename']=$imgs_details_r['filename'];}//filename
	if($target_width <200 and $target_width >=100 ){$result['filename']="~klein~".$imgs_details_r['filename'];}//filename
	if($target_width <100){$result['filename']="~mini~".$imgs_details_r['filename'];}//filename
	
	$result['imgs_url']="/site_12_1/assets/".$result['category'].$result['class'].$result['path'].$result['filename'];
	$result['imgs_breite']=$imgs_details_r['breite'];//breite
	$result['imgs_hoehe']=$imgs_details_r['hoehe'];//hoehe
	$result['alt_tag']=$imgs_details_r['alt_tag'];//alt-tag
	$result['type']=$imgs_details_r['type'];//type
	return $result;}
?>
<? //function to replace special characters
function replace($x){
	$k1=array(' - ','ß','ä','ö','ü','Ä','Ö','Ü',' ',':','&','?','!','"',',','.',"\'","/");
	$k2=array('-','ss','ae','oe','ue','ae','oe','ue','-','-','und','','','','','',"","-");
	for ($i='0';$i<count($k1);$i++) {$x = str_replace($k1[$i],$k2[$i],$x);}
	return $x;}
?>
<? ///////////Function to identify which file has included another
function trace(){
	$trace=debug_backtrace();
	foreach($trace as $t)
	{
		if (in_array($t['function'], 
					 array('include', 'include_once', 'require', 'require_once')))
		{
			$file_path=$t['file'];//gesamter Pfad inkl. Filename und Extention.
			
			//Filenamen
			$parts = pathinfo($file_path);//Vorbereitung
			$filename = $parts['basename'];//Filename incl. extention.
			$filetype = $parts['extension'];//Nur die extention.
			$path_only = $parts['dirname'];//Nur der Pfad.
			break;
		}
	}
	return ($filename);}
?>
<? ///////function whereami -- braucht layout (="content" oder "admin") und $menu_id als input. Von dieser ID weg wird nach oben zurückgearbeitet und ein echo-fertiges statement zurück gegeben.
function whereami($layout,$menu_id){
	global $home_menu_id;
	$test= menu_select($menu_id,"up",99,0,1,0);//$start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id_in=null

	if($test[id][0]!=0 and $test[id][0]!=$home_menu_id)
	{
		$test[id]=array_reverse($test[id]);
		$test[description]=array_reverse($test[description]);
		$test[googleurl]=array_reverse($test[googleurl]);
	
		for($i=0,$max=count($test[id]);$i<$max;$i++)
		{
			if($layout=="content")
			{
				$href=$test[googleurl][$i];
				$class="whereamilink";
			}
			elseif($layout=="admin")
			{	
				$href="/site_12_1/admin/papa/menu.php?men_id=".$test[id][$i];
				$class="";
			}
			$result.=" &raquo <a href='".$href."' class=$class>".$test[description][$i]."</a>";
		}
	}
	
	//print_r($test);
	echo $result;
	echo "<br>";
	return($whereamihref);
} 
?>
<? 
function truncate_max($string, $limit, $break=" ", $pad="...") { // return with no change if string is shorter than $limit 
//////Function to truncate text to the maximum of characters
// Original PHP code by Chirp Internet: www.chirp.com.au (http://www.the-art-of-web.com/php/truncate/)
// Please acknowledge use of this code by including this header. 

	if(strlen($string) <= $limit) return $string; 
	$string = substr($string, 0, $limit); 
	if(false !== ($breakpoint = strrpos($string, $break))) 
	{ $string = substr($string, 0, $breakpoint); } 
	return $string . $pad; }
?>
<?php
###Funktion zum Checken von Dateneingaben bei SQL-Abfragen...
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{//$theValue=secure($theValue);
if (PHP_VERSION < 6) {
$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
}

$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

switch ($theType) {
case "text":
  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
  break;    
case "long":
case "int":
  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
  break;
case "double":
  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
  break;
case "date":
	$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
  break;
case "defined":
  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
  break;
}

return $theValue;
}}
?>
<?
function test_login($user,$password,$site_id){
	$users_pwd_query=mysql_query("select id from user_sites_x_groups where groups_id in (select groups_ID from user_users_x_groups where users_id=(select id from user_users where username='$user' and password='$password')) and sites_ID='$site_id'") or die (mysql_error());
	if(mysql_num_rows($users_pwd_query)>0)
	{	$result = "true";
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['site_id'] = $site_id;
		$_SESSION['loggedIn'] = "true";
		include_once("12_1_admin_functions.php");
		
		$users_config_q=mysql_query("select * from user_users where username='$user'");
		$users_config_r=mysql_fetch_assoc($users_config_q);
		$_SESSION['user_id'] = $users_config_r[ID];
		$_SESSION['autoupdate'] = $users_config_r[auto_update_menu_hierarchy];
		?><script>user_config_autoupdate=<? echo $_SESSION['autoupdate'];?></script><?
	}
	else
	{$result = "false";}
	return $result;}
?>
<?
function capture(){
	if (isset($_SESSION['captcha_spam']) AND $_POST["sicherheitscode"] == $_SESSION['captcha_spam'])
	{
		unset($_SESSION['captcha_spam']); 
		$eintrag_OK=true;
	}
	else{$eintrag_OK=false;}
	return $eintrag_OK;}
?>
<?
function thumb($source, $target, $width, $height, $prop = TRUE) {
	@unlink($target);
	$infos = @getimagesize($source);
	if($prop) {
		$iWidth = $infos[0];
		$iHeight = $infos[1];
		$iRatioW = $width / $iWidth;
		$iRatioH = $height / $iHeight;
		if ($iRatioW < $iRatioH)
		{
		$iNewW = $iWidth * $iRatioW;
		$iNewH = $iHeight * $iRatioW;
		} else {
		$iNewW = $iWidth * $iRatioH;
		$iNewH = $iHeight * $iRatioH;
		} // end if
	} else {
		$iNewW = $width;
		$iNewH = $height;
	}
	####jpg
	if($infos[2] == 2) {
		$imgA = imagecreatefromjpeg($source);
		$imgB = imagecreatetruecolor($iNewW,$iNewH);
		imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW,
						   $iNewH, $infos[0], $infos[1]);
		imagejpeg($imgB, $target,80);
	} 
	#####gif
	elseif ($infos[2] == 1) {
		$imgA = imagecreatefromgif($source);
		$imgB = imagecreatetruecolor($iNewW,$iNewH);
		imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW,
						   $iNewH, $infos[0], $infos[1]);
		imagegif($imgB, $target);
	}
	##### png
	elseif($infos[2] == 3) {
		$imgA = imagecreatefrompng($source);
		$imgB = imagecreatetruecolor($iNewW, $iNewH);
		imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW,
						   $iNewH, $infos[0], $infos[1]);
		imagepng($imgB, $target,2);
	} else {
		return FALSE;
	}
}
?>
<script>
function getsupportedprop(proparray){
	var root=document.documentElement //reference root element of document
	for (var i=0; i<proparray.length; i++){ //loop through possible properties
		if (typeof root.style[proparray[i]]=="string"){ //if the property value is a string (versus undefined)
			return proparray[i] //return that string
		}
	}
}

var shadowprop=getsupportedprop(['boxShadow', 'MozBoxShadow', 'WebkitBoxShadow'])
var roundborderprop=getsupportedprop(['borderRadius', 'MozBorderRadius', 'WebkitBorderRadius'])
var csstransform=getsupportedprop(['transform', 'MozTransform', 'WebkitTransform', 'msTransform', 'OTransform'])
var divscale=getsupportedprop(['transform', '-moz-transform','-ms-transform','-webkit-transform','-o-transform'])

function changecssproperty(target, prop, value, action){
	if (typeof prop!="undefined")
		target.style[prop]=(action=="remove")? "" : value
}

function GetXmlHttpObject() {
	var xmlhttp=null;
	try {
	   // Firefox, Opera 8.0+, Safari
	   xmlhttp=new XMLHttpRequest();}
	catch (e) {
	   // Internet Explorer
	   try {xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}
	   catch (e) {xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}}
	return xmlhttp;
}

function update_statistik_pc_id(pc_id,googleurl,menu_id)
{
	url="/Connections/flash_cookie/pc_id_update.php";
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null) {//alert ("Your browser does not support AJAX!");return;
	} 

	var http = new XMLHttpRequest();
	params = "pc_id=" + pc_id + "&googleurl="+googleurl+"&menu_id="+menu_id;
	http.open("POST", url, true);
	
	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//http.setRequestHeader("Content-length", params.length);
	//http.setRequestHeader("Connection", "close");
	
	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {document.getElementById('pc_id_update_response').innerHTML=xmlhttp.responseText;}
	}
	http.send(params);
}

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}

</script>

<? /////////////////Unterdrücke alle Admin Funktionen für alle non-admin-Seiten die in /site_12_1/admin stehen & teste Login-Status.
if ($_SESSION['loggedIn'] == "true"){include_once("12_1_admin_functions.php");}?>