<?php echo $this->element('top_content'); ?>
<?php

$this->Html->css('home', null, array('inline' => false));

$this->Html->script(array('jquery-1.7.2.min','jquery-accordion'),array( 'inline' => false ));

App::import('Vendor', 'configRent');

$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$setubiArr = setubiArr();
$tiikiArr = tiikiArr();
$cityArr = array();
$districtArr = array();
$eki_koArr = eki_koArr();
$tinryouStartArr = tinryouStartArr();
$tinryouEndArr = tinryouEndArr();
$hosyou_kuArr = hosyou_kuArr();
$kaiyaku_kuArr = kaiyaku_kuArr();

// address.json 読み込みと zipcode → 英語住所変換用
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


App::import('Vendor', 'configRentEki');

$ensenArr = ensenArr();
$ekiArr = ekiArr();
//debug(array_keys($ekiArr));
//debug(array_keys($ekiArr[1])); // 1 = Iwate Galaxy Railway Line として確認

//$connection = ConnectionManager::getDataSource('default');
//$address = $connection->execute('SELECT zip, pref, cityward_en, street_en FROM zipaddress')->fetchAll(PDO::FETCH_ASSOC);
//$trains = $connection->execute('SELECT id, pref, linename_en, stationname_en FROM trains')->fetchAll(PDO::FETCH_ASSOC);
//file_put_contents('../../address.json', json_encode($address));
//file_put_contents('../../trains.json', json_encode($trains));




$ekiSeArr = array(''=>'　　　');


if (!empty($this->request->query['en']) && isset($ekiArr[$this->request->query['en']])) {
	foreach ($ekiArr[$this->request->query['en']] as $key => $val) {
		$ekiSeArr[$key] = $val;
	}
}

$ekiArJs = '';
foreach ($ekiArr as $key => $val) {
    $values = array_map(function ($v) {
        return '"' . $v . '"';
    }, $val);

    $ekiArJs .= 'ekis[' . $key . '] = new Array(' . implode(',', $values) . ");\n";
}

$table = '';
$address_en = '';
if (!empty($data)) {
    $first = $data[0];
    $zipcode = $first[$modelName]['zipcode'];
    $address_en = getEnglishAddress($zipcode, $addressArr);
	
}

