//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function wclose(){
	var userAgent = window.navigator.userAgent.toLowerCase();
	if(userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
		window.open('about:blank','_self').close();
	}else{
		window.close();
	}
}
