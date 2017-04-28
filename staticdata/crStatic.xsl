<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
                xmlns="http://www.w3.org/2000/svg">
  <xsl:output method="xml" omit-xml-declaration="yes" />

  <xsl:template match="/">
    <svg viewBox="0 0 2400 1400" style="background: #000 ; font-family: 'Racing Sans One'"  id="zcanvas2" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink">
      <defs>
        <!--link xmlns="http://www.w3.org/1999/xhtml" href="http://fonts.googleapis.com/css?family=Racing+Sans+One|Six+Caps" type="text/css" rel="stylesheet" /-->
      </defs>
      <xsl:apply-templates select="roll/dayquantum">
        <xsl:sort select="@date" order="descending" data-type="number"/>
      </xsl:apply-templates>
    </svg>
  </xsl:template>
  
  <!-- each day -->
  
  <xsl:template match="dayquantum">
  
    <xsl:variable name="total"><xsl:call-template name="summasumarum"><xsl:with-param name="list" select="dayquantum"/></xsl:call-template> </xsl:variable>
  
    <xsl:variable name="y" select="(position() * 180) - 100" />

    <text fill="#fff" font-size="48" x="80" y="{$y - 40}" transform="rotate(90, 80, {$y - 40})">
      <xsl:value-of select="substring(@date,7,2)" />
      <xsl:value-of select="substring('  JANFEBMARAPRMAYJUNJULAUGSEPOCTNOVDEC', number(substring(@date,5,2)) * 3, 3)" />
    </text>
    <text fill="#ff6000" font-size="48" x="120" y="{$y - 10}">
      <xsl:value-of select="sum(item/@value)" />
    </text>
    
    <text fill="#fff" font-size="48" x="120" y="{$y - 10}">
      <xsl:value-of select="$total" />
    </text>
     
    <xsl:variable name="topItem" select="item[not(../item/@value > @value)][1]" />
    
    <xsl:apply-templates select="$topItem">
      <xsl:with-param name="y" select="$y" />
      <xsl:with-param name="remainingItems" select="item[generate-id() != generate-id($topItem)]" />
    </xsl:apply-templates>
    
  </xsl:template>

  <!-- each item -->
  
  <xsl:template match="item">
    <xsl:param name="y" />
    <xsl:param name="previousItems" select="/.." />
    <xsl:param name="remainingItems" />

    <xsl:variable name="leadingSpace" select="200 + sum($previousItems/@value) * 16" />
    <xsl:variable name="width" select="@value * 16" />
    <xsl:variable name="hCenter" select="$leadingSpace + $width div 2" />

    <rect fill="green" x="{$leadingSpace}" y="{$y - 48}" width="{$width}" rx="10" height="48" />

    <g font-family="sans-serif">
      <text fill="#fff" font-size="20" text-anchor="middle" x="{$hCenter}" y="{$y - 20}">
        <xsl:value-of select="@value" />
      </text>

      <text fill="#888" font-size="18" text-anchor="start" x="{$hCenter}"
            y="{$y}" transform="rotate(90, {$hCenter}, {$y})">
        <xsl:value-of select="@product" />
      </text>
    </g>

    <xsl:variable name="topItem" select="$remainingItems[not($remainingItems/@value > @value)][1]" />
    
    <xsl:apply-templates select="$topItem">
      <xsl:with-param name="y" select="$y" />
      <xsl:with-param name="previousItems" select="$previousItems | ." />
      <xsl:with-param name="remainingItems" select="$remainingItems[generate-id() != generate-id($topItem)]" />
    </xsl:apply-templates>
  </xsl:template>
  
  <xsl:template name="summasumarum">
  <xsl:param name="list"/>
  <xsl:choose>
    <xsl:when test="$list">
    88
      <xsl:variable name="first" select="$list[1]"/>
      <xsl:variable name="price" select="document('menu51.xml')/root/item[@name = @product]/@price" />
      <xsl:variable name="between">
      
        <xsl:call-template name="summasumarum">
          <xsl:with-param name="list" select="$list[position()!=1]"/>

        </xsl:call-template>
      </xsl:variable>
      <xsl:value-of select="$first/@value * $price + $between"/>
    </xsl:when>
    <xsl:otherwise>99</xsl:otherwise>
  </xsl:choose>
</xsl:template>
  
</xsl:stylesheet>