foreach( $data as $da ){
	if(!empty($da[$modelName]['gaikan_img'])){
		$photoImage = '';
		$photoAlt = 'Property photo of property No.'.$da[$modelName]['id'];
		foreach (array(1,2,3,4,5,6,7,8,9,10,11,12) as $photoIndex) {
			$photoPath = 'img/rent/gazou/'.$da[$modelName]['id'].'_'.$photoIndex.'.jpg';
			if (file_exists(WWW_ROOT.$photoPath)) {
				$photoImage = $photoPath;
				if ($photoIndex == 1) {
					$photoAlt = 'Exterior photo of property No.'.$da[$modelName]['id'];
				}
				break;
			}
		}
		if (!empty($photoImage)) {
			$da[$modelName]['gaikan_img'] = '<img class="reg-rent-card-photo" src="'.$this->webroot.$photoImage.'" alt="'.$photoAlt.'" />';
		} else {
			$da[$modelName]['gaikan_img'] = '<img class="reg-rent-card-photo" src="'.$this->webroot.'img/noimage100.gif" alt="Property photo unavailable" />';
		}
	}else{
		$da[$modelName]['gaikan_img'] = '<img class="reg-rent-card-photo" src="'.$this->webroot.'img/noimage100.gif" alt="Property photo unavailable" />';
	}
	//--金額カンマ挿入処理
	$nfArray = array('yatin_k');
	foreach( $nfArray  as $va ){
		if(is_numeric($da[$modelName][$va])){$da[$modelName][$va] = number_format($da[$modelName][$va]);}
	}
	//--金額カンマ挿入+円追加処理
	$nfArray = array('kyoueki_k','hosyou_k','kaiyaku_k');
	foreach( $nfArray  as $va ){
		if(is_numeric($da[$modelName][$va])){
			$da[$modelName][$va] = number_format($da[$modelName][$va]);
		}
	}
	for($a = 1; $a <= 3; $a++) {
		if (!empty($da[$modelName]['eki_eki' . $a]) &&
    	isset($ekiArr[$da[$modelName]['eki_en' . $a]][$da[$modelName]['eki_eki' . $a]])) {
    	$da[$modelName]['eki_eki' . $a] = $ekiArr[$da[$modelName]['eki_en' . $a]][$da[$modelName]['eki_eki' . $a]];
	} else {
    	$da[$modelName]['eki_eki' . $a] = '';
	}

		if(!empty($da[$modelName]['eki_hun'.$a])){
			$da[$modelName]['eki_hun'.$a] = $da[$modelName]['eki_hun'.$a];
		} else {
			$da[$modelName]['eki_hun'.$a] = "";
		}
	}
	if($da[$modelName]['new'] == 1){
		$dateTo = preg_replace("/-/", '', $da[$modelName]['touroku_date']);
		$dateNew =date("Ymd", strtotime(date("Y-m-d").' -'.DATE_NEW.' day'));
		if($dateTo >= $dateNew){
			$da[$modelName]['new'] = '<span class="new">NEW!</span><br />';
		}else{
			$da[$modelName]['new'] = '';
		}
	}else{
		$da[$modelName]['new'] = '';
	}
	$table .= '
<article class="reg-rent-card">
	<a class="reg-rent-card-media" href="'.$this->webroot.'Rent/view?id='.$da[$modelName]['id'].'">
		'.$da[$modelName]['gaikan_img'].'
		<span>Exterior photo</span>
	</a>
	<div class="reg-rent-card-body">
		<div class="reg-rent-card-head">
			<div>
				<p class="reg-card-kicker">'.$da[$modelName]['new'].'Property No. '.$da[$modelName]['id'].'</p>
				<h3>'.$syubetuArr[$da[$modelName]['syubetu']].' in Tokyo</h3>
			</div>
			<a href="'.$this->webroot.'Rent/view?id='.$da[$modelName]['id'].'" class="reg-save-button" aria-label="Save property">♡</a>
		</div>
		<p class="reg-rent-address">'.h($address_en).$da[$modelName]['bu_zyuusyo2'].'</p>
		<div class="reg-station-lines">
   '.(
function($da, $modelName, $ensenArr) {
    $stationStr = '';
    for ($i = 1; $i <= 3; $i++) {
      if (!empty($da[$modelName]['eki_en' . $i])) {
        $line = isset($ensenArr[$da[$modelName]['eki_en' . $i]]) ? $ensenArr[$da[$modelName]['eki_en' . $i]] : '';
        $station = h($da[$modelName]['eki_eki' . $i]);
        $minutes = h($da[$modelName]['eki_hun' . $i]);
        $stationStr .= '<span>' . $line . ' / ' . $station . ' / ' . $minutes . ' min walk</span>';
      }
    }
    return $stationStr;
  }
)($da, $modelName, $ensenArr).'
		</div>
		<div class="reg-rent-facts">
			<span>'.$madori1Arr[$da[$modelName]['madori1']].$da[$modelName]['madori2'].'</span>
			<span>'.$da[$modelName]['heibei'].'㎡</span>
			<span>'.$da[$modelName]['syozaikai'].'th floor</span>
			<span>Built '.$da[$modelName]['tiku_nen'].'</span>
		</div>
		<div class="reg-room-row">
			<div>
				<strong>¥'.$da[$modelName]['yatin_k'].'</strong>
				<p>Managing fee ¥'.$da[$modelName]['kyoueki_k'].' / Deposit '.$da[$modelName]['hosyou_k'].' / Key money '.$da[$modelName]['kaiyaku_k'].'</p>
			</div>
			<a href="'.$this->webroot.'Rent/view?id='.$da[$modelName]['id'].'" class="reg-detail-button">Details</a>
		</div>
	</div>
</article>
';
}
?>

