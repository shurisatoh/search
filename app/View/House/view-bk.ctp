
<?php


$this->Html->css(array('home','slick/slick','slick/slick-theme'), null, array('inline' => false));
$this->Html->script(array('jquery-3.6.0.min','slick/slick.min'),	array( 'inline' => false ));

App::import('Vendor', 'configHouse');
$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$youtotiArr = youtotiArr();
$kouzouArr = kouzouArr();
$timokuArr = timokuArr();
$setubiArr = setubiArr();
$eki_koArr = eki_koArr();
$tosikeiArr = tosikeiArr();
$totikenArr = totikenArr();


App::import('Vendor', 'configHouseEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();

$addressJson = file_get_contents(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'address.json');
$addressArr = json_decode($addressJson, true);

function getEnglishAddress($zipcode, $addressArr) {
    foreach ($addressArr as $entry) {
        if ((string)$entry['zip'] === (string)$zipcode) {
            return $entry['prefecture_en'] . ', ' . $entry['cityward_en'] . ', ' . $entry['street_en'];
        }
    }
    return '';
}



$koutuu = '';
$address_en = '';
if (!empty($data)) {
    $zipcode = $data[$modelName]['zipcode'];
	
    $address_en = getEnglishAddress($zipcode, $addressArr);
	
}
if(!empty($data[$modelName]['eki_en1'])){
	$koutuu = $ensenArr[$data[$modelName]['eki_en1']].' '.
			$ekiArr[$data[$modelName]['eki_en1']][$data[$modelName]['eki_eki1']].' '.
			$eki_koArr[$data[$modelName]['eki_ko1']].' '.$data[$modelName]['eki_hun1'].' minutes';
}
if(!empty($data[$modelName]['eki_en2'])){
	$koutuu .= '<br />'.$ensenArr[$data[$modelName]['eki_en2']].' '.
			$ekiArr[$data[$modelName]['eki_en2']][$data[$modelName]['eki_eki2']].' '.
			$eki_koArr[$data[$modelName]['eki_ko2']].' '.$data[$modelName]['eki_hun2'].' minutes';
}
if(!empty($data[$modelName]['eki_en3'])){
	$koutuu .= '<br />'.$ensenArr[$data[$modelName]['eki_en3']].' '.
			$ekiArr[$data[$modelName]['eki_en3']][$data[$modelName]['eki_eki3']].' '.
			$eki_koArr[$data[$modelName]['eki_ko3']].' '.$data[$modelName]['eki_hun3'].' minutes';
}

$imgFile  = array(
	array('gaikan_img','gaikan_co'),
	array('madori_img','madori_co'),
	array('syousai_img1','syousai_co1'),
	array('syousai_img2','syousai_co2'),
	array('syousai_img3','syousai_co3'),
	array('syousai_img4','syousai_co4'),
	array('syousai_img5','syousai_co5'),
	array('syousai_img6','syousai_co6'),
	array('syousai_img7','syousai_co7'),
	array('syousai_img8','syousai_co8'),
	array('syousai_img9','syousai_co9'),
	array('syousai_img10','syousai_co10')
);
$trImg = 0;
foreach($imgFile as $index => $va){
	if(!empty($data[$modelName][$va[0]])){
		$imgNumber = $index;
		$data[$modelName][$va[0]] = '<img src="../img/house/gazou/'.$data[$modelName]['id'] . '_' .$imgNumber.'.jpg" width="100%" /><div class="imgtitle">'.$data[$modelName][$va[1]].'</div>';
		
	}else{
		$data[$modelName][$va[0]] = '';
	}
}
if (!empty($data[$modelName]['id'])) :
//--金額カンマ挿入処理
$nfArray = array('kakaku');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]);
	}
}
$setubi ='';
$setubi_msc ='';
foreach($setubiArr as $key => $val){
	if(!empty($val) && $data[$modelName]['setubi'.$key] == 1){
		$setubi_msc .= "{$val} 　";
		$setubi_ms = strlen( $setubi_msc );
		if($setubi_ms > VIEW_SETUBIMOZISUU){$setubi .= "<br />\n"; $setubi_msc = "{$val} 　";}
		$setubi .= "{$val}".", ";
	}
}
$data[$modelName]['comment'] = preg_replace('/\n/', '<br />', $data[$modelName]['comment']);

