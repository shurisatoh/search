<script type="text/javascript">
var ekis = new Array();



<?php echo $ekiArJs; ?>




var line_start = 0;


var local = window.location;
	var url = local.origin;
	url + getDir(local); // 現在のディレクトリ
	url + getDir(local,1); // 1つ上のディレクトリ

function getDir(place, n) {
	return place.pathname.replace(new RegExp("(?:\\\/+[^\\\/]*){0," + ((n || 0) + 1) + "}$"), "/");
}

var trains;


var address;


window.line = function(){
  const ti = parseInt(document.getElementById('ti').value);
  const prefMap = {
    1: 11, // Saitama
    2: 12, // Chiba
    3: 13, // Tokyo
    4: 14  // Kanagawa
  };
  const actualPref = prefMap[ti];

  const enSelect = document.getElementById('en');
  enSelect.length = 1; // 初期化
  const lineSet = new Set();
  const lineMap = {};

  trains.forEach((station) => {
    if (parseInt(station.pref) === actualPref) {
      if (!lineSet.has(station.linename_en)) {
        lineSet.add(station.linename_en);
        lineMap[station.linename_en] = station.linecode;
      }
    }
  });

  const lineNames = Array.from(lineSet);
  for (let i = 0; i < lineNames.length; i++) {
    const option = document.createElement('option');
    option.value = lineMap[lineNames[i]];
    option.textContent = lineNames[i];
    enSelect.appendChild(option);
  }

  // 復元
  const prevLine = <?php echo json_encode($this->request->query('en') ?? ''); ?>;
  if (prevLine !== '') {
    enSelect.value = prevLine;
    station();
  }
};


window.station = function()  {
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

  line(); // ← ここで呼ぶ！
  station();     // ← ここで呼ぶ！

})
.catch(err => {
  console.error('? JSON load error:', err);
});


</script>

<?php


$this->Html->css('admin.search', null, array('inline' => false));
$this->Html->script(array('search','jquery-1.7.2.min','jquery-accordion'),array( 'inline' => false ));

App::import('Vendor', 'configHouse');
$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$setubiArr = setubiArr();
$tiikiArr = tiikiArr();
$eki_koArr = eki_koArr();
$kakakuStartArr = kakakuStartArr();
$kakakuEndArr = kakakuEndArr();

