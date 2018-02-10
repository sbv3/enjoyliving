<link rel="stylesheet" type="text/css" href="jquery-editable/jquery-editable/css/jquery-editable.css">
<link rel="stylesheet" type="text/css" href="poshytip-master/src/tip-yellowsimple/tip-yellowsimple.css">
<script type="text/javascript" src="/Connections/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/Connections/poshytip-master/src/jquery.poshytip.js"></script>
<script type="text/javascript" src="/Connections/jquery-editable/jquery-editable/js/jquery-editable-poshytip.js">
 $.fn.editable.defaults.mode = 'popup';
</script>
 
<div class="editable-click" style="width:30px;" id="days" data-type="text" data-pk="1">17</div>
 
<script>
 $('.editable-click').editable({
	 url:"result.php",
	 emptytext:"hier eingeben",
	 mode:"popup",
	 params: {
	 task:"update_jq_editable",
	 tabelle:"xxx"
	 },
	 onblur:"submit"
 });
</script>