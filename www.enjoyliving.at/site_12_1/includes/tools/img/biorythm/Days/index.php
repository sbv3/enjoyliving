<?php
session_start();
$adminpath="$DOCUMENT_ROOT";
require("$adminpath/well/config/configv.php");
require("$adminpath/well/traphic_counter.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="/well/styles/main.css" type="text/css">

<link rel="SHORTCUT ICON" href="/well/img/design/icon.ico">
<?php
$dbtable= "metatags";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable")or die("Could not connect with the table $dbtable...");
while ($show=mysql_fetch_object($result)) {
echo "$show->type_1$show->text$show->type_2";
}?>
</head>

<body bgcolor="#E3EBF6" text="#000000" leftmargin="5" topmargin="0" marginwidth="5" marginheight="0">
<table border=0 cellpadding=1 cellspacing=0 width="774" align="center">
  <tr> 
    <td bgcolor="#006384" valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#FAFAEB"> 
          <td height="18" colspan="3" bgcolor="#FAFAEB">
            <table width="772" cellspacing="0" cellpadding="0" bgcolor="#B6BDF1" align="center">
              <tr valign="bottom"> 
                <td colspan="5"><img src="/well/img/design/logo.jpg" width="772" height="120"></td>
              </tr>
              <tr> 
                <td width="150" colspan="2" bgcolor="#B6BDF1"> <font color="#FFFFFF"> 
                  <?$datum = date("d.m.Y, H:i");
			 	echo "&nbsp;$datum"; ?>
                  </font> </td>
                <td width="5" bgcolor="#FFFFFF" background="/well/img/design/weilx.gif">&nbsp;</td>
                <td width="617" height="25" valign="top" colspan="2" bgcolor="#B6BDF1"> 
                  <?
$dbtable= "topmenue";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE aktiv='1' order by id ")or die("Kann keine Datenbankverbindung herstellen!");
echo "<table width='617' cellspacing='0' cellpadding='0' height='25'><tr valign='middle'><td width='112'></td>";
while ($show=mysql_fetch_object($result))
{
if($show->titel == "HOME")
{
$bg="/well/img/design/button_o.gif";
$f="#006394";
}
else
{
$bg="/well/img/design/button_m.gif";
$f="#FFFFFF";
}
echo "<td width='101' background='$bg' valign='middle'><div align='center'><a href='$show->link' class='variante1'><font color='$f'>$show->titel</font></a></div></font></td>";
	
}	
echo "</td></table>";
	?>
                </td>
              </tr>
              <tr valign="top" bgcolor="#006394"> 
                <td colspan="5"> 
                  <table cellspacing=0 cellpadding=0 width="100%" border=0>
                    <tbody> 
                    <tr> 
                      <td 
          height=1></td>
                    </tr>
                    </tbody> 
                  </table>
                </td>
              </tr>
              <tr> 
                <td width="3" bgcolor="#E3EBF6">&nbsp; </td>
                <td width="146" bgcolor="#E3EBF6" valign="top"> 
                  <table width="145" cellspacing="0" cellpadding="0" align="center">
                    <tr valign="top"> 
                      <td colspan="2"> 
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=5></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2"> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="22" width="6"><img src="/well/img/design/border_left1.gif" width="6" height="22"></td>
                            <td height="22" width="138" background="/well/img/design/border_mitte.gif"><b><font color="#010347">Start 
                              Living Men&uuml;</font></b></td>
                            <td height="22" width="6"><img src="/well/img/design/border_right1.gif" width="6" height="22"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2"> 
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=5></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <?
$dbtable1= "leftmenue";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result1 = mysql_query("SELECT * FROM $dbtable1 order by listing")or die("Kann keine Datenbankverbindung herstellen!");
while ($show1=mysql_fetch_object($result1))
{							 
								 ?>
                    <tr> 
                      <td valign="middle" width="15" height="19" bgcolor="#B6BDF1"> 
                        <div align="right"><img src="/well/img/design/butt.gif" width="10" height="5"></div>
                      </td>
                      <td valign="middle" height="19" width="130" bgcolor="#B6BDF1"><b><a href="<?echo "$show1->link";?>" class="variante">&nbsp; 
                        <?echo "$show1->titel";?>
                        </a> </b></td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2"> 
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=2></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <?
if ($show1->cat=="home")
{
$dbtable= "menue";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE cat='home' order by id")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{							 
								 ?>
                    <tr> 
                      <td colspan="2"> </td>
                    </tr>
                    <tr> 
                      <td valign="middle" width="15" height="10">&nbsp;</td>
                      <td valign="middle" height="13" width="130">&raquo; 
                        <?
									echo "<a href='/well/$show->link'>$show->subheadl</a>";
									?>
                      </td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2"> 
                        <?}?>
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=5></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <?
								 }
								 
								
								 ?>
                    <?
								 }
								 ?>
                    <tr> 
                      <td colspan="2"> </td>
                    </tr>
                    <tr> 
                      <td valign="middle" colspan="2">&nbsp;</td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2"> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="22" width="6"><img src="/well/img/design/border_left1.gif" width="6" height="22"></td>
                            <td height="22" width="138" background="/well/img/design/border_mitte.gif"><b><font color="#010347">kostenlose 
                              News </font></b></td>
                            <td height="22" width="6"><img src="/well/img/design/border_right1.gif" width="6" height="22"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2"> 
                        <div align="left"> 
                          <table width="99%" cellspacing="0" cellpadding="0" align="center">
                            <form name="form1" method="post" action="/well/newsletter.php">
                              <tr> 
                                <td colspan="2"> 
                                  <div align="justify">Tragen Sie sich in unseren 
                                    Newsletter ein!</div>
                                </td>
                              </tr>
                              <tr> 
                                <td colspan="2" height="18">Email-Adresse:</td>
                              </tr>
                              <tr> 
                                <td width="*"> 
                                  <input type="text" name="newsletter" style="font-family: Verdana; font-size: 8pt;" size="15">
                                </td>
                                <td width="35"> 
                                  <input type="image" src="/well/img/design/b1.gif" alt="Go" name="Submit2">
                                </td>
                              </tr>
                            </form>
                          </table>
                        </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2"> <br>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="22" width="6"><img src="/well/img/design/border_left1.gif" width="6" height="22"></td>
                            <td height="22" width="138" background="/well/img/design/border_mitte.gif"><b><font color="#010347">Werbung</font></b></td>
                            <td height="22" width="6"><img src="/well/img/design/border_right1.gif" width="6" height="22"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2"> 
                        <table width="100%" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td> 
                              <?
