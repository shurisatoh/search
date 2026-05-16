<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.daityou.t', null, array('inline' => false));
$this->Html->script('jquery-1.7.2.min',array( 'inline' => false ));

App::import('Vendor', 'configRent');
$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$hosyou_kuArr = hosyou_kuArr();
$kaiyaku_kuArr = kaiyaku_kuArr();
$kouzouArr = kouzouArr();
$barukoniiArr = barukoniiArr();
$mukiArr = mukiArr();
$setubiArr = setubiArr();
$eki_koArr = eki_koArr();
$gasuArr = gasuArr();
$kousin_syuArr = kousin_syuArr();

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
	$koutuu .= ' ／ '.$ensenArr[$data[$modelName]['eki_en2']].' '.
			$ekiArr[$data[$modelName]['eki_en2']][$data[$modelName]['eki_eki2']].' '.
			$eki_koArr[$data[$modelName]['eki_ko2']].' '.$data[$modelName]['eki_hun2'].'分';
}
if(!empty($data[$modelName]['eki_en3']) && !empty($data[$modelName]['eki_eki3']) &&
	!empty($data[$modelName]['eki_ko3']) && !empty($data[$modelName]['eki_hun3'])){
	$koutuu .= '<br /> ／ '.$ensenArr[$data[$modelName]['eki_en3']].' '.
			$ekiArr[$data[$modelName]['eki_en3']][$data[$modelName]['eki_eki3']].' '.
			$eki_koArr[$data[$modelName]['eki_ko3']].' '.$data[$modelName]['eki_hun3'].'分';
}

$dateAr = explode('-', $data[$modelName]['touroku_date']);
$data[$modelName]['touroku_date'] = $dateAr[0].'年'.$dateAr[1].'月'.$dateAr[2].'日';

$setubi ='';
$setubi_msc ='';
foreach($setubiArr as $key => $val){
	if(!empty($val) && $data[$modelName]['setubi'.$key] == 1){
		$setubi_msc .= "{$val} 　";
		$setubi_ms = strlen( $setubi_msc );
		if($setubi_ms > DAITYOU_SETUBIMOZISUU){$setubi .= "<br />\n"; $setubi_msc = "{$val} 　";}
		$setubi .= "{$val}　";
	}
}

