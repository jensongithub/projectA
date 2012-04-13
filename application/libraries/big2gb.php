<?php
/***************************************************************************
*                             big2gb.php
*                           --------------
*   begin                : Friday, Jan 3, 2003
*   author               : CRLin
*   url                  : http://web.dhjh.tcc.edu.tw/~gzqbyr/forum/
*
*   $Id: big2gb.php,v 1.0.0 2006/4/24 14:43:44 Exp $
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

class big2gb {
	var $file_dir;
	var $charset;
	var $str1;
	
	function __construct(){
		$this->file_dir = dirname(__FILE__);
		$this->charset = 'gb';
		$this->set_charset($this->charset);
	}
	
	function set_charset($charset = 'gb'){	
		if ($charset=='gb'){
			$fd = fopen($this->file_dir."/big2gb.map",'r');
			$this->str1 = fread($fd,filesize($this->file_dir."/big2gb.map"));
		}
		else{
			$fd = fopen($this->file_dir."/gb2big.map",'r');
			$this->str1 = fread($fd,filesize($this->file_dir."/gb2big.map"));
		}
		fclose($fd);
	}
	
	// charset can be big5 or gb
	function chg_utfcode($str){
		// convert to unicode and map code
		$chg_utf = array();
		for ($i=0;$i<strlen($this->str1);$i=$i+4){
			$ch1=ord(substr($this->str1,$i,1))*256;
			$ch2=ord(substr($this->str1,$i+1,1));
			$ch1=$ch1+$ch2;
			$ch3=ord(substr($this->str1,$i+2,1))*256;
			$ch4=ord(substr($this->str1,$i+3,1));
			$ch3=$ch3+$ch4;
			$chg_utf[$ch1]=$ch3;
		}
		
		// convert to UTF-8
		$outstr='';
		for ($k=0;$k<strlen($str);$k++){
			$ch=ord(substr($str,$k,1));
			if ($ch<0x80){
				$outstr.=substr($str,$k,1);
			}
			else{
				if ($ch>0xBF && $ch<0xFE){
					if ($ch<0xE0) {
						$i=1;
						$uni_code=$ch-0xC0;
					} elseif ($ch<0xF0)	{
						$i=2;
						$uni_code=$ch-0xE0;
					} elseif ($ch<0xF8)	{
						$i=3;
						$uni_code=$ch-0xF0;
					} elseif ($ch<0xFC)	{
						$i=4;
						$uni_code=$ch-0xF8;
					} else {
						$i=5;
						$uni_code=$ch-0xFC;
					}
				}
	
				$ch1=substr($str,$k,1);
				for ($j=0;$j<$i;$j++){
					$ch1 .= substr($str,$k+$j+1,1);
					$ch=ord(substr($str,$k+$j+1,1))-0x80;
					$uni_code=$uni_code*64+$ch;
				}
				
				if ( !isset( $chg_utf[$uni_code] ) || !$chg_utf[$uni_code] ){
					$outstr.=$ch1;
				}
				else{
					$outstr.=$this->uni2utf($chg_utf[$uni_code]);
				}
				$k += $i;
			}
		}
		return $outstr;
	}

	// Return utf-8 character
	function uni2utf($uni_code){
		if ($uni_code<0x80) return chr($uni_code);
		$i=0;
		$outstr='';
		while ($uni_code>63) // 2^6=64
		{
			$outstr=chr($uni_code%64+0x80).$outstr;
			$uni_code=floor($uni_code/64);
			$i++;
		}
		switch($i)
		{
			case 1:
				$outstr=chr($uni_code+0xC0).$outstr;break;
			case 2:
				$outstr=chr($uni_code+0xE0).$outstr;break;
			case 3:
				$outstr=chr($uni_code+0xF0).$outstr;break;
			case 4:
				$outstr=chr($uni_code+0xF8).$outstr;break;
			case 5:
				$outstr=chr($uni_code+0xFC).$outstr;break;
			default:
				echo "unicode error!!";exit;
		}
		return $outstr;
	}
}

?>