$dbtable= "ads";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='startseite' and aktiv='ja' order by id")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td> 
                              <div align="center"> 
                                <?echo "$show->url";?>
                              </div>
                            </td>
                          </tr>
                          <tr> 
                            <td height="8">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td> 
                              <?}?>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2">&nbsp;</td>
                    </tr>
                  </table>
                </td>
                <td width="5" bgcolor="#FFFFFF" background="/well/img/design/weilkv1.gif">&nbsp;</td>
                <td width="7" height="80" bgcolor="#FFFFFF" valign="top">&nbsp; </td>
                <td width="610" height="80" bgcolor="#FFFFFF" valign="top"> 
                  <table cellspacing=0 cellpadding=0 width="100%" border=0>
                    <tbody> 
                    <tr> 
                      <td 
          height=5></td>
                    </tr>
                    </tbody> 
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td colspan="3" height="20"><b>Willkommen bei StartLiving.at 
                        - der Wellnessplattform im Web !</b></td>
                    </tr>
                    <tr> 
                      <td colspan="3" bgcolor="#006394"> 
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=1></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="3"> 
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody> 
                          <tr> 
                            <td 
          height=5></td>
                          </tr>
                          </tbody> 
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td width="450" valign="top"> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr bgcolor="#E3EBF6"> 
                            <td height="18" colspan="3"><b>&nbsp;StartLiving Monatsspecial: 
                              <?
