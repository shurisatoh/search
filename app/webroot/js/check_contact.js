

function check_in(){
	var re_in = true;
	for (i = 0; i < inph.length; i++) {
		if(document.getElementById(inph[i]).value == ''){
			document.getElementById('msgh'+i).innerHTML = '必須項目です';
			document.getElementById(inph[i]).focus();
			document.getElementById(inph[i]).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			document.getElementById('msgh'+i).innerHTML = '';
			document.getElementById(inph[i]).style.backgroundColor = '';
		}
	}
	
	for (i = 0; i < inpe.length; i++) {
		if(document.getElementById(inpe[i]).value == ''){
			document.getElementById('msge'+i).innerHTML = '必須項目です';
			document.getElementById(inpe[i]).focus();
			document.getElementById(inpe[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('msgec'+i).innerHTML = '';
			document.getElementById(inpec[i]).style.backgroundColor = '';
		}else{
			if(document.getElementById(inpe[i]).value.match(/^[0-9a-zA-Z][0-9a-zA-Z\-_\.]+\@[0-9a-zA-Z]+[0-9a-zA-Z\-_\.]*\.[0-9a-zA-Z]{2,4}$/)){
				document.getElementById('msge'+i).innerHTML = '';
				document.getElementById(inpe[i]).style.backgroundColor = '';
				for (i = 0; i < inpec.length; i++) {
					if(document.getElementById(inpec[i]).value != document.getElementById(inpe[i]).value){
						document.getElementById('msgec'+i).innerHTML = 'E-mailが一致しません';
						document.getElementById(inpec[i]).focus();
						document.getElementById(inpec[i]).style.backgroundColor = '#ffeeee';
						re_in = false;
					}else{
						document.getElementById('msgec'+i).innerHTML = '';
						document.getElementById(inpec[i]).style.backgroundColor = '';
					}
				}
			}else{
				document.getElementById('msge'+i).innerHTML = 'E-mailが正しくありません';
				document.getElementById(inpe[i]).focus();
				document.getElementById(inpe[i]).style.backgroundColor = '#ffeeee';
				re_in = false;
			}
		}
	}
	
	
	
	if(re_in){document.formCo.submit();}
}
function check_in1(){
	formCo.action="./contact";
	document.formCo.submit();
}
function check_in2(){
	formCo.action="./contact3";
	document.formCo.submit();

}

