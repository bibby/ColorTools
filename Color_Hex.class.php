<?php
/**
* Class to represent a Hex Color, to be used in conjuntion with ColorConvert
*@author bibby <bibby@surfmerchants.com>
*$Id: Color_Hex.class.php,v 1.1 2008/11/17 15:22:49 abibby Exp $
*/
require_once('ColorConvert.class.php');

class Color_Hex
{
	/*** Color_Hex ***
	@param string Hex
	*/
	function Color_Hex($str)
	{
		$this->hex = preg_replace('/[^0-9a-f]/i','',$str);
	}
	
	/*** isHex ***
	Validate if string is a hex color.
	Can be called statically.
	(Class) Does not support short hex (#FFF) (yet? see ColorMap)
	@access public
	@param string (optional)
	@return bool
	*/
	function isHex($hex=false)
	{
		if(!$hex)
			$hex = $this->hex;
			
		return preg_match('/^#?[a-f0-9]{6}$/i', $hex) == 1;
		//return (strlen($hex)==6 && !ereg('[^0-9A-F]',$hex));
	}
	
	/*** toRGB ***
	Convert hex to RGB array.
	Can be called statically
	@access public
	@param string (optional)
	@return array (r,g,b)
	*/
	function toRGB($hex=false)
	{
		if(!$hex)
			$hex = $this->hex;
		
		
		return array(
			'r'=>hexdec(substr($hex,0,2)),
			'g'=>hexdec(substr($hex,2,2)),
			'b'=>hexdec(substr($hex,4,2))
		);
	}
	
	/*** toString ***
	Print Hex
	@access public
	@param bool (#hex)?
	@return string
	*/
	function toString($hash=false)
	{
		return ($hash?'#':'').$this->hex;
	}
	
	/*** toHSL ***
	Convert hex to Hue-Saturation-Lightness array
	@access public
	@param string (optional)
	@return array (h,s,l)
	*/
	function toHSL($hex=false)
	{
		$rgb = ($hex? ColorConvert::convert($hex,'rgb') : $this->toRGB());
		$rgb=new Color_RGB($rgb);
		return $rgb->toHSL();
	}
}

?>