$dbtable= "codetemplate";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='special' and aktiv='1'")or die("Could not connect with the table $dbtable...");
while ($show=mysql_fetch_object($result)) {
echo "$show->titel";
			 }?>
                              </b> 
                              <?
/*
@param text, string
@param zeichen, integer, Stringlength
@param kolanz, integer, optional, Kolanzwert für Länge
@param punkte, integer, optional, Anzahl angehangener Punkte
*/
function word_substr($text, $zeichen, $kolanz=3, $punkte=0) {
    $wort = explode(" ",$text);
    $newstr = "";
    $i = 0;
    while(strlen($newstr)<=$zeichen &&
          strlen($newstr.$wort[$i])<=($zeichen+$kolanz)) {
        $newstr .= $wort[$i]." ";
        $i++;
    }
    $newstr .= str_repeat(".",$punkte);
    return $newstr;
}
?>
                            </td>
                          </tr>
                          <tr> 
                            <td bgcolor="#006384" valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=3></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='special' and aktiv='1' order by datum desc limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <? echo "<img src='/well/img/design/top.gif'> <b>$show->titel</b>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" height="19" colspan="3"> 
                              <?if (empty($show->img_s))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='left'>
                    <tr> 
                      <td><img src='$show->img_s'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                    </table>";
				}?>
                              <?if ($show->extra=="3")
							  {
							  $text="$show->text";
							  }
							  else
							  {
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  }
				  if ($show->extra=="1")
				  {
				  echo "$text <br><div align='justify'><a href='/well/artikel.php?id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="2")
				  {
				  echo "$text <br><div align='justify'><a href='$show->ext'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="3")
				  {
				  echo "$text <br>";
				  }
				  else
				  {
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  ?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?}?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1 bgcolor="#E3EBF6"></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='special' and aktiv='1' order by datum desc limit 1,1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <? echo "<img src='/well/img/design/top.gif'> <b>$show->titel</b>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" height="19" colspan="3"> 
                              <?if (empty($show->img_s))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='right'>
                    <tr> 
                      <td><img src='$show->img_s'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                                      </table>";
				}?>
                              <?if ($show->extra=="3")
							  {
							  $text="$show->text";
							  }
							  else
							  {
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  }
				  if ($show->extra=="1")
				  {
				  echo "$text <br><div align='justify'><a href='/well/artikel.php?id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="2")
				  {
				  echo "$text <br><div align='justify'><a href='$show->ext'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="3")
				  {
				  echo "$text <br>";
				  }
				  else
				  {
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  ?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?}?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1 bgcolor="#E3EBF6"></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='special' and aktiv='1' order by datum desc limit 2,1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <? echo "<img src='/well/img/design/top.gif'> <b>$show->titel</b>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" height="19" colspan="3"> 
                              <?if (empty($show->img_s))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='left'>
                    <tr> 
                      <td><img src='$show->img_s'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                    </table>";
				}?>
                              <?if ($show->extra=="3")
							  {
							  $text="$show->text";
							  }
							  else
							  {
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  }
				  if ($show->extra=="1")
				  {
				  echo "$text <br><div align='justify'><a href='/well/artikel.php?id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="2")
				  {
				  echo "$text <br><div align='justify'><a href='$show->ext'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="3")
				  {
				  echo "$text <br>";
				  }
				  else
				  {
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  ?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?}?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr bgcolor="#E3EBF6"> 
                            <td height="18" colspan="3"><b>&nbsp;Aktuelles </b> 
                            </td>
                          </tr>
                          <tr> 
                            <td bgcolor="#006384" valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr valign="top"> 
                            <td colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <table width="100%" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="49%" valign="top"> 
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td> 
                                          <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='1' and aktiv='1' order by datum desc limit 4")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                                          <? echo "<img src='/well/img/design/top.gif'> <b>$show->titel</b>";?>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <?if (empty($show->img_ss))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='left'>
                    <tr> 
                      <td><img src='$show->img_ss'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                                      </table>";
				}?>
                                          <?if ($show->extra=="3")
							  {
							  $text="$show->text";
							  }
							  else
							  {
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  }
				  if ($show->extra=="1")
				  {
				  echo "$text <br><div align='justify'><a href='/well/artikel.php?id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="2")
				  {
				  echo "$text <br><div align='justify'><a href='$show->ext'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  elseif ($show->extra=="3")
				  {
				  echo "$text <br>";
				  }
				  else
				  {
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  ?>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=5></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td valign="top"> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=1 bgcolor="#E3EBF6"></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td height="4"> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=5></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <?}?>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td width="2%" background="/well/img/design/trenner1.gif">&nbsp;</td>
                                  <td width="49%" valign="top"> 
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td> 
                                          <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='1a' and aktiv='1' order by datum desc limit 4")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                                          <? echo "<img src='/well/img/design/top.gif'> <b>$show->titel</b>";?>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <?if (empty($show->img_ss))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='right'>
                    <tr> 
                      <td><img src='$show->img_ss'></td>
                                         </tr>
                                      </table>";
				}?>
                                          <?if ($show->extra=="3")
							  {
							  $text="$show->text";
							  }
							  else
							  {
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  }
				  if ($show->extra=="1")
				  {
				  echo "$text <br><a href='/well/artikel.php?id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a>";
				  }
				  elseif ($show->extra=="2")
				  {
				  echo "$text <br><a href='$show->ext'><img src='/well/img/design/go_w.gif' border='0'> weiter</a>";
				  }
				  elseif ($show->extra=="3")
				  {
				  echo "$text <br>";
				  }
				  else
				  {
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";
				  }
				  ?>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=5></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=1 bgcolor="#E3EBF6"></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                            <tbody> 
                                            <tr> 
                                              <td 
          height=5></td>
                                            </tr>
                                            </tbody> 
                                          </table>
                                        </td>
                                      </tr>
                                      <tr> 
                                        <td> 
                                          <?}?>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr valign="top"> 
                            <td colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr bgcolor="#E3EBF6"> 
                            <td height="18" colspan="3"><b>Das Aroma&ouml;l des 
                              Monats</b></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#006384" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='2' and aktiv='1' order by datum desc limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <? echo "<b><img src='/well/img/design/top.gif'> $show->titel</b>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?if (empty($show->img_s))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='left'>
                    <tr> 
                      <td><img src='$show->img_s'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan='2'>&nbsp;</td>
                    </tr>
                  </table>";
				}?>
                              <?
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?}?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr bgcolor="#E3EBF6"> 
                            <td height="18" colspan="3"><b>Der Stein des Monats</b></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#006384" valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?
$dbtable= "cms";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE hauptsite='3' and aktiv='1' order by datum desc limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <? echo "<b><img src='/well/img/design/top.gif'> $show->titel</b>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=8></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?if (empty($show->img_s))
				{
				}
				else
				{
				echo "<table width='*' border='0' cellspacing='0' cellpadding='0' align='right'>
                    <tr> 
                      <td><img src='$show->img_s'></td>
                      <td width='8'>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan='2'>&nbsp;</td>
                    </tr>
                  </table>";
				}?>
                              <?
				  $text=word_substr($show->text,250,20)."...";
				  #$text=wordwrap($show->text, 250, "\0") . ' ...';
				  echo "$text <br><div align='justify'><a href='/well/magazin_d.php?channel=$show->channel&id=$show->id'><img src='/well/img/design/go_w.gif' border='0'> weiter</a></div>";?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"> 
                              <?}?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr bgcolor="#E3EBF6"> 
                            <td height="18" colspan="3"><b>Das Monats-Voting</b></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#006384" valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=1></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td valign="top" colspan="3"> 
                              <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                <tbody> 
                                <tr> 
                                  <td 
          height=5></td>
                                </tr>
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="3"><iframe src='/well/voting.php' width='445' height='350' frameborder=0 scrolling=auto></iframe></td>
                          </tr>
                          <tr> 
                            <td colspan="3">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                      <td width="10">&nbsp;</td>
                      <td width="150" valign="top"> 
                        <?
