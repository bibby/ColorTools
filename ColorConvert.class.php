<?php
/**
* Class to convert color-related strings and arrays into usable objects
*@author bibby <bibby@surfmerchants.com>
*$Id: ColorConvert.class.php,v 1.2 2009/03/19 16:35:32 abibby Exp $
*
* convert method can be called statically, but if you'd prefer to set a default 
* return type (for many conversions), instatiate an object naming a default
* options are :
	__string__		__return__
	'hex'			'ABCDEF'
	'#hex'			'#ABCDEF'	*default*
	'color_hex'		Color_Hex
	'rgb'			array(r,g,b)
	'color_rgb'		Color_RGB
	'hsl'			array(h,s,l)
	'color_hsl'		Color_HSL
*/


require_once('ColorMap.class.php');
require_once('Color_Hex.class.php');
require_once('Color_RGB.class.php');
require_once('Color_HSL.class.php');
class ColorConvert
{
	function ColorConvert($returnType='#hex')
	{
		$types=array('hex','#hex','color_hex','rgb','color_rgb','hsl','color_hsl');
		$returnType=strtolower($returnType);
		$this->defaultReturnType=in_array($returnType,$types)?$returnType:'#hex';
	}
	
	/*** convert ***
	@access public
	@param mixed
	@param string classname or type
	@return mixed
	*/
	function convert($color,$to=false)
	{
		if(!$to) $to=$this->defaultReturnType;
		
		if(is_array($color) && count($color)==3)
		{
			//could be rgb or hsl, make a judgement call
			if($color['r'] || $color['R'])
				$color = new Color_RGB($color);
			elseif($color['h'] || $color['H'])
				$color = new Color_HSL($color);
			else
				return false; // could not decide
		}
		elseif(is_string($color) || is_numeric($color))
		{
			$tryword=ColorMap::wordToHex($color);
			if($tryword)
				$color=$tryword;
			// could be a hex code or a color name
			$color = new Color_Hex($color);
			if(!$color->isHex())
				return false; // whups not hex.
		}
		
		$class=strtolower(get_class($color));
		if(!$class)
			return false; // not color usable
		
		$hash=FALSE;
		switch(strtolower($to))
		{
			case '#hex':
				$hash=TRUE;
			case 'hex':
				if($class=='color_hex')
					return $color->toString($hash);
				if(method_exists($color,'toHex'))
					return $color->toHex($hash);
				break;
			case 'color_hex':
				if($class=='color_hex')
					return $color;
				if(method_exists($color,'toHex'))
					return new Color_Hex($color->toHex());
				break;
				
				
			case 'rgb':
				if($class=='color_rgb')
					return $color->toArray();
				if(method_exists($color,'toRGB'))
					return $color->toRGB();
				break;
			case 'color_rgb':
				if($class=='color_rgb')
					return $color;
				if(method_exists($color,'toRGB'))
					return new Color_RGB( $color->toRGB());
				break;
				
				
			case 'hsl':
				if($class=='color_hsl')
					return $color->toArray();
				if(method_exists($color,'toHSL'))
					return $color->toHSL();
				break;
			case 'color_hsl':
				if($class=='color_hsl')
					return $color;
				if(method_exists($color,'toHSL'))
				{
					return new Color_HSL($color->toHSL());
				}
				break;
		}
		
		return null;
	}
}
?>
