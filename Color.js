/***
Color functions for javascript.
@author bibby <bibby@surfmerchants.com>

ColorBlend
ColorMap (* PHP by Dave, port by bibby)
ColorConvert
Color_Hex
Color_RGB
Color_HSL
**/

var ColorBlend=function(colorA,colorB,steps)
{
	this.colors=[];
	this.steps = steps? parseInt(steps,10) : 10;
	this.colors.push( ColorMap.wordToHex(colorA).replace('#','') );
	this.colors.push( ColorMap.wordToHex( (colorB? colorB : 'black') ).replace('#','') );
	
	this.blends=[];
	
	this.get=
	this.getColor=
	this.getBlend=function(i)
	{
		return this.blends[i];
	}
	
	this.toRGB=function(c)
	{
		return ColorConvert.convert(c,'rgb');
	};
	
	this.isDark=function(c, max)
	{
		max = max ? parseInt(max,10) : 250;
		var col = this.toRGB(c);
		return (col.r+col.g+col.b) < max;
	};
	
	this.blend=function()
	{
		var increments=[];
		
		var cols=[
			this.toRGB(this.colors[0]),
			this.toRGB(this.colors[1])
		];
		
		var increments=[{r:0,g:0,b:0}];
		for(var c in increments[0])
		{
			increments[c] = ( cols[1][c] - cols[0][c]) / this.steps;
		}
		
		for(i=0;i<=this.steps;i++)
		{
			var cval={},conv={r:0,g:0,b:0};
			for(var c in conv)
			{
				cval=Math.round( cols[0][c] + (increments[c]*i));
				if(cval<0) cval=0;
				if(cval>255) cval=255;
				conv[c]=cval;
			}
			
			this.blends.push( new Color_RGB(conv).toHex() );
		}
	};
	
	this.blend();
}