$dbtable= "forum";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable order by datum desc limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                        <table border=0 cellpadding=1 cellspacing=0 width="148">
                          <tr> 
                            <td bgcolor="#B6BDF1" valign="top"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr bgcolor="#E3EBF6"> 
                                  <td height="18" colspan="3"> 
                                    <div align="center"><b><font color="#FF0000"> 
                                      <font color="#010347"> letzter Forenbeitrag</font></font></b></div>
                                  </td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF" valign="top" colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
 height=1 bgcolor="#B6BDF1"></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center"><b> 
                                      <?echo "$show->topic";?>
                                      </b></div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
          height=5></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp; </td>
                                  <td valign="top" width="138"> 
                                    <div align="center"> 
                                      <?
									  $text1=word_substr($show->text,100,50)."...";
									  echo "$text1";
									  ?>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                                <tr bgcolor="#F4F7FC" valign="middle"> 
                                  <td colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
          height=5></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center"><i> 
                                      <?
$datum_s = substr($show->datum, 6, 2).".".
 substr($show->datum, 4, 2).".".
		 	 substr($show->datum, 0, 4);
			 echo "$datum_s, "; 
			 $datum_s2 = substr($show->datum, 8, 2).":".
 substr($show->datum, 10, 2);
		 	 echo "$datum_s2<br>$show->autor"; 
									  ?>
                                      </i></div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center">
									<?
									if ($show->ref=="")
									{
									$id1="$show->id";
									}
									else
									{
									$dbtableaa= "forum";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$resultaa = mysql_query("SELECT * FROM $dbtableaa WHERE id='$show->ref'")or die("Kann keine Datenbankverbindung herstellen!");
while ($showaa=mysql_fetch_object($resultaa))
{
$id1="$showaa->id";
}
									
									}
									?>
									<a href='/well/forum/forum_topic.php?f=<?echo "$show->forum_channel&id=$id1";?>'><img src='/well/img/design/go_w2.gif' border='0' width="10" height="15"> 
                                      weiter</a></div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <br>
                        <?}?>
                        <?
