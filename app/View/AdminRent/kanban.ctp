<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

App::import('Vendor', 'configRent');
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$hosyou_kuArr = hosyou_kuArr();
$kaiyaku_kuArr = kaiyaku_kuArr();
$setubiArr = setubiArr();
$eki_koArr = eki_koArr();
App::import('Vendor', 'configRentEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();

if(isset($this->request->data['fcolor'])){
	$filepointer=fopen('../Vendor/configRentKanban.php', "a+");
	flock($filepointer, LOCK_EX);
	$fileData = '';
	while(!feof($filepointer)){
		$value = fgets($filepointer);
		if(preg_match("/backgroundColor/", $value)){
			$value = "	return '".$this->request->data['bkcolor']."';//--backgroundColor\n";
		}elseif(preg_match("/fontColor/", $value)){
			$value = "	return '".$this->request->data['fcolor']."';//--fontColor\n";
		}elseif(preg_match("/borderColor/", $value)){
			$value = "	return '".$this->request->data['bcolor']."';//--borderColor\n";
		}
		$fileData.= $value;
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $fileData);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);
}else{
	App::import('Vendor', 'configRentKanban');
	$this->request->data['bkcolor'] = baGrCoArr();
	$this->request->data['fcolor'] = fontCoArr();
	$this->request->data['bcolor'] = borderCoArr();
}

$koutuu = '';
if(!empty($data[$modelName]['eki_en1']) && !empty($data[$modelName]['eki_eki1']) &&
	!empty($data[$modelName]['eki_ko1']) && !empty($data[$modelName]['eki_hun1'])){
	$koutuu = $ensenArr[$data[$modelName]['eki_en1']].' '.
			$ekiArr[$data[$modelName]['eki_en1']][$data[$modelName]['eki_eki1']].' '.
			$eki_koArr[$data[$modelName]['eki_ko1']].' '.$data[$modelName]['eki_hun1'].'分';
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
	array('gaikan_img','390'),
	array('madori_img','390')
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

$setubi ='';
$setubi_msc ='';
foreach($setubiArr as $key => $val){
	if(!empty($val) && $data[$modelName]['setubi'.$key] == 1){
		$setubi_msc .= "{$val} 　";
		$setubi_ms = strlen( $setubi_msc );
		if($setubi_ms > KANBAN_SETUBIMOZISUU){$setubi .= "<br />\n"; $setubi_msc = "{$val} 　";}
		$setubi .= "{$val}　";
	}
}

$zyouken = '<ul id="zyouken">';
if(!empty($data[$modelName]['hosyou_ku'])){
	$zyouken .= '
		<li><p>'.$hosyou_kuArr[$data[$modelName]['hosyou_ku']].'：</p>'.$data[$modelName]['hosyou_k'].'</li>';
}else{
	$zyouken .= '
		<li>&nbsp;</li>';
}
if(!empty($data[$modelName]['kaiyaku_ku'])){
	$zyouken .= '
	<li><p>'.$kaiyaku_kuArr[$data[$modelName]['kaiyaku_ku']].'：</p>'.$data[$modelName]['kaiyaku_k'].'</li>';
}else{
	$zyouken .= '
		<li>&nbsp;</li>';
}
if(!empty($data[$modelName]['kyoueki_k'])){
	$zyouken .= '
	<li><p>共益費：</p>'.$data[$modelName]['kyoueki_k'].'</li>';
}else{
	$zyouken .= '
		<li>&nbsp;</li>';
}
if(!empty($data[$modelName]['tyuusya_k'])){
	$zyouken .= '
	<li><p>駐車場：</p>'.$data[$modelName]['tyuusya_k'].'</li>';
}else{
	$zyouken .= '
		<li>&nbsp;</li>';
}
if(!empty($data[$modelName]['tiku_nen'])){
	$zyouken .= '
	<li><p>完　成：</p>'.$data[$modelName]['tiku_nen'].'年'.$data[$modelName]['tiku_tuki'].'月築</li>';
}else{
	$zyouken .= '
		<li>&nbsp;</li>';
}
$zyouken .= "\n".'</ul>';

?>
<link type="text/css" href="../js/spectrum/spectrum.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/spectrum/spectrum.js"></script>
<style type="text/css">
td {
	padding-left: 5px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-right-style: solid;
	border-bottom-style: solid;
	border-right-color: #999999;
	border-bottom-color: #999999;
}
table {
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-left-style: solid;
	border-top-color: #999999;
	border-left-color: #999999;
	font-family: "メイリオ";
	font-weight: bold;
}
#img {
	padding: 5px;
}
hr {margin-top: 30px;}
#rent {
	font-weight: bold;
	background-color: <?php echo $this->request->data['bkcolor']; ?>;
	color: <?php echo $this->request->data['fcolor']; ?>;
}
#rent #title {
	font-size: 105px;
	border-top-width: 10px;
	border-bottom-width: 10px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: <?php echo $this->request->data['bcolor']; ?>;
	border-bottom-color: <?php echo $this->request->data['bcolor']; ?>;
}
#rent .syousai {
	font-size: 30px;
	vertical-align: top;
	padding-top: 10px;
}
.rent_mozityuu {
	font-size: 50px;
}
.rent_mozisyou {
	font-size: 15px;
}
.noline {
	border-style: none;
}
#colorTable{
	font-weight: normal;
}
p#page_title{
	font-family: "メイリオ";
	text-align: center;
}
#zyouken{
	margin: 0px;
	padding: 0px;
}
#zyouken li{
	list-style-type: none;
	margin: 0px;
	padding: 0px;
		text-align: center;
}
#zyouken li p {
	float: left;
	width: 160px;
	margin: 0px;
	padding: 0px;
	text-align: right;
}
@media print{
	.leftcol {display: none}
}
.copyright {
	width: 950px;
	margin-right: auto;
	margin-left: auto;
	text-align: right;
	font-size: xx-small;
}
.copyright hr{
	border: 0;
    height: 0;
	border-top-width: 1px;
	border-top-style: solid;
}
.copyright a {
	color: #333;
}
</style>
<div class="leftcol">
<p  id="page_title">不動産検索システム ebs3 管理 <font color="#FF0000">賃貸</font> 看板</p>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'./kanban?id='.$data[$modelName]['id']))."\n"; ?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="noline" id="colorTable">
  <tr>
    <td class="noline" width="150">&nbsp;</td>
    <td class="noline">
    文字色：
      <?php echo $this->Form->text('fcolor',array('id'=>'ffull'))."\n"; ?>
    </td>
    <td class="noline" width="10">&nbsp;</td>
    <td class="noline">
    ボーダー色：
      <?php echo $this->Form->text('bcolor',array('id'=>'bfull'))."\n"; ?>
    </td>
    <td class="noline" width="10">&nbsp;</td>
    <td class="noline">
    背景色：
      <?php echo $this->Form->text('bkcolor',array('id'=>'full'))."\n"; ?>
    </td>
    <td class="noline" width="10">&nbsp;</td>
    <td class="noline">
      <?php echo $this->Form->submit('設定')."\n";?>
    </td>
    <td class="noline" width="150">&nbsp;</td>
  </tr>
