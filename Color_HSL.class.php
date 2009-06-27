<?php
/**
* Class to represent a Hex Color, to be used in conjuntion with ColorConvert
* Hue - Saturation - Lightness/Brightness
* Each of which are floats 0-1
* Where possible, "brightness" is aliased to "lightness"
*@author bibby <bibby@surfmerchants.com>
*$Id: Color_HSL.class.php,v 1.3 2008/11/18 14:25:44 abibby Exp $
*/


class Color_HSL
{
	/*** Color_HSL ***
	new Color_HSL( array $hsl)
	new Color_HSL( $h, $s, $l)
	*/
	function Color_HSL($Hsl,$s=false,$l=false)
	{
		if(is_array($Hsl))
			list($h,$s,$l)=array_values($Hsl);
		else
			$h=$Hsl;
		
		$this->h=floatval($h);
		$this->s=floatval($s);
		$this->l=floatval($l);
	}
	
	/*** enforce_bounds ***
	keeps a float within bounds
	@access private
	@param float
	@return float
	*/
	function enforce_bounds($f,$wrap=false)
	{
		$f=floatval($f);
		if($wrap)
		{
			while($f>1)$f-=1;
			while($f<0)$f+=1;
		}
		else
		{
			if($f>1)$f=1;
			if($f<0)$f=0;
		}
		return $f;
	}
	
	/*** toArray ***
	redundant dump of members
	@access public
	@return array (h,s,l)
	*/
	function toArray()
	{
		return array
		(
			'h'=>$this->h,
			's'=>$this->s,
			'l'=>$this->l
		);
	}
	
	/*** hue2rgb ***
	Hue finder
	@access PRIVATE
	@param float
	@param float
	@param float
	@return float
	*/
	function hue2rgb($v1,$v2,$vh)
	{
		if ($vh < 0)
				$vh += 1;
		
		if ($vh > 1)
				$vh -= 1;
		
		if ((6 * $vh) < 1)
				return ($v1 + ($v2 - $v1) * 6 * $vh);
		
		if ((2 * $vh) < 1)
				return ($v2);
		
		if ((3 * $vh) < 2)
				return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
		
		return ($v1);
	}
	
	/*** toRGB ***
	convert color to RGB
	@access public
	@return array (r,g,b)
	*/
	function toRGB()
	{
		$h=$this->h;
		$s=$this->s;
		$l=$this->l;
		
		if ($s == 0)
		{
			$r = $l * 255;
			$g = $l * 255;
			$b = $l * 255;
		}
		else
		{
			if ($l < 0.5)
					$var_2 = $l * (1 + $s);
			else
					$var_2 = ($l + $s) - ($s * $l);
			
			$var_1 = 2 * $l - $var_2;
			$r = 255 * $this->hue2rgb($var_1,$var_2,$h + (1 / 3));
			$g = 255 * $this->hue2rgb($var_1,$var_2,$h);
			$b = 255 * $this->hue2rgb($var_1,$var_2,$h - (1 / 3));
		}
		
		return array('r'=>round($r),'g'=>round($g),'b'=>round($b));
	}
	
	/*** toHex ***
	convert color to Hex
	@access public
	@param bool (#hex)?
	@return string
	*/
	function toHex($hash=false)
	{
		list($r,$g,$b)=array_values($this->toRGB());
		return ($hash?'#':'')
		.sprintf("%02X",round($r))
		.sprintf("%02X",round($g))
		.sprintf("%02X",round($b));
	}
	
	
	/*** getSaturation ***
	@access public
	@return float
	*/
	function getSaturation()
	{
		return $this->s;
	}
	
	
	/*** getLightness ***
	@access public
	@return float
	*/
	function getLightness()
	{
		return $this->l;
	}
	
	/*** getBrightness ***
	@access public
	@return float
	*/
	function getBrightness()
	{
		return $this->getLightness();
	}
	
	/*** getHue ***
	@access public
	@return float
	*/
	function getHue()
	{
		return $this->h;
	}
	
	/*** compliment ***
	Retrieve the this color's opposite on the color wheel
	@access public
	@return Color_HSL
	*/
	function compliment()
	{
		return $this->hue( $this->getHue() + 0.5 );
	}
	
	
	/*** findHues ***
	Retrieve multiple hues from a single offset (clockwise and counter)
	@access PRIVATE
	@param float
	@return array (Color_HSL +offset,Color_HSL -offset)
	*/
	function findHues($offset)
	{
		$vals=array($offset,$offset*-1);
		foreach($vals as $k=>$v)
		{
			$vals[$k]= $this->hue( $this->getHue() + $v);
		}
		return $vals;
	}
	
	/*** triads ***
	Get the colors @ 120 degress 
	@access public
	@return array (Color_HSL +offset,Color_HSL -offset)
	*/
	function triads()
	{
		return $this->findHues(0.33333);
	}
	
	/*** split_compliments ***
	@access public
	@return array (Color_HSL +offset,Color_HSL -offset)
	*/
	function split_compliments()
	{
		return $this->findHues(0.41666);
	}
	
	/*** analogs ***
	@access public
	@return array (Color_HSL +offset,Color_HSL -offset)
	*/
	function analogs()
	{
		return $this->findHues(0.08333);
	}
	
	/*** analagous ***
	alias to analogs
	@access public
	@return array (Color_HSL +offset,Color_HSL -offset)
	*/
	function analagous()
	{
		return $this->analogs();
	}
	
	/*** saturate ***
	Get a new color, based on this one, with a different saturation
	@access public
	@param float 0-1
	@return Color_HSL
	*/
	function saturate($set)
	{
		$hsl=$this->toArray();
		$hsl['s']=$this->enforce_bounds($set);
		return new Color_HSL($hsl);
	}
	
	/*** lightness ***
	Get a new color, based on this one, with a different lightness
	@access public
	@param float 0-1
	@return Color_HSL
	*/
	function lightness($set)
	{
		$hsl=$this->toArray();
		$hsl['l']=$this->enforce_bounds($set);
		return new Color_HSL($hsl);
	}
	
	/*** hue ***
	Get a new color, based on this one, with a different hue
	@access public
	@param float 0-1
	@return Color_HSL
	*/
	function hue($set)
	{
		$hsl=$this->toArray();
		$hsl['h']=$this->enforce_bounds($set,TRUE);
		return new Color_HSL($hsl);
	}
	
	/*** brightness ***
	Alias to lightness()
	@access public
	@param float 0-1
	@return Color_HSL
	*/
	function brightness($set)
	{
		return $this->lighteness($set);
	}
	
	
	/*** set ***
	Set H,S, and/or L with array
	@access public
	@param array assoc (h=>float,s=>float,l=>float)
	@return Color_HSL
	*/
	function set($A,$adjust=false)
	{
		if(!is_array($A))
			return false;
			
		$hsl = $this->toArray();
		foreach(array_keys($hsl) as $p)
		{
			$P=false;
			if($A[strtoupper($p)])
				$P=strtoupper($p);
			elseif($A[$p])
				$P=$p;
				
			if(!$P)
				continue;
			
			if(!$adjust)
				$hsl[$p]=$this->enforce_bounds($A[$P],($p=='h'?true:false));
			else
				$hsl[$p]=$this->enforce_bounds( ($hsl[$p]+$A[$P]) ,($p=='h'?true:false));
		}
		
		return new Color_HSL($hsl);
	}
	
	/*** adjust ***
	Set H,S, and/or L with array relative to its current value
	@access public
	@param array assoc (h=>float,s=>float,l=>float)
	@return Color_HSL
	*/
	function adjust($A)
	{
		return $this->set($A,TRUE);
	}
}

?>
