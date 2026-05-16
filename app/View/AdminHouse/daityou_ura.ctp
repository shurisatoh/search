<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.daityou', null, array('inline' => false));
App::import('Vendor', 'configHouse');
$urinusikeiArr = urinusikeiArr();
$torihikitaiArr = torihikitaiArr();

if(!empty($data[$modelName]['siryou_img'])){
	if($data[$modelName]['siryou_img'] == 1){
		$data[$modelName]['siryou_img'] = '<a href="./imgRoad?no='.$data[$modelName]['id'].'" target="_blank">'.
			'<img src="./imgRoad?no='.$data[$modelName]['id'].'" title="物件資料：'.$data[$modelName]['siryou_co'].'" width="800" border="0" /></a>';
	}else{
		$data[$modelName]['siryou_img'] = '<a href="./imgRoad?no='.$data[$modelName]['id'].'" target="_blank">'.
			'<img src="./imgRoad?no='.$data[$modelName]['id'].'" title="物件資料：'.$data[$modelName]['siryou_co'].'" height="800" border="0" /></a>';
	}
}else{
	$data[$modelName]['siryou_img'] = '';
}
?>
<div align="center" id="leftcol">
<p  id="page_title">
不動産検索システム ebs3 管理 <font color="#0000FF">売買</font> 台帳 裏
<a href="javascript:history.back();" style="font-size:small;margin-left:50px;">戻る</a>
</p>
</div>
<table width="1300" height="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="400" align="left" valign="bottom" id="td2"><table width="350" height="500" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><p>物件番号：<?php echo $data[$modelName]['id']; ?></p>
          <p>登録日：
            <?php echo $data[$modelName]['touroku_date']; ?>
            </p>
<?php //if($view_array['root'] == 'm'){echo '<p>号室：'.$view['data'][45].'号室</p>';}
echo '<p>売主形態：'.$urinusikeiArr[$data[$modelName]['urinusikei']].'</p>
<p>取引態様：'.$torihikitaiArr[$data[$modelName]['torihikitai']].'</p>
<p>受取報酬：'.$data[$modelName]['uketorikei'].'</p>
<p>売主 氏名（会社）：'.$data[$modelName]['u_simei'].'</p>
<p>売主 担当：'.$data[$modelName]['u_tantou'].'</p>
<p>売主 住所：'.$data[$modelName]['u_zyuusyo'].'</p>
<p>売主 TEL：'.$data[$modelName]['u_tel'].'</p>
<p>売主 FAX：'.$data[$modelName]['u_fax'].'</p>
<p>鍵所在：'.$data[$modelName]['kagi_syozai'].'</p>
<p>入力者：'.$data[$modelName]['nyuuryokusya'].'</p>
<p>備考：'.$data[$modelName]['bikou'].'</p>';
?>
</td>
      </tr>
    </table></td>
    <td align="center" valign="middle"><table width="640" height="640" border="0" align="center" id="td1">
  <tr>
    <td align="center" valign="middle" id="td1">
<?php echo $data[$modelName]['siryou_img']; ?></td>
  </tr>
</table></td>
  </tr>
</table>
<div class="leftcol">
<div class="copyright">
	<hr width="950" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>
