<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('menu', null, array('inline' => false));
$this->Html->script(array('search'),array( 'inline' => false ));
$list = '';
foreach( $data as $da ){
	if($da['User']['id'] == 1){
		$list .= '<tr>
<td>'.$da['User']['id'].'</td>
<td>'.$da['User']['name'].'</td>
<td>'
.$this->Form->create(false,array('type'=>'post','url'=>"add"))."\n"
.$this->Form->hidden('User.id',array('value'=>$da['User']['id']))."\n"
.$this->Form->hidden('Aro.id',array('value'=>$da['Aro']['id']))."\n"
.$this->Form->hidden('aro',array('value'=>$da['Aro']['parent_id']))."\n"
.$this->Form->end('変更')."\n".'
</td>
<td>&nbsp;</td>
<tr>';
	}else{
		$list .= '<tr>
<td>'.$da['User']['id'].'</td>
<td>'.$da['User']['name'].'</td>
<td>'
.$this->Form->create(false,array('type'=>'post','url'=>"add"))."\n"
.$this->Form->hidden('User.id',array('value'=>$da['User']['id']))."\n"
.$this->Form->hidden('Aro.id',array('value'=>$da['Aro']['id']))."\n"
.$this->Form->hidden('aro',array('value'=>$da['Aro']['parent_id']))."\n"
.$this->Form->end('変更')."\n".'
</td>
<td>'
.$this->Form->create(false,array('type'=>'post','url'=>"delRecord",'onSubmit'=>"return check('ID:{$da['User']['id']}')"))."\n"
.$this->Form->hidden('User.id',array('value'=>$da['User']['id']))."\n"
.$this->Form->hidden('Aro.id',array('value'=>$da['Aro']['id']))."\n"
.$this->Form->end('削除')."\n".'
</td>
<tr>';
	}
}
?>
<p><?php echo $title_for_layout; ?></p>
<table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="4" class="title">
      <?php echo $this->Form->create(false,array('type'=>'post','url'=>'add'))."\n".
$this->Form->end('メンバー登録')."\n"; ?>
      <?php //echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs'))."\n".$this->Form->end('userAclPs')."\n"; ?>
    </td>
  </tr>
  <tr>
    <td>ID</td>
    <td>名前</td>
    <td>変更</td>
    <td>削除</td>
  </tr>
<?php echo $list; ?>
</table>
  <table align="center" border="0" cellpadding="5" cellspacing="0" style="border-style: none;">
      <tr>
        <td style="border-style: none;text-align: left;">
        <font size="-1">※ID:1デフォルトの管理者は、削除出来ません。</font>
        </td>
      </tr>
  </table>
<div class="copyright">
<hr width="600" size="1">
不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
