<?php echo $this->element('top_content'); ?>
<?php

$modelName = 'house'; 

$this->Html->css('home', null, array('inline' => false));

$this->Html->script(array('jquery-1.7.2.min','jquery-accordion'),array( 'inline' => false ));

App::import('Vendor', 'configHouse');

$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$setubiArr = setubiArr();
$tiikiArr = tiikiArr();
$cityArr = array();
$districtArr = array();
$eki_koArr = eki_koArr();
$kakakuStartArr = kakakuStartArr();
$kakakuEndArr = kakakuEndArr();


unset($tiikiArr[0]);

// address.json 読み込みと zipcode → 英語住所変換用
$addressJson = file_get_contents(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'address.json');
$addressArr = json_decode($addressJson, true);

function getEnglishAddress($zipcode, $addressArr) {
    // 不要なゼロ埋めは削除！
    foreach ($addressArr as $entry) {
        if ((int)$entry['zip'] === (int)$zipcode) {
            return $entry['prefecture_en'] . ', ' . $entry['cityward_en'] . ', ' . $entry['street_en'];
        }
    }
    return '';
}

function getEnglishAddressByShicd($shicd, $addressArr) {
    foreach ($addressArr as $entry) {
        if ((int)$entry['citywardnum'] == (int)$shicd) {
            return $entry['prefecture_en'] . ', ' . $entry['cityward_en'];
        }
    }
    return '';
}

App::import('Vendor', 'configHouseEki');

$ensenArr = ensenArr();
$ekiArr = ekiArr();




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
$address_en_list = array(); // ★ ここで先に定義

if (!empty($data)) {
    foreach ($data as $da) {

        $id = $da[$modelName]['id'];
        $zipcode = $da[$modelName]['zipcode'];
        $shicd = $da[$modelName]['shicd'];

        if (!empty($zipcode)) {
            $address_en = getEnglishAddress($zipcode, $addressArr);
        } elseif (!empty($shicd)) {
            $address_en = getEnglishAddressByShicd($shicd, $addressArr);
        } else {
            $address_en = '';
        }

        $address_en_list[(string)$id] = $address_en;
    }
}

foreach( $data as $key => $da ){
	if(!empty($da[$modelName]['gaikan_img'])){
		
			$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/house/gazou/'.$da[$modelName]['id'].'_0.jpg" width="100" border="0" />';
		
	}else{
		$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/noimage100.gif" border="0" />';
	}
	//--金額カンマ挿入処理
	$nfArray = array('kakaku');
	foreach( $nfArray  as $va ){
		if(is_numeric($da[$modelName][$va])){$da[$modelName][$va] = number_format($da[$modelName][$va]);}
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
<div class="post" id="list'.$key.'" style="display:none;">
		<table class="list"><tr><td width="93" align="center">
			<a href="'.$this->webroot.'HOuse/view?id='.$da[$modelName]['id'].'">
				'.$da[$modelName]['gaikan_img'].'
			</a>
		</td></tr></table>
		<table class="list"><tr><td align="center" width="140">
						'.'<br />

			'.$da[$modelName]['tatemen'].'㎡
		</td></tr></table>
		<table class="list"><tr><td align="center" width="177">
			    '.h($address_en_list[$da[$modelName]['id']]).$da[$modelName]['bu_zyuusyo2'].'<br />
   '.(
function($da, $modelName, $ensenArr) {
    $stationStr = '';
    for ($i = 1; $i <= 3; $i++) {
      if (!empty($da[$modelName]['eki_en' . $i])) {
        $line = isset($ensenArr[$da[$modelName]['eki_en' . $i]]) ? $ensenArr[$da[$modelName]['eki_en' . $i]] : '';
        $station = h($da[$modelName]['eki_eki' . $i]);
        $minutes = h($da[$modelName]['eki_hun' . $i]);
        $stationStr .= $line . ' ' . $station . ' ' . $minutes . ' minutes walk<br />';
      }
    }
    return $stationStr;
  }
)($da, $modelName, $ensenArr).'
 
			
		</td></tr></table>
		<table class="list"><tr><td align="center" width="92">
			'.$da[$modelName]['new'].'
			No.'.$da[$modelName]['id'].'<br />
			'.$syubetuArr[$da[$modelName]['syubetu']].'<br />
			'.'Constructed in '.$da[$modelName]['tiku_nen'].' '.'
		</td></tr></table>
		<table class="list"><tr><td align="center" width="56">
			<a href="'.$this->webroot.'House/view?id='.$da[$modelName]['id'].'" class="viewlink">Details</a>
		</td></tr></table>
</div>
';
}
?>

<!-- コンテンツ -->
<div id="content">
<p>&nbsp;</p>
<ul id="search">
	<li><h2>Search</h2></li>
<?php

echo $this->Form->create(false,array('type'=>'get','url'=>'map','name'=>'searchForm'))."\n";
?>
<?php echo $this->Form->hidden('zipcode', ['id' => 'zipcode']); ?>
<?php echo $this->Form->hidden('shicd', ['id' => 'shicd']); ?>
<li class="search">Prefecture：<?php echo $this->Form->select('ti',$tiikiArr,array('empty'=>false,'id'=>'ti','onchange'=>'cityandline()'))."\n"; ?>
</li>
<li class="search">City：<?php echo $this->Form->select('city',$cityArr,array('empty'=>false,'id'=>'city','onchange'=>'street()'))."\n"; ?>
<li class="search">District：<?php echo $this->Form->select('district',$districtArr,array('empty'=>false))."\n"; ?></li>

