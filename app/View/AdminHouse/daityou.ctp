<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.daityou', null, array('inline' => false));
$this->Html->script('jquery-1.7.2.min',array( 'inline' => false ));

App::import('Vendor', 'configHouse');
$setubiArr = setubiArr();
$eki_koArr = eki_koArr();
$syubetuArr = syubetuArr();
$totisyuArr = totisyuArr();
$kokudoArr = kokudoArr();
$hutaikenArr = hutaikenArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$kouzouArr = kouzouArr();
$totikenArr = totikenArr();
$timokuArr = timokuArr();
$tosikeiArr = tosikeiArr();
$youtotiArr = youtotiArr();
$tiseiArr = tiseiArr();
$genzyouArr = genzyouArr();
$seigenArr = seigenArr();

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
	$koutuu .= '<br />　　　&nbsp;&nbsp;'.$ensenArr[$data[$modelName]['eki_en2']].' '.
			$ekiArr[$data[$modelName]['eki_en2']][$data[$modelName]['eki_eki2']].' '.
			$eki_koArr[$data[$modelName]['eki_ko2']].' '.$data[$modelName]['eki_hun2'].'分';
}
if(!empty($data[$modelName]['eki_en3']) && !empty($data[$modelName]['eki_eki3']) &&
	!empty($data[$modelName]['eki_ko3']) && !empty($data[$modelName]['eki_hun3'])){
	$koutuu .= '<br />　　　&nbsp;&nbsp;'.$ensenArr[$data[$modelName]['eki_en3']].' '.
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
$seigen ='';
foreach($seigenArr as $key => $val){
if(!empty($val) && $data[$modelName]['seigen'.$key] == 1){
		$seigen .= "{$val} ";
	}
}
//--金額カンマ挿入処理
$nfArray = array('kakaku');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]);
	}
}
//--金額カンマ挿入+万円追加処理
$nfArray = array('tax');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]).'万円';
	}
}
$imgFile  = array(
	array('gaikan_img','gaikan_co','300'),
	array('madori_img','madori_co','300'),
	array('syousai_img1','syousai_co1','86'),
	array('syousai_img2','syousai_co2','86'),
	array('syousai_img3','syousai_co3','86'),
	array('syousai_img4','syousai_co4','86'),
	array('syousai_img5','syousai_co5','86'),
	array('syousai_img6','syousai_co6','86'),
	array('syousai_img7','syousai_co7','86'),
	array('syousai_img8','syousai_co8','86'),
	array('syousai_img9','syousai_co9','86'),
	array('syousai_img10','syousai_co10','86')
);
foreach( $imgFile as $va ){
	if(!empty($data[$modelName][$va[0]])){
		if($data[$modelName][$va[0]] == 1){
			$data[$modelName][$va[0]] = '<a href="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].
			'.jpg" rel="lightbox['.$data[$modelName]['id'].']" title="'.$data[$modelName][$va[1]].'">'.
			'<img src="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" width="'.$va[2].'" border="0" /></a>';
		}else{
			$data[$modelName][$va[0]] = '<a href="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].
			'.jpg" rel="lightbox['.$data[$modelName]['id'].']" title="'.$data[$modelName][$va[1]].'">'.
			'<img src="../img/house/'.$va[0].'/no'.$data[$modelName]['id'].$va[0].'.jpg" height="'.$va[2].'" border="0" /></a>';
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
<?php
for($a = 0; $a <= 100; $a++) {
	$view['data'][$a] = '';
}
?>
<div align="center" id="leftcol">
<p  id="page_title">
不動産検索システム ebs3 管理 <font color="#0000FF">売買</font> 台帳
<a href="./daityouUra?id=<?php echo $data[$modelName]['id']; ?>" style="font-size:small;margin-left:50px;">裏へ</a>
</p>
</div>
<table width="1300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="300" height="300" align="center" valign="middle" id="td1"><?php echo $data[$modelName]['gaikan_img']; ?></td>
    <td width="560" rowspan="2" align="center" valign="middle" id="td2">
      <font size="+1"><?php echo $data[$modelName]['comment']; ?></font><br />
      <br /><br /><?php echo $data[$modelName]['madori_img']; ?>
      <br />
      <br />
      <br /><br />
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
    <td width="300" rowspan="2">
    <table width="340" height="700" border="0" align="right" cellpadding="0" cellspacing="0" id="syousai">
      <tr>
        <td><div align="center">物件種目：<font size="+2"><strong>
          <?php echo $syubetuArr[$data[$modelName]['syubetu']]; ?>
        </strong></font>　棟数：(<?php echo $data[$modelName]['tousuu']; ?>)<br />
        <br />
		        物件番号：<?php echo $data[$modelName]['id']; ?>　名称：<?php echo $data[$modelName]['bukkenmei']; ?></div></td>
      </tr>
      <tr>
        <td><div align="center">価格：<strong><font size="+3">
          <?php echo $data[$modelName]['kakaku']; ?>
        </font></strong>万円　内消費税：(<?php echo $data[$modelName]['tax']; ?>)</div></td>
      </tr>
      <tr>
        <td>物件所在地：
          <?php echo $data[$modelName]['bu_zyuusyo1'].$data[$modelName]['bu_zyuusyo2']; ?></td>
      </tr>
      <tr>
        <td>交通：<?php echo $koutuu; ?></td>
      </tr>
      <tr>
        <td>土地面積：<?php echo $data[$modelName]['totimen']; ?>㎡(<?php echo $totisyuArr[$data[$modelName]['totisyu']]; ?>)　ほかに私道面積：<?php echo $data[$modelName]['sidoumen']; ?>㎡</td>
      </tr>
      <tr>
        <td>国土法届：<?php echo $kokudoArr[$data[$modelName]['kokudo']]; ?>　
        付帯権利：<?php echo $hutaikenArr[$data[$modelName]['hutaiken']]; ?></td>
      </tr>
      <tr>
        <td>建物面積： <?php echo $data[$modelName]['tatemen']; ?> ㎡　地上  <?php echo $data[$modelName]['tizyoukai']; ?> 階　地下  <?php echo $data[$modelName]['tikakai']; ?> 階
          <br /> １Ｆ　　㎡　２Ｆ　　㎡　３Ｆ　　㎡　その他　　㎡
        </td>
      </tr>
      <tr>
        <td>間取り：<?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?><br />
			１Ｆ：<?php echo $data[$modelName]['madori1f']; ?>
			<br />
			２Ｆ：<?php echo $data[$modelName]['madori2f']; ?><br />
			３Ｆ：<?php echo $data[$modelName]['madori3f']; ?>　その他：<?php echo $data[$modelName]['madorita']; ?>
		</td>
      </tr>
      <tr>
        <td>設備：<br /><div id="setubi"><?php echo $setubi; ?></div></td>
      </tr>
      <tr>
        <td>建物構造：<?php echo $kouzouArr[$data[$modelName]['kouzou']]; ?>造　築年月：<?php echo $data[$modelName]['tiku_nen'].'年'.$data[$modelName]['tiku_tuki'].'月'; ?></td>
      </tr>
      <tr>
        <td>土地権利：<?php echo $totikenArr[$data[$modelName]['totiken']]; ?>　地目：<?php echo $timokuArr[$data[$modelName]['timoku']]; ?>　都市計画：<?php echo $tosikeiArr[$data[$modelName]['tosikei']]; ?></td>
      </tr>
      <tr>
        <td>用途地域：<?php echo $youtotiArr[$data[$modelName]['youtoti']]; ?>　建ペイ率：<?php echo $data[$modelName]['kenpei']; ?>％　容積率：<?php echo $data[$modelName]['youseki']; ?>％</td>
      </tr>
      <tr>
        <td>他の法令上の制限：<?php echo $seigen; ?></td>
      </tr>
      <tr>
        <td>地勢：<?php echo $tiseiArr[$data[$modelName]['tisei']]; ?>　接道状況：</td>
      </tr>
      <tr>
        <td>接道方向等：<br />
		          位置指定　　　に　　　　m接道</td>
      </tr>
      <tr>
        <td>現状：<?php echo $genzyouArr[$data[$modelName]['genzyou']]; ?>　引渡：<?php echo $data[$modelName]['hikiwatasi']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">備考：
            <br /><br /><br /><br /><br />
       </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" id="td2"><div id="map_canvas"></div></td>
  </tr>
  <tr>
    <td height="100" colspan="2" align="left" valign="middle" id="syougou">
    <p>商号　　<font size="+1">〇〇〇〇不動産</font><br /><br />
	所在地　００００県０００００市００００町１－１<br /><br />
	TEL　００００－００００００　　　FAX　１１１１－１１－１１１１<br />
	</p>
	</td>
    <td width="300"><table width="340" border="0" align="right" cellpadding="0" cellspacing="0" id="syousai">
      <tr>
        <td>宅建免許番号：　　　　　　（　）第　　　　　　　号<br />
		   所属団体<br /><br />
		   担当　　　　　取引態様　　　　　報酬形態<br /><br />
		   報酬率／額
		</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<div class="leftcol">
<div class="copyright">
	<hr width="950" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>
