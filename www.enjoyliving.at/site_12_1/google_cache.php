#!/usr/local/php5/bin/php-cli
<?php session_start();?>
<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

$cache_sites_q=mysql_query("select id,top_menu_id,host_string from sites");
while ($cache_sites_r=mysql_fetch_assoc($cache_sites_q))
{
	$cache_sites=$cache_sites_r[id];
	$top_menu_id=$cache_sites_r[top_menu_id];
	$host_string=$cache_sites_r['host_string'];
	$href_root="http://".$host_string;

	$urls=menu_select($top_menu_id,'down','99','1','','1',$cache_sites);
	
	$anz=count($urls['id']);
	$text='<'.'?xml version="1.0" encoding="UTF-8"?'.'>'; 
	$text="$text<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\">";
	
	for($i = 0; $i <= $anz-1; ++$i)
	{
		$text="$text<url>";
		$text="$text<loc>".$href_root.$urls['googleurl'][$i]."</loc>";
		$text="$text<lastmod>";
			$id=$urls['id'][$i];
			$lastmod=mysql_query("select date(up_date) from menu where id=$id") or die (mysql_error());
			$lastmod=mysql_fetch_row($lastmod);
			$lastmod=$lastmod[0];
		$text=$text.$lastmod."</lastmod>";
		$text="$text<changefreq>daily</changefreq>";
		$text="$text<priority>0.8</priority>";
		$text="$text</url>";
	}
	$text="$text</urlset>";
	$text=str_replace("'","\'",$text);
	$text=GetSQLValueString($text,"text");
	mysql_query("insert into google_sitemap_cache (cache,site_id) values($text,$cache_sites)") or die (mysql_error());
}
?>