var ColorMap={
	wordToHex:function(w)
	{
		if(this.isHex(w))
			return w;
		else
		{
			var c =this.WordToHexMap[w];
			return c ? c.toLowerCase() : false; 
		}
	},
	hexToWords:function(h)
	{
		for(var w in this.WordToHexMap)
			if(this.WordToHexMap[w]==h)
				return w;
		return false;
	},
	isHex:function(h)
	{
		return /^#?[a-f0-9]{3}([a-f0-9]{3})?$/i.test(h);
	},
	WordToHexMap:
	{
		'aliceblue':'#f0f8ff',
		'antiquewhite':'#faebd7',
		'aqua':'#00ffff',
		'aquamarine':'#7fffd4',
		'azure':'#f0ffff',
		'beige':'#f5f5dc',
		'bisque':'#ffe4c4',
		'black':'#000000',
		'blanchedalmond':'#ffebcd',
		'blue':'#0000ff',
		'blueviolet':'#8a2be2',
		'brown':'#a52a2a',	
		'burlywood':'#deb887',
		'cadetblue':'#5f9ea0',
		'chartreuse':'#7fff00',
		'chocolate':'#d2691e',
		'coral':'#ff7f50',
		'cornflowerblue':'#6495ed',
		'cornsilk':'#fff8dc',
		'crimson':'#dc143c',
		'cyan':'#00ffff',
		'darkblue':'#00008b',
		'darkcyan':'#008b8b',
		'darkgoldenrod':'#b8860b',
		'darkgray':'#a9a9a9',
		'darkgrey':'#a9a9a9',
		'darkgreen':'#006400',
		'darkkhaki':'#bdb76b',
		'darkmagenta':'#8b008b',
		'darkolivegreen':'#556b2f',
		'darkorange':'#ff8c00',
		'darkorchid':'#9932cc',
		'darkred':'#8b0000',
		'darksalmon':'#e9967a',
		'darkseagreen':'#8fbc8f',
		'darkslateblue':'#483d8b',
		'darkslategray':'#2f4f4f',
		'darkslategrey':'#2f4f4f',
		'darkturquoise':'#00ced1',
		'darkviolet':'#9400d3',
		'deeppink':'#ff1493',
		'deepskyblue':'#00bfff',
		'dimgray':'#696969',
		'dimgrey':'#696969',
		'dodgerblue':'#1e90ff',
		'firebrick':'#b22222',
		'floralwhite':'#fffaf0',
		'forestgreen':'#228b22',
		'fuchsia':'#ff00ff',
		'gainsboro':'#dcdcdc',
		'ghostwhite':'#f8f8ff',
		'gold':'#ffd700',
		'goldenrod':'#daa520',
		'gray':'#808080',
		'grey':'#808080',
		'green':'#008000',
		'greenyellow':'#adff2f',
		'honeydew':'#f0fff0',
		'hotpink':'#ff69b4',
		'indianred':'#cd5c5c',
		'indigo':'#4b0082',
		'ivory':'#fffff0',
		'khaki':'#f0e68c',
		'lavender':'#e6e6fa',
		'lavenderblush':'#fff0f5',
		'lawngreen':'#7cfc00',
		'lemonchiffon':'#fffacd',
		'lightblue':'#add8e6',
		'lightcoral':'#f08080',
		'lightcyan':'#e0ffff',
		'lightgoldenrodyellow':'#fafad2',
		'lightgray':'#d3d3d3',
		'lightgrey':'#d3d3d3',
		'lightgreen':'#90ee90',
		'lightpink':'#ffb6c1',
		'lightsalmon':'#ffa07a',
		'lightseagreen':'#20b2aa',
		'lightskyblue':'#87cefa',
		'lightslategray':'#778899',
		'lightslategrey':'#778899',
		'lightsteelblue':'#b0c4de',
		'lightyellow':'#ffffe0',
		'lime':'#00ff00',
		'limegreen':'#32cd32',
		'linen':'#faf0e6',
		'magenta':'#ff00ff',
		'maroon':'#800000',
		'mediumaquamarine':'#66cdaa',
		'mediumblue':'#0000cd',
		'mediumorchid':'#ba55d3',
		'mediumpurple':'#9370d8',
		'mediumseagreen':'#3cb371',
		'mediumslateblue':'#7b68ee',
		'mediumspringgreen':'#00fa9a',
		'mediumturquoise':'#48d1cc',
		'mediumvioletred':'#c71585',
		'midnightblue':'#191970',
		'mintcream':'#f5fffa',
		'mistyrose':'#ffe4e1',
		'moccasin':'#ffe4b5',
		'navajowhite':'#ffdead',
		'navy':'#000080',
		'oldlace':'#fdf5e6',
		'olive':'#808000',
		'olivedrab':'#6b8e23',
		'orange':'#ffa500',
		'orangered':'#ff4500',
		'orchid':'#da70d6',
		'palegoldenrod':'#eee8aa',
		'palegreen':'#98fb98',
		'paleturquoise':'#afeeee',
		'palevioletred':'#d87093',
		'papayawhip':'#ffefd5',
		'peachpuff':'#ffdab9',
		'peru':'#cd853f',
		'pink':'#ffc0cb',
		'plum':'#dda0dd',
		'powderblue':'#b0e0e6',
		'purple':'#800080',
		'red':'#ff0000',
		'rosybrown':'#bc8f8f',
		'royalblue':'#4169e1',
		'saddlebrown':'#8b4513',
		'salmon':'#fa8072',
		'sandybrown':'#f4a460',
		'seagreen':'#2e8b57',
		'seashell':'#fff5ee',
		'sienna':'#a0522d',
		'silver':'#c0c0c0',
		'skyblue':'#87ceeb',
		'slateblue':'#6a5acd',
		'slategray':'#708090',
		'slategrey':'#708090',
		'snow':'#fffafa',
		'springgreen':'#00ff7f',
		'steelblue':'#4682b4',
		'tan':'#d2b48c',
		'teal':'#008080',
		'thistle':'#d8bfd8',
		'tomato':'#ff6347',
		'turquoise':'#40e0d0',
		'violet':'#ee82ee',
		'wheat':'#f5deb3',
		'white':'#ffffff',
		'whitesmoke':'#f5f5f5',
		'yellow':'#ffff00',
		'yellowgreen':'#9acd32',
	}
};




var ColorConvert=function(returnType)
{
	var types={'hex':1,'#hex':1,'color_hex':1,'rgb':1,'color_rgb':1,'hsl':1,'color_hsl':1};
	if(!returnType || !types[returnType])
		returnType='#hex';
	this.defaultReturnType=returnType;
}


