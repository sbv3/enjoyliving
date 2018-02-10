<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:param name="horoskopID" />
<xsl:param name="zodiacID" />

<xsl:variable name="zodiac">
 <xsl:choose>
  <xsl:when test="string-length($zodiacID) &lt; 1">Widder</xsl:when>
  <xsl:when test="$zodiacID = 'widder'">Widder</xsl:when>
  <xsl:when test="$zodiacID = 'stier'">Stier</xsl:when>
  <xsl:when test="$zodiacID = 'zwillinge'">Zwillinge</xsl:when>
  <xsl:when test="$zodiacID = 'krebs'">Krebs</xsl:when>
  <xsl:when test="$zodiacID = 'loewe'">Löwe</xsl:when>
  <xsl:when test="$zodiacID = 'jungfrau'">Jungfrau</xsl:when>
  <xsl:when test="$zodiacID = 'waage'">Waage</xsl:when>
  <xsl:when test="$zodiacID = 'skorpion'">Skorpion</xsl:when>
  <xsl:when test="$zodiacID = 'schuetze'">Schütze</xsl:when>
  <xsl:when test="$zodiacID = 'steinbock'">Steinbock</xsl:when>
  <xsl:when test="$zodiacID = 'wassermann'">Wassermann</xsl:when>
  <xsl:when test="$zodiacID = 'fische'">Fische</xsl:when>
  <xsl:otherwise>Widder</xsl:otherwise>
 </xsl:choose>
</xsl:variable>

<xsl:variable name="horoskop">
 <xsl:choose>
  <xsl:when test="string-length($horoskopID) &lt; 1">
   <xsl:value-of select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[@id = 'tageshoroskop']/name" />
  </xsl:when>
  <xsl:when test="count(document('includes/horoscopes.xml')/root/horoscopes/horoscope[@id = $horoskopID]) &gt; 0">
   <xsl:value-of select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[@id = $horoskopID]/name" />
  </xsl:when>
  <xsl:otherwise>
   <xsl:value-of select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[@id = 'tageshoroskop']/name" />
  </xsl:otherwise>
 </xsl:choose>
</xsl:variable>

<xsl:template match="/">
<!--
<p>$horoskopID: <xsl:value-of select="$horoskopID" />; $horoskop: <xsl:value-of select="$horoskop" /></p>
<p>$zodiacID: <xsl:value-of select="$zodiacID" />; $zodiac: <xsl:value-of select="$zodiac" /></p>
-->

<xsl:call-template name="zodiacoverwiev">
 <xsl:with-param name="horoskop" select="$horoskop"/>
 <xsl:with-param name="horoskopID" select="$horoskopID"/>
 <xsl:with-param name="zodiac" select="$zodiac"/>
 <xsl:with-param name="zodiacID" select="$zodiacID"/>
</xsl:call-template>

<xsl:call-template name="horoscopecontents">
 <xsl:with-param name="horoskop" select="$horoskop"/>
 <xsl:with-param name="horoskopID" select="$horoskopID"/>
 <xsl:with-param name="zodiac" select="$zodiac"/>
 <xsl:with-param name="zodiacID" select="$zodiacID"/>
</xsl:call-template>

<xsl:call-template name="horoscopeoverwiew">
 <xsl:with-param name="horoskop" select="$horoskop"/>
 <xsl:with-param name="horoskopID" select="$horoskopID"/>
 <xsl:with-param name="zodiac" select="$zodiac"/>
 <xsl:with-param name="zodiacID" select="$zodiacID"/>
</xsl:call-template>

<xsl:call-template name="horoskopform">
</xsl:call-template>

</xsl:template>