<style>
/* Real Estate Guide rental search refresh */
#content.reg-rent-search {
	width: min(1180px, calc(100% - 32px)) !important;
	margin: 0 auto !important;
	padding: 42px 0 64px !important;
	background: #eef3f5 !important;
	color: #16202a;
	font-family: Arial, "Helvetica Neue", sans-serif;
}
.reg-page-title {
	margin-bottom: 22px;
}
.reg-page-title p {
	margin: 0 0 6px;
	color: #667484;
	font-size: 12px;
	font-weight: 800;
	text-transform: uppercase;
}
	.reg-page-title h1 {
		margin: 0;
		font-size: clamp(32px, 4vw, 46px);
		line-height: 1.08;
	}
	#content.reg-rent-search #search {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		align-items: start;
		gap: 16px;
		margin: 0 0 26px;
		padding: 0 20px 20px;
		border: 1px solid #dfe6ec;
		border-radius: 8px;
		background: #fff;
		box-shadow: 0 14px 36px rgba(20, 36, 50, 0.11);
	}
	#content.reg-rent-search #search form {
		display: contents;
	}
	#content.reg-rent-search #search > li:first-child {
		grid-column: 1 / -1;
		margin: 0 -20px 2px;
		padding: 0;
	}
	#content.reg-rent-search #search h2 {
		margin: 0;
		padding: 18px 20px;
		border-radius: 8px 8px 0 0;
		background: #0a6d8f;
		color: #fff;
		font-size: 22px;
	font-weight: 900;
	text-align: left;
}
	#content.reg-rent-search .search {
		display: block;
		float: none;
		padding: 0;
		color: #667484;
	font-size: 12px;
	font-weight: 800;
}
	#content.reg-rent-search select,
	#content.reg-rent-search input[type="text"] {
		width: 100%;
		min-height: 44px;
	margin-top: 7px;
	padding: 0 10px;
	border: 1px solid #cfd9e2;
	border-radius: 8px;
	background: #fff;
		color: #16202a;
		font-size: 15px;
		box-sizing: border-box;
	}
	#content.reg-rent-search .search select + select {
		margin-top: 8px;
	}
	#content.reg-rent-search .search input[type="checkbox"] {
		margin: 0 8px 0 0;
	}
	#content.reg-rent-search #setubi,
	#content.reg-rent-search #submit {
	grid-column: 1 / -1;
	border-top: 1px solid #dfe6ec;
}
#content.reg-rent-search #setubi {
	padding-top: 14px;
	text-align: left;
}
#content.reg-rent-search #setubi_menu {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 0 0 12px;
	color: #064d66;
	font-weight: 900;
}
#content.reg-rent-search #setubi_koumoku {
	display: grid;
	grid-template-columns: repeat(4, minmax(150px, 1fr));
	gap: 8px;
}
#content.reg-rent-search #setubi_koumoku label {
	float: none;
	display: inline-flex;
	align-items: center;
	gap: 8px;
	min-height: 36px;
	padding: 0 10px;
	border: 1px solid #d8e3e8;
	border-radius: 8px;
	background: #fbfdfe;
	color: #304852;
	font-size: 13px;
	font-weight: 700;
}
	#content.reg-rent-search #submit {
		padding: 16px 0 0;
		text-align: right;
	}
	#content.reg-rent-search #submit .submit {
		display: flex;
		justify-content: flex-end;
	}
