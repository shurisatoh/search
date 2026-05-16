//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function check(me){
	if(window.confirm('「'+me+'」　を削除してもよろしいですか？')){
		return true;
	}
	else{
		return false;
	}
}
function check_title(fno){
	if(document.forms['form'+fno].title.value.match(/<>/)){
		document.getElementById('title_msg'+fno).innerHTML = '半角【<>】は入力禁止です。';
		document.forms['form'+fno].title.style.backgroundColor = '#ffeeee';
		document.forms['form'+fno].title.focus();
		return false;
	}else{
		document.getElementById('title_msg'+fno).innerHTML = '';
		document.forms['form'+fno].title.style.backgroundColor = '';
		return true;
	}
}
function check_in(fno){
	var re_in = true;
	if(document.forms['form'+fno].id.value != '' && 0 == document.forms['form'+fno].bu.selectedIndex){
		document.getElementById('no_msg'+fno).innerHTML = '分類が選択されてません<br />';
		document.forms['form'+fno].bu.style.backgroundColor = '#ffeeee';
		document.forms['form'+fno].bu.focus();
		re_in = false;
	}else{
		document.getElementById('no_msg'+fno).innerHTML = '';
		document.forms['form'+fno].bu.style.backgroundColor = '';
	}
	var me = document.getElementById('no_msg'+fno).innerHTML;
	if(0 != document.forms['form'+fno].bu.selectedIndex && document.forms['form'+fno].id.value == ''){
		if(me == ''){
			document.getElementById('no_msg'+fno).innerHTML = '物件番号が入力されてません。<br />';
		}else{
			document.getElementById('no_msg'+fno).innerHTML = me+'物件番号が入力されてません。<br />';
		}
		document.forms['form'+fno].id.style.backgroundColor = '#ffeeee';
		document.forms['form'+fno].id.focus();
		re_in = false;
	}else if(document.forms['form'+fno].id.value.match(/[^0-9]+/)){
		if(me == ''){
			document.getElementById('no_msg'+fno).innerHTML = '半角数字のみです。<br />';
		}else{
			document.getElementById('no_msg'+fno).innerHTML = me+'半角数字のみです。<br />';
		}
		document.forms['form'+fno].id.style.backgroundColor = '#ffeeee';
		document.forms['form'+fno].id.focus();
		re_in = false;
	}else{
		document.forms['form'+fno].id.style.backgroundColor = '';
	}

	if(document.forms['form'+fno].co.value.match(/<>/)){
		document.getElementById('co_msg'+fno).innerHTML = '半角【<>】は入力禁止です。<br />';
		document.forms['form'+fno].co.style.backgroundColor = '#ffeeee';
		re_in = false;
	}else{
		document.getElementById('co_msg'+fno).innerHTML = '';
		document.forms['form'+fno].co.style.backgroundColor = '';
	}
	if(re_in){return true;}else{return false;}
}
