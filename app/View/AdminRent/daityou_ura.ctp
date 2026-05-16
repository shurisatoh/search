<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.daityou.t', null, array('inline' => false));

if(!empty($data[$modelName]['siryou_img'])){
	if($data[$modelName]['siryou_img'] == 1){
		$data[$modelName]['siryou_img'] = '<a href="./imgRoad?no='.$data[$modelName]['id'].'" target="_blank">'.
			'<img src="./imgRoad?no='.$data[$modelName]['id'].'" title="物件資料：'.$data[$modelName]['siryou_co'].'" width="500" border="0" /></a>';
	}else{
		$data[$modelName]['siryou_img'] = '<a href="./imgRoad?no='.$data[$modelName]['id'].'" target="_blank">'.
			'<img src="./imgRoad?no='.$data[$modelName]['id'].'" title="物件資料：'.$data[$modelName]['siryou_co'].'" height="500" border="0" /></a>';
	}
}else{
	$data[$modelName]['siryou_img'] = '';
}
?>
<div align="center" id="leftcol">
<p  id="page_title">
不動産検索システム ebs3 管理 <font color="#FF0000">賃貸</font> 台帳 裏
<a href="javascript:history.back();" style="font-size:small;margin-left:50px;">戻る</a>
</p>
</div>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td colspan="26" height="545" align="right" valign="bottom">

<table width="500" height="500" border="0" align="center" id="no_border">
  <tr>
    <td align="center" valign="middle" id="no_border"><?php echo $data[$modelName]['siryou_img']; ?></td>
  </tr>
</table>
<br>
物件番号：<?php echo $data[$modelName]['id']; ?>　／　登録日：<?php echo $data[$modelName]['touroku_date']; ?><font color="#FFFFFF">＿＿</font></td>
    </tr>
    <tr>
      <td colspan="23" width="120" height="34">鍵所在（ｵｰﾄﾛｯｸ）</td>
      <td width="210" align="right" height="34"><?php echo $data[$modelName]['kagi_syozai']; ?>（ <?php echo $data[$modelName]['autolock']; ?> ）</td>
      <td width="120" height="34">ＢＫ</td>
      <td width="210" height="34" align="center"><?php echo $data[$modelName]['koukokuryou']; ?></td>
    </tr>
    <tr>
      <td colspan="23" height="35">家主名</td>
      <td height="35" align="center"><?php echo $data[$modelName]['yanusi_mei']; ?>　</td>
      <td height="35">管理会社（担当）</td>
      <td height="35" align="center"><?php echo $data[$modelName]['kanri_mei'].'（'.$data[$modelName]['kanri_tantou']; ?>）　</td>
    </tr>
    <tr>
      <td colspan="23" height="31">家主　住所</td>
      <td height="31" align="center"><?php echo $data[$modelName]['yanusi_zyuu']; ?>　</td>
      <td height="31">管理会社　住所</td>
      <td height="31" align="center"><?php echo $data[$modelName]['kanri_zyuu']; ?>　</td>
    </tr>
    <tr>
      <td colspan="23" height="35">家主　TEL</td>
      <td height="35" align="center"><?php echo $data[$modelName]['yanusi_tel']; ?>　</td>
      <td height="35">管理会社　TEL</td>
      <td height="35" align="center"><?php echo $data[$modelName]['kanri_tel']; ?>　</td>
    </tr>
    <tr>
      <td colspan="23" height="30">家主　FAX</td>
      <td height="30" align="center"><?php echo $data[$modelName]['yanusi_fax']; ?>　</td>
      <td height="30">管理会社　FAX</td>
      <td height="30" align="center"><?php echo $data[$modelName]['kanri_fax']; ?>　</td>
    </tr>
    <tr>
      <td colspan="23" height="30">家主　Email</td>
      <td height="30" align="center"><?php echo $data[$modelName]['yanusi_email']; ?>　</td>
      <td height="30">管理会社　Email</td>
      <td height="30" align="center"><?php echo $data[$modelName]['kanri_email']; ?>　</td>
    </tr>
    <tr>
      <td colspan="23" height="27">必要書類　法人</td>
      <td height="27">　</td>
      <td rowspan="4">振込先</td>
      <td height="27">　　銀行</td>
    </tr>
    <tr>
      <td colspan="23" height="29">必要書類　個人</td>
      <td height="29">　</td>
      <td height="29">（当座・普通）No.</td>
    </tr>
    <tr>
      <td colspan="23" height="31">管理人　氏名</td>
      <td height="31">　</td>
      <td rowspan="2">ﾌﾘｶﾞﾅ<br>名義</td>
    </tr>
    <tr>
      <td colspan="23" height="30">管理人　TEL</td>
      <td height="30">　</td>
    </tr>
    <tr>
      <td colspan="26" valign="top" height="126">備考　　　（入力者：<?php echo $data[$modelName]['nyuuryokusya']; ?>）<br>
        <br>
      <?php echo $data[$modelName]['daityou_bi']; ?></td>
    </tr>
</tbody>
</table>
<div class="leftcol">
<div class="copyright">
	<hr width="700" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>
