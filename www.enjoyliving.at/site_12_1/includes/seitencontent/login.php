<?
global $site_id;

function set_login_cookies($crypttext,$keep_logged_in)
{
	?>
	<script>
		setCookie("login","<? echo $crypttext;?>",1);
	</script>
	<?
	$_COOKIE["login"]=$crypttext;
	
	if($keep_logged_in!="")
	{?>
		<script>
		setCookie("keep_logged_in","<? echo $crypttext;?>",365);
		</script>
		<? 
		$_COOKIE["keep_logged_in"]=$crypttext;
	}
}
function remove_login_cookies()
{
	?>
	<script>
		setCookie("login","",-1);
	</script>
    <?
	unset ($_COOKIE["login"]);
	
	if($_COOKIE["keep_logged_in"])
	{
		?>
		<script>
			setCookie("keep_logged_in","",-1);
		</script>
		<?
		unset ($_COOKIE["keep_logged_in"]);
	}
}
function hash_pwd($password)
{
	$password_hashed=crypt($password,"$2a$30$mangoo");
	return $password_hashed;
}
function create_hash($username,$password)
{
	$password_hashed=hash_pwd($password);
	$cookie_string=($username."|".$password_hashed);
	
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$crypttext = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "This is a very secret key", $cookie_string, MCRYPT_MODE_ECB, $iv));
	return $crypttext;
}
function decode_hash($crypttext)
{
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, "This is a very secret key", base64_decode($crypttext), MCRYPT_MODE_ECB, $iv);
	return $plaintext;
}
function register_user($username,$email,$password,$update_pwd)
{
	global $site_id;
	$user_sql=GetSQLValueString($username, "text");
	$email_sql=GetSQLValueString($email, "text");
	if($update_pwd==0)
	{
		$user_exist_q=mysql_query("select * from visitor_credentials where username=$user_sql or user_email=$email_sql and site_id=$site_id limit 1");
		if(mysql_num_rows($user_exist_q)>0)
		{		
			return false;
		}
		else
		{
			$password_hashed=hash_pwd($password);
			$crypttext=create_hash($username,$password);
			mysql_query("insert into visitor_credentials (username,password,user_email,site_id) values ($user_sql, '$password_hashed',$email_sql,$site_id)");
			set_login_cookies($crypttext,"");

			$pc_id_q=mysql_query("select visitor_id from visitor_pc_id where pc_id=$_COOKIE[my_pc_id]");
			if(mysql_num_rows($pc_id_q)>0)
			{
				$pc_id_r=mysql_fetch_assoc($pc_id_q);
				$visitor_id=$pc_id_r[visitor_id];
				mysql_query("update visitor_credentials set visitor_id=$visitor_id where id=last_insert_id()");
			}
			return true;
		}
	}
	elseif($update_pwd==1)
	{
		$user_exist_q=mysql_query("select * from visitor_credentials where username=$user_sql or user_email=$email_sql and site_id=$site_id limit 1");
		if(mysql_num_rows($user_exist_q)==0)
		{		
			return false;
		}
		else
		{
			$password_hashed=hash_pwd($password);
			$crypttext=create_hash($username,$password);
			mysql_query("update visitor_credentials set password='$password_hashed' where username=$user_sql and site_id=$site_id");
			set_login_cookies($crypttext,"");
			return true;
		}
	}
}
function set_pwd_neu($email,$password)
{
	global $site_id;

	$email_sql=GetSQLValueString($email, "text");
	$user_exist_q=mysql_query("select * from visitor_credentials where user_email=$email_sql and site_id=$site_id limit 1");
	$user_exist_r=mysql_fetch_assoc($user_exist_q);
	$username=$user_exist_r[username];
	
	if(!register_user($username,$email,$password,1)){echo "Beim setzen des neuen Passworts ist ein Fehler aufgetreten. Wir haben den link aus dem Email ungültig gesetzt. Bitte versuchen Sie es noch einmal.";}
}		
function show_login_form($cookie_username)
{?>
	<script>
	function test_fields()
	{
		if($("#username").val()=="") {alert("Bitte einen Benutzernamen angeben");$("#username").focus();return false;}
		if($("#password").val()=="") {alert("Bitte ein Passwort angeben");$("#password").focus();return false;}
	}
	</script>
	<form method="post" onsubmit="return test_fields();" target="_self">
		<table style="">
			<tr>
				<td align="right">
					Benutzer: 
				</td>
				<td align="left">
					<input id="username" type="text" name="form_username" value="<? echo $cookie_username;?>">
			</tr>
			<tr>
				<td align="right">
					Passwort: 
				</td>
				<td align="left">
					<input id="password" type="password" name="form_password">
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td align="left">
					<input id="keep_logged_in" type="checkbox" name="form_keep_logged_in">
					Eingelogged bleiben
				</td>
			</tr>
            <tr>
                <td>
                </td>
                <td align="left">
                    <a href="?task=forgot_pwd">Passwort vergessen.</a> 
                </td>
            </tr>
            <tr>
                <td>
                	<input type="button" value="Registrieren" onclick="window.location='?task=register'"/>
                </td>
                <td align="right">
                	<input type="hidden" name="task" value="login" />
                	<input type="submit" value="Einloggen"/>
                </td>
            </tr>
		</table>
	</form>
<? 
}
function show_logoff_form($username)
{?>
	<form method="post" target="_self">
		<table>
			<tr>
				<td align="right">
					Eingelogged als:  
				</td>
				<td align="left">
					<? echo $username;?>
			</tr>
            <tr>
                <td>
                </td>
                <td align="right">
                	<input type="hidden" name="task" value="logoff" />
                	<input type="submit" value="log off"/>
                </td>
            </tr>
		</table>
	</form>
<? 	
}
function reset_pwd($reset_string)
{
	global $site_id;
	
	$reset_string_sql=GetSQLValueString($reset_string, "text");
	$user_email_exist_q=mysql_query("select * from visitor_credentials where password_reset_hash=$reset_string_sql and site_id=$site_id limit 1");
	if(mysql_num_rows($user_email_exist_q)>0)
	{		
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$password_reset_string=mcrypt_decrypt(MCRYPT_RIJNDAEL_256,"This is a very secret key",base64_decode($reset_string),MCRYPT_MODE_ECB, $iv);
		$password_reset_arr=explode("|",$password_reset_string);
		$date=$password_reset_arr[1];
		
		if(time()<$date)
		{
			$user_email_exist_r=mysql_fetch_assoc($user_email_exist_q);
			$user_email=$user_email_exist_r['user_email'];

			$user_email_update_q=mysql_query("update visitor_credentials set password_reset_hash=NULL where password_reset_hash=$reset_string_sql and site_id=$site_id limit 1");
			?>
			<script>
			function test_fields()
			{
				if($("#password1").val()=="") {alert("Bitte ein Passwort eingeben.");$("#password1").focus();return false;}
				if($("#password2").val()=="") {alert("Bitte das Passwort wiederholen.");$("#password2").focus();return false;}
				if($("#password1").val() != $("#password2").val()) {alert("Die beiden Passwörter stimmen nicht überein.");document.getElementById("password1").value=""; document.getElementById("password2").value=""; $("#password1").focus();return false;}
			}
			</script>
			<form method="post" onsubmit="return test_fields();" target="_self">
				<table>
					<tr>
						<td align="right">
							Neues Passwort: 
						</td>
						<td align="left">
							<input id="password1" type="password" name="password1">
					</tr>
					<tr>
						<td align="right">
							Passwort wiederholen: 
						</td>
						<td align="left">
							<input id="password2" type="password" name="password2">
					</tr>
					<tr>
						<td align="left">
						<input type="button" value="abbrechen" onclick="window.location=$(location).attr('pathname');" />
						</td>
						<td align="right">
						<input type="hidden" name="task" value="PWD_neu" />
						<input type="hidden" name="form_email" value="<? echo $user_email;?>" />
						<input type="submit" value="Password setzen"/>
						</td>
					</tr>
				</table>
			</form>
			<?
		}
		else{echo "Der angegebene Schlüssel ist leider abgelaufen";}
	}
	else{echo "Der angegebene Schlüssel ist leider ung&uuml;ltig.";}
}

