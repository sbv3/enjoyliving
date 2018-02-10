<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];


//////////////////////////////////////////Vorbereitende Abfragen

// Abfrage der buchtipp Tabelle
$buchtipp_query=mysql_query("select id,titel,subtitel,kurztext,bild,autor,verlag,ISBN,format,seiten,rezensionslink,amazonlink from buchtipp where element_id='$elem_id' order by sort") or die ("buchtipp Tabelle Abfrage1: ".mysql_error());
$buchtipp_num_rows = mysql_num_rows($buchtipp_query);
while(($buchtipp_query_result[] = mysql_fetch_assoc($buchtipp_query)) || array_pop($buchtipp_query_result));

?>



<table border="0px">
<?
// Für jeden Menüpunkt wird durchsucht, ob es schon Inhalte in der Tabelle menu_teaser gibt. Wenn nicht, müssen sie angelegt werden. Wenn doch, fragen wir der Reihe nach ab, was es schon gibt. Alles was leer ist wird von den Elementen befüllt.
	$counter_buchtipp=0;
	for ($anz=0;$anz<=$buchtipp_num_rows-1;$anz+=1)
	{$counter_buchtipp=$counter_buchtipp+1;?>
		<? if($counter_buchtipp==1){ echo "<tr>";} ?>
				<td class="trenner" style="width: 201px; padding-top:1px; padding-right:5px; text-align:center; vertical-align:top;border-width:0px 0px 1px 0px"> 
					<div style="height:5px"></div>
					<? $anzi=$anz+1;
					echo "<img title='$imgs_alt_tag[$anzi]' alt='$imgs_alt_tag[$anzi]' class='$imgs_type[$anzi]' src='$imgs[$anzi]'>";
					?>
					<div style="height:5px"></div>
					<div class='teaser_einleitung'> <? echo $buchtipp_query_result[$anz]['titel']?></div>
					<div class='artikeltext'> <? echo $buchtipp_query_result[$anz]['subtitel']?></div>
					<div class='autor'> <? echo $buchtipp_query_result[$anz]['autor']?></div>
					<div style='height:8px;'>&nbsp;</div>
					<div style='text-align: left; '>
						<span class='teasertext'> <? echo $buchtipp_query_result[$anz]['kurztext']?></span>
						<br><br />
						
						<? if($buchtipp_query_result[$anz]['verlag']!=""){?>
							<a class="teasertext">Verlag:&nbsp;</a>
							<div class='teasertext'> <? echo $buchtipp_query_result[$anz]['verlag']?></div>
						<? }?>
					
						<? if($buchtipp_query_result[$anz]['ISBN']!=""){?>
							<a class="teasertext" style="float:left">ISBN:&nbsp;</a>
							<div class='teasertext'> <? echo $buchtipp_query_result[$anz]['ISBN']?></div>
						<? }?>
					
						<? if($buchtipp_query_result[$anz]['format']!=""){?>
							<a class="teasertext" style="float:left">Format:&nbsp;</a>
							<div class='teasertext'> <? echo $buchtipp_query_result[$anz]['format']?></div>
						<? }?>
						
						<? if($buchtipp_query_result[$anz]['seiten']!=""){?>
							<a class="teasertext" style="float:left">Seitenzahl:&nbsp;</a>
							<div class='teasertext'> <? echo $buchtipp_query_result[$anz]['seiten']?></div>
						<? }?>
					
						<? if($buchtipp_query_result[$anz]['rezensionslink']!=""){?>
							<br><br />
							<a class='teasertext' href="<? echo $testpfad.$buchtipp_query_result[$anz]['rezensionslink']?>">Zur Rezension</a>
						<? }?>
					
						<? if($buchtipp_query_result[$anz]['ISBN']!=""){ //Amazon link?>
							<br>
							<a class='teasertext' style="font-weight:bold;" target="_blank" href="<? echo "http://www.amazon.de/exec/obidos/redirect?link_code=as2&path=ASIN/".$buchtipp_query_result[$anz]['ISBN']."%3Fsite-redirect=at&tag=enjoylivingda-21&camp=1638&creative=6742"?>">Bei Amazon kaufen</a>
							<br />
						<? }?>
					</div>
				</td>
	<? if($counter_buchtipp==3){ echo "</tr>";$counter_buchtipp=0;} ?>
	
	<?
	}//Schleife Ende for all Menu ids
	?>
	<? 
	if($counter_buchtipp==1){ echo "<td class='trenner' style='border-width:0px 0px 1px 0px'>&nbsp;</td><td class='trenner' style='border-width:0px 0px 1px 0px'>&nbsp;</td></tr>";} 
	if($counter_buchtipp==2){ echo "<td class='trenner' style='border-width:0px 0px 1px 0px'>&nbsp;</td></tr>";} 
	?>

</table>
