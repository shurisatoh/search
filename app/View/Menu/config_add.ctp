<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('menu', null, array('inline' => false));
//-----------------------------------------------------------------セレクトメニュー
$select_array = array(
	array(0,'',''),
	array(1,'../Vendor/configTopPage.php','トップページ'),
	array(2,'../Vendor/configGoogleMapsApiKey.php','GoogleMap'),
	array(3,'../Vendor/configContact.php','お問合せ'),
	array(4,'../Vendor/configRent.php','賃貸'),
	array(5,'../Vendor/configRentEki.php','賃貸　駅'),
	array(6,'../Vendor/configHouse.php','売買'),
	array(7,'../Vendor/configHouseEki.php','売買　駅'),
	array(12,'../Vendor/reference.txt','リファレンス')
);
//-----------------------------------------------------------------更新
if(!empty($this->request->data['config_open'])){
	if (get_magic_quotes_gpc()){
		$this->request->data['config_file'] = stripslashes($this->request->data['config_file']);
	}
	$filepointer = fopen($this->request->data['config_open'], "w");
	flock($filepointer, LOCK_EX);
	fputs($filepointer, $this->request->data['config_file']);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);
}
//-----------------------------------------------------------------開く

if(!empty($this->request->data['open'])){

	foreach( $select_array as $value ){
		if($this->request->data['open'] == $value[0]){
			$config_file = file_get_contents($value[1]);
			//$config_file = htmlspecialchars($config_file);
			$config_open = $value[1];
			$select = $value[2].
$this->Form->hidden('config_open',array('value'=>$value[1]))."\n".
'<div id="container">'."\n".
$this->Form->textarea('config_file',array('id'=>'code','value'=>$config_file))."\n".
'</div>
<script>
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
	lineNumbers: true,
	matchBrackets: true,
	mode: "application/x-httpd-php",
	indentUnit: 4,
	indentWithTabs: true,
	enterMode: "keep",
	tabMode: "shift"
});
</script>'."\n";
			$submit = '更新';
			$button = '<input type="button" onclick="location.href=\'./configAdd\'"value="中止">　';
			break;
		}
	}
}else{
	$formSelect = array();
	foreach( $select_array as $value ){
		$formSelect[$value[0]] = $value[2];
	}
	$select = $this->Form->select('open',$formSelect,array('empty'=>false))."\n";
	$submit = '開く';
	$button = '<input type="button" value="閉じる" onClick="window.close()">　';
}
?>
<link rel="stylesheet" href="../js/codemirror-3.02/lib/codemirror.css">
<script src="../js/codemirror-3.02/lib/codemirror.js"></script>
<script src="../js/codemirror-3.02/addon/edit/matchbrackets.js"></script>
<script src="../js/codemirror-3.02/mode/htmlmixed/htmlmixed.js"></script>
<script src="../js/codemirror-3.02/mode/xml/xml.js"></script>
<script src="../js/codemirror-3.02/mode/javascript/javascript.js"></script>
<script src="../js/codemirror-3.02/mode/css/css.js"></script>
<script src="../js/codemirror-3.02/mode/clike/clike.js"></script>
<script src="../js/codemirror-3.02/mode/php/php.js"></script>
<style type="text/css">
.CodeMirror {border: 1px solid #999;height: 500px;}
#container {width: 1000px;margin-right: auto;margin-left: auto;text-align: left;}
#page_title {margin-bottom: 50px;}
</style>
<p id="page_title">不動産検索システム ebs3 Config　各種設定</p>
<?php
echo $this->Form->create(false,array('type'=>'post','url'=>'configAdd'))."\n".
	$select."\n".
	'<p>'.$button.$this->Form->end(array('label'=>$submit,'div'=>false))."</p>\n";
?>
<div class="copyright">
<hr width="600" size="1">
不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
