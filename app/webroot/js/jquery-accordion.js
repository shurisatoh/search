/*jQueryで超簡単アコーディオン---------------------------------------------------*/
$(document).ready(function(){
	$('.accordion_head').click(function() {
	$(this).next().slideToggle();
	if(document.getElementById("setubi_menu").innerHTML == 'Features ↓Open Click'){
		document.getElementById('setubi_menu').innerHTML = 'Features ↑Close Click';
	}else{
		document.getElementById('setubi_menu').innerHTML = 'Features ↓Open Click';
	}
	}).next().hide();
});

