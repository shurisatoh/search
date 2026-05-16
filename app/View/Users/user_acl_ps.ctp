<?php

$aliasArray = array('admin'=>'admin','member'=>'member');

foreach( $userData as $da ){
	$aliasArray[$da['User']['username']] = $da['User']['name'].$da['User']['username'];
}
foreach( $userData as $da ){
	$userIdArray[$da['User']['id']] = $da['User']['name'].$da['User']['username'];
}

$parent_idArray = array(1=>'admin',2=>'member');

$aroaco1Array = array('allow'=>'許可','deny'=>'不許可');
/*
$aroaco3Ar = array('users','board','calendar','timerecorder','importis','menu','reform');
foreach( $aroaco3Ar as $da ){
	$aroaco3Array[$da] = $da;
}
*/
$aroaco4Array = array('create'=>'新規作成','read'=>'読み込み','update'=>'更新','delete'=>'削除');

if(empty($this->request->data['User']['password'])){
	$abc = 'abcdefghijklmnopqrstuvwxyz';
	$no123 = '1234567890';
	$this->request->data['User']['password'] = '';
	$this->request->data['User']['password'] .= substr(str_shuffle($abc), 0, 2);
	$this->request->data['User']['password'] .= substr(str_shuffle($no123), 0, 4);
}
$arosTable = '';
$aro_deleteArray = array();
foreach( $arosData as $da ){
	$parentId[$da['Aro']['id']] = $da['Aro']['alias'];
	if($da['Aro']['parent_id'] != ''){
		$da['Aro']['parent_id'] = $parentId[$da['Aro']['parent_id']];
	}
	$da['Aro']['alias'] = $aliasArray[$da['Aro']['alias']];
	$arosTable .= '<tr>';
	foreach( $da['Aro'] as $key2 => $da2 ){
		$arosTable .= '<td>'.$da2.'</td>';
	}
	$arosTable .= '</tr>'."\n";
	$aro_deleteArray[$da['Aro']['id']] = $da['Aro']['id'];
}
$acosTable = '';
$aco_deleteArray = array();
foreach( $acosData as $da ){
	$acoId[$da['Aco']['id']] = $da['Aco']['alias'];
	$aroaco3Array[$da['Aco']['alias']] = $da['Aco']['alias'];
	$acosTable .= '<tr>';
	foreach( $da['Aco'] as $da2 ){
		$acosTable .= '<td>'.$da2.'</td>';
	}
	$acosTable .= '</tr>'."\n";
	$aco_deleteArray[$da['Aco']['id']] = $da['Aco']['id'];
}
$aroacosTable = '';
$aroaco_deleteArray = array();
foreach( $aroacoData as $da ){
	$aroacosTable .= '<tr>';
	foreach( $da['Aros_aco'] as $key2 => $da2 ){
		if($key2 == 'aro_id' && $da2 != ''){$da2 = $aliasArray[$parentId[$da2]];}
		if($key2 == 'aco_id' && $da2 != ''){$da2 = $acoId[$da2];}
		$aroacosTable .= '<td>'.$da2.'</td>';
	}
	$aroacosTable .= '</tr>'."\n";
	$aroaco_deleteArray[$da['Aros_aco']['id']] = $da['Aros_aco']['id'];
}
?>
<style type="text/css">
table {
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: dotted;
	border-left-style: dotted;
	border-top-color: #000;
	border-left-color: #000;
}
td {
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-right-style: dotted;
	border-bottom-style: dotted;
	border-right-color: #000;
	border-bottom-color: #000;
}
</style>
<p>&nbsp;</p>
<table align="center" border="0" cellpadding="5" cellspacing="0">
<tr><td valign="top">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#aroForm','id'=>'aroForm'))."\n"; ?>
  <table border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2">権限者追加[ARO]</td>
      </tr>
      <tr>
        <td>メンバー追加</td>
        <td>
        <?php echo $this->Form->select('alias',$aliasArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>メンバー名属する権限</td>
        <td>
        <?php echo $this->Form->select('parent_id',$parent_idArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->hidden("aro",array('value'=>1))."\n"; ?>
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td>[ARO]メンバー削除</td>
        <td>
        <?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#aroForm'))."\n".
        $this->Form->select('aro_delete',$aro_deleteArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="copyright">Copyright © ITS All Rights Reserved</td>
      </tr>
  </table>
</td><td>
<table border="0" cellpadding="5" cellspacing="0">
<?php
echo '<tr><td colspan="'.count($arosData[0]['Aro']).'">メンバー[Aro]</td></tr>'."\n";
echo '<tr>';
foreach( $arosData[0]['Aro'] as $key => $da ){
	echo '<td>'.$key.'</td>';
}
echo '</tr>'."\n".$arosTable;
?>
</table>
</td></tr><tr><td valign="top">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#acoForm','id'=>'acoForm'))."\n"; ?>
  <table border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2">クラスの追加[ACO]</td>
      </tr>
      <tr>
        <td>クラス名</td>
        <td>
        <?php echo $this->Form->text('alias')."\n"; ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->hidden("aco",array('value'=>1))."\n"; ?>
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td>[ACO]クラス削除</td>
        <td>
        <?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#acoForm'))."\n".
        $this->Form->select('aco_delete',$aco_deleteArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="copyright">Copyright © ITS All Rights Reserved</td>
      </tr>
  </table>
</td><td>
<table border="0" cellpadding="5" cellspacing="0">
<?php
echo '<tr><td colspan="'.count($acosData[0]['Aco']).'">クラス[Aco]</td></tr>'."\n";
echo '<tr>';
foreach( $acosData[0]['Aco'] as $key => $da ){
	echo '<td>'.$key.'</td>';
}
echo '</tr>'."\n".$acosTable;
?>
</table>
</td></tr><tr><td valign="top">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#aroacoForm','id'=>'aroacoForm'))."\n"; ?>
  <table border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2">メンバー・クラス関連付[AroAco]</td>
      </tr>
      <tr>
        <td>許可・不許可</td>
        <td>
        <?php echo $this->Form->select('aroaco1',$aroaco1Array,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>メンバー名</td>
        <td>
        <?php echo $this->Form->select('aroaco2',$aliasArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>クラス名</td>
        <td>
        <?php echo $this->Form->select('aroaco3',$aroaco3Array,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>権限</td>
        <td>
        <?php echo $this->Form->select('aroaco4',$aroaco4Array,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->hidden("aroaco",array('value'=>1))."\n"; ?>
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td>[AroAco]削除</td>
        <td>
        <?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#aroacoForm'))."\n".
        $this->Form->select('aroaco_delete',$aroaco_deleteArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->end('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="copyright">Copyright © ITS All Rights Reserved</td>
      </tr>
  </table>
<pre style="text-align: left;">
[board]
-index-read
-add-read
-updateRecord-read
-member-create
-memberUpdateRecord-create
-memberDelRecord-create

[calendar]
-index-read
-edit-create
-edit2-create
-updateRecord-create
-holiday-create
-member-create
-memberUpdateRecord-create
-memberDelRecord-create
-config-create
-recordCheck-create
-copy-create

[importis]
-index-read
-key-read
-mailbox-read
-carProof-read
-building-read
-building2-read
-import-create

[menu]
-index-read
-setting-read

[reform]
-index-read
-seikyuuDaityou-read
-seikyuuAdd-read
-updateRecord-read
-delRecord-read
-tokuisakiMototyou-read
-tukiRuikei-read
-nyuukin-read
-nyuukinAdd-read

[soumu]
index-read
yuukyuu-create
syuugyou-update
syuugyouMember-update

[timerecorder]
-index-read
-updateRecord-read
-recordCheck-read
-member-create
-memberUpdateRecord-create
-memberDelRecord-create
-tmList-create

[users]
-index-create
-add-create
-updateRecord-create
-delRecord-create
-logout-read
-userAclPs-update
</pre>
</td><td valign="top">
<table border="0" cellpadding="5" cellspacing="0">
<?php
echo '<tr><td colspan="'.count($aroacoData[0]['Aros_aco']).'">メンバー・クラス関連[AroAco]</td></tr>'."\n";
echo '<tr>';
foreach( $aroacoData[0]['Aros_aco'] as $key => $da ){
	echo '<td>'.$key.'</td>';
}
echo '</tr>'."\n".$aroacosTable;
?>
</table>
</td></tr>
<tr><td valign="top">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#psForm','id'=>'psForm'))."\n"; ?>
  <table border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2">パスワード設定</td>
      </tr>
      <tr>
        <td>設定者</td>
        <td>
        <?php echo $this->Form->select('User.id',$userIdArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>パスワード</td>
        <td>
        <?php echo $this->Form->text('User.password')."\n"; ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->hidden("ps",array('value'=>1))."\n"; ?>
        <?php echo $this->Form->submit('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="copyright">Copyright © ITS All Rights Reserved</td>
      </tr>
  </table>
<?php echo $this->Form->end(); ?>
<p>&nbsp;</p>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'userAclPs#psForm'))."\n"; ?>
  <table border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2">username設定</td>
      </tr>
      <tr>
        <td>設定者</td>
        <td>
        <?php echo $this->Form->select('User.id',$userIdArray,array('empty'=>''))."\n";?>
        </td>
      </tr>
      <tr>
        <td>username</td>
        <td>
        <?php echo $this->Form->text('User.username')."\n"; ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <?php echo $this->Form->hidden("ps",array('value'=>1))."\n"; ?>
        <?php echo $this->Form->submit('Enter'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="copyright">Copyright © ITS All Rights Reserved</td>
      </tr>
  </table>
<?php echo $this->Form->end(); ?>
</td><td>
<table border="0" cellpadding="5" cellspacing="0">
<?php
echo '<tr><td colspan="'.count($userData[0]['User']).'">メンバー[User]</td></tr>'."\n";
echo '<tr>';
foreach( $userData[0]['User'] as $key => $da ){
	echo '<td>'.$key.'</td>';
}
echo '</tr>'."\n";
foreach( $userData as $da ){
	echo '<tr>';
	foreach( $da['User'] as $key2 => $da2 ){
		echo '<td>'.$da2.'</td>';
	}
	echo '</tr>'."\n";
}
?>
</table>
</td>
</tr>
</table>
<p>&nbsp;</p>
<?php //print_r($arosData);?>
<?php //print_r($arosData);?>

