<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:param name="horoskopID" />
<xsl:param name="zodiacID" />

<xsl:variable name="horoskop">
 <xsl:choose>
  <xsl:when test="string-length($horoskopID) &lt; 1">
   <xsl:value-of select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[@id = 'tageshoroskop']/name" />
  </xsl:when>
  <xsl:when test="count(document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[@id = $horoskopID]) &gt; 0">
   <xsl:value-of select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[@id = $horoskopID]/name" />
  </xsl:when>
  <xsl:otherwise>
   <xsl:value-of select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[@id = 'tageshoroskop']/name" />
  </xsl:otherwise>
 </xsl:choose>
</xsl:variable>

<xsl:variable name="horoskoptype">
 <xsl:choose>
  <xsl:when test="$horoskopID = 'chinesischesmonatshoroskop'">chinese</xsl:when>
  <xsl:otherwise>normal</xsl:otherwise>
 </xsl:choose>
</xsl:variable>

<xsl:variable name="zodiac">
 <xsl:choose>
  <xsl:when test="count(document('includes/tools/horoskop/includes/zodiacs.xml')/root/zodiacs/zodiac[@id = $zodiacID and @type = $horoskoptype]) &gt; 0">
   <xsl:value-of select="document('includes/tools/horoskop/includes/zodiacs.xml')/root/zodiacs/zodiac[@id = $zodiacID]/name"/>
  </xsl:when>
  <xsl:otherwise><xsl:value-of select="document('includes/tools/horoskop/includes/zodiacs.xml')/root/zodiacs/zodiac[@type = $horoskoptype]/name"/></xsl:otherwise>
 </xsl:choose>
</xsl:variable>

<xsl:template match="/">
<!--
<p>$horoskopID: '<xsl:value-of select="$horoskopID" />'; $horoskop: '<xsl:value-of select="$horoskop" />'</p>
<p>$zodiacID: '<xsl:value-of select="$zodiacID" />'; $zodiac: '<xsl:value-of select="$zodiac" />'</p>
<p>$horoskoptype: '<xsl:value-of select="$horoskoptype" />'</p>
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

</xsl:template>

<xsl:template name="zodiacoverwiev">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />
 <xsl:param name="baseurl" />
 
 <div style="background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 11px;padding-bottom:11px;margin-bottom:12px;margin-top:0px;">
  <xsl:choose>
   <xsl:when test="count(/root/horoscope/zodiacSign[name = $zodiac]) &gt; 0">
    <xsl:for-each select="/root/horoscope/zodiacSign">
     <xsl:if test="position() &lt; 13"> <!-- Omits faulty extra horoscope xml nodes in delivered xml -->
	  <a>
       <xsl:attribute name="href"><xsl:value-of select="$baseurl"/>/horoskope/horoskope/<xsl:value-of select="$horoskopID" />,<xsl:value-of select="document('includes/tools/horoskop/includes/zodiacs.xml')/root/zodiacs/zodiac[name = current()/name]/@id" /></xsl:attribute>
       <img>
	    <xsl:choose>
	     <xsl:when test="position() = 1">
	      <xsl:attribute name="style">margin-left:4px;cursor:pointer;width:39px;height:40px;border:0px</xsl:attribute>
	     </xsl:when>
		 <xsl:otherwise>
	      <xsl:attribute name="style">margin-left:5px;cursor:pointer;width:39px;height:40px;border:0px</xsl:attribute>
		 </xsl:otherwise>
	    </xsl:choose>
        <xsl:attribute name="alt"><xsl:value-of select="current()/name" /></xsl:attribute>
        <xsl:attribute name="title"><xsl:value-of select="current()/name" /></xsl:attribute>
        <xsl:choose>
         <xsl:when test="current()/name = 'Schütze'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Schuetze<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:when test="current()/name = 'Löwe'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Loewe<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:when test="current()/name = 'Büffel'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Bueffel<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:otherwise>
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/<xsl:value-of select="current()/name" /><xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:otherwise>
        </xsl:choose> 
       </img>
	  </a>
     </xsl:if>
    </xsl:for-each>
   </xsl:when>
   <xsl:when test="count(/root/typology/zodiacSign[name = $zodiac]) &gt; 0">
    <xsl:for-each select="/root/typology/zodiacSign">
     <xsl:if test="position() &lt; 13"> <!-- Omits faulty extra typology xml nodes in delivered xml -->
	  <a>
       <xsl:attribute name="href"><xsl:value-of select="$baseurl"/>/horoskope/horoskope/<xsl:value-of select="$horoskopID" />,<xsl:value-of select="document('includes/tools/horoskop/includes/zodiacs.xml')/root/zodiacs/zodiac[name = current()/name]/@id" /></xsl:attribute>
       <img style="margin-right:5px;cursor:pointer;width:39px;height:40px;border:0px">
        <xsl:attribute name="alt"><xsl:value-of select="current()/name" /></xsl:attribute>
        <xsl:attribute name="title"><xsl:value-of select="current()/name" /></xsl:attribute>
        <xsl:choose>
         <xsl:when test="current()/name = 'Schütze'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Schuetze<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:when test="current()/name = 'Löwe'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Loewe<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:when test="current()/name = 'Büffel'">
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/Bueffel<xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:when>
         <xsl:otherwise>
          <xsl:attribute name="src"><xsl:value-of select="$baseurl"/>/site_12_1/includes/tools/horoskop/img/zodiacs/<xsl:value-of select="current()/name" /><xsl:if test="current()/name = $zodiac">active</xsl:if>.gif</xsl:attribute>
         </xsl:otherwise>
        </xsl:choose> 
       </img>
	  </a>
     </xsl:if>
    </xsl:for-each>
   </xsl:when>
   <xsl:otherwise>
    <p style="margin-left:6px;margin-right:6px;">Das xml für '<xsl:value-of select="$horoskop" />' und '<xsl:value-of select="$zodiac"/>' ist leider falsch...</p>
   </xsl:otherwise>
  </xsl:choose>
 </div>	
