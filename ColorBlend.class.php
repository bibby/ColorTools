<?php
/**
* Color Blender - Shades one color into another
*@author bibby <bibby@surfmerchants.com>
*$Id: ColorBlend.class.php,v 1.4 2008/11/07 16:18:13 abibby Exp $

Accepts named colors (Dave's ColorMap uses many CSS named colors).
ColorB defaults to black, and steps to 10, 
so for the easiest way to get a "darker shade" of a color
one could do

$cb = new ColorBlend('navy');
$cb->get(4); // the 4th step of 10 from navy towards black.
// 0 = navy, 10 = black

You *can* get more precise by choosing to use more steps, but most of the time, fewer is better:
$cb = new ColorBlend('blue','black',2);
$cb->get(1);

// (^ more effecient than: )

$cb = new ColorBlend('blue','black',500);
$cb->get(250);
*/

require_once('ColorMap.class.php');
class ColorBlend
{
	/*** ColorBlend ***
	constructor
	@param string hex color
	@param string hex color
	@param int A to B in X steps
	*/
	function ColorBlend($colorA,$colorB=0,$steps=10)
	{
		$this->colors=array($colorA,$colorB);
		$this->steps=$steps;
		$this->blends=array();
		$this->blend();
	}
	
	/*** blend ***
	calculates colors between A and B
	@access private
	@return void
	*/
	function blend()
	{
		if(count($this->blends))
			return;
		
		if(!$this->colors[1] && $this->isDark($this->colors[0]))
			$this->colors[1]='white';
		
		foreach(array_keys($this->colors) as $c)
			$this->colors[$c]=$this->toRGB($this->colors[$c]);
		
		$increments=array();
		foreach(range(0,2) as $c)
			$increments[$c] = ($this->colors[1][$c] - $this->colors[0][$c]) / $this->steps;
			
		foreach(range(0,$this->steps+1) as $i)
		{
			$conv=array();
			foreach(range(0,2) as $c)
			{
				$cval=round($this->colors[0][$c]+($increments[$c]*$i));
				if($cval < 0) $cval=0;
				if($cval >255) $cval=255;
				$conv[]=sprintf('%02X',$cval);
			}
			array_push($this->blends,'#'.join($conv));
		}
	}
	
	/*** toRGB ***
	@access public
	@param string arbitrary color
	@param bool return array
	@return
	*/
	function toRGB($color)
	{
		$named=ColorMap::wordToHex($color);
		if($named)
			$color=$named;
		$color=str_replace('#','',$color);
		$rgb=array();
		foreach(range(0,2) as $i)
			array_push($rgb, hexdec(substr($color,$i*2,2)));
		
		return $rgb;
	}
	
	/*** isDark ***
	@access public
	@param string color HEX
	@param int optional personal floor
	@return bool
	*/
	function isDark($color, $max=250)
	{
		return array_sum($this->toRGB($color)) < intval($max);
	}
	
	/*** get ***
	@access public
	@param int 
	@return string #HEXColor
	*/
	function get($i)
	{
		return $this->blends[$i];
	}
	
	/*** some aliases! ***/
	function getColor($i) { return $this->get($i); }
	function getBlend($i) { return $this->get($i); }
}
?>
