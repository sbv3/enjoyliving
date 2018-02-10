<?php
/**
* Beispiel fuer public, private und protected
*
*/
class TestClass
{
	public $strPub = "Ich bin public";
	protected $strProt = "Ich bin protected";
	private $strPriv = "Ich bin private";
	function showVars()
	{		
	echo "Das sieht die Klasse TestClass:<br>";
		echo "\$strPub: $this->strPub<br>";
		echo "\$strProt: $this->strProt<br>";
		echo "\$strPriv: $this->strPriv<br>";
		echo "<br>";
	}
}

class ExtClass extends TestClass
{
	function showVars()
	{
		parent::showVars();
		echo "Das sieht die Klasse ExtClass:<br>";
		echo "\$strPub: $this->strPub<br>";
		echo "\$strProt: $this->strProt<br>";
		// Die folgende Zeile zeigt nichts an
		echo "\$strPriv: $this->strPriv<br>";
		echo "<br>";
	}
}

$objTest = new TestClass();
$objExt = new ExtClass();
// Die Variablen innerhalb der Klasse ExtClass anzeigen
$objExt->showVars();
// Variablen ansehen

echo "Das sieht das Hauptprogramm:<br>";
echo "\$objTest->strPub: $objTest->strPub<br>";
//echo "\$objTest->strProt: $objTest->strProt<br>";
//echo "\$objTest->strPriv: $objTest->strPriv<br>";
echo "<br>";
// Aenderungsversuche
// Eine public-Variable aendern
$objTest->strPub =
"Ich bin public, vom Hauptprogramm geändert!";
// Eine protected-Variable aendern --> FEHLER
// $objTest->strProt =
// "Ich bin protected. Das Hauptprogramm kann mich nicht
// ändern";
// Eine prvate Variable aendern --> FEHLER
// $objTest->strPriv =
// "Ich bin private. Das Hauptprogramm kann mich
// nicht ändern";
$objTest->showVars();
?>