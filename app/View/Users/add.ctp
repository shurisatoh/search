<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('menu', null, array('inline' => false));
$this->Html->script(array('check_user'),array( 'inline' => false ));
if(isset($this->request->data['User']['id'])){
	$title = 'メンバー　変更';
	$id = $this->request->data['User']['id']."\n";
	$submit = '変更';
	if($this->request->data['User']['id'] == 1){
		$aroArray = array(1=>'管理者');
	}else{
		$aroArray = array(1=>'管理者',2=>'メンバー');
	}
	$psh = '※[Password]は変更時のみ記入';
	$jsh = 'var inphe = new Array("UserUsername");'."\n";
	$jsh2 = '';
}else{
	$title = 'メンバー　登録';
	$id = '新規'."\n";
	$submit = '登録';
	$this->request->data['aro'] = 2;
	$aroArray = array(1=>'管理者',2=>'メンバー');
	$this->request->data['User']['password'] = '';
	$this->request->data['User']['password'] .= substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4);
	$this->request->data['User']['password'] .= substr(str_shuffle('1234567890'), 0, 4);
	$psh = '<span class="errmsg" id="msghe1"></span>';
	$jsh = 'var inphe = new Array("UserUsername","UserPassword");'."\n";
	$jsh2 = ' <font color="#FF0000" size="1">(必須)</font>';
}
?>
<script type="text/javascript">
//-----------------------------必須項目
var inph = new Array("UserName");
//-----------------------------必須項目英数半角
<?php echo $jsh; ?>
</script>
<p><a href="<?php echo $this->webroot.'users'; ?>">戻る</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $title; ?></p>
<?php echo $this->Form->create(false,array('class'=>'useradd','type'=>'post','url'=>'updateRecord','name'=>'form1'))."\n"; ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tbody>
      <tr>
        <td>ID</td>
        <td>
        <?php echo $id.$this->Form->hidden('User.id')."\n"; ?>
        </td>
      </tr>
      <tr>
        <td id="outerh0">氏名 <font color="#FF0000" size="1">(必須)</font></td>
        <td>
        <?php echo $this->Form->text('User.name')."\n"; ?>
        <br /><span class="errmsg" id="msgh0"></span>
        </td>
      </tr>
      <tr>
        <td id="outerhe0">UserName <font color="#FF0000" size="1">(必須)</font></td>
        <td>
        <?php echo $this->Form->text('User.username'); ?>
        <br /><span class="errmsg" id="msghe0"></span>
        </td>
      </tr>
      <tr>
        <td id="outerhe1">Password<?php echo $jsh2; ?></td>
        <td>
        <?php echo $this->Form->text('User.password'); ?>
        <br /><?php echo $psh; ?>
        </td>
      </tr>
      <tr>
        <td>権限 <font color="#FF0000" size="1">(必須)</font></td>
        <td>
        <?php echo $this->Form->select('aro',$aroArray,array('empty'=>false))."\n"; ?>
        </td>
      </tr>
    </tbody>
  </table>
  <br />
    <input type="button" id="busub" value="<?php echo $submit; ?>" onClick="check_in()">
<?php echo $this->Form->hidden('Aro.id').$this->Form->end()."\n"; ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0" style="border-style: none;">
      <tr>
        <td style="border-style: none;text-align: left;">
        <font size="-1">※権限：「管理者：登録・変更・削除・設定」<br />
        　「メンバー：登録・変更・削除」が出来ます。</font>
        </td>
      </tr>
  </table>
<div class="copyright">
<hr width="600" size="1">
不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