<xsl:template name="zodiacoverwiev">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />
 
 <div style="width:628px;background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 11px;padding-left:6px;padding-bottom:11px;padding-right:6px;margin-right:14px">
  <xsl:for-each select="/root/horoscope/zodiacSign">
   <xsl:if test="position() &lt; 13"> <!-- Omits faulty extra horoscope xml nodes in delivered xml -->
    <img style="margin-right:6px;cursor:pointer;width:46px;height:47px;">
     <xsl:attribute name="alt"><xsl:value-of select="current()/name" /></xsl:attribute>
     <xsl:attribute name="title"><xsl:value-of select="current()/name" /></xsl:attribute>
     <xsl:attribute name="onclick">javascript:reloadHoroscope('<xsl:value-of select="$horoskopID" />','<xsl:value-of select="document('includes/zodiacs.xml')/root/zodiacs/zodiac[name = current()/name]/@id" />');</xsl:attribute>
     <xsl:choose>
      <xsl:when test="current()/name = 'Schütze'">
       <xsl:attribute name="src">/page/site/horoskop/img/zodiacs/Schuetze.gif</xsl:attribute>
      </xsl:when>
      <xsl:when test="current()/name = 'Löwe'">
       <xsl:attribute name="src">/page/site/horoskop/img/zodiacs/Loewe.gif</xsl:attribute>
      </xsl:when>
      <xsl:otherwise>
       <xsl:attribute name="src">/page/site/horoskop/img/zodiacs/<xsl:value-of select="current()/name" />.gif</xsl:attribute>
      </xsl:otherwise>
     </xsl:choose> 
    </img>
   </xsl:if>
  </xsl:for-each>
 </div>	
</xsl:template>

<xsl:template name="horoscopecontents">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />

 <div style="width:628px;background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 11px;padding-left:6px;padding-bottom:11px;padding-right:6px;margin-right:14px">
  <h1><xsl:value-of select="$zodiac"/> - <xsl:value-of select="$horoskop"/></h1>
  <xsl:choose>
   <xsl:when test="count()"
  </xsl:choose>
  <xsl:for-each select="/root/horoscope/zodiacSign[name = $zodiac]/section">
   <p style="font-weight:bold">
    <xsl:value-of select="current()/headline" />
   </p>
   <p>
    <xsl:value-of select="current()/content" />
   </p>
  </xsl:for-each>
 </div>
</xsl:template>

<xsl:template name="horoscopeoverwiew">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />

 <div style="width:628px;background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 11px;padding-left:6px;padding-bottom:11px;padding-right:6px;margin-right:14px">
  <table>
   <tr>
    <td>
     <div style="width:209px;">
      <xsl:for-each select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[position() &lt; (count(document('includes/horoscopes.xml')/root/horoscopes/horoscope) div 3)]">
       <a style="cursor:pointer;">
        <xsl:attribute name="onclick">reloadHoroscope('<xsl:value-of select="@id"/>','<xsl:value-of select="$zodiacID" />');</xsl:attribute>
        &#187;&#160;<xsl:value-of select="name"/>
       </a>
       <br/>
      </xsl:for-each>
     </div>
    </td>
	<td>
     <div style="width:209px;">
      <xsl:for-each select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[position() &gt; (count(document('includes/horoscopes.xml')/root/horoscopes/horoscope) div 3) and position() &lt; (count(document('includes/horoscopes.xml')/root/horoscopes/horoscope) div (3 div 2))]">
       <a style="cursor:pointer;">
        <xsl:attribute name="onclick">javascript:reloadHoroscope('<xsl:value-of select="@id"/>','<xsl:value-of select="$zodiacID" />');</xsl:attribute>
        &#187;&#160;<xsl:value-of select="name"/>
       </a>
       <br/>
      </xsl:for-each>
     </div>
	</td>
	<td>
     <div style="width:209px;">
      <xsl:for-each select="document('includes/horoscopes.xml')/root/horoscopes/horoscope[position() &gt; (count(document('includes/horoscopes.xml')/root/horoscopes/horoscope) div (3 div 2))]">
       <a style="cursor:pointer;">
        <xsl:attribute name="onclick">javascript:reloadHoroscope('<xsl:value-of select="@id"/>','<xsl:value-of select="$zodiacID" />');</xsl:attribute>
        &#187;&#160;<xsl:value-of select="name"/>
       </a>
       <br/>
      </xsl:for-each>
     </div>
	</td>
   </tr>
  </table> 
 </div>
</xsl:template>

<xsl:template name="horoskopform">´
 <script>
  <![CDATA[
function reloadHoroscope(horoskopID,zodiacID)
{
document.getElementById("horoscopeform").action = "http://enjoyliving.at/horoskope/horoskope/" + horoskopID + "," + zodiacID;
document.getElementById("horoscopeform").submit();
}
]]>
 </script>
 <form id="horoscopeform" method="post" action="http://enjoyliving.at/horoskope/horoskope">
 </form>
</xsl:template>

</xsl:stylesheet>