</xsl:template>

<xsl:template name="horoscopecontents">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />
 <xsl:param name="baseurl" />

 <div style="background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 11px;padding-left:6px;padding-bottom:11px;padding-right:6px;margin-bottom:12px;">
  <h1 class="titel" style="margin-left:6px;margin-right:6px;"><xsl:value-of select="$zodiac"/> - <xsl:value-of select="$horoskop"/></h1>
  <xsl:choose>
   <xsl:when test="count(/root/horoscope/zodiacSign[name = $zodiac]) &gt; 0">
    <xsl:for-each select="/root/horoscope/zodiacSign[name = $zodiac]/section">
     <p class="einleitung" style="font-weight:bold;margin-left:6px;margin-right:6px;margin-top:16px;padding-bottom:6px;">
      <xsl:value-of select="current()/headline" />
     </p>
     <p class="artikeltext" style="margin-left:6px;margin-right:6px;">
      <xsl:value-of select="current()/content" />
     </p>
    </xsl:for-each>
   </xsl:when>
   <xsl:when test="count(/root/typology/zodiacSign[name = $zodiac]) &gt; 0">
    <xsl:for-each select="/root/typology/zodiacSign[name = $zodiac]/section">
     <p class="einleitung" style="font-weight:bold;margin-left:6px;margin-right:6px;margin-top:16px;padding-bottom:6px;">
      <xsl:value-of select="current()/headline" />
     </p>
     <p class="artikeltext" style="margin-left:6px;margin-right:6px;">
      <xsl:value-of select="current()/content" />
     </p>
    </xsl:for-each>
   </xsl:when>
   <xsl:otherwise>
    <p style="margin-left:6px;margin-right:6px;">Das xml für '<xsl:value-of select="$horoskop" />' und '<xsl:value-of select="$zodiac"/>' ist leider falsch...</p>
	</xsl:otherwise>
  </xsl:choose>
 </div>
</xsl:template>

<xsl:template name="horoscopeoverwiew">
 <xsl:param name="horoskop" />
 <xsl:param name="horoskopID" />
 <xsl:param name="zodiac" />
 <xsl:param name="zodiacID" />
 <xsl:param name="baseurl" />

 <div style="background-color:#ffffff;border:1px solid #C6E3FF;padding-top: 3px;padding-left:6px;padding-bottom:3px;padding-right:6px;margin-bottom:0px;">
  <table>
   <tr>
    <td>
     <div style="width:199px;margin-left:6px;">
      <xsl:for-each select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[position() &lt; (count(document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope) div 3)]">
       <a class="artikellink" style="cursor:pointer;">
        <xsl:attribute name="href"><xsl:value-of select="$baseurl"/>/horoskope/horoskope/<xsl:value-of select="@id"/>,<xsl:value-of select="$zodiacID" /></xsl:attribute>
        &#187;&#160;<xsl:value-of select="name"/>
       </a>
       <br/>
      </xsl:for-each>
     </div>
    </td>
	<td>
     <div style="width:199px;">
      <xsl:for-each select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[position() &gt; (count(document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope) div 3) and position() &lt; (count(document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope) div (3 div 2))]">
       <a class="artikellink" style="cursor:pointer;">
        <xsl:attribute name="href"><xsl:value-of select="$baseurl"/>/horoskope/horoskope/<xsl:value-of select="@id"/>,<xsl:value-of select="$zodiacID" /></xsl:attribute>
        &#187;&#160;<xsl:value-of select="name"/>
       </a>
       <br/>
      </xsl:for-each>
     </div>
	</td>
	<td>
     <div style="width:198px;">
      <xsl:for-each select="document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope[position() &gt; (count(document('includes/tools/horoskop/includes/horoscopes.xml')/root/horoscopes/horoscope) div (3 div 2))]">
       <a class="artikellink" style="cursor:pointer;">
        <xsl:attribute name="href"><xsl:value-of select="$baseurl"/>/horoskope/horoskope/<xsl:value-of select="@id"/>,<xsl:value-of select="$zodiacID" /></xsl:attribute>
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

</xsl:stylesheet>