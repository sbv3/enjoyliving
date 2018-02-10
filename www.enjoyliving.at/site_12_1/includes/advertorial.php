<div>
<?

//Identifikation von robots
if (isset($_SERVER['HTTP_USER_AGENT'])){ $user_agent = ($_SERVER['HTTP_USER_AGENT']); } else { $b4yc_user_agent = ""; }
if (checkBot($user_agent)) {} else {


	if($kampagne_element_id==""){$kampagne_element_id=$zeige->id;}
	if($kampagne_element_id==""){$kampagne_element_id=$curr_element_id;}//wenn es ein seitencontent_V1 ist
	if($element_content_id[$kampagne_element_id]==""){$element_content_id[$kampagne_element_id]=$zeige->element_layout_id;}
	if($element_content_id[$kampagne_element_id]==""){$element_content_id[$kampagne_element_id]=$curr_element_layout_id;}//wenn es ein seitencontent_V1 ist
	
	//////////////////////////////////////////Ausgabe
	//Zuerst den anzuzeigenden code laden
	//dann die ...tags... wieder zurückkonvertieren
	//dann ausgeben
	//danach die Statistik dazu
	
	$kampagnen_element_query=mysql_query("select kampagnen_code.id, code, insert_click_tags from kampagnen_code, kampagnen,kampagnen_element
	where element_layout_id ='$element_content_id[$kampagne_element_id]'
	and kampagnen_element.element_id='$kampagne_element_id'
	and kampagnen.id=kampagnen_code.kampagnen_id
	and kampagnen_code.id=kampagnen_element.kampagnen_code_id
	and (now() > startdate or enddate ='0000-00-00')
	and (now() < enddate or enddate ='0000-00-00')") or die ("Kampagnen Query".mysql_error());
	$kampagnen_element_row_num=mysql_num_rows($kampagnen_element_query);
	
		$kampagnen_element_text=mysql_fetch_row($kampagnen_element_query);
		$code_id=$kampagnen_element_text[0];
		$code=$kampagnen_element_text[1];
		$code=str_replace("...tagopen...","<",$code);
		$code=str_replace("...tagclose...",">",$code);
		
if($kampagnen_element_text[4]==1){
?>
<div id="banners_<? echo $kampagne_element_id;?>" class="banners">
<? }
		echo "$code";
if($kampagnen_element_text[4]==1){?> 
</div>
<? }
	if($kampagnen_element_row_num >0){	
		//als nächstes tragen wir den Aufruf in die Datenbank kampagne_statistik ein.
		$kampagne_menu_id=$active_menu_id;
		$count_query=mysql_query("select count, id from kampagnen_statistik where kampagnen_element_id='$kampagne_element_id' and menu_id='$kampagne_menu_id' and kampagnen_code_id='$code_id' and date=date(now()) and hour=hour(now())") or die ("Count query 1 hat nicht geklappt".mysql_error());
		$count_row_num=mysql_num_rows($count_query);
		
		
		if($count_row_num=="0")
		{
			$count_insert_query=mysql_query("insert into kampagnen_statistik (kampagnen_element_id,menu_id,kampagnen_code_id,count) values ('$kampagne_element_id','$kampagne_menu_id','$code_id','0')") or die ("Count query initial insert hat nicht geklappt".mysql_error());
			$count_query=mysql_query("select count, id from kampagnen_statistik where kampagnen_element_id='$kampagne_element_id' and menu_id='$kampagne_menu_id' and kampagnen_code_id='$code_id' and date=date(now()) and hour=hour(now())") or die ("Count query 2 hat nicht geklappt".mysql_error());
		}
		$count_neu_result=mysql_fetch_assoc($count_query);
		
		$count_neu=$count_neu_result[count]+1;
		$kampagnen_statistik_id=$count_neu_result[id];
		$kampagnen_statistik_insert=mysql_query("update kampagnen_statistik set count='$count_neu' where id='$kampagnen_statistik_id'") or die ("Insert hat nicht geklappt".mysql_error());
	}
		
	$kampagne_element_id="";
	$element_content_id[$kampagne_element_id]=""; //f. welches Layout ist das gültig
}?>
</div>