if($data[$modelName]['new'] == 1){
	$dateTo = preg_replace("/-/", '', $data[$modelName]['touroku_date']);
	$dateNew =date("Ymd", strtotime(date("Y-m-d").' -'.DATE_NEW.' day'));
	if($dateTo >= $dateNew){
		$data[$modelName]['new'] = '<span class="new">NEW!</span>　';
	}else{
		$data[$modelName]['new'] = '';
	}
}else{
	$data[$modelName]['new'] = '';
}
endif;
if(!empty($data[$modelName]['map2'])){
	App::import('Vendor', 'configGoogleMapsApiKey');
	$map = explode('/', $data[$modelName]['map2']);
	echo '<script src="https://maps.googleapis.com/maps/api/js?key='.GOOGLEMAPAPIKEY.'&language=en"></script>
<script type="text/javascript">
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
	$trMap = '  <tr>
    <td>
    <p>Map</p>
    <div id="map_canvas"></div>
    <br />
    </td>
  </tr>'."\n";
}else{
	$trMap = '';
}
?>
<link rel="stylesheet" type="text/css" href="../js/jquery-lightbox-0.5/jquery.lightbox-0.5.css" />
<script type="text/javascript" src="../js/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="../js/jquery-lightbox-0.5/jquery-lightbox-0.5-setup.js"></script>
<!-- コンテンツ -->
<div id="content">
<p>&nbsp;</p>
<div class="post">
<h2> Details</h2>
<?php if (!empty($data[$modelName]['id'])) : ?>
<?php
if (!empty($address_en)) {
	App::import('Vendor', 'configGoogleMapsApiKey');
	echo '
	<script src="https://maps.googleapis.com/maps/api/js?key='.GOOGLEMAPAPIKEY.'&callback=initMap&language=en" async defer></script>
	<script type="text/javascript">
		function initMap() {
			var geocoder = new google.maps.Geocoder();
			var address = "'.h($address_en . $data[$modelName]['bu_zyuusyo2']).'";
			geocoder.geocode({ "address": address }, function(results, status) {
				if (status === "OK") {
					var map = new google.maps.Map(document.getElementById("map_canvas"), {
						zoom: 16,
						center: results[0].geometry.location
					});
					new google.maps.Marker({
						map: map,
						position: results[0].geometry.location
					});
				} else {
					console.error("Geocode was not successful: " + status);
				}
			});
		}
	</script>';
	$trMap = '
	<tr>
		<td>
			<p>Map</p>
			<div id="map_canvas" style="width:100%;height:400px;"></div>
			<br />
		</td>
	</tr>';
} else {
	$trMap = '';
}
?>
<table class="table_center w50"><tr>
    <td class="bkco">Price (Yen)</td>
    <td><span class="pu"><?php echo $data[$modelName]['kakaku']; ?></span></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Property No</td>
    <td><?php echo $data[$modelName]['new'].'No.'.$data[$modelName]['id']; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Layout</td>
    <td><?php echo $madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']]; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Type</td>
    <td><?php echo $syubetuArr[$data[$modelName]['syubetu']]; ?></td>
</tr></table>
<?php
$isMansion = ($data[$modelName]['syubetu']);
?>
<table class="table_center w50"><tr>
    <td class="bkco"><?php echo $isMansion ? 'Property Size' : 'Land／Property Size'; ?></td>
    <td>
        <?php
        if ($isMansion) {
            echo $data[$modelName]['tatemen'] . '㎡';
        } else {
            echo $data[$modelName]['totimen'] . '㎡／' . $data[$modelName]['tatemen'] . '㎡';
        }
        ?>
    </td>
</tr></table>

<table class="table_center w50"><tr>
    <td class="bkco">Zoning</td>
    <td><?php echo $youtotiArr[$data[$modelName]['youtoti']]; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Structure</td>
    <td><?php echo $kouzouArr[$data[$modelName]['kouzou']]; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Land Right</td>
    <td><?php echo $totikenArr[$data[$modelName]['totiken']]; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco">Built Year</td>
    <td><?php echo $data[$modelName]['tiku_nen']; ?></td>
</tr></table>


<?php
$isMansion = ($data[$modelName]['syubetu']);
?>
<table class="table_center w50"><tr>
    <td class="bkco"><?php echo $isMansion ? 'Monthly Maintenance Fee/Sinking Fund' : 'Building Area Ratio／Floor Area Ratio'; ?></td>
    <td>
        <?php
        if ($isMansion) {
            echo number_format($data[$modelName]['kanrihi']).' yen／'.number_format($data[$modelName]['tumitatekin']).' yen';
        } else {
            echo $data[$modelName]['kenpei'].'%／'.$data[$modelName]['youseki'].'%';
        }
        ?>
    </td>
