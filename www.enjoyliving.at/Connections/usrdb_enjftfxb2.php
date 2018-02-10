<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
//$testpfad="/neuesmag";
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once("db_link.php");
require_once("jquery-1.7.2.php");
require_once("pwd.php");
$date=date("Y-m-d");
//$hostname_usrdb_enjftfxb2 = "127.0.0.1:3307";
$database_usrdb_enjftfxb2 = "usrdb_enjftfxb2";
$username_usrdb_enjftfxb2 = "enjftfxb2";
$password_usrdb_enjftfxb2 = $db_pwd;
$usrdb_enjftfxb2 = mysql_pconnect($hostname_usrdb_enjftfxb2, $username_usrdb_enjftfxb2, $password_usrdb_enjftfxb2) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_usrdb_enjftfxb2, $usrdb_enjftfxb2);
?>
<? /////Bots identifizieren
function checkBot($string) {
	$bots = array(	
	'bot','altaVista intranet','beholder','fido','gazz','scan','medicalmatrix','ultraseek','ezresult','ask jeeves/teoma','looksmart','Ask Jeeves','crawler','msnbot','Baiduspider','Mediapartners-Google','bumblebee','crescent','gigabaz','fireball','mercator','quosa','piranha','informant','libwww','url_spider_sql','TECNOSEEK','www.galaxy.com','appie','Feedfetcher-Google','Sogou web spider','java','arachnoidea','cherrypicker','emailsiphon','gulliver','link','larbin','miixpc','t-h-u-n-d-e-r-s-t-o-n-e','swisssearch','teoma','firefly','InfoSeek','Googlebot','FAST','TechnoratiSnoop','WebAlta Crawler','alexa','froogle','gigabot','girafabot','inktomi','nationaldirectory','rabaz','Rankivabot','Scooter','Slurp','Spade','WebBug','WebFindBot','ZyBorg','agentname','asterias','cosmos','crawl','emailwolf','extractorpro','hcat','hloader','incywincy','indy library','internetami','internetseer','libweb','mata hari','moget','muscatferret','openxxx','robo','search','sly','spider','spy','spyder','sqworm','trivial','webbandit','wisewire','jeeves','yandex','google','yahoo','archiver','curl','python','nambu','twitt','perl','shpere','PEAR','wordpress','radian','eventbox','monitor','mechanize','facebookexternal','mj12','google','robot','Magpie','spider','bbot'
	);
	$string = strtolower($string);
	$i = 0;
	$summe = count($bots);
	
	while ($i < $summe) {
	  if (strstr($string, $bots[$i])) return true;
	  $i++;
	}
	return false;
}
?>
<?
function find_googleurl($menu_id)
{
	global $testpfad;
	$googleurl_query=mysql_query("select googleurl from googleurl where menu_id='$menu_id' order by create_date desc limit 1") or die ("1".mysql_error());
	$googleurl_result=mysql_fetch_row($googleurl_query);
	$googleurl=$googleurl_result[0];
	return($testpfad.$googleurl);
}
?>
<?
function find_parent($menu_id)
{
	$parent_query=mysql_query("select parent_id from menu where id='$menu_id'") or die ("parent_query failed");
	$result=mysql_fetch_assoc($parent_query);
	$result=$result[parent_id];
	return $result;
	}
