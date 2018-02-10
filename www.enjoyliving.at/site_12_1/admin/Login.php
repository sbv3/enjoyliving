<? session_start();?>
<? //if($kill_session==1){$kill_session=0;
	unset($_SESSION['user']);unset($_SESSION['password']);unset($_SESSION['site_id']);unset($_SESSION['autoupdate']);unset($_SESSION['loggedIn']);
	//}?>
<div style="background-color: transparent; text-align: center;position: absolute;top: 50%;left: 0px;width: 100%;height: 1px;overflow: visible;visibility: visible;display: block;">
	<div style="background-color: transparent;height: 150px;top: -75px;width: 250px;margin-left: -125px;position: absolute;left: 50%; visibility: visible;">
		<div>
			<form action="papa/menu.php" method="post" enctype="application/x-www-form-urlencoded">
				<table width="250">
					<tr>
						<td colspan="2" align="center">
							
						</td>
					</tr>
					<? if($wrong_longin==1){?>
					<tr>
						<td colspan="2" align="center">
							<a style="color:#F00; font-size:18px"> "Login hat fehlgeschlagen"</a>
						</td>
					</tr>
					<? }?>
					<? if($wrong_longin==2){?>
					<tr>
						<td colspan="2" align="center">
							<a style="color:#F00; font-size:18px"> "Sie haben keine Berechtigung zur Administration"</a>
						</td>
					</tr>
					<? }?>
					<tr>
						<td width="125" align="right">
							Benutzer: 
						</td>
						<td width="125">
							<input type="text" name="user" width="125">
						</td>
					</tr>
					<tr>
						<td width="125" align="right">
							Passwort: 
						</td>
						<td width="125">
							<input type="password" name="password" width="125">
						</td>
					</tr>
				</table>
				<input type="submit" name="submit" value="einloggen">
			</form>
		</div>	
	</div>
</div>	