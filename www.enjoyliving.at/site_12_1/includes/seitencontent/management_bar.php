<?
if (class_exists("visitor"))
{?>
	<div style="position:relative;">
		<div style="position:relative; left:-5px; right:-5px; bottom:-5px; background-image:url(/site_12_1/css/verlauf.gif); background-repeat:repeat-x;width:310px;height:33px;">
			<div name="management_tab1" style="float:left; width:61px;height:31px;position:relative; top:2px;" onMouseOver="this.style.backgroundImage='url(/site_12_1/css/Reiter.png)'" onMouseOut="this.style.backgroundImage=''">
				<div name="recentlyViewed" style="position:relative; top: 6px; left:20px; width: 20px; height:20px; background-image:url(/site_12_1/css/Uhr.png);background-repeat: no-repeat;">
				</div>
				<div name="management_tab1_selected" style="position:absolute; top: 28px; left:15px; width:30px; height:3px; background-color:#999; display:none"></div>
			</div>
			<div name="management_tab2" style="float:left; width:61px;height:31px;position:relative; top:2px;" onMouseOver="this.style.backgroundImage='url(/site_12_1/css/Reiter.png)'" onMouseOut="this.style.backgroundImage=''">
				<div name="settings" style="position:relative; top: 6px; left:20px; width: 20px; height:20px; background-image:url(/site_12_1/css/Zahnrad.png);background-repeat: no-repeat;">
				</div>
				<div name="management_tab2_selected" style="position:absolute; top: 28px; left:15px; width:30px; height:3px; background-color:#999; display:none"></div>
			</div>
			<div name="management_tab3" style="float:left; width:61px;height:31px;position:relative; top:2px;" onMouseOver="this.style.backgroundImage='url(/site_12_1/css/Reiter.png)'" onMouseOut="this.style.backgroundImage=''">
				<div name="tasks" style="position:relative; top: 6px; left:20px; width: 20px; height:20px; background-image:url(/site_12_1/css/Haken.png);background-repeat: no-repeat;">
				</div>
				<div name="management_tab3_selected" style="position:absolute; top: 28px; left:15px; width:30px; height:3px; background-color:#999; display:none"></div>
			</div>
			<div name="management_tab4" style="float:left; width:61px;height:31px;position:relative; top:2px;" onMouseOver="this.style.backgroundImage='url(/site_12_1/css/Reiter.png)'" onMouseOut="this.style.backgroundImage=''">
				<div name="accounting" style="position:relative; top: 6px; left:20px; width: 20px; height:20px; background-image:url(/site_12_1/css/EUR.png);background-repeat: no-repeat;">
				</div>
				<div name="management_tab4_selected" style="position:absolute; top: 28px; left:15px; width:30px; height:3px; background-color:#999; display:none"></div>
			</div>
		</div>
	</div>
	<script>
	 $("[name='management_tab1']").click(function(e)
	 {
		 close_menus(1);
		 load_history();
		 //other functions being management from the "management_bar_history.php"
	 })
	 $("[name='management_tab2']").click(function()
	 {
		 close_menus(2);
		 $("[name='management_tab2_list']").slideToggle("fast");
		 $("[name='management_tab2_selected']").toggle();
	 })
	 $("[name='management_tab3']").click(function()
	 {
		 close_menus(3);
		 $("[name='management_tab3_list']").slideToggle("fast");
		 $("[name='management_tab3_selected']").toggle();
	 })
	 $("[name='management_tab4']").click(function()
	 {
		 close_menus(4);
		 $("[name='management_tab4_list']").slideToggle("fast");
		 $("[name='management_tab4_selected']").toggle();
	 })
	
	function close_menus(trig)
	{
		for(var sel=1;sel<=4;sel++)
		{
			if($("[name='management_tab"+sel+"_selected']").is(":visible") && trig!=sel)
			{
				$("[name='management_tab"+sel+"_list']").slideToggle("fast");		
				$("[name='management_tab"+sel+"_selected']").toggle();
			}
		}
	}
	 
	</script>
	<div name="management_tab1_list" style="display:none;padding-top:10px;">
		<? include("management_bar_history.php");?>
	</div>
	<div name="management_tab2_list" style="display:none;height:200px; padding-top:10px;background-color:#0C0">
		<? include("management_bar_profileinstellungen.php");?>
	</div>
	<div name="management_tab3_list" style="display:none;height:300px; padding-top:10px;background-color:#FF0">
		<? include("management_bar_tasks.php");?>
	</div>
	<div name="management_tab4_list" style="display:none;height:400px; padding-top:10px;background-color:#F0F">
		<? include("management_bar_abrechnung.php");?>
	</div>
<? }?>