?>
<?
function _Strip_Tag($Str_Input)
{
	@settype($Str_Input, 'string');
	$Str_Input= @strip_tags($Str_Input);
	$_Ary_TagsList= array(chr(9));
	$Str_Input= @str_replace($_Ary_TagsList, '', $Str_Input);
	$Str_Input= @str_replace('', '', $Str_Input);
	return((string)$Str_Input);
}
?>
<?
function menu_select($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten)
{
 //function to select parent_ids or daughter_ids of the menu.
//$start_id ist die ID, von der weg geprüft werden soll.
//$direction ist entweder "up" oder "down".
//$numer_levels ist ein numerischer Wert, der nur bei "down" relevanz hat. Er gibt an, wie viele Ebenen durchsucht werden sollen.
//$only active ist enteder "1" oder was anderes. Nur wenn es "1" ist, werden nur die aktiven Einträge druchsucht. 
//$menu_only ist entweder "1" oder "2" oder was anderes. Nur wenn es "1" ist, werden nur die Menüeinträge gezeigt. Wenn es "2" ist, werden nur jene Einträge wieder gegeben, die selbst kein Meunü sind.
//Aufrufen durch: print_r(menu_select('46','down','1','',''));
	unset($GLOBALS['menu_select_siblings']);
	unset($GLOBALS['menu_select_parent']);
	if($only_active=="1"){$search_append_string="and (active_startdate<=now() or active_startdate='0000-00-00') and (active_enddate>=now() or active_enddate='0000-00-00') and active='A'";}
	if($menu_only=="1"){$search_append_string=$search_append_string." and display='1'";}
	if($exclude_subseiten=="1"){$search_append_string=$search_append_string." and search_type not like '%Subseiten%'";}

	$i=-1;
	if(function_exists('menu_select_siblings')){unset ($menu_select_siblings);} else
	{
		function menu_select_siblings($parent_id,$number_levels,$i,$search_append_string,$menu_only)
		{
			$i=$i+1;
			if($i<$number_levels or $number_levels==0 or $number_levels=="")
			{
				global $menu_select_siblings;
				$sibling_query=mysql_query("select id, description, display from menu where parent_id=$parent_id $search_append_string order by sort") or die ("sibling_query: ".mysql_error());
				echo $parent_id;
				if($parent_id==3) {echo "hh";echo "select id, description, display from menu where parent_id=$parent_id $search_append_string order by sort";}
				
				while($sibling_query_result=mysql_fetch_assoc($sibling_query))
				{
					if(($menu_only==2 and $sibling_query_result['display']==0) or $menu_only!=2){//if the selector menu only is set to 2, only those items are recorded that are actually NOT menus.
						$menu_select_siblings['id'][] = $sibling_query_result['id'];
						$menu_select_siblings['description'][] = $sibling_query_result['description'];
						$menu_select_siblings['googleurl'][] = find_googleurl($sibling_query_result['id']);			
						$menu_select_siblings['level_down'][] = $i;	
					}
					menu_select_siblings($sibling_query_result['id'],$number_levels,$i,$search_append_string,$menu_only);
				}
			}
			return($menu_select_siblings);
		}
	}
	
	if(function_exists('menu_select_parents')){} else
	{
		function menu_select_parents($sibling_id, $only_active_string)
		{	if($sibling_id=="" or $sibling_id=="0" or !$sibling_id){} else
			{
				global $menu_select_parent;
				$parent_query=mysql_query("select id, parent_id, description from menu where id=$sibling_id $search_append_string order by sort") or die ("parent_query: ".mysql_error());
				while($parent_query_result=mysql_fetch_assoc($parent_query))
				{
					if($parent_query_result[id]==0){break;}
					$menu_select_parent['id'][] = $parent_query_result['id'];
					$menu_select_parent['description'][] = $parent_query_result['description'];
					$menu_select_parent['googleurl'][] = find_googleurl($parent_query_result['id']);			
					menu_select_parents($parent_query_result[parent_id],$search_append_string);
				}
				return($menu_select_parent);
			}
		}
	}
	
	if($direction=="up"){return(menu_select_parents($start_id,$search_append_string));}
	elseif($direction=="down"){return(menu_select_siblings($start_id,$number_levels,$i,$search_append_string,$menu_only));}
}
?>
<? //function to replace special characters
function replace($x) {
	$k1=array(' - ','ß','ä','ö','ü','Ä','Ö','Ü',' ',':','&','?','!','"',',','.',"\'","/");
	$k2=array('-','ss','ae','oe','ue','ae','oe','ue','-','-','und','','','','','',"","-");
	for ($i='0';$i<count($k1);$i++) {$x = str_replace($k1[$i],$k2[$i],$x);}
	return $x;
}
?>
<? ///////////Function to identify which file has included another
function trace()
	{$trace=debug_backtrace();
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
	return ($filename);
}
?>
<? ///////function whereami -- braucht layout (="content" oder "admin") und $menu_id als input. Von dieser ID weg wird nach oben zurückgearbeitet und ein echo-fertiges statement zurück gegeben.
function whereami($layout,$menu_id){
	global $testpfad;
	###Ausgabe des aktuellen Menüs
	$location=mysql_query("select id, parent_id, description from menu where id='$menu_id'") or die ("x2");
	while ($locationshow=mysql_fetch_object($location))
	{
/*		if($layout=="content")
		{	$whereamigoogle_query=mysql_query("select googleurl from googleurl where menu_id='$menu_id' order by create_date desc limit 1") or die ("x2.1");
			$whereamigoogle_result=mysql_fetch_row($whereamigoogle_query);
			$whereamigoogle=$testpfad.$whereamigoogle_result[0];
			$class="teasertext";
			$whereamiurl="$locationshow->description"; 
			$whereamihref=" &raquo <a href='".$whereamigoogle."' class=$class>".$whereamiurl."</a>";
		}
		elseif($layout=="admin")
		{
			$class="";
		}		
*/		if ($locationshow->parent_id!="0"){$parent_id="$locationshow->parent_id";}else{$parent_id="";}
	}
	###Ausgabe der weiteren Parent Menüs
	while ($parent_id != "")
	{
		$location=mysql_query("select parent_id, description from menu where id='$parent_id'") or die ("x3");
		while ($locationshow=mysql_fetch_object($location))
		{
		if($layout=="content")
		{	$whereamigoogle_query=mysql_query("select googleurl from googleurl where menu_id='$parent_id' order by create_date desc limit 1") or die ("x2.3");
			$whereamigoogle_result=mysql_fetch_row($whereamigoogle_query);
			$whereamigoogle=$testpfad.$whereamigoogle_result[0];
			$class="whereamilink";
		}
		elseif($layout=="admin")
		{	
			$whereamigoogle="/site_11_1/admin/papa/menu.php?men_id=".$parent_id;
			$class="";
		}
			$whereamiurl="$locationshow->description"; 
			$whereamihref=" &raquo <a href='".$whereamigoogle."' class=$class>".$whereamiurl."</a>".$whereamihref;
			if ($locationshow->parent_id!="0"){$parent_id="$locationshow->parent_id";}else{$parent_id="";}
		}
	}
	return($whereamihref);
} 
?>
<? //////Function to truncate text to the maximum of characters
// Original PHP code by Chirp Internet: www.chirp.com.au (http://www.the-art-of-web.com/php/truncate/)
// Please acknowledge use of this code by including this header. 
function truncate_max($string, $limit, $break=" ", $pad="...") { // return with no change if string is shorter than $limit 
	if(strlen($string) <= $limit) return $string; 
	$string = substr($string, 0, $limit); 
	if(false !== ($breakpoint = strrpos($string, $break))) 
	{ $string = substr($string, 0, $breakpoint); } 
	return $string . $pad; 
}
?>
<? ///die Funktion NewMenu legt einen neuen Menüpunkt, inkl. Google-URL. Es werden doppelte Google-URLs vermieden. Benötigt werden Menü-hierarchy, sort, parent_id, description,display (0/1), active (Y/N),startdatum, enddatum und seitentyp. Die Funktion ruft danach die Element-Anlage auf.

