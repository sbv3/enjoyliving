<?php header ('Content-type: text/html; charset=iso-8859-1'); ?>
<?
ini_set("include_path",ini_get("include_path").":/home/enjftfxb/www.enjoyliving.at/"); 
require_once("Connections/usrdb_enjftfxb2_12_1.php");

if($mgt_bar_task=="show_mgt_menu_id" && $mgt_bar_menu_id!="")
{
	class mySQL
	{
		private function executeQuery($query)
		{
			return $result=mysql_query($query);
		}
		private function getAssoc($sql)
		{
			return $result=mysql_fetch_assoc($sql);
		}
		public function getData($query)
		{
			$sql=$this->executeQuery($query);
			
			while($data=$this->getAssoc($sql))
			{$result[]=$data;}
			return $result;
		}
	}
	
	class page
	{
		public $menu_id;
		public $mode;
		public $type;
		
		public function display()
		{
			$this->getElements();
		}
	
		private function getElements()
		{
			global $mySQL;
			$elements=$mySQL->getData("SELECT element.id, element.element_layout_id FROM element, element_layout WHERE menu_id='$this->menu_id' and element_layout.id=element.element_layout_id and element_layout.type not like '%seitencontent%' and element_layout.type not like '%sponsorbanner%' order by sort");
			foreach($elements as $elementsData)
			{
				$elementData = $this->getElementData($elementsData['id']);
				$this->displayElement($elementsData['id'],$elementsData['element_layout_id'],$elementData);
				
			}
		}
		
		private function getElementData($elementId)
		{
			global $mySQL,$site_id;
			$text_abfrage=$mySQL->getData("select id as texts_id, text as texts, editor as editors, style_tag as texts_style, sort as texts_sort from element_content_text where element_id='$elementId' order by sort");
			$img_abfrage=$mySQL->getData("select concat('/site_12_1/assets/',category,class,path,filename) as imgs,assets.ID as assets_id, element_content_img.id as imgs_id, element_content_img.sort as imgs_sort, category as imgs_category, class as imgs_class, element_content_img.type as imgs_type, filename as filename, path as path from assets, element_content_img where element_id='$elementId' and element_content_img.assets_ID=assets.ID and category ='img' order by sort");
			$menu_abfrage=$mySQL->getData("select element_content_menu.id as menus_id, element_content_menu.menu_id as menus, menu_hierarchy.active as menus_active, menu_hierarchy.active_startdate as menus_start, menu_hierarchy.active_enddate as menus_end from element_content_menu,menu,menu_hierarchy where element_id='$elementId' and element_content_menu.menu_id=menu.id and site_id=$site_id and menu_hierarchy.menu_id=menu.id order by element_content_menu.sort");
			$code_abfrage=$mySQL->getData("select id as codes_id, if(admin_url='',concat('/site_12_1/',url),concat('/site_12_1/',url)) as codes, active as codes_active from element_content_code where element_id='$elementId' order by sort");
			
			$result['textData']=$this->resolveData($text_abfrage);
			$result['imgData']=$this->resolveData($img_abfrage);
			$result['menuData']=$this->resolveData($menu_abfrage);
			$result['codeData']=$this->resolveData($code_abfrage);
			return $result;
		}
		
		private function resolveData($text_abfrage)
		{
			for($row=0,$row_total=count($text_abfrage);$row<$row_total;$row++)
			{
				$fieldSet=$row;
				foreach($text_abfrage[$row] as $field => $data)
				{
					if($initial==""){$result[$field][0]="";$initial=1;}
					$result[$field][$row+1]=$data;
				}
			}
			return $result;
			//print_r($result);
		}
		
		private function displayElement($elem_id,$elem_layout_id,$elementData)
		{
			global $mySQL,$site_id,$counter;
			include "../../../Connections/resolve_get_post.php";
			$active_menu_id=$this->menu_id;
			
			$textData=$elementData['textData'];
			$imgData=$elementData['imgData'];
			$menuData=$elementData['menuData'];
			$codeData=$elementData['codeData'];
			
			$snippet_abfrage = $mySQL->getData("select type,php_admin_snippet, php_snippet from element_layout where id='$elem_layout_id'");
	
			$php_snippet = $snippet_abfrage[0]['php_snippet'];
			$php_admin_snippet = $snippet_abfrage[0]['php_admin_snippet'];
			$php_snippet_type = $snippet_abfrage[0]['type'];
			
			
			if(count($textData)>0){foreach($textData as $field => $data){$$field=$data;}}
			if(count($imgData)>0){foreach($imgData as $field => $data){$$field=$data;}}
			if(count($menuData)>0){foreach($menuData as $field => $data){$$field=$data;}}	
			if(count($codeData)>0){foreach($codeData as $field => $data){$$field=$data;}}	
	
			$this->type=$php_snippet_type;
			
			if($php_admin_snippet==""){$php_admin_snippet=$php_snippet;}
			
			$scope="main";
			if(strchr($this->type,"in padding"))
			{ 
				if($counter==0){echo "<div id='outsidebox_$elem_id' class='content_v1'>";$counter=1;}
				?>
				<div class="content_v1_elements"><? include $_SERVER['DOCUMENT_ROOT']."site_12_1/$php_snippet";?></div>
			<? }
			elseif(strchr($this->type,"break padding"))
			{
				if($counter>0){echo "</div>";}
				$counter=0;?>
				<div class="content_v1_elements_break_padding"><? include $_SERVER['DOCUMENT_ROOT']."site_12_1/$php_snippet";?></div>
			<? } 
	
		}
	}
	
	
	$mySQL=new mySQL;
	
	$x=new page;
	$x->menu_id=$mgt_bar_menu_id;
	
	?>
	<? $x->display();?>
<?
}
?>