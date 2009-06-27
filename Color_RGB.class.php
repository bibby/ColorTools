<?php
/**
* Class to represent a RGB Color, to be used in conjuntion with ColorConvert
*@author bibby <bibby@surfmerchants.com>
*$Id: Color_RGB.class.php,v 1.1 2008/11/17 15:22:49 abibby Exp $
*/
require_once('ColorConvert.class.php');


class Color_RGB
{
	/*** Color_RGB ***
	new Color_RGB( array $rgb )
	new Color_RGB( r, g, b)
	*/
	function Color_RGB($Rgb,$g=false,$b=false)
	{
		if(is_array($Rgb))
			list($r,$g,$b)=array_values($Rgb);
		else
			$r=$Rgb;
		
		$this->r=intval($r);
		$this->g=intval($g);
		$this->b=intval($b);
	}
	
	/*** toHex ***
	convert this rgb to hex
	@access public
	@param bool (#hex)?
	@return string
	*/
	function toHex($hash=true)
	{
		return ($hash?'#':'')
		.sprintf("%02X",$this->r)
		.sprintf("%02X",$this->g)
		.sprintf("%02X",$this->b);
	}
	
	/*** toArray ***
	redundant dump of rgb members
	@access public
	@return array (r,g,b)
	*/
	function toArray()
	{
		return array
		(
			$this->r,
			$this->g,
			$this->b
		);
	}
	
	/*** toHSL ***
	convert this color to Hue-Saturation-Lightness
	@access public
	@return array (h,s,l)
	*/
	function toHSL()
	{
		$var_r = ($this->r) / 255;
		$var_g = ($this->g) / 255;
		$var_b = ($this->b) / 255;
		
		// Input is $var_r, $var_g and $var_b from above
		// Output is HSL equivalent as $h, $s and $l — these are again expressed as fractions of 1, like the input values
		
		$var_min = min($var_r,$var_g,$var_b);
		$var_max = max($var_r,$var_g,$var_b);
		$del_max = $var_max - $var_min;
		
		$l = ($var_max + $var_min) / 2;
		
		if ($del_max == 0)
		{
			$h = 0;
			$s = 0;
		}
		else
		{
			if ($l < 0.5)
					$s = $del_max / ($var_max + $var_min);
			else
					$s = $del_max / (2 - $var_max - $var_min);
			
			$del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
			$del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
			$del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

			if ($var_r == $var_max)
					$h = $del_b - $del_g;
			elseif ($var_g == $var_max)
					$h = (1 / 3) + $del_r - $del_b;
			elseif ($var_b == $var_max)
					$h = (2 / 3) + $del_g - $del_r;

			if ($h < 0)
					$h += 1;
			
			if ($h > 1)
					$h -= 1;
		};
		
		return array('h'=>$h,'s'=>$s,'l'=>$l);
	}
	
	/*** get ***
	@access public
	@param string member var
	@return int (most likely)
	*/
	function get($m)
	{
		return $this->{$m};
	}
	
	/*** set ***
	@access
	@param string member var
	@param int value
	@return void
	*/
	function set($m,$to)
	{
		$this->{$m}=intval($to);
	}
	
	
	/*** getRed ***
	@access public
	@return int
	*/
	function getRed()
	{
		return $this->get('r');
	}
	
	/*** setRed ***
	@access public
	@param int
	@return void
	*/
	function setRed($to)
	{
		$this->set('r',$to);
	}
	
	/*** getGreen ***
	@access public
	@return int
	*/
	function getGreen()
	{
		return $this->get('g');
	}
	
	/*** setGreen ***
	@access public
	@param int
	@return void
	*/
	function setGreen($to)
	{
		$this->set('g',$to);
	}
	
	/*** getBlue ***
	@access public
	@return int
	*/
	function getBlue()
	{
		return $this->get('b');
	}
	
	/*** setBlue ***
	@access public
	@param int
	@return void
	*/
	function setBlue($to)
	{
		$this->set('b',$to);
	}
}

?>