function newmenu($menu_ordering2,$parent_id,$titel2,$display,$active,$active_startdate,$active_enddate,$seitentyp,$search_type) 
{
	$titel3=GetSQLValueString($titel2,"text");
	$datum_heute = date("Y-m-d H:i");
	mysql_query("INSERT INTO menu (description,metatag_title,parent_id,sort,display,active,active_startdate,active_enddate,up_date,pagetype,search_type) VALUES ($titel3,$titel3,'$parent_id','$menu_ordering2','$display','$active','$active_startdate','$active_enddate','$datum_heute','$seitentyp','$search_type')")or die("xxx");
	$result = mysql_query("SELECT * FROM menu order by id desc limit 1")or die("x1");
	while ($show=mysql_fetch_object($result))
	{$menuid="$show->id";}
		 
	create_googleurl($titel2,$menuid);
	
	$result = mysql_query("SELECT * FROM pagetype WHERE description='$seitentyp' order by sort")or die("stop");
	while ($show=mysql_fetch_object($result))
	{
		new_element($menuid,$show->element_layout_id,$show->sort);
	}
	return;
} //ende funktion
?>
<?
function create_googleurl($titel_neu,$menuid)
{
	global $testpfad;
	$parent_id=menu_select($menuid,"up","","","","");
	
	$parent_id=$parent_id['id'][1];

	if($parent_id==0){
		$own_string = "/home";
		$own_url=$own_string.".html";
		$parent_string="";
		$parent_url="";}
	elseif($parent_id==230){
		$own_string="/".replace($titel_neu)."-magazin";$own_string=strtolower($own_string);
		$own_url=$own_string.".html";
		$parent_string="home";
		$parent_url="home.html";}
	elseif($parent_id!=0 and $parent_id!=230){
		$own_string="/".replace($titel_neu);$own_string=strtolower($own_string);
		$parent_url=find_googleurl($parent_id);
		$length=strlen($testpfad);
		$parent_url=substr($parent_url,$length);
		$parent_string=substr($parent_url,0,-5);
		$own_url=$parent_string.$own_string.".html";}

	$pre_url_sql=GetSQLValueString($own_url,"text");
	$unique_test=mysql_query("select count(1) as anz, max(appendix_counter) as max from googleurl where googleurl like concat(left($pre_url_sql,CHAR_LENGTH($pre_url_sql)-(LEAST(1,(ifnull(CHAR_LENGTH(appendix_counter),0)*1))+ ifnull(CHAR_LENGTH(appendix_counter),0))-5),'%.html')") or die ("2".mysql_error());
	$unique_test_result=mysql_fetch_assoc($unique_test);
	if($unique_test_result['anz']>0)
	{
		$appendix_counter=$unique_test_result['max']+1;
		$final_url=$parent_string.$own_string."-".$appendix_counter.".html";
	}
	else{$final_url=$own_url;}
		
	if($appendix_counter=="" or $appendix_counter==0){$appendix_counter="NULL";}
	$final_url_sql=GetSQLValueString($final_url,"text");
	mysql_query("insert into googleurl (menu_id, googleurl, appendix_counter) values ('$menuid',$final_url_sql,$appendix_counter)") or die ("insert into googleurl (menu_id, googleurl, appendix_counter) values ('$menuid',$final_url,$appendix_counter)"." | ".mysql_error());
}
?>
<?
function update_googleurl($menuid)//Funktion zum aktualisieren einer Googleurl + allen anderen darunter in der Hierarchie.
{
	$upd_siblings_arr=menu_select($menuid,"down",99,'','','');
	$i=0;
	do{
		create_googleurl($upd_siblings_arr['description'][$i],$upd_siblings_arr['id'][$i]);
		$i=$i+1;
	} while ($i<count($upd_siblings_arr['id']));
}
?>
<? ///new_element erstellt ein neues element und auch die entsprechenden element_content einträge (text, image und code). Benötigt werden nur die menu_id, die element_layout_id, und die sort_order.
function new_element ($f_menu_id,$f_element_layout_id,$f_sort){
	mysql_query("INSERT INTO element (menu_id,element_layout_id, sort) 
	VALUES ('$f_menu_id','$f_element_layout_id','$f_sort')")or die("xxx");
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
					mysql_query("INSERT INTO element_content_text(element_id,editor,style_tag, sort) VALUES ('$show1->id','$editor','$default_style_tag','$sortx')")or die("xxx0");	
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
					mysql_query("INSERT INTO element_content_code(element_id,url,admin_url, sort) VALUES ('$show1->id','$urlxxx','$admin_urlxxx','$sortx')")or die("xxx1");	
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
	return($show1->id);
} //ende Funktion
?>
<?php
###Funktion zum Checken von Dateneingaben bei SQL-Abfragen -- damit keine Hacker durchkommen...
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
}
}
?>
<?
function test_login($user,$password,$site_id)
{
	$users_pwd_query=mysql_query("select id from user_sites_x_groups where groups_id in (select groups_ID from user_users_x_groups where users_id=(select id from user_users where username='$user' and password='$password')) and sites_ID='$site_id'") or die (mysql_error());
	if(mysql_num_rows($users_pwd_query)>0)
	{$result = "true";
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$_SESSION['site_id'] = $site_id;
	}
	else
	{$result = "false";}
	return $result;
}
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
function capture()
{
	if (isset($_SESSION['captcha_spam']) AND $_POST["sicherheitscode"] == $_SESSION['captcha_spam'])
	{
		unset($_SESSION['captcha_spam']); 
		$eintrag_OK=true;
	}
	else{$eintrag_OK=false;}
	return $eintrag_OK;
}