ColorConvert.convert=
ColorConvert.prototype.convert=function(color, to)
{
	if(!color) return;
	if(!to)
		to = this.defaultReturnType? this.defaultReturnType : '#hex';
	
	to=to.toLowerCase();
	
	if(!(color instanceof Color_Hex || color instanceof Color_RGB || color instanceof Color_HSL))
	{
		//is_array?
		if(typeof color.length === 'number' && !(color.propertyIsEnumerable('length')) && typeof color.splice === 'function' && color.length==3)
		{
			
			color = new Color_RGB(color);
		}
		else if(typeof color == 'object')
		{
			if(color.r || color.R)
				color = new Color_RGB(color);
			else if(color.h || color.H)
				color = new Color_HSL(color);
			else
				return false;
		}
		
		if(typeof color == 'string' || typeof color == 'number')
		{
			var named = ColorMap.wordToHex(color);
			if(named)
				color = named;
			
			color = new Color_Hex(color);
			if(!color.isHex())
				return false;
		}
	}
	
	var hash=false;
	switch(to)
	{
		case '#hex':
			hash=true;
		case 'hex':
			if(color instanceof Color_Hex)
				return color.toString(hash);
			if(typeof color.toHex == 'function')
				return color.toHex(hash);
			break;
		case 'color_hex':
			if(color instanceof Color_Hex)
				return color;
			if(typeof color.toHex == 'function')
				return new Color_Hex(color.toHex(hash));
			break;
			
		case 'rgb':
			if(color instanceof Color_RGB)
				return color.toArray();
			if(typeof color.toRGB == 'function')
				return color.toRGB();
			break;
		case 'color_rgb':
			if(color instanceof Color_RGB)
				return color;
			if(typeof color.toRGB == 'function')
				return new Color_RGB( color.toRGB());
			break;
				
		case 'hsl':
			if(color instanceof Color_HSL)
				return color.toArray();
			if(typeof color.toHSL == 'function')
				return color.toHSL();
			break;
		case 'color_hsl':
			if(color instanceof Color_HSL)
				return color;
			if(typeof color.toHSL == 'function')
				return new Color_HSL(color.toHSL());
			break;
	}
}


var Color_Hex=function(str)
{
	this.hex = str.toString().replace(/[^0-9a-f]/i,'');
}

Color_Hex.prototype={
	hex:null,
	isHex:function(hex)
	{
		if(!hex) hex=this.hex;
		return /^#?[0-9a-f]{6}$/i.test(hex);
	},
	toRGB:function(hex)
	{
		if(!hex) hex=this.hex;
		return {
			r:parseInt(hex.substr(0,2),16),
			g:parseInt(hex.substr(2,2),16),
			b:parseInt(hex.substr(4,2),16)
		};
	},
	toString:function(hash)
	{
		return (hash?'#':'')+this.hex;
	},
	toHSL:function(hex)
	{
		var rgb = hex? ColorConvert(hex,'rgb') : this.toRGB();
		rgb = new Color_RGB(rgb);
		return rgb.toHSL();
	}
};

// static-like fns
Color_Hex.toRGB = Color_Hex.prototype.toRGB;
Color_Hex.toHSL = Color_Hex.prototype.toHSL;


Color_RGB=function(Rgb,g,b)
{
	var r;
	if(typeof Rgb == 'object')
	{
		r= Rgb.r? Rgb.r : Rgb[0];
		g= Rgb.g? Rgb.g : Rgb[1];
		b= Rgb.b? Rgb.b : Rgb[2];
	}
	else
		r=Rgb;
	
	if(r == undefined) r=0;
	if(g == undefined) g=0;
	if(b == undefined) b=0;
	
	this.r=parseInt(r,10);
	this.g=parseInt(g,10);
	this.b=parseInt(b,10);
};

Color_RGB.prototype={
	r:0,
	g:0,
	b:0,
	toHex:function(hash)
	{
		function x(h)
		{
			h=h.toString(16);
			return h.length==1? '0'+h.toString() : h.toString();
		}
		
		return (hash?'#':'')+x(this.r)+x(this.g)+x(this.b);
	},
	toArray:function()
	{
		return {
			r:this.r,
			g:this.g,
			b:this.b
		};
	},
	toHSL:function()
	{
		var tr,tg,tb, min=256,max=0,del_max,  h,s,l, del_r,del_g,del_b;
		tr= this.r/255;
		tg= this.g/255;
		tb= this.b/255;
		
		del_max={'tr':tr,'tg':tg,'tb':tb};
		for(var i in del_max)
		{
			if(del_max[i] < min)
				min=del_max[i];
			if(del_max[i] > max)
				max=del_max[i];
		}
		
		del_max = max-min;
		l = (max+min)/2;
		
		if(del_max == 0)
		{
			h=0;
			s=0;
		}
		else
		{
			if(l < 0.5)
				s = del_max / (max + min);
			else
				s = del_max / (2 - max - min);
			
			del_r = (((max - tr) / 6) + (del_max / 2)) / del_max;
			del_g = (((max - tg) / 6) + (del_max / 2)) / del_max;
			del_b = (((max - tb) / 6) + (del_max / 2)) / del_max;
			
			if(tr == max)
				h = del_b - del_g;
			else if(tg == max)
				h = (1/3) + del_r - del_b;
			else if(tb == max)
				h = (2/3) + del_g - del_r;
			
			while(h<0)
				h+=1;
			while(h>1)
				h-=1;
		}
		
		return {
			'h':h,
			's':s,
			'l':l
		};
	},
	get:function(m)
	{
		return this[m];
	},
	set:function(m,to)
	{
		to=parseInt(to,10);
		to=isNaN(to)?0:to;
		this[m]=to;
	},
	getRed:function()
	{
		return this.get('r');
	},
	setRed:function(to)
	{
		this.set('r',to);
	},
	getGreen:function()
	{
		return this.get('g');
	},
	setGreen:function(to)
	{
		this.set('g',to);
	},
	getBlue:function()
	{
		return this.get('b');
	},
	setBlue:function(to)
	{
		this.set('b',to);
	}
};