//--金額カンマ挿入処理
$nfArray = array('yatin_k','kasai_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]);
	}
}
//--金額カンマ挿入+円追加処理
$nfArray = array('kyoueki_k','hosyou_k','kaiyaku_k','suidouryou','tyuusya_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]).'円';
	}
}
$imgFile  = array(
	array('gaikan_img','gaikan_co','300'),
	array('madori_img','madori_co','300'),
	array('syousai_img1','syousai_co1','56'),
	array('syousai_img2','syousai_co2','56'),
	array('syousai_img3','syousai_co3','56'),
	array('syousai_img4','syousai_co4','56'),
	array('syousai_img5','syousai_co5','56'),
	array('syousai_img6','syousai_co6','56'),
	array('syousai_img7','syousai_co7','56'),
	array('syousai_img8','syousai_co8','56'),
	array('syousai_img9','syousai_co9','56'),
	array('syousai_img10','syousai_co10','56')
);
foreach( $imgFile as $va ){
	if(!empty($data[$modelName][$va[0]])){
		if($data[$modelName][$va[0]] == 1){
			$data[$modelName][$va[0]] = '<a href="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].
			'.jpg" rel="lightbox['.$data[$modelName]['id'].']" title="'.$data[$modelName][$va[1]].'">'.
			'<img src="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" width="'.$va[2].'" border="0" /></a>';
		}else{
			$data[$modelName][$va[0]] = '<a href="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].
			'.jpg" rel="lightbox['.$data[$modelName]['id'].']" title="'.$data[$modelName][$va[1]].'">'.
			'<img src="../img/rent/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" height="'.$va[2].'" border="0" /></a>';
		}
	}else{
		if($va[0] == 'gaikan_img' || $va[0] == 'madori_img'){
			$data[$modelName][$va[0]] = '<img src="../img/noimage300.gif" border="0" />';
		}else{
			$data[$modelName][$va[0]] = '';
		}
	}
}
if(!empty($data[$modelName]['map2'])){
	App::import('Vendor', 'configGoogleMapsApiKey');
	$map = explode('/', $data[$modelName]['map2']);
	echo '<script src="https://maps.googleapis.com/maps/api/js?key='.GOOGLEMAPAPIKEY.'"></script>
<script type="text/javascript">
var hukidasi = "'.$map[0].'";
var marker_flag = '.$map[1].';
var marker_lat = '.$map[2].';
var marker_lng = '.$map[3].';
var lat = '.$map[4].';
var lng = '.$map[5].';
var zoomp = '.$map[6].';
</script>
<script src="../js/googlemap_view.js" type="text/javascript"></script>
<script type="text/javascript">
window.onload = googlemap;
</script>'."\n";
}
?>
<link rel="stylesheet" type="text/css" href="../js/jquery-lightbox-0.5/jquery.lightbox-0.5.css" />
<script type="text/javascript" src="../js/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="../js/jquery-lightbox-0.5/jquery-lightbox-0.5-setup.js"></script>
<div align="center" id="leftcol">
<p  id="page_title">
不動産検索システム ebs3 管理 <font color="#FF0000">賃貸</font> 台帳
<a href="./daityouUra?id=<?php echo $data[$modelName]['id']; ?>" style="font-size:small;margin-left:50px;">裏へ</a>
</p>
</div>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
    <tr>
      <td colspan="22" height="39"><b><font size="+2">　物　　件　　資　　料</font></b>　　　
        <font size="-1" color="#000000">物件番号：<?php echo $data[$modelName]['id']; ?>
        　種別：<?php echo $syubetuArr[$data[$modelName]['syubetu']]; ?></font>
      </td>
      <td height="39" colspan="6" align="middle"><?php echo $data[$modelName]['touroku_date']; ?></td>
    </tr>
    <tr>
      <td height="38" width="66"><div align="center">名　称</div></td>
      <td align="middle" colspan="8" height="38" id="meisyou">
        <font color="#0000cc"><b><?php echo $data[$modelName]['bukkenmei']; ?></b></font></td>
      <td height="38" colspan="12" align="center">
        <font size="-1"><?php echo $kouzouArr[$data[$modelName]['kouzou']]; ?>造<br />
        地上 <?php echo $data[$modelName]['kaisuu']; ?> 階建</font>
        </td>
      <td width="50" height="38">築年</td>
      <td colspan="6" align="center" height="38">
      <?php echo $data[$modelName]['tiku_nen'].'年'.$data[$modelName]['tiku_tuki'].'月'?>築
      </td>
    </tr>
    <tr>
      <td rowspan="2" width="66"><div align="center">所在地</div></td>
      <td colspan="20" rowspan="2"><?php echo $data[$modelName]['bu_zyuusyo1'].$data[$modelName]['bu_zyuusyo2']; ?></td>
      <td colspan="2"><font size="-1">総　戸　数</font></td>
      <td colspan="5" align="center"><font size="-1">全<?php echo $data[$modelName]['soukosuu']; ?>戸</font></td>
    </tr>
    <tr>
      <td colspan="2"><font size="-1">契約期間</font></td>
      <td colspan="5" align="center"><font size="-1"><?php echo $data[$modelName]['keiyaku_ki']; ?>年</font></td>
    </tr>
    <tr>
      <td width="66" height="42"><div align="center">交　通</div></td>
      <td colspan="27" height="42" style="line-height: 20px;"><?php echo $koutuu; ?></td>
    </tr>
    <tr>
      <td rowspan="3" width="66" height="37"><div align="center">設　備</div></td>
      <td colspan="20" rowspan="3" height="37">
        <div id="setubi"><font size="-1"><?php echo $setubi; ?></font></div>
      </td>
      <td colspan="2"><font size="-1">ガス (<?php echo $gasuArr[$data[$modelName]['gasu']]; ?>)</font></td>
      <td colspan="5"><font size="-1">更　新 (<?php echo $kousin_syuArr[$data[$modelName]['kousin_syu']]; ?>)</font></td>
    </tr>
    <tr>
      <td colspan="2"><font size="-1">バルコニー (<?php echo $barukoniiArr[$data[$modelName]['barukonii']]; ?>)</font></td>
      <td colspan="5"><font size="-1">更 新 料 (<?php echo $data[$modelName]['kousinryou']; ?>)</font></td>
    </tr>
    <tr>
      <td colspan="7" align="middle">
        <font size="-1">火災保険(<?php echo $barukoniiArr[$data[$modelName]['kasaihoken']].' '.
        $data[$modelName]['kasai_k'].'円/'.$data[$modelName]['kasai_nen'].'年'; ?>)
        </font>
      </td>
    </tr>
    <tr>
      <td rowspan="5" width="66"><div align="center">空　室</div></td>
      <td align="center" width="72"><font size="-1">号　室</font></td>
      <td colspan="2" align="center"><font size="-1">間取</font></td>
      <td align="center" width="32"><font size="-1">向</font></td>
      <td colspan="2" align="center"><font size="-1">面積</font></td>
      <td colspan="5" align="center"><font size="-1">
      <?php echo $hosyou_kuArr[$data[$modelName]['hosyou_ku']]; ?></font>
      </td>
      <td colspan="3" align="center">
      <font size="-1"><?php echo $kaiyaku_kuArr[$data[$modelName]['kaiyaku_ku']]; ?></font>
      </td>
      <td colspan="7" align="center"><font size="-1">家賃</font></td>
      <td align="center" colspan="2"><font size="-1">共益費</font></td>
      <td colspan="2" align="center"><font size="-1">水道料</font></td>
      <td colspan="2" align="center" width="73"><font size="-1">状況</font></td>
    </tr>
    <tr>
      <td height="32" width="72" align="center"><?php echo $data[$modelName]['gousitu']; ?></td>
      <td colspan="2" height="33" align="center">
      <?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?>
      </td>
      <td height="33" width="32" align="center">
        <font size="-1"><?php echo $mukiArr[$data[$modelName]['muki']]; ?></font>
      </td>
      <td colspan="2" align="right" height="33"><?php echo $data[$modelName]['heibei']; ?>㎡</td>
      <td colspan="5" height="33" align="center"><?php echo $data[$modelName]['hosyou_k']; ?></td>
      <td colspan="3" height="33" align="center"><?php echo $data[$modelName]['kaiyaku_k']; ?></td>
      <td colspan="7" height="33" align="center"><?php echo $data[$modelName]['yatin_k']; ?>円</td>
      <td height="33" colspan="2" align="center"><?php echo $data[$modelName]['kyoueki_k']; ?></td>
      <td colspan="2" height="33" align="center"><?php echo $data[$modelName]['suidouryou']; ?></td>
      <td colspan="2" height="33" width="73" align="center">
        <font size="-1"><?php echo $data[$modelName]['zyoukyou']; ?></font>
      </td>
    </tr>
    <tr>
      <td height="32" width="72">　</td>
      <td colspan="2" height="32">　</td>
      <td height="32" width="32">　</td>
      <td colspan="2" align="right" height="32">㎡</td>
      <td colspan="5" height="32">　</td>
      <td colspan="3" height="32">　</td>
      <td colspan="7" height="32">　　</td>
      <td height="32" colspan="2">　</td>
      <td colspan="2" height="32">　</td>
      <td colspan="2" height="32" width="73">　</td>
    </tr>
    <tr>
      <td height="32" width="72">　</td>
      <td colspan="2" height="35">　</td>
      <td height="35" width="32">　</td>
      <td colspan="2" align="right" height="35">㎡</td>
      <td colspan="5" height="35">　</td>
      <td colspan="3" height="35">　</td>
      <td colspan="7" height="35">　　</td>
      <td height="35" colspan="2">　</td>
      <td colspan="2" height="35">　</td>
      <td colspan="2" height="35" width="73">　</td>
    </tr>
    <tr>
      <td height="32" width="72">　</td>
      <td colspan="2" height="28">　</td>
      <td height="28" width="32">　</td>
      <td colspan="2" align="right" height="28">㎡</td>
      <td colspan="5" height="28">　</td>
      <td colspan="3" height="28">　</td>
      <td colspan="7" height="28">　　</td>
      <td height="28" colspan="2">　</td>
      <td colspan="2" height="28">　</td>
      <td colspan="2" height="28" width="73">　</td>
    </tr>
    <tr>
      <td rowspan="2" width="66"><div align="center">駐車場</div></td>
      <td colspan="2" height="22"><font size="-2">空有・空無</font></td>
      <td rowspan="2" colspan="9">　　<font size="-1">保証金　 </font></td>
      <td colspan="10" align="left" height="22">
        　<font size="-1">賃料 <?php echo $data[$modelName]['tyuusya_k']; ?></font>
      </td>
      <td width="66" rowspan="2">校　区</td>
      <td colspan="5" align="right" height="22"><font size="-1">小学校</font></td>
    </tr>
    <tr>
      <td colspan="2"><font size="-2">無・近隣</font></td>
      <td colspan="10" align="left" height="22">　<font size="-1">賃料 </font> </td>
      <td colspan="5" align="right"><font size="-1">中学校</font></td>
    </tr>
    <tr>
      <td height="240" colspan="11" align="center" valign="middle" id="img">
        <?php echo $data[$modelName]['gaikan_img']; ?>
      </td>
      <td colspan="17" rowspan="2" valign="top" align="center">
        <br /><?php echo $data[$modelName]['madori_img']; ?><br /><br />
        <font size="-1"><?php echo $data[$modelName]['comment']; ?></font><br /><br />

	<table border="0" align="center" class="img_sy">
	<tr>
	<td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img1']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img2']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img3']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img4']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img5']; ?>
	</td>
	</tr><tr>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co1']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co2']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co3']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co4']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co5']; ?></td>
	</tr><tr>
	<td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img6']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img7']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img8']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img9']; ?>
	</td><td width="60" align="center" valign="middle" class="img_sy">
		<?php echo $data[$modelName]['syousai_img10']; ?>
	</td>
	</tr><tr>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co6']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co7']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co8']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co9']; ?></td>
	<td class="img_sy"><?php echo $data[$modelName]['syousai_co10']; ?></td>
	</tr>
	</table>

      </td>
    </tr>
    <tr>
      <td height="240" colspan="11" align="center" valign="middle" id="img">
      <div id="map_canvas"></div>
      </td>
    </tr>
    <tr>
      <td colspan="28" align="right">○○○○不動産<font color="#FFFFFF">＿＿</font></td>
    </tr>
  </tbody>
</table>
<div class="leftcol">
<div class="copyright">
	<hr width="700" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>