$dbtable= "codetemplate";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='main' and subcode='rechts' and aktiv='1' limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                        <table border=0 cellpadding=1 cellspacing=0 width="148">
                          <tr> 
                            <td bgcolor="#B6BDF1" valign="top"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr bgcolor="#E3EBF6"> 
                                  <td height="18" colspan="3"> 
                                    <div align="center"><b><font color="#FF0000"> 
                                      <font color="#010347">
                                      <?echo "$show->titel";?>
                                      </font></font></b></div>
                                  </td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF" valign="top" colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
 height=1 bgcolor="#B6BDF1"></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <?if (empty($show->img)){} else{?>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp; </td>
                                  <td valign="top" width="138"> 
                                    <div align="center"> 
                                      <?echo "<img src='$show->img'>";?>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                                <?}?>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center"> 
                                      <?echo "<a href='$show->url'>$show->text</a>";?>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <br>
                        <?}?>
                        <?
$dbtable= "codetemplate";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='main2' and subcode='rechts' and aktiv='1'")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
?>
                        <table border=0 cellpadding=1 cellspacing=0 width="148">
                          <tr> 
                            <td bgcolor="#B6BDF1" valign="top"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr bgcolor="#E3EBF6"> 
                                  <td height="18" colspan="3"> 
                                    <div align="center"><b><font color="#FF0000"> 
                                      <font color="#010347"> 
                                      <?echo "$show->titel";?>
                                      </font></font></b></div>
                                  </td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF" valign="top" colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
 height=1 bgcolor="#B6BDF1"></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <?if (empty($show->img)){} else{?>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp; </td>
                                  <td valign="top" width="138"> 
                                    <div align="center"> 
                                      <?echo "<img src='$show->img'>";?>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                                <?}?>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center"> 
                                      <?echo "<a href='$show->url'>$show->text</a>";?>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <br>
                        <?}?>
                        <?