Color_HSL=function(Hsl,s,l)
{
	var h,s,l;
	if(typeof Hsl == 'object')
	{
		h = Hsl.h ? Hsl.h : Hsl[0];
		s = Hsl.s ? Hsl.s : Hsl[1];
		l = Hsl.l ? Hsl.l : Hsl[2];
	}
	else
		h=Hsl;
	
	if(h == undefined) h=0;
	if(s == undefined) s=0;
	if(l == undefined) l=0;
	
	this.h=parseFloat(h);
	this.s=parseFloat(s);
	this.l=parseFloat(l);
}

Color_HSL.prototype={
	h:0,
	s:0,
	l:0,
	enforce_bounds:function(f,wrap)
	{
		f=parseFloat(f,10);
		if(wrap)
		{
			while(f>1) f-=1;
			while(f<0) f+=1;
		}
		else
		{
			if(f>1) f=1;
			if(f<0) f=0;
		}
		return f;
	},
	toArray:function()
	{
		return {
			h:this.h,
			s:this.s,
			l:this.l
		};
	},
	hue2rgb:function($v1,$v2,$vh)
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
	},
	toRGB:function()
	{
		var $h=this.h;
		var $s=this.s;
		var $l=this.l;
		
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
			$r = 255 * this.hue2rgb($var_1,$var_2,$h + (1 / 3));
			$g = 255 * this.hue2rgb($var_1,$var_2,$h);
			$b = 255 * this.hue2rgb($var_1,$var_2,$h - (1 / 3));
		}
		
		return {
			r:Math.round($r),
			g:Math.round($g),
			b:Math.round($b)
		};
	},
	toHex:function(hash)
	{
		var rgb = new Color_RGB(this.toRGB());
		return rgb.toHex(hash);
	},
	getSaturation:function()
	{
		return this.s;
	},
	getLightness:function()
	{
		return this.l;
	},
	getBrightness:function()
	{
		return this.getLightness();
	},
	getHue:function()
	{
		return this.h;
	},
	findHues:function(offset)
	{
		var vals=[offset,(offset*-1)];
		vals[0] = this.hue(this.getHue() + vals[0]);
		vals[1] = this.hue(this.getHue() + vals[1]);
		return vals;
	},
	compliment:function()
	{
		return this.hue( this.getHue() + 0.5 );
	},
	triads:function()
	{
		return this.findHues(0.33333);
	},
	split_compliments:function()
	{
		return this.findHues(0.41666);
	},
	analogs:function()
	{
		return this.findHues(0.08333);
	},
	analagous:function()
	{
		return this.analogs();
	},
	saturate:function(set)
	{
		return this.set({s:set});
	},
	lightness:function(set)
	{
		return this.set({l:set});
	},
	brightness:function(set)
	{
		return this.lightness(set);
	},
	hue:function(set)
	{
		return this.set({h:set});
	},
	set:function(HSL,adjust)
	{
		if(typeof(HSL)!='object')
			return false;
		
		hsl=this.toArray();
		for(var i in hsl)
		{
			P=undefined;
			if(HSL[i])
				P=i;
			else if(HSL[i.toUpperCase()])
				P=i.toUpperCase();
			
			if(P == undefined) continue;
			
			if(!adjust)
				hsl[i]= this.enforce_bounds(HSL[P], (i=='h'?true:false));
			else
				hsl[i]= this.enforce_bounds((hsl[i]+HSL[P]), (i=='h'?true:false));
		}
		
		return new Color_HSL(hsl);
	},
	adjust:function(HSL)
	{
		return this.set(HSL,true);
	}
};
