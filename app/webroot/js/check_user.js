//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
function check_in(){
	var re_in = true;
	for (i = 0; i < inph.length; i++) {//-----------------------------必須項目
		if(document.getElementById(inph[i]).value == ''){
			document.getElementById('msgh'+i).innerHTML = '必須項目です';
			document.getElementById(inph[i]).focus();
			document.getElementById(inph[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outerh'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			document.getElementById('msgh'+i).innerHTML = '';
			document.getElementById(inph[i]).style.backgroundColor = '';
			document.getElementById('outerh'+i).style.backgroundColor = '';
		}
	}
	for (i = 0; i < inphe.length; i++) {//-----------------------------必須項目英数半角
		if(document.getElementById(inphe[i]).value == ''){
			document.getElementById('msghe'+i).innerHTML = '必須項目です';
			document.getElementById(inphe[i]).focus();
			document.getElementById(inphe[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outerhe'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(document.getElementById(inphe[i]).value.match(/[^A-Za-z0-9]+/)){
				document.getElementById('msghe'+i).innerHTML = '英数半角のみです';
				document.getElementById(inphe[i]).focus();
				document.getElementById(inphe[i]).style.backgroundColor = '#ffeeee';
				document.getElementById('outerhe'+i).style.backgroundColor = '#ffeeee';
				re_in = false;
			}else{
				document.getElementById('msghe'+i).innerHTML = '';
				document.getElementById(inphe[i]).style.backgroundColor = '';
				document.getElementById('outerhe'+i).style.backgroundColor = '';
			}
		}
	}
	if(re_in){document.form1.submit();}
}