#content.reg-rent-search .submit input {
	min-height: 44px;
	padding: 0 24px;
	border: 0;
	border-radius: 8px;
	background: #d45d33;
	color: #fff;
	font-size: 16px;
	font-weight: 900;
}
.reg-results-bar {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	margin-bottom: 14px;
	padding: 18px;
	border: 1px solid #dfe6ec;
	border-radius: 8px;
	background: #fff;
	box-shadow: 0 8px 22px rgba(20, 36, 50, 0.06);
}
.reg-results-bar p {
	margin: 0;
	color: #667484;
	font-size: 13px;
	font-weight: 800;
}
#content.reg-rent-search .page {
	height: auto;
	margin: 0 0 18px;
	text-align: right;
}
#content.reg-rent-search .post {
	padding: 0;
	border: 0;
	margin: 0;
	text-align: left;
	overflow: visible;
}
.reg-rent-card {
	display: grid;
	grid-template-columns: 280px minmax(0, 1fr);
	gap: 20px;
	margin-bottom: 16px;
	padding: 18px;
	border: 1px solid #dfe6ec;
	border-radius: 8px;
	background: #fff;
	box-shadow: 0 8px 22px rgba(20, 36, 50, 0.06);
}
.reg-rent-card-media {
	position: relative;
	display: block;
	min-height: 220px;
	overflow: hidden;
	border-radius: 8px;
	background: #dfe8ec;
}
.reg-rent-card-photo {
	width: 100%;
	height: 100%;
	min-height: 220px;
	object-fit: cover;
	display: block;
}
.reg-rent-card-media span {
	position: absolute;
	left: 12px;
	top: 12px;
	padding: 7px 10px;
	border-radius: 6px;
	background: rgba(255,255,255,.94);
	color: #064d66;
	font-size: 12px;
	font-weight: 900;
}
.reg-rent-card-head {
	display: flex;
	justify-content: space-between;
	gap: 14px;
	margin-bottom: 10px;
}
.reg-card-kicker {
	margin: 0 0 5px;
	color: #667484;
	font-size: 12px;
	font-weight: 800;
	text-transform: uppercase;
}
.reg-rent-card h3 {
	margin: 0;
	font-size: 24px;
	line-height: 1.2;
}
.reg-save-button {
	display: grid;
	place-items: center;
	width: 42px;
	height: 42px;
	border: 1px solid #dfe6ec;
	border-radius: 8px;
	color: #d45d33 !important;
	background: #fff;
	font-size: 22px;
	text-decoration: none;
}
.reg-rent-address {
	margin: 0 0 10px;
	color: #667484;
	line-height: 1.5;
}
.reg-station-lines,
.reg-rent-facts {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 12px;
}
.reg-station-lines span,
.reg-rent-facts span {
	min-height: 32px;
	padding: 8px 11px;
	border-radius: 999px;
	background: #edf6f6;
	color: #225a61;
	font-size: 13px;
	font-weight: 800;
}
.reg-room-row {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 14px;
	padding-top: 14px;
	border-top: 1px solid #dfe6ec;
}
.reg-room-row strong {
	display: block;
	color: #d45d33;
	font-size: 28px;
	line-height: 1.1;
}
.reg-room-row p {
	margin: 6px 0 0;
	color: #667484;
	font-size: 13px;
	line-height: 1.5;
}
.reg-detail-button {
	min-height: 40px;
	padding: 11px 18px;
	border-radius: 8px;
	background: #0a6d8f;
	color: #fff !important;
	font-weight: 900;
	text-decoration: none;
}
	@media (max-width: 900px) {
		#content.reg-rent-search #search,
		#content.reg-rent-search #setubi_koumoku {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	.reg-rent-card {
		grid-template-columns: 1fr;
	}
}
@media (max-width: 620px) {
	#content.reg-rent-search #search,
	#content.reg-rent-search #setubi_koumoku {
		grid-template-columns: 1fr;
	}
	.reg-results-bar,
	.reg-room-row {
		align-items: stretch;
		flex-direction: column;
	}
}
</style>

<div id="content" class="reg-rent-search">
<div class="reg-page-title">
	<p>Rental property search</p>
	<h1>Find your next apartment in Japan</h1>
</div>
<ul id="search">
	<li><h2>Search conditions</h2></li>
<?php
$syubetuArr2 = array();
foreach($syubetuArr as $key => $val){
	$syubetuArr2[$key] = str_replace('<br />', '', $syubetuArr[$key]);
}
echo $this->Form->create(false,array('type'=>'get','url'=>'search','name'=>'searchForm'))."\n";
?>
<?php echo $this->Form->hidden('zipcode', ['id' => 'zipcode']); ?>
<?php echo $this->Form->hidden('shicd', ['id' => 'shicd']); ?>
<li class="search">Prefecture：<?php echo $this->Form->select('ti',$tiikiArr,array('empty'=>false,'id'=>'ti','onchange'=>'cityandline()'))."\n"; ?>
</li>
<li class="search">City：<?php echo $this->Form->select('city',$cityArr,array('empty'=>false,'id'=>'city','onchange'=>'street()'))."\n"; ?>
<li class="search">District：<?php echo $this->Form->select('district',$districtArr,array('empty'=>false))."\n"; ?></li>