</tr></table>

<table class="table_center w50"><tr>
    <td class="bkco2">Station</td>
    <td><?php echo $koutuu; ?></td>
</tr></table><table class="table_center w50"><tr>
    <td class="bkco2">Address</td>
    <td><?php echo h($address_en . $data[$modelName]['bu_zyuusyo2']); ?></td>
</tr></table><table class="table_center w100"><tr>
    <td class="bkco">Features</td>
    <td colspan="3">
    <table align="center">
      <tr>
        <td align="left">
<?php echo $setubi; ?>
        </td>
      </tr>
    </table>
    </td>
</tr></table><table class="table_center w100"><tr>
    <td class="bkco">Transaction Cost</td>
    <td colspan="3">
    <table align="center">
      <tr>
        <td align="left">Agent fee 3% plus 60,000yen plus tax, Registration Cost, Stamp fee
        </td>
      </tr>
    </table>
    </td>
</tr></table>
<ul class="slider-for">
<?php
$count = 0;
if (!empty($data[$modelName]['gaikan_img'])){
	echo '<li><table><tr><td align="center" valign="middle">'.$data[$modelName]['gaikan_img'].'</td></tr></table></li>'."\n";
	$count++;
}
if (!empty($data[$modelName]['madori_img'])){
	echo '<li><table><tr><td align="center" valign="middle">'.$data[$modelName]['madori_img'].'</td></tr></table></li>'."\n";
	$count++;
}
for($a = 1; $a <= 10; $a++) {
	if(!empty($data[$modelName]['syousai_img'.$a])){
 		echo '   <li><table><tr><td align="center" valign="middle">'.$data[$modelName]['syousai_img'.$a].'</td></tr></table></li>'."\n";
 		$count++;
	}
}
for($a = $count; $a <= 5; $a++) {
	echo '   <li><table><tr><td align="center" valign="middle"><img src="'.$this->webroot.'img/noimage640.jpg" width="100%" border="0" /></td></tr></table></li>'."\n";
}
?>
 </ul>
<ul class="slider-nav">
<?php
if (!empty($data[$modelName]['gaikan_img'])){
	echo '   <li><table><tr><td align="center" valign="middle">'.$data[$modelName]['gaikan_img'].'</td></tr></table></li>'."\n";
}
if (!empty($data[$modelName]['madori_img'])){
	echo '   <li><table><tr><td align="center" valign="middle">'.$data[$modelName]['madori_img'].'</td></tr></table></li>'."\n";
}
for($a = 1; $a <= 10; $a++) {
	if(!empty($data[$modelName]['syousai_img'.$a])){
		echo '   <li><table><tr><td align="center" valign="middle">'.$data[$modelName]['syousai_img'.$a].'</td></tr></table></li>'."\n";
	}
}
for($a = $count; $a <= 5; $a++) {
	echo '   <li><table><tr><td align="center" valign="middle"><img src="'.$this->webroot.'img/noimage640.jpg" width="100%" border="0" /></td></tr></table></li>'."\n";
}
?>
 </ul>
<style type="text/css">
.slider-for {
	width: 90%;
	height: 90%;
	margin: auto;
}
.slider-nav {
  width: 90%;
  height: 90%;
  margin: auto;
}
.slick-prev:before,
.slick-next:before {
  color: black;
}
.slider-nav .slick-current {
  outline: solid 3px #398FCA;
  outline-offset: -3px;
}
</style>
<script type="text/javascript">
$(".slider-for").slick({
	  arrows: true,
	  asNavFor: ".slider-nav"
});
$(function () {
	$('.slider-nav').slick({
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  arrows: true,
	  centerMode: true,
	  focusOnSelect: true,
	  slidesToShow: 5,
	    responsive: [
	      {
	        breakpoint: 767,
	        settings: {
	          slidesToShow: 3,
	        },
	      },
	    ],
	});
});
</script>
<?php echo $trMap; ?>
<table align="center" class="table_center contact_td">
  <tr>
    <td style="border-style: none;">
    <table border="0" align="center" id="noborder">
      <tr>
        <td width="300" align="center" id="noborder">
        <a href="<?php echo $this->webroot.'House/contact?id='.$data[$modelName]['id']; ?>">
        <div class="contact">Inquiry</div>
        </a><br />
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php else : ?>
No such property.
<?php endif; ?>
</div>
<p>&nbsp;</p>
</div>