if($task=="register")
{?>
	<div id="register_response"></div>
	<script>
	function test_fields()
	{
		if($("#username").val()=="") {alert("Bitte einen Benutzernamen angeben");$("#username").focus();return false;}
		if($("#email").val()=="") {alert("Bitte eine Email Adresse angeben");$("#email").focus();return false;}
		if($("#password1").val()=="") {alert("Bitte ein Passwort eingeben.");$("#password1").focus();return false;}
		if($("#password2").val()=="") {alert("Bitte das Passwort wiederholen.");$("#password2").focus();return false;}
		if($("#password1").val() != $("#password2").val()) {alert("Die beiden Passwörter stimmen nicht überein.");document.getElementById("password1").value=""; document.getElementById("password2").value=""; $("#password1").focus();return false;}
	}
	</script>
	<form method="post" onsubmit="return test_fields();" target="_self">
		<table>
			<tr>
				<td align="right">
					Benutzer: 
				</td>
				<td align="left">
					<input id="username" type="text" name="form_username" value="<? echo $cookie_username;?>">
			</tr>
			<tr>
				<td align="right">
					E-Mail: 
				</td>
				<td align="left">
					<input id="email" type="text" name="form_email">
				</td>
			</tr>
			<tr>
				<td align="right">
					Passwort: 
				</td>
				<td align="left">
					<input id="password1" type="password" name="form_password1">
				</td>
			</tr>
            <tr>
				<td align="right">
					Passwort wiederholen: 
				</td>
				<td align="left">
					<input id="password2" type="password" name="form_password2">
				</td>
            </tr>
            <tr>
                <td>
                 	<input type="button" value="abbrechen" onclick="window.location='?task='"/>
               </td>
                <td align="right">
                	<input type="hidden" name="task" value="signup_new_user" />
                	<input type="submit" value="Registrieren"/>
                </td>
            </tr>
		</table>
	</form>
<? }