?>
<? /////////////////Unterdrücke alles JavaSCript für alle Seiten die in /site_11_1/admin stehen & teste Login-Status.
if (substr($_SERVER['PHP_SELF'],0,16)=="/site_11_1/admin"){
	if(!$_SESSION['user']){
		if(test_login($user,$password,$site_id)!="true")
		{
			echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_11_1/admin/Login.php?wrong_longin=1\">";
			exit;
		}
	}

	
	
	?>
<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">
	
	//AJAX Funktion, die das backend aufruft. 
	function display_data(url,wait) 
	
		//test if AJAX is supported	
	{url="/site_11_1/admin/"+url;
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
	//set all read-only fields to invisible
	   what.style.display="none";
	//set all edit fields to visible
	var objid=what.id.substring(0,what.id.indexOf("_div"));   
	   document.getElementById(objid).style.display="inline";
	   if(texts =="")
		   {document.getElementById(objid).value="hier eingeben";}
		   //   else {document.getElementById(objid).value=what.innerHTML;}     
	   else {document.getElementById(objid).value=texts;}     
	//put curser into the clicked field & select all
	   document.getElementById(objid).focus();
	   document.getElementById(objid).select();
	}
	
	
	//Funktion zum aktualisieren der Tabelle mit Textfeld
	function updateField(what,tabelle,recordid,script){
	value=what.value;
	var field=what.name;
	var str2=secure_code(value,script);
	if(value=="hier eingeben"){value="";}
	if(tabelle==""){return};
	//if(value==""){return};
	if(field==""){return};
	var url="Admin_table_result.php";
	url=url+"?task=update&tabelle="+tabelle+"&id="+recordid+"&field="+field+"&value="+URLencode(value,script);
	//set all read-only fields to visible
	var objid=what.id+"_div";
	   document.getElementById(objid).style.display="inline";
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
			document.getElementById(elem_id).src="../../css/Pin_unten.jpg";
			document.getElementById(elem_id).onclick = new Function("update_exklusiver_seitencontent("+menu_id+",0)");
			document.getElementById(elem_id).title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Seitencontent wieder vererbt.";
		}
		else if(set==0){
			document.getElementById(elem_id).src="../../css/Pin_oben.jpg";
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
			document.getElementById(elem_id).src="../../css/Pin_unten.jpg";
			document.getElementById(elem_id).onclick = new Function("update_exklusiver_sponsorbanner("+menu_id+",0)");
			document.getElementById(elem_id).title="Der Inhalt wird nicht weitervererbt. Bei clicken wird der Sponsorbaner wieder vererbt.";
		}
		else if(set==0){
			document.getElementById(elem_id).src="../../css/Pin_oben.jpg";
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
			document.getElementById(elem_id).src="../../css/Seitencontent_OK.png";
			document.getElementById(elem_id).onclick = new Function("update_page_finished("+menu_id+",0)");
			document.getElementById(elem_id).title="Die Seite ist fertiggestellt.";
		}
		else if(set==0){
			document.getElementById(elem_id).src="../../css/Seitencontent_fehlt.png";
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
			document.getElementById(elem_id).src="../../site_11_1/css/checkbox_checked.png";
			document.getElementById(elem_id).onclick = new Function("update_code_active("+codes_id+",0)");
			document.getElementById(elem_id).title="Das Element wird angezeigt.";
		}
		else if(set==0){
			document.getElementById(elem_id).src="../../site_11_1/css/checkbox_unchecked.png";
			document.getElementById(elem_id).onclick = new Function("update_code_active("+codes_id+",1)");
			document.getElementById(elem_id).title="Das Element wird nicht angezeigt.";
		}
	}


	</script>
<? }?>
