//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function check_in(){
	var re_in = true;
	for (i = 0; i < inp.length; i++) {//-----------------------------半角数字のみ（INT）
		var intNum = document.getElementById(inp[i]).value;
		if(intNum.match(/[^0-9]+/)){
			document.getElementById('msg'+i).innerHTML = '半角数字のみです';
			document.getElementById(inp[i]).focus();
			document.getElementById(inp[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outer'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(intNum != ''){
				var num = intNum;
				intNum = Number(intNum);
				if(String(num) === String(intNum)){
					if(intNum >= 0 && intNum <= 2147483647){
						document.getElementById('msg'+i).innerHTML = '';
						document.getElementById(inp[i]).style.backgroundColor = '';
						document.getElementById('outer'+i).style.backgroundColor = '';
					}else{
						document.getElementById('msg'+i).innerHTML = '0~2147483647の数値のみです';
						document.getElementById(inp[i]).focus();
						document.getElementById(inp[i]).style.backgroundColor = '#ffeeee';
						document.getElementById('outer'+i).style.backgroundColor = '#ffeeee';
						re_in = false;
					}
				}else{
					document.getElementById('msg'+i).innerHTML = '整数のみです';
					document.getElementById(inp[i]).focus();
					document.getElementById(inp[i]).style.backgroundColor = '#ffeeee';
					document.getElementById('outer'+i).style.backgroundColor = '#ffeeee';
					re_in = false;
				}
			}else{
				document.getElementById('msg'+i).innerHTML = '';
				document.getElementById(inp[i]).style.backgroundColor = '';
				document.getElementById('outer'+i).style.backgroundColor = '';
			}
		}
	}
	for (i = 0; i < inpti.length; i++) {//-----------------------------半角数字のみ（TINYINT）
		var intNum = document.getElementById(inpti[i]).value;
		if(intNum.match(/[^0-9]+/)){
			document.getElementById('msgti'+i).innerHTML = '半角数字のみです';
			document.getElementById(inpti[i]).focus();
			document.getElementById(inpti[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outerti'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(intNum != ''){
				var num = intNum;
				intNum = Number(intNum);
				if(String(num) === String(intNum)){
					if(intNum >= 0 && intNum <= 127){
						document.getElementById('msgti'+i).innerHTML = '';
						document.getElementById(inpti[i]).style.backgroundColor = '';
						document.getElementById('outerti'+i).style.backgroundColor = '';
					}else{
						document.getElementById('msgti'+i).innerHTML = '0~127の数値のみです';
						document.getElementById(inpti[i]).focus();
						document.getElementById(inpti[i]).style.backgroundColor = '#ffeeee';
						document.getElementById('outerti'+i).style.backgroundColor = '#ffeeee';
						re_in = false;
					}
				}else{
					document.getElementById('msgti'+i).innerHTML = '整数のみです';
					document.getElementById(inpti[i]).focus();
					document.getElementById(inpti[i]).style.backgroundColor = '#ffeeee';
					document.getElementById('outerti'+i).style.backgroundColor = '#ffeeee';
					re_in = false;
				}
			}else{
				document.getElementById('msgti'+i).innerHTML = '';
				document.getElementById(inpti[i]).style.backgroundColor = '';
				document.getElementById('outerti'+i).style.backgroundColor = '';
			}
		}
	}
	for (i = 0; i < inpsm.length; i++) {//-----------------------------半角数字のみ（SMALLINT）
		var intNum = document.getElementById(inpsm[i]).value;
		if(intNum.match(/[^0-9]+/)){
			document.getElementById('msgsm'+i).innerHTML = '半角数字のみです';
			document.getElementById(inpsm[i]).focus();
			document.getElementById(inpsm[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outersm'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(intNum != ''){
				var num = intNum;
				intNum = Number(intNum);
				if(String(num) === String(intNum)){
					if(intNum >= 0 && intNum <= 32767){
						document.getElementById('msgsm'+i).innerHTML = '';
						document.getElementById(inpsm[i]).style.backgroundColor = '';
						document.getElementById('outersm'+i).style.backgroundColor = '';
					}else{
						document.getElementById('msgsm'+i).innerHTML = '0~32767の数値のみです';
						document.getElementById(inpsm[i]).focus();
						document.getElementById(inpsm[i]).style.backgroundColor = '#ffeeee';
						document.getElementById('outersm'+i).style.backgroundColor = '#ffeeee';
						re_in = false;
					}
				}else{
					document.getElementById('msgsm'+i).innerHTML = '整数のみです';
					document.getElementById(inpsm[i]).focus();
					document.getElementById(inpsm[i]).style.backgroundColor = '#ffeeee';
					document.getElementById('outersm'+i).style.backgroundColor = '#ffeeee';
					re_in = false;
				}
			}else{
				document.getElementById('msgsm'+i).innerHTML = '';
				document.getElementById(inpsm[i]).style.backgroundColor = '';
				document.getElementById('outersm'+i).style.backgroundColor = '';
			}
		}
	}
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
	for (i = 0; i < inps.length; i++) {//-----------------------------必須項目セレクト
		var seNo = document.getElementById(inps[i]).selectedIndex;
		if(seNo == 0){
			document.getElementById('msgs'+i).innerHTML = '必須項目を選択してください';
			document.getElementById(inps[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outers'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			document.getElementById('msgs'+i).innerHTML = '';
			document.getElementById(inps[i]).style.backgroundColor = '';
			document.getElementById('outers'+i).style.backgroundColor = '';
		}
	}
	for (i = 0; i < inpt.length; i++) {//-----------------------------半角数字小数点のみ（少数第２位まで）
		var num1 = document.getElementById(inpt[i]).value;
		if(num1.match(/[^0-9\.]+/)){
			document.getElementById('msgt'+i).innerHTML = '半角数字小数点のみです';
			document.getElementById(inpt[i]).focus();
			document.getElementById(inpt[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outert'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(num1 != ''){
				var num2 = Number(String(num1).replace( "." , "" )) / 100;//文字にして少数第２位の数値作成
				var num3 = Number(String(num1).replace( "." , "" )) / 10;//文字にして少数第１位の数値作成
				var num4 = Number(String(num1).replace( "." , "" ));//文字にして整数の数値作成
				if(num1 == num2 || num1 == num3 || num1 == num4){
					document.getElementById('msgt'+i).innerHTML = '';
					document.getElementById(inpt[i]).style.backgroundColor = '';
					document.getElementById('outert'+i).style.backgroundColor = '';
				}else{
					document.getElementById('msgt'+i).innerHTML = '少数第２位までです';
					document.getElementById(inpt[i]).focus();
					document.getElementById(inpt[i]).style.backgroundColor = '#ffeeee';
					document.getElementById('outert'+i).style.backgroundColor = '#ffeeee';
					re_in = false;
				}
			}else{
				document.getElementById('msgt'+i).innerHTML = '';
				document.getElementById(inpt[i]).style.backgroundColor = '';
				document.getElementById('outert'+i).style.backgroundColor = '';
			}
		}
	}
	for (i = 1; i <= 3; i++) {//-----------------------------沿線・駅・交通種別・分セットで入力
		if(document.getElementById('en'+i).selectedIndex != 0 ||
		document.getElementById('eki'+i).selectedIndex != 0 ||
		document.getElementById('ko'+i).selectedIndex != 0 ||
		document.getElementById('hun'+i).value != ''){
			if(document.getElementById('en'+i).selectedIndex != 0 &&
			document.getElementById('eki'+i).selectedIndex != 0 &&
			document.getElementById('ko'+i).selectedIndex != 0 &&
			document.getElementById('hun'+i).value != ''){
				document.getElementById('msgsm'+i).innerHTML = '';
				document.getElementById('en'+i).style.backgroundColor = '';
				document.getElementById('outeren'+i).style.backgroundColor = '';
				document.getElementById('eki'+i).style.backgroundColor = '';
				document.getElementById('outereki'+i).style.backgroundColor = '';
				document.getElementById('ko'+i).style.backgroundColor = '';
				document.getElementById('outerko'+i).style.backgroundColor = '';
				document.getElementById('hun'+i).style.backgroundColor = '';
				document.getElementById('outersm'+i).style.backgroundColor = '';
			}else{
				document.getElementById('msgsm'+i).innerHTML = '沿線・駅・交通種別・分セットで入力してください';
				if(document.getElementById('en'+i).selectedIndex == 0){
					document.getElementById('en'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('outeren'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('en'+i).focus();
				}
				if(document.getElementById('eki'+i).selectedIndex == 0){
					document.getElementById('eki'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('outereki'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('eki'+i).focus();
				}
				if(document.getElementById('ko'+i).selectedIndex == 0){
					document.getElementById('ko'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('outerko'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('ko'+i).focus();
				}
				if(document.getElementById('hun'+i).value == ''){
					document.getElementById('hun'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('outersm'+i).style.backgroundColor = '#ffeeee';
					document.getElementById('hun'+i).focus();
				}
				re_in = false;
			}
		}
	}
	if(re_in){document.form1.submit();}
}
function copy_h(){
	if(document.getElementById('copy').checked == true){
		document.getElementById("busub").value = '登録';
	}else{
		document.getElementById("busub").value = '変更';
	}
}