<li class="search">Type：<?php echo $this->Form->select('sy',$syubetuArr2,array('empty'=>false))."\n"; ?>
</li>
<li class="search">Train line：<?php echo $this->Form->select('en',$ensenArr,array('id'=>'en','onchange'=>'station()'))."\n"; ?>
</li>
<li class="search">Station：<?php echo $this->Form->select('ek',$ekiSeArr,array('id'=>'eki','empty'=>false))."\n"; ?>
</li>
<li class="search">Rent：<?php echo $this->Form->select('ts',$tinryouStartArr,array('empty'=>false))."\n"; ?>
 Yen ～ <?php echo $this->Form->select('te',$tinryouEndArr,array('empty'=>false))."\n"; ?>  Yen</li>
<li class="search">Layout：<?php echo $this->Form->select('ms',$madori1Arr,array('empty'=>false))."\n".
$this->Form->select('mt',$madori2Arr,array('empty'=>false))."\n"; ?></li>

<li class="search">
  <label>
    <input type="checkbox" name="keymoney0" value="1"
      <?php if (!empty($this->request->query['keymoney0'])) echo 'checked="checked"'; ?> />
    No Key Money
  </label>
</li>

<li id="setubi">
<div class="accordion_head" id="setubi_menu">Features ↓Open Click</div>
<div id="setubi_koumoku">
<?php
$setubi = '';
$seCheck = 1;
foreach($setubiArr as $key => $val){
	if($val != ''){
		$checked = '';
		if(!empty($this->request->query['s'.$key])){$checked = ' checked="checked"';$seCheck = 1;}
		$setubi .= '<label><input name="s'.$key.'" type="checkbox" value="1"'.$checked.'>'.$val.'</label>'."\n";
	}
}
if($seCheck == 1){
	$setubi .= '<script type="text/javascript">
$(document).ready(function(){
	$(".accordion_head").next().show();
	document.getElementById(\'setubi_menu\').innerHTML = \'Features ↑Close Click\';
});
</script>';
}
echo $setubi;
?>
</div>
</li>
<li id="submit">
<div class="submit">
<?php echo $this->Form->end(array(
  'label'=>'Search',
  'div'=>false,
  'onclick'=>'return clearShicdIfNeeded();'
)); ?>
</div>
</li>
</ul>
<div class="reg-results-bar">
	<div>
		<p>Search results</p>
		<strong><?php echo $this->Paginator->counter('Search result: {:count} rooms'); ?></strong>
	</div>
		<span>30 per page</span>
</div>
<p class="page">
		<span id="line"><?php echo '30 per page / '.
		$this->Paginator->counter('Total {:pages} pages / Search result: {:count}'); ?>
	</span>
<span class="mobile"><br /><br /></span>
<?php
if ($this->Paginator->hasPrev()) {	echo $this->Paginator->prev('back');
}else{echo '&nbsp;&nbsp;';}
echo '&nbsp;&nbsp;'.$this->Paginator->numbers().'&nbsp;&nbsp;';
if ($this->Paginator->hasNext()) {echo $this->Paginator->next('next');
}else{echo '&nbsp;&nbsp;';}
?>
</p>
<?php echo $table; ?>
<p class="page">
	<?php echo $this->Paginator->first('back',array()).'&nbsp;'.
	$this->Paginator->numbers().'&nbsp;'.
	$this->Paginator->last('next',array()); ?>
</p>
<p>&nbsp;</p>
</div>

<script type="text/javascript">
var ekis = new Array();



<?php echo $ekiArJs; ?>




var line_start = 0;
var city_start = 0;
var street_start = 0;



var local = window.location;
	var url = local.origin;
	url + getDir(local); // 現在のディレクトリ
	url + getDir(local,1); // 1つ上のディレクトリ

function getDir(place, n) {
	return place.pathname.replace(new RegExp("(?:\\\/+[^\\\/]*){0," + ((n || 0) + 1) + "}$"), "/");
}

var trains;


var address;


function cityandline(){
    var i = 0;
    var ind = 0;
    var prev_city = "";
    var cur_city = "";
    var pref_started = 0;
    // ----- City Select Box -------------------------
	document.getElementById('city').selectedIndex = 0;

	const prefMap = {
  1: 11, // Saitama
  2: 12, // Chiba
  3: 13, // Tokyo ←ココ！
  4: 14, // Kanagawa
  5: 27,
  6: 26,
  7: 23

};

var s_pref = parseInt(document.getElementById('ti').value);
var actual_pref_code = prefMap[s_pref]; // これを使って比較

	let citySet = new Set();
	Object.keys(address).forEach((key) => {
    	if (parseInt(address[key]["pref"]) === actual_pref_code) {
        	citySet.add(address[key]["cityward_en"]);
    	}
	});

	const citys = Array.from(citySet);
	document.getElementById('city').length = citys.length + 1;
	for (let i = 0; i < citys.length; i++) {
    	document.getElementById('city').options[i + 1].value = i;
    	document.getElementById('city').options[i + 1].text = citys[i];
	}


    // Train line ------------------
    i = 0;
    ind = 0;
    var prev_line = "";
    var cur_line = "";
    pref_started = 0;
    var lines = [];

    document.getElementById('en').selectedIndex = 0;

    Object.keys(trains).forEach((key) => {
        if (parseInt(trains[key]["pref"]) === actual_pref_code) {
            pref_started = 1;
            cur_line = trains[key]["linename_en"];

            if (line_start == 0) {
                line_start = key;
            }

            if (cur_line != prev_line) {
                lines[cur_line] = trains[key]["linecode"];;
                prev_line = cur_line;
                ind++;
            }
        }
    });

    document.getElementById('en').length = ind+1;
    for (let i = 0; i < ind; i++) {
        const keys = Object.keys(lines);
document.getElementById('en').length = keys.length + 1;
for (let i = 0; i < keys.length; i++) {
    document.getElementById('en').options[i + 1].value = lines[keys[i]];
    document.getElementById('en').options[i + 1].text = keys[i];
}

    }

    // 復元（City）
const prevCity = <?php echo json_encode($this->request->query('city') ?? ''); ?>;
if (prevCity !== '') {
    document.getElementById('city').value = prevCity;
    street();
}

// 復元（Train Line）
const prevLine = <?php echo json_encode($this->request->query('en') ?? ''); ?>;
if (prevLine !== '') {
    document.getElementById('en').value = prevLine;
    station(); // ← 駅セレクトボックスを再構築
}

}

function street(){


	var i = 0;
	var ind = 0;
	var prev_street = "";
	var cur_street = ""
	var city_started = 0;
	var streets = [];

	if (document.getElementById('city').selectedIndex == 0) {
		document.getElementById('district').length = 1;
		document.getElementById('district').selectedIndex = 0;
	}else{
		document.getElementById('district').selectedIndex = 0;

		var s_city = document.getElementById('city').options[document.getElementById('city').selectedIndex].textContent;

		
		Object.keys(address).forEach((key) => {

			if (address[key]["cityward_en"] == s_city) {

				

				city_started = 1;
				
				cur_street = address[key]["street_en"];
				
				if (street_start == 0) {
					street_start = key;
				}

				if(cur_street != prev_street) {
					
					
					streets[ind]=address[key]["street_en"];
					prev_street = cur_street;
					ind ++;
				}
			}
			else {
				if (city_started == 1) {
				
					return;
				}
			}
		});


		document.getElementById('district').length = ind+1;
		for (let i = 0; i < ind; i++) {
  			document.getElementById('district').options[i + 1].value = i;
	    	document.getElementById('district').options[i + 1].text = streets[i];
		}

	}

	const prevDistrict = <?php echo json_encode($this->request->query('district') ?? ''); ?>;
	if (prevDistrict !== '') {
 		 document.getElementById('district').value = prevDistrict;

  		// district が入った「後」で呼ぶ！
  		updateZipcode();
	}

	


}

function station() {
    const ekiSelect = document.getElementById('eki');
    ekiSelect.length = 1;  // 最初の空要素だけ残す
    ekiSelect.selectedIndex = 0;

    const lineSelect = document.getElementById('en');
    if (lineSelect.selectedIndex === 0) return;

    const selectedLineCode = lineSelect.options[lineSelect.selectedIndex].value;

    // 同じ linecode の駅をすべて取得
    const stationsMap = {};

    trains.forEach((station) => {
        if (station.linecode === selectedLineCode) {
            if (!stationsMap[station.stationcode]) {
                stationsMap[station.stationcode] = station.stationname_en;
            }
        }
    });

    // 駅を追加
    const codes = Object.keys(stationsMap);
    for (let i = 0; i < codes.length; i++) {
        const option = document.createElement('option');
        option.value = codes[i];                          // ← value に stationcode
        option.textContent = stationsMap[codes[i]];       // ← 表示に駅名
        ekiSelect.appendChild(option);
    }

    // 復元
    const prevStation = <?php echo json_encode($this->request->query('ek') ?? ''); ?>;
    if (prevStation !== '') {
        ekiSelect.value = prevStation;
    }
}



Promise.all([
  fetch('/search/trains.json').then(res => res.json()),
  fetch('/search/address.json').then(res => res.json())
])
.then(([trainsData, addressData]) => {
  console.log('trains loaded:', trainsData.length, 'items');
  console.log('address loaded:', addressData.length, 'items');

  trains = trainsData;
  address = addressData;

  // ? JSONロード完了後に初期処理を実行
  const prevPref = <?php echo json_encode($this->request->query('ti') ?? ''); ?>;
  if (prevPref !== '') {
    document.getElementById('ti').value = prevPref;
  }

  cityandline(); // ← ここで呼ぶ！
  station();     // ← ここで呼ぶ！

})
.catch(err => {
  console.error('? JSON load error:', err);
});


function updateZipcode() {
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');

    const zipcodeField = document.getElementById('zipcode');
    const shicdField = document.getElementById('shicd');

    if (!citySelect || citySelect.selectedIndex < 0 ||
        !citySelect.options[citySelect.selectedIndex]) {
        console.warn("City select not ready");
        return;
    }

    const selectedCity = citySelect.options[citySelect.selectedIndex].textContent;

    // ▼ Districtが未選択（インデックス0は空要素）
    if (!districtSelect || districtSelect.selectedIndex <= 0 ||
        !districtSelect.options[districtSelect.selectedIndex]) {
        zipcodeField.value = '';  // ← zipは使わない
        const shicdEntry = address.find(entry => entry.cityward_en === selectedCity);
        if (shicdEntry) {
            shicdField.value = shicdEntry.citywardnum.toString();
        }
        return;
    }

    // ▼ Districtが選択されている場合
    const selectedDistrict = districtSelect.options[districtSelect.selectedIndex].textContent;

    const selectedZip = address.find(entry =>
        entry.cityward_en === selectedCity &&
        entry.street_en === selectedDistrict
    );

    if (selectedZip) {
        zipcodeField.value = selectedZip.zip.toString();
        shicdField.value = ''; // ← shicdはクリアする
    }
}

function updateShicd() {
    const selectedCity = document.getElementById('city').options[document.getElementById('city').selectedIndex].textContent;
	//Console.log(selectedCity);
    const selectedShicd = address.find(entry => entry.cityward_en === selectedCity);
    if (selectedShicd) {
        document.getElementById('shicd').value = selectedShicd.citywardnum.toString();
    }
}

function clearShicdIfNeeded() {
  const shicd = document.getElementById('shicd');
  const zipcode = document.getElementById('zipcode');
  const district = document.getElementById('district');
  const city = document.getElementById('city');

  const districtSelected = district && district.selectedIndex > 0;
  const citySelected = city && city.selectedIndex > 0;

  if (!districtSelected && !citySelected) {
    shicd.value = '';
    zipcode.value = '';
    // disabled はやめる（Controller側で判断できなくなる）
  }
  return true;
}

// ↓ これらのセレクトボックス変更時に実行
window.addEventListener('DOMContentLoaded', function () {
  document.getElementById('district').addEventListener('change', updateZipcode);
  document.getElementById('city').addEventListener('change', updateShicd);
});
</script>
<script>
let trains = [];

fetch('/search/trains.json')
  .then(response => response.json())
  .then(data => {
    trains = data;

    document.getElementById('ti').addEventListener('change', function () {
      const selectedPref = parseInt(this.value);
      const lineSelect = document.getElementById('en');
      lineSelect.innerHTML = '';

      const usedLines = {};

      trains.forEach(station => {
        if (parseInt(station.pref) === selectedPref) {
          if (!usedLines[station.linecode]) {
            usedLines[station.linecode] = station.linename_en;
          }
        }
      });

      for (const code in usedLines) {
        const opt = document.createElement('option');
        opt.value = code;
        opt.textContent = usedLines[code];
        lineSelect.appendChild(opt);
      }
    });
  });
</script>

<?php echo $this->element('bottom_content'); ?>
