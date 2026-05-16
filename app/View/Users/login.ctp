<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

echo $this->Html->css('menu');
?>
<br /><br />
ebs3&nbsp;&nbsp;<?php echo $title_for_layout; ?><br />
<?php
echo $this->Form->create('User', array('url'=>'login','id'=>'loginform'))."\n".
$this->Form->input('username',array('label' => array('text' =>'UserName'),'style'=>'width:150px'))."\n".
$this->Form->input('password',array('label' => array('text' =>'Password'),'style'=>'margin-left:8px;width:150px'))."\n".
$this->Form->end('Login');
?>
