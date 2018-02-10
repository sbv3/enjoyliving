<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output omit-xml-declaration="yes" method="text"/>
<xsl:param name="horoskopID" />
<xsl:param name="zodiacID" />

<xsl:template match="/" name="returnxmlurl">

<xsl:choose>
 <xsl:when test="count(root/horoscopes/horoscope[@id = $horoskopID]) &gt; 0">
  <xsl:value-of select="root/info/@baseurl"/>
   <xsl:for-each select="root/horoscopes/horoscope">
    <xsl:if test="@id = $horoskopID"><xsl:value-of select="current()/url"/></xsl:if>
   </xsl:for-each>
  <xsl:value-of select="root/info/@apikey"/>
 </xsl:when>
 <xsl:otherwise>
  <xsl:value-of select="root/info/@baseurl"/>horoscopeDayFormal<xsl:value-of select="root/info/@apikey"/>
 </xsl:otherwise>
</xsl:choose>

</xsl:template>

</xsl:stylesheet>