<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
$user_email=$_POST[user_email];
$googleurl=$_POST[googleurl];

if($user_email!=""){validate_username($user_email,$googleurl);}

function validate_username($user_email,$googleurl)
{
	global $site_title,$managing_editor;
	$user_email_sql=GetSQLValueString($user_email, "text");
	$user_email_exist_q=mysql_query("select * from visitor_credentials where user_email=$user_email_sql limit 1");
	if(mysql_num_rows($user_email_exist_q)>0)
	{
		$date = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+14, date("Y"));
		$password_reset_string=$user_email."|".$date;

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$password_reset_hash = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "This is a very secret key", $password_reset_string, MCRYPT_MODE_ECB, $iv));

		$user_email_update_q=mysql_query("update visitor_credentials set password_reset_hash='$password_reset_hash' where user_email=$user_email_sql limit 1");
		
		$password_reset_hash_url=rawurlencode($password_reset_hash);	

		$user_email_exist_r=mysql_fetch_assoc($user_email_exist_q);
		$username=$user_email_exist_r['username'];
		$header = "MIME-Version: 1.0\r\n";
		$header .= "Return-Path: $managing_editor\n";
		$header .= "X-Sender: $managing_editor\n";
		$header .= "From: $site_title <$managing_editor>\n";
		$header .= "Bcc: $managing_editor\n";
		$header .= "X-Mailer:PHP 5.1\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$text = "<br>
		Liebe(r) $username !<br><br>
		Wenn Sie auf folgenden link clicken wird Ihr Passwort zur&uuml;ckgesetzt:
		<br><a href='$googleurl?task=pwd_reset&reset_string=$password_reset_hash_url'>$googleurl?task=pwd_reset&reset_string=$password_reset_hash_url</a><br><br>
		Mit lieben Gr&uuml;&szlig;en,<br><br>Ihr $site_title Team";
		$betreff="$site_title - Passwort zurücksetzen";

		if(mail("$user_email", "$betreff", "$text", $header)){echo "Wir haben Ihnen ein email mit einem link geschickt, mit dem Sie Ihr Passwort zur&uuml;cksetzen k&ouml;nnen.";}
	}
	else
	{
		echo "Kein Benutzer mit dieser e-Mail bekannt.";
	}
}
?>