$dbtable= "ads";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='own' and aktiv='1' order by rand() limit 1")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
echo "$show->url";
}?>
                        <br>
                       
                        <table border=0 cellpadding=1 cellspacing=0 width="148">
                          <tr> 
                            <td bgcolor="#B6BDF1" valign="top"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr bgcolor="#E3EBF6"> 
                                  <td height="18" colspan="3"> 
                                    <div align="center"><b><font color="#FF0000"> 
                                      <font color="#010347"> Veranstaltungstipps</font></font></b></div>
                                  </td>
                                </tr>
                                <tr> 
                                  <td bgcolor="#FFFFFF" valign="top" colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                      <tbody> 
                                      <tr> 
                                        <td 
 height=1 bgcolor="#B6BDF1"></td>
                                      </tr>
                                      </tbody> 
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="#F4F7FC" valign="middle"> 
                                  <td colspan="3"> 
                                    <table cellspacing=0 cellpadding=0 width="100%" border=0>
                                        <tbody> 
                                        <tr> 
                                          <td 
          height=5></td>
                                        </tr>
                                        </tbody> 
                                      </table>
                                    
                                  </td>
                                </tr>
                                <tr bgcolor="#F4F7FC"> 
                                  <td valign="top" width="5">&nbsp;</td>
                                  <td valign="top" width="138"> 
                                    <div align="center">
                                      <?
$datum_ab2 =date("Y-m-d");
$dbtable= "events1";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result1 = mysql_query("SELECT * FROM $dbtable WHERE datum='$datum_ab2' and aktiv='1' group by ort")or die("Kann keine Datenbankverbindung herstellen!");
while ($show1=mysql_fetch_object($result1))

{echo "<b>$show1->ort</b><br>";
$result = mysql_query("SELECT * FROM $dbtable WHERE datum='$datum_ab2' and ort='$show1->ort' and aktiv='1'")or die("Kann keine Datenbankverbindung herstellen!");
while ($show=mysql_fetch_object($result))
{
echo "<a href='/well/event_list.php'>$show->titel<br><i>$show->v_ort</i></a><br><br>";
}}?>
                                      <br>
                                    </div>
                                  </td>
                                  <td valign="top" width="5">&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <br>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td width="3" bgcolor="#E3EBF6">&nbsp;</td>
                <td width="146" bgcolor="#E3EBF6" valign="top"><a href="#top"><b>&raquo; 
                  </b> nach oben</a></td>
                <td width="5" bgcolor="#FFFFFF" background="/well/img/design/weilkv1.gif">&nbsp;</td>
                <td width="7" bgcolor="#FFFFFF" valign="top">&nbsp;</td>
                <td width="610" bgcolor="#FFFFFF" valign="top"> 
                  <div align="center"> 
                    <?
$dbtable= "codetemplate";
mysql_connect("$dbhost","$dbuser","$dbpassword") or die ("Could not connect to the server...");
mysql_select_db("$dbdatabase");
$result = mysql_query("SELECT * FROM $dbtable WHERE code='footer'")or die("Could not connect with the table $dbtable...");
echo "&#149; ";
while ($show=mysql_fetch_object($result)) {
echo "<a href='$show->url'>$show->titel</a> &#149; ";
			 }?>
                  </div>
                </td>
              </tr>
              <tr> 
                <td width="3" bgcolor="#E3EBF6">&nbsp;</td>
                <td width="146" bgcolor="#E3EBF6" valign="top">&nbsp;</td>
                <td width="5" bgcolor="#FFFFFF" background="/well/img/design/weilkv1.gif">&nbsp;</td>
                <td width="7" bgcolor="#FFFFFF" valign="top">&nbsp;</td>
                <td width="610" bgcolor="#FFFFFF" valign="top">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <?if (empty($show->img)){} else{?>
        <?}?>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
