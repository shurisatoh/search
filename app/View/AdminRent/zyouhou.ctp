<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.zyouhou', null, array('inline' => false));
App::import('Vendor', 'configRent');
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$hosyou_kuArr = hosyou_kuArr();
$kaiyaku_kuArr = kaiyaku_kuArr();
$kouzouArr = kouzouArr();
$eki_koArr = eki_koArr();
App::import('Vendor', 'configRentEki');
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
$nfArray = array('yatin_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]);
	}
}
//--金額カンマ挿入+円追加処理
$nfArray = array('kyoueki_k','hosyou_k','kaiyaku_k','tyuusya_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]).'円';
	}
}

$imgFile  = array(
	array('gaikan_img','300'),
	array('madori_img','300')
);
foreach( $imgFile as $va ){
	if(!empty($data[$modelName][$va[0]])){
		if($data[$modelName][$va[0]] == 1){
			$data[$modelName][$va[0]] = '<img src="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" width="'.$va[1].'" border="0" />';
		}else{
			$data[$modelName][$va[0]] = '<img src="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" height="'.$va[1].'" border="0" />';
		}
	}else{
		$data[$modelName][$va[0]] = '<img src="../img/noimage300.gif" border="0" />';
	}
}
$data[$modelName]['comment'] = preg_replace("/\n/", '<br />', $data[$modelName]['comment']);
?>
<div align="center" id="leftcol">
<p  id="page_title">不動産検索システム ebs3 管理 <font color="#FF0000">賃貸</font> 情報誌</p>
<br /><br />
</div>
<table cellspacing="1" cellpadding="5" align="center" bgcolor="#ffffff">
  <tbody>
    <tr>
      <td align="center" bgcolor="#ffffff" height="29" width="310">
        <font size="+2"><?php echo $koutuu; ?></font>
      </td>
      <td align="center" bgcolor="#ffffff" height="29" width="310">
        <font size="+3"><i><font size="+3">
        <?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?>
        </font>
        <font size="+3"><br />　</font></i></font><font size="+2"><font size="+0">家賃</font>
        <font size="+2"> </font></font>
        <font size="+3"><?php echo $data[$modelName]['yatin_k']; ?></font><font size="+0">円</font>
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
      <td colspan="2" bgcolor="#ffffff" align="center" valign="middle" height="39">
        <font size="+1">
        <?php echo $hosyou_kuArr[$data[$modelName]['hosyou_ku']].' '.$data[$modelName]['hosyou_k'].' ／ '.
        $kaiyaku_kuArr[$data[$modelName]['kaiyaku_ku']].' '.$data[$modelName]['kaiyaku_k'].' ／ 共益費 '.
        $data[$modelName]['kyoueki_k'].' ／ 駐車料 '.$data[$modelName]['tyuusya_k']; ?>
        </font>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ffffff" valign="middle" align="center" height="39">
        <font size="+1">
        <?php echo $data[$modelName]['bu_zyuusyo1'].'　　　'.$kouzouArr[$data[$modelName]['kouzou']].'造 ／ '.
        	$data[$modelName]['tiku_nen'].'年築　　No.'.$data[$modelName]['id']; ?>
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