App::import('Vendor', 'configHouseEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();

$ekiSeArr = array(''=>'　　　');
if(!empty($this->request->query['en']) && $this->request->query['en'] != 0){
	foreach($ekiArr[$this->request->query['en']] as $key => $val){
		$ekiSeArr[$key] = $val;
	}
}

$ekiArJs = '';
foreach($ekiArr as $key => $val){
	$ekiArJs .= 'ekis['.$key.'] = new Array(';
	foreach($val as $ke => $va){
		if($ke == 1){
			$ekiArJs .= '"'.$va.'"';
		}else{
			$ekiArJs .= ',"'.$va.'"';
		}
	}
	$ekiArJs .= ');'."\n";
}

$pageArrey = explode('se/search', $_SERVER['REQUEST_URI']);

$table = '';
foreach( $data as $da ){
	$this->request->data[$modelName]['id'] = $da[$modelName]['id'];
	if(!empty($da[$modelName]['gaikan_img'])){
		if($da[$modelName]['gaikan_img'] == 1){
			$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/house/gazou/'.$da[$modelName]['id'].'_0.jpg" width="100" border="0" />';
		}elseif($da[$modelName]['gaikan_img'] == 2){
			$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/house/gazou/'.$da[$modelName]['id'].'_0.jpg" height="100" border="0" />';
		}else{
			$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/house/gazou/'.$da[$modelName]['id'].'_0.jpg" border="0" />';
		}
	}else{
		$da[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/house/gazou/'.$da[$modelName]['id'].'_0.jpg" border="0" />';
	}
	//--金額カンマ挿入処理
	$nfArray = array('kakaku');
	foreach( $nfArray  as $va ){
		if(is_numeric($da[$modelName][$va])){$da[$modelName][$va] = number_format($da[$modelName][$va]);}
	}
	for($a = 1; $a <= 3; $a++) {
		if(!empty($da[$modelName]['eki_eki'.$a])){
			$da[$modelName]['eki_eki'.$a] = $ekiArr[$da[$modelName]['eki_en'.$a]][$da[$modelName]['eki_eki'.$a]];
		}
		if(!empty($da[$modelName]['eki_en'.$a])){
			$da[$modelName]['eki_en'.$a] = $ensenArr[$da[$modelName]['eki_en'.$a]];
		}
		$da[$modelName]['eki_ko'.$a] = $eki_koArr[$da[$modelName]['eki_ko'.$a]];
		if(!empty($da[$modelName]['eki_hun'.$a])){
			$da[$modelName]['eki_hun'.$a] = $da[$modelName]['eki_hun'.$a].'分';
		}
	}
	if($da[$modelName]['new'] == 1){
		$dateTo = preg_replace("/-/", '', $da[$modelName]['touroku_date']);
		$dateNew =date("Ymd", strtotime(date("Y-m-d").' -'.DATE_NEW.' day'));
		if($dateTo >= $dateNew){
			$da[$modelName]['new'] = '<span class="new">NEW!</span>　';
		}else{
			$da[$modelName]['new'] = '';
		}
	}else{
		$da[$modelName]['new'] = '';
	}
	if($da[$modelName]['hp_hyouzi'] == 1){
		$da[$modelName]['hp_hyouzi'] = '<font color="#0000FF">表示なし</font>　';
	}else{
		$da[$modelName]['hp_hyouzi'] = '';
	}
	$table .= '
<div class="post">
	<table width="693">
		<tr>
		<td width="100" height="100" align="center">
			'.$da[$modelName]['gaikan_img'].'
		</td>
		<td align="center" width="139">
			<span class="pu">'.$da[$modelName]['kakaku'].'</span><br />
			<span class="pu">'.$madori1Arr[$da[$modelName]['madori1']].$madori2Arr[$da[$modelName]['madori2']].'</span>
		</td>
		<td align="center" width="74">
			'.$da[$modelName]['totimen'].'㎡<br />
			'.$da[$modelName]['tatemen'].'㎡
		</td>
		<td align="center" width="181">
			'.$da[$modelName]['bukkenmei'].'<br />
			'.$da[$modelName]['eki_en1'].$da[$modelName]['eki_eki1'].$da[$modelName]['eki_ko1'].$da[$modelName]['eki_hun1'].'<br />
			'.$da[$modelName]['eki_en2'].$da[$modelName]['eki_eki2'].$da[$modelName]['eki_ko2'].$da[$modelName]['eki_hun2'].'<br />
			'.$da[$modelName]['eki_en3'].$da[$modelName]['eki_eki3'].$da[$modelName]['eki_ko3'].$da[$modelName]['eki_hun3'].'<br />
			'.$da[$modelName]['bu_zyuusyo1'].'
		</td>
		<td align="center" width="96">
			No.'.$da[$modelName]['id'].'<br />
			'.$syubetuArr[$da[$modelName]['syubetu']].'<br />
			'.$da[$modelName]['tiku_nen'].'年'.$da[$modelName]['tiku_tuki'].'月
		</td>
		<td align="center" width="75">
			<a href="'.$this->webroot.'AdminHouse/daityou?id='.$da[$modelName]['id'].'" target="_blank">台帳</a><br>
			<a href="'.$this->webroot.'AdminHouse/kanban?id='.$da[$modelName]['id'].'" target="_blank">看板</a><br>
			<a href="'.$this->webroot.'AdminHouse/zyouhou?id='.$da[$modelName]['id'].'" target="_blank">情報</a>
		</td>
		</tr>
		<tr>
		<td colspan="6" align="center">
'.$this->Form->create(false,array('type'=>'post','url'=>'delRecord','onSubmit'=>"return check('ID:{$da[$modelName]['id']}')"))."\n"
.$this->Form->hidden('page',array('value'=> $pageArrey[1]))."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->end(array('label'=>'削除','div'=>false))."\n"
.$this->Form->create(false,array('type'=>'post','url'=>'imgAdd'))."\n"
.$this->Form->hidden('page',array('value'=> $pageArrey[1]))."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->end(array('label'=>'画像','div'=>false))."\n"
.$this->Form->create(false,array('type'=>'post','url'=>'add'))."\n"
.$this->Form->hidden('page',array('value'=> $pageArrey[1]))."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->end(array('label'=>'変更','div'=>false)).'
			<form>'.$da[$modelName]['new'].$da[$modelName]['hp_hyouzi'].$da[$modelName]['touroku_date'].'　</form>
		</td>
		</tr>
	</table>
</div>
';
}
?>

<!-- コンテナ -->
<div id="container">
	<!-- ヘッダー -->
	<div id="header">
		<!-- ナビゲーションバー -->
		<div id="nav">
		<p id="page_title">Property Search System 管理 <font color="#0000FF">売買</font> 検索</p>
		</div>
	</div>
	<div id="container-inner">
		<!-- サイドバー -->
		<div id="sidebar">
			<ul>
				<li class="widget widget_pages"><h2 class="widgettitle">検索</h2>
				<ul>
<?php echo $this->Form->create(false,array('type'=>'get','url'=>'search','name'=>'searchForm'))."\n"; ?>
			<li id="search">地域&nbsp;
<?php echo $this->Form->select('ti',$tiikiArr,array('empty'=>false,'id'=>'ti','onchange'=>'line()'))."\n"; ?>
</li>
<li id="search">種別&nbsp;
<?php echo $this->Form->select('sy',$syubetuArr,array('empty'=>false))."\n"; ?>
</li>
<li id="search">沿線&nbsp;
<?php echo $this->Form->select('en',$ensenArr,array('id'=>'en','onchange'=>'station()'))."\n"; ?>
</li>
<li id="search">駅　&nbsp;
<?php echo $this->Form->select('ek',$ekiSeArr,array('id'=>'eki','empty'=>false))."\n"; ?>
</li>
<li id="search">価格&nbsp;
<?php echo $this->Form->select('ts',$kakakuStartArr,array('empty'=>false))."\n"; ?>
 円 ～<br />　　&nbsp;
<?php echo $this->Form->select('te',$kakakuEndArr,array('empty'=>false))."\n"; ?>
 円</li>
<li id="search">間取り&nbsp;
<?php echo $this->Form->select('ms',$madori1Arr,array('empty'=>false))."\n".
$this->Form->select('mt',$madori2Arr,array('empty'=>false))."\n"; ?>
</li>
<li id="search">
物件番号&nbsp;
<?php echo $this->Form->text('id',array('size'=>10)); ?>
</li>
<li id="search">
Word&nbsp;
<?php echo $this->Form->text('wo',array('size'=>15)); ?>
<br /><font size="-2">　（物件名・売主・売主担当・<br />　　コメント・備考）</font>
</li>
<li id="search">
新　築&nbsp;
<?php echo $this->Form->checkbox('si'); ?>
</li>
<li id="search">
お客様HP表示なし&nbsp;
<?php echo $this->Form->checkbox('oh'); ?>
</li>
<li id="setubi">
<div class="accordion_head" id="setubi_menu">設備 ↓Open Click</div>
<div id="setubi_koumoku">
<?php
$setubi = '';
$seCheck = 0;
foreach($setubiArr as $key => $val){
	if($val != ''){
		$checked = '';
		if(!empty($this->request->query['s'.$key])){$checked = ' checked="checked"';$seCheck = 1;}
		$setubi .= '<label><input name="s'.$key.'" type="checkbox" value="1"'.$checked.'>'.$val.'</label><br />'."\n";
	}
}
if($seCheck == 1){
	$setubi .= '<script type="text/javascript">
$(document).ready(function(){
	$(".accordion_head").next().show();
	document.getElementById(\'setubi_menu\').innerHTML = \'設備 ↑Close Click\';
});
</script>';
}
echo $setubi;
?>
</div>
</li>
<li id="submit">
	<div class="submit">
<?php echo $this->Form->end(array('label'=>'検索','div'=>false)); ?>
	</div>
</li>
				</ul>
				</li>
			</ul>
			<!-- ナビゲーション -->
			<ul>
				<li class="widget widget_pages">
				<ul>
					<li id="submit">
					<div class="submit"><br />
					<form method="post" action="<?php echo $this->webroot; ?>AdminHouse/add">
					<?php echo $this->Form->hidden('page',array('value'=> $pageArrey[1]))."\n"; ?>
					<input value="登録" type="submit" />
					</form>
					</div>
					</form><br />
					</li>
				</ul>
				</li>
			</ul>
		</div>
		<!-- コンテンツ -->
		<div id="content">
		<p class="page">
	<span id="line">　<?php echo PAGE_NUMK.'件表示／'.
		$this->Paginator->counter('全{:pages}ページ　検索結果:{:count}件'); ?>
	</span>
<?php
if ($this->Paginator->hasPrev()) {	echo $this->Paginator->prev('back');
}else{echo '　　';}
echo '　　'.$this->Paginator->numbers().'　　';
if ($this->Paginator->hasNext()) {echo $this->Paginator->next('next');
}else{echo '　　';}
?>
		</p>
		<div class="post">
		<table width="693" align="center"><tr>
		<td width="97" align="center" class="bkco">画像</td>
<td width="142" align="center" class="bkco">
<?php echo $this->Paginator->sort('kakaku','価格'); ?><br />
<?php echo $this->Paginator->sort('madori1','間取り'); ?></td>
<td width="74" align="center" class="bkco">
<?php echo $this->Paginator->sort('totimen','土地面積'); ?><br />
<?php echo $this->Paginator->sort('tatemen','建物面積'); ?></td>
<td width="181" align="center" class="bkco">物件名<br />最寄沿線 駅 徒歩<br />住所</td>
<td width="96" align="center" class="bkco">物件No<br />種別<br />
<?php echo $this->Paginator->sort('tiku_nen','築年月'); ?>
</td>
<td width="75" align="center" class="bkco">台帳<br />看板<br />情報</td>
		</tr>
		<tr>
		 <td colspan="6" align="right" class="bkco"><form>NEW!!　お客様HP　
<?php echo $this->Paginator->sort('touroku_date','入力日'); ?>
　　変更　 　画像　 　削除</form></td>
		</tr>
		</table>
		</div>
<?php echo $table; ?>
		<p class="page">
		<?php echo $this->Paginator->first('back',array()).'&nbsp;'.
		$this->Paginator->numbers().'&nbsp;'.
		$this->Paginator->last('next',array()); ?>
		</p>
		</div>
	</div>
	<!-- フッター -->
	<div id="footer">
		<div id="footer-inner">
			<div class="copyright">
				<hr width="950" size="1" />
				Property Search System Copyright(C) <a href="https:realestateguide.jp" target="_blank">ITS</a>
			</div>
		</div>
	</div>
</div>