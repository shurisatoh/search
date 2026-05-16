//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function googlemap_ad1(){
var value1 =encodeURI(document.getElementById("ad1").value);
var value2 = '../Menu/googlemap?q='+value1+'&map=1';
window.open(value2, '_blank')
}
function googlemap_ad2(){
var value1 =encodeURI(document.getElementById("ad1").value);
var value2 =encodeURI(document.getElementById("ad2").value);
var value3 = '../Menu/googlemap?q='+value1+value2+'&map=2';
window.open(value3, '_blank')
}