</table>
<?php echo $this->Form->end()."\n"; ?>
<br /><br />
<script type="text/javascript">
$("#full").spectrum({
    color: "<?php echo $this->request->data['bkcolor']; ?>",
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxPaletteSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {},
    show: function () {},
    beforeShow: function () {},
    hide: function () {},
    change: function() {},
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});
$("#ffull").spectrum({
    color: "<?php echo $this->request->data['fcolor']; ?>",
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxPaletteSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {},
    show: function () {},
    beforeShow: function () {},
    hide: function () {},
    change: function() {},
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});
$("#bfull").spectrum({
    color: "<?php echo $this->request->data['bcolor']; ?>",
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxPaletteSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {},
    show: function () {},
    beforeShow: function () {},
    hide: function () {},
    change: function() {},
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});
</script>
</div>
<table width="1260" height="880" border="0" align="center" cellpadding="0" cellspacing="0" id="rent">
  <tbody>
    <tr>
      <td height="100" colspan="3" align="center" valign="center" id="title">
      <?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?>　
      <span class="rent_mozityuu">家賃</span>　<?php echo $data[$modelName]['yatin_k']; ?>円
      </td>
    </tr>
    <tr>
    <td colspan="3" align="center" valign="center" class="syousai">
    <span class="rent_mozityuu"><?php echo $koutuu; ?></span>
    </td>
    </tr>
    <tr>
      <td width="400" height="400" align="center" valign="center"><?php echo $data[$modelName]['gaikan_img']; ?></td>
      <td width="400" align="center" valign="center" class="syousai">
        <?php echo $zyouken.$data[$modelName]['bu_zyuusyo1']; ?>
      </td>
      <td width="400" align="center" valign="center"><?php echo $data[$modelName]['madori_img']; ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="center" class="syousai">
      <?php echo $data[$modelName]['comment']; ?>
      </td>
      <td align="center" valign="center" class="syousai">
        <span class="rent_mozisyou">
          <?php echo $setubi; ?>
        <br /><br />
        </span>
        No.<?php echo $data[$modelName]['id']; ?>
      </td>
    </tr>
  </tbody>
</table>
<div class="leftcol">
<div class="copyright">
	<hr width="950" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
</div>
