<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.zyouhou', null, array('inline' => false));
App::import('Vendor', 'configHouse');
$syubetuArr = syubetuArr();
$sintikuArr = sintikuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$eki_koArr = eki_koArr();
$kouzouArr = kouzouArr();

App::import('Vendor', 'configHouseEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();

$koutuu = '';
if(!empty($data[$modelName]['eki_en1']) && !empty($data[$modelName]['eki_eki1']) &&
	!empty($data[$modelName]['eki_ko1']) && !empty($data[$modelName]['eki_hun1'])){
	$koutuu = $ensenArr[$data[$modelName]['eki_en1']].' '.
			$ekiArr[$data[$modelName]['eki_en1']][$data[$modelName]['eki_eki1']].' '.
			$eki_koArr[$data[$modelName]['eki_ko1']].' '.$data[$modelName]['eki_hun1'].'分';
}
if(!empty($data[$modelName]['eki_en2']) && !empty($data[$modelName]['eki_eki2']) &&
	!empty($data[$modelName]['eki_ko2']) && !empty($data[$modelName]['eki_hun2'])){
	$koutuu .= '<br />'.$ensenArr[$data[$modelName]['eki_en2']].' '.
			$ekiArr[$data[$modelName]['eki_en2']][$data[$modelName]['eki_eki2']].' '.
			$eki_koArr[$data[$modelName]['eki_ko2']].' '.$data[$modelName]['eki_hun2'].'分';
}
if(!empty($data[$modelName]['eki_en3']) && !empty($data[$modelName]['eki_eki3']) &&
	!empty($data[$modelName]['eki_ko3']) && !empty($data[$modelName]['eki_hun3'])){
	$koutuu .= '<br />'.$ensenArr[$data[$modelName]['eki_en3']].' '.
			$ekiArr[$data[$modelName]['eki_en3']][$data[$modelName]['eki_eki3']].' '.
			$eki_koArr[$data[$modelName]['eki_ko3']].' '.$data[$modelName]['eki_hun3'].'分';
}

//--金額カンマ挿入処理
$nfArray = array('kakaku');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]);
	}
}

$imgFile  = array(
	array('gaikan_img','300'),
	array('madori_img','300')
);
foreach( $imgFile as $va ){
	if(!empty($data[$modelName][$va[0]])){
		if($data[$modelName][$va[0]] == 1){
			$data[$modelName][$va[0]] = '<img src="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" width="'.$va[1].'" border="0" />';
		}else{
			$data[$modelName][$va[0]] = '<img src="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" height="'.$va[1].'" border="0" />';
		}
	}else{
		$data[$modelName][$va[0]] = '<img src="../img/noimage300.gif" border="0" />';
	}
}
$data[$modelName]['comment'] = preg_replace("/\n/", '<br />', $data[$modelName]['comment']);
?>
<div align="center" id="leftcol">
<p  id="page_title">不動産検索システム ebs3 管理 <font color="#0000FF">売買</font> 情報誌</p>
<br /><br />
</div>
<table cellspacing="1" cellpadding="5" align="center" bgcolor="#ffffff">
  <tbody>
    <tr>
      <td align="center" bgcolor="#ffffff" height="29" width="310">
        <font size="+2"><?php echo $koutuu; ?></font>
      </td>
      <td align="center" bgcolor="#ffffff" height="29" width="310">
        <font size="+3"><i>
        <?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?>
        </i></font>
        <br />価格
        <font size="+3"><?php echo $data[$modelName]['kakaku']; ?></font>
        <font size="+0">万円</font>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#ffffff" height="279" width="310">
        <?php echo $data[$modelName]['gaikan_img']; ?>
      </td>
      <td align="center" bgcolor="#ffffff" height="279" width="310">
        <?php echo $data[$modelName]['madori_img']; ?>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#ffffff" colspan="2" height="33">
        <font size="+1"><?php echo $data[$modelName]['comment']; ?></font>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="center" valign="middle" height="39">
        <font size="+1">
        <?php echo $kouzouArr[$data[$modelName]['kouzou']].'造 ／ '.$data[$modelName]['tiku_nen'].'年築'; ?>
        </font>
      </td>
      <td bgcolor="#ffffff" align="center" valign="middle" height="39">
        <font size="+1">
        <?php echo $syubetuArr[$data[$modelName]['syubetu']]; ?>
        </font>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ffffff" valign="middle" align="center" height="39">
        <font size="+1">
        <?php echo $data[$modelName]['bu_zyuusyo1'].'　　　　　　　　　　No.'.$data[$modelName]['id']; ?>
        </font>
      </td>
    </tr>
  </tbody>
</table>
<div id="leftcol">
<div class="copyright">
	<hr width="700" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>