<li class="search">Type：<?php echo $this->Form->select('sy',$syubetuArr,array('empty'=>false))."\n"; ?>
</li>
<li class="search">Train line：<?php echo $this->Form->select('en',$ensenArr,array('id'=>'en','onchange'=>'station()'))."\n"; ?>
</li>
<li class="search">Station：<?php echo $this->Form->select('ek',$ekiSeArr,array('id'=>'eki','empty'=>false))."\n"; ?>
</li>
<li class="search">Price：<?php echo $this->Form->select('ts',$kakakuStartArr,array('empty'=>false))."\n"; ?>
 Yen ～ <?php echo $this->Form->select('te',$kakakuEndArr,array('empty'=>false))."\n"; ?> Yen</li>
<li class="search">Layout：<?php echo $this->Form->select('ms',$madori1Arr,array('empty'=>false))."\n".
$this->Form->select('mt',$madori2Arr,array('empty'=>false))."\n"; ?></li>
<li id="setubi">
<div class="accordion_head" id="setubi_menu">Equipments ↓Open Click</div>
<div id="setubi_koumoku">
<?php
$setubi = '';
$seCheck = 0;
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
	document.getElementById(\'setubi_menu\').innerHTML = \'Equipments ↑Close Click\';
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

	</li>
</ul>
<p class="page">
	<span id="line">　<?php echo PAGE_NUMK.' per page／'.
		$this->Paginator->counter('Total{:pages} pages　Search result: {:count}'); ?>
	</span>
<span class="mobile"><br /><br /></span>
<?php
if ($this->Paginator->hasPrev()) {	echo $this->Paginator->prev('back');
}else{echo '　　';}
echo '　　'.$this->Paginator->numbers().'　　';
if ($this->Paginator->hasNext()) {echo $this->Paginator->next('next');
}else{echo '　　';}
?>
</p>
<style type="text/css">
#map_canvas {
    width: 98%;
    height: 600px;
    margin-right: auto;
    margin-left: auto;
    border-width: 1px;
    border-style: dotted;
    border-color: #CCCCCC;
}
#content .gm-style-iw-d {
	color: #398FCA;
}
</style>
<div class="post">
	<div id="map_canvas"></div>
</div>

<script type="text/javascript">
var markerData = [
<?php
foreach ($data as $key => $da) {
    $id = $da[$modelName]['id'];
    $address_full = h($address_en_list[$id] . $da[$modelName]['bu_zyuusyo2']); // ← ここに修正
    $name = 'No.' . $da[$modelName]['id'] . '<br />' .
            $madori1Arr[$da[$modelName]['madori1']] . $da[$modelName]['madori2'] . '<br />' .
            number_format($da[$modelName]['kakaku']) . ' Yen';
    echo '{ name: "' . $name . '", address: "' . $address_full . '" }';
    if (isset($data[$key + 1])) echo ",";
}
?>
];
</script>


<script type="text/javascript">
function initMap() {
  var add = "<?php echo $tiikiArr[$this->request->query['ti']]; ?>";
  var geocoder = new google.maps.Geocoder();

  geocoder.geocode({ address: add }, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      map = new google.maps.Map(document.getElementById("map_canvas"), {
        center: results[0].geometry.location,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      // markerData 配列から一つずつ住所をジオコードしてマーカー追加
      markerData.forEach(function(data, i) {
        geocoder.geocode({ address: data.address }, function(results2, status2) {
          if (status2 === google.maps.GeocoderStatus.OK) {
            marker[i] = new google.maps.Marker({
              position: results2[0].geometry.location,
              map: map,
              icon: '/search/img/mapicon.png'
            });

            infoWindow[i] = new google.maps.InfoWindow({
              content: data.name
            });

            marker[i].addListener('click', function() {
              infoWindow[i].open(map, marker[i]);
              var listEl = document.getElementById('list' + i);
              if (listEl) listEl.style.display = '';
            });
          } else {
            console.warn("Geocode failed for: " + data.address + " - " + status2);
          }
        });
      });

    } else {
      alert("Could not center map: " + status);
    }
  });
}


</script>


<script type="text/javascript">
//<![CDATA[
var map;
var marker = [];
var infoWindow = [];


// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
      document.getElementById('list'+i).style.display='';
  });
}
window.onload = initMap;
//]]>
</script>
<?php
App::import('Vendor', 'configGoogleMapsApiKey');
echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.GOOGLEMAPAPIKEY.'&callback=initMap&language=en"></script>';
?>
<?php echo $table; ?>
<p class="page">
	<?php echo $this->Paginator->first('back',array()).'&nbsp;'.
	$this->Paginator->numbers().'&nbsp;'.
	$this->Paginator->last('next',array()); ?>
</p>
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
  4: 14  // Kanagawa
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


console.log('?? JS start', location.pathname);

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
<?php echo $this->element('bottom_content'); ?>



