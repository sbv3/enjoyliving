<span id="status"></span></p>
<script src="/Connections/flash_cookie/src/swfstore.js"></script>

<script type="text/javascript">

var mySwfStore = new SwfStore({
	
	namespace: 'pc_id', // the this must match all other instances that want to share cookies
	
	swf_url: '/Connections/flash_cookie/storage.swf', // to work cross-domain, use the same absolute url on both pages (meaning http://site.com/path/to/store.swf not just /path/to.store.swf)
	
	debug: false, // depending on your browser, this will either go to the console or the bottom of the page.
	
	onready: function(){
		var pc_id=mySwfStore.get('my_pc_id');
		// read the existing value (if any)
		if(pc_id)
		{
			setCookie("my_pc_id",pc_id,365);
		}
		else
		{
		// set up an onclick handler to save the text to the swfStore whenever the Save button is clicked
		// IE converts null to "null", so we're adding an `or "" ` to the end to fix that
			pc_id=Math.floor(Math.random()*10000000000001);
			mySwfStore.set('my_pc_id', pc_id);
			setCookie("my_pc_id",pc_id,365);
			//document.getElementById("status").innerHTML="write: "+val(mySwfStore.get('myValue'));
		}
		update_statistik_pc_id(pc_id,"<? echo $googleurl;?>","<? echo $menu_id;?>")
	},
	onerror: function(){
		var pc_id=getCookie("my_pc_id");
		if (pc_id!=null && pc_id!="")
		{
			setCookie("my_pc_id",pc_id,365);
		}
		else 
		{
			pc_id=Math.floor(Math.random()*10000000000001);
			setCookie("my_pc_id",pc_id,365);
		}
		update_statistik_pc_id(pc_id,"<? echo $googleurl;?>","<? echo $menu_id;?>");
	}
});
</script>