if($task=="login" and $form_username!="" and $form_password!="")
{
	$task="";
	$crypttext=create_hash($form_username,$form_password);
	set_login_cookies($crypttext,$form_keep_logged_in);
}
if($task=="logoff")
{
	$task="";
	remove_login_cookies();
}
if($task=="forgot_pwd")
{
	$task="";?>
<script>
function test_username(googleurl)
{
	if($("#user_email").val()=="") {alert("Bitte einen Benutzernamen angeben");$("#user_email").focus();return false;}
	else {var user_email=$("#user_email").val();}

	url="/site_12_1/includes/seitencontent/login_backend.php";
	
	$.ajax({
	type: "POST",
	url:  url,
	data: { user_email: user_email, googleurl:googleurl},
	success: function(result)
		{
		   $('#user_email_test_response').html(result);
		   $('#test_usernmail').remove();
		}
	});
}
</script>
<div id="user_email_test_response"></div>
<form id="test_usernmail" method="post" onsubmit="return test_username();" target="_self">
	<table>
		<tr>
			<td align="right">
				e-Mail: 
			</td>
			<td align="left">
				<input id="user_email" type="text" name="form_username">
		</tr>
		<tr>
			<td>
			</td>
			<td align="right">
				<input type="button" value="Password zur&uuml;cksetzen" onclick="test_username('<? echo $host_string.$googleurl;?>')"/>
			</td>
		</tr>
	</table>
</form>
<div id="test_usermail2" class="trenner"></div>
<? 
}
if($task=="pwd_reset")
{
	$reset_string=$_GET[reset_string];	
	$reset_string=rawurldecode($reset_string);	
	if($reset_string!=""){reset_pwd($reset_string);}
}
if($task=="PWD_neu")
{
	$task="";
	if($password1!="" and $password2!="" and $password1==$password2)
	{
		set_pwd_neu($form_email,$password1);
	}
	else
	{echo "Das neue Passwort konnte leider nicht gesetzt werden. Wir haben den link aus dem Email ungültig gesetzt. Bitte versuchen Sie es noch einmal.";}
}
if($task=="signup_new_user")
{
	$task="";
	if($form_username!="" and $form_email!="" and $form_password1!="" and $form_password2!="" and $form_password1==$form_password2)
	{
		if(register_user($form_username,$form_email,$form_password1,0)==false)
		{echo "Diesen Benutzernamen oder diese Email-Adresse sind bereits vergeben";} 
		else {
			$crypttext=create_hash($form_username,$form_password1);
			set_login_cookies($crypttext,"");
		}
	}
}
if(($_COOKIE["login"]!="" or $_COOKIE["keep_logged_in"]!="") and $task=="")
{
	if($_COOKIE["login"]!=""){$cookie_crypttext=$_COOKIE["login"];}
	elseif($_COOKIE["keep_logged_in"]!=""){$cookie_crypttext=$_COOKIE["keep_logged_in"];}
	
	$plaintext=decode_hash($cookie_crypttext);
	$cookie_logoncredentials=explode("|",$plaintext);
	$cookie_username=$cookie_logoncredentials[0];
	$cookie_password_hashed=$cookie_logoncredentials[1];
		
	$test_login_q=mysql_query("select * from visitor_credentials where username='$cookie_username' and password='$cookie_password_hashed' and site_id=$site_id");
	if(mysql_num_rows($test_login_q)>0)
	{//user login hat geklappt.
		$test_login_r=mysql_fetch_assoc($test_login_q);
		$visitor_credential_id=$test_login_r['id'];
		$visitor_id=$test_login_r['visitor_id'];
		$password_reset_hash==$test_login_r['password_reset_hash'];
		
		$visitor_username=$cookie_username;
		
		class visitor
		{
			public $visitor_id;
			public $username;
			public $pc_ids = array();
			public $visited_menu_ids = array();
			
			public function __construct($visitor_id, $username)
			{
				$this->visitor_id = $visitor_id;
				$this->username = $username;
				$this->load_pc_ids();
				$this->load_visited_menu_ids();
			}
			
			function load_pc_ids()
			{
				global $site_id;
				unset($this->pc_ids);
				$this->pc_ids = array();
				$visitor_pc_ids_q=mysql_query("select pc_id from visitor_pc_id where visitor_id in (select visitor_id from visitor_credentials where username='$this->username' and site_id='$site_id') ");
				while($visitor_pc_ids_r=mysql_fetch_assoc($visitor_pc_ids_q)){$this->pc_ids[]=$visitor_pc_ids_r[pc_id];}
			}
			
			function load_visited_menu_ids()
			{
				global $site_id;
				unset ($this->visited_menu_ids);
				$this->visited_menu_ids = array();
				if(count($this->pc_ids)>0)
				{
					$pc_ids=implode(",",$this->pc_ids);
					$visited_menu_ids_q=mysql_query("select menu_id from statistik_pc_id where pc_id in ($pc_ids) and site_id=$site_id order by id desc");
					while ($visited_menu_ids_r=mysql_fetch_assoc($visited_menu_ids_q)){$this->visited_menu_ids[$visited_menu_ids_r['menu_id']]=$visited_menu_ids_r['count'];}
				}
			}
		}
		$visitor=new visitor($visitor_id,$visitor_username);

		if($_COOKIE["my_pc_id"]!="")
		{//pc_id ist bekannt.
			$my_pc_id=$_COOKIE["my_pc_id"];
			$visitor_details_q=mysql_query("select visitor_pc_id.visitor_id, username from visitor_pc_id, visitor_credentials where visitor_pc_id.visitor_id=visitor_credentials.visitor_id and pc_id='$my_pc_id' and username='$visitor_username' and site_id=$site_id");
			if(mysql_num_rows($visitor_details_q)>0)
			{
			}
			else
			{//pc_id passt nicht zum user:es muss ein neuer visitor dem PC zugeordnet werden.
				$visitor_details_q=mysql_query("select pc_id from visitor_pc_id where pc_id='$my_pc_id'");
				if(mysql_num_rows($visitor_details_q)>0)
				{
					mysql_query("update visitor_pc_id set visitor_id='$visitor->visitor_id' where pc_id='$my_pc_id' limit 1");
				}
				else
				{ // den Fall gibt's nicht, weil ja jeder der ne PCID hat von der DB schon als Visitor angelegt wird. Nur die credentials Zuordnung erfoglt erst später...
				}
			}
			$visitor->load_pc_ids();
		}
		
		if($password_reset_hash!=""){mysql_query("update visitor_credentials set password_reset_hash=NULL where id=$visitor_credential_id and site_id=$site_id");}
		
		show_logoff_form($cookie_username);
	}
	else
	{
		echo "<b>Ihre Anmeldedaten sind ung&uuml;ltig.</b><br>";
		//remove_login_cookies();
		show_login_form($cookie_username);
	}
}
elseif($task=="")
{
	show_login_form($cookie_username);
}
?>
