
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







Promise.all([
  fetch('/search/trains.json').then(res => res.json()),
  fetch('/search/address.json').then(res => res.json())
])
.then(([trainsData, addressData]) => {

  trains = trainsData;
  address = addressData;

  document.getElementById('en1').addEventListener('change', () => station(1));
  document.getElementById('en2').addEventListener('change', () => station(2));
  document.getElementById('en3').addEventListener('change', () => station(3));

  line(); // ← ここで呼ぶ！

})
.catch(err => {
  console.error('? JSON load error:', err);
});


</script>

<?php


$this->Html->css('admin.add', null, array('inline' => false));
$this->Html->script(array('googlemap_ad','check_add'),array( 'inline' => false ));

App::import('Vendor', 'configHouse');
$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$totisyuArr = totisyuArr();
$kouzouArr = kouzouArr();
$kokudoArr = kokudoArr();
$timokuArr = timokuArr();
$tosikeiArr = tosikeiArr();
$youtotiArr = youtotiArr();
$seigenArr = seigenArr();
$tiseiArr = tiseiArr();
$hutaikenArr = hutaikenArr();
$totikenArr = totikenArr();
$genzyouArr = genzyouArr();
$urinusikeiArr = urinusikeiArr();
$torihikitaiArr = torihikitaiArr();
$eki_koArr = eki_koArr();
$setubiArr = setubiArr();

App::import('Vendor', 'configHouseEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();
$ekiArSe = array();
$copy = '';
$ekiArJs = '';
foreach($ekiArr as $key => $var){
	$ekiArJs .= 'ekis['.$key.'] = new Array(';
	foreach($var as $ke => $va){
		if($ke == 1){
			$ekiArJs .= '"'.$va.'"';
		}else{
			$ekiArJs .= ',"'.$va.'"';
		}
	}
	$ekiArJs .= ');'."\n";
}
if(isset($this->request->data[$modelName]['id'])){
	$submit = '変更';
	for( $i = 1; $i<= 3; $i++ ){
		if(!empty($this->request->data[$modelName]['eki_en'.$i])){
			foreach($ekiArr[$this->request->data[$modelName]['eki_en'.$i]] as $key => $var){
				$ekiArSe[$i][$key] = $var;
			}
		}else{
			$ekiArSe[$i] = array();
		}
	}
	$copy = '（'.$this->Form->checkbox('copy',array('id'=>'copy','onclick'=>'copy_h()')).$this->Form->label('copy','コピーして新規登録').
	'）　　 ';
	$id = $this->request->data[$modelName]['id'];
}else{
	$submit = '登録';
	for( $i = 1; $i<= 3; $i++ ){
		$ekiArSe[$i] = array();
	}
	$id = '新規番号取得';
}

$monthAr = array();
for($a = 1; $a <= 12; $a++) {$monthAr[$a] = $a;}
?>
<script type="text/javascript">
//-----------------------------半角数字のみ（INT）
var inp = new Array("houseKakaku");
//-----------------------------半角数字のみ（TINYINT）
var inpti = new Array("houseTizyoukai","houseTikakai");
//-----------------------------半角数字のみ（SMALLINT）
var inpsm = new Array("houseKenpei","hun1","hun2","hun3","houseTikuNen","houseYouseki");
//-----------------------------必須項目
var inph = new Array("houseBukkenmei");
//-----------------------------必須項目セレクト
var inps = new Array("houseSyubetu");
//-----------------------------半角数字小数点のみ（少数第２位まで）
var inpt = new Array("houseTotimen","houseSidoumen","houseTatemen");




</script>
<p id="page_title">不動産検索システム ebs3 管理 <font color="#0000FF">売買</font> <?php echo $submit; ?></p>
<div id="modoru">
<input type="button" onclick="location.href='<?php echo $this->webroot.'AdminHouse/search'.$this->request->data['page']; ?>'"value="戻る">
</div>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'updateRecord','name'=>'form1'))."\n"
		.$this->Form->hidden('page'); ?>
 <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td width="165" class="koumoku">項目名</td>
   <td width="520" class="koumoku">データ</td>
  </tr>
  <tr>
   <td>物件番号</td>
   <td><?php echo $this->Form->hidden($modelName.'.id').$id; ?></td>
  </tr>
  <tr>
   <td id="outers0">種別　<font color="#FF0000" size="1">(必須)</font></td>
   <td>
<?php echo $this->Form->select($modelName.'.syubetu',$syubetuArr,array('empty'=>false))."\n"; ?>
<br /><span class="errmsg" id="msgs0"></span>
   </td>
  </tr>
  <tr>
   <td id="outerh0">物件名　<font color="#FF0000" size="1">(必須)</font></td>
   <td>
<?php echo $this->Form->text($modelName.'.bukkenmei',array('size'=>40,'class'=>'example2')); ?>
<br /><span class="errmsg" id="msgh0"></span>
   </td>
  </tr>
   <tr>
   <td>物件住所</td>
   <td>
<?php echo $this->Form->text($modelName.'.bu_zyuusyo1',array('id'=>'ad1','size'=>40,'class'=>'example2')); ?><br />
	 　　　<font size="-2">○○市○○区○○町○丁目</font>
   </td>
  </tr>
  <tr>
   <td>物件住所詳細</td>
   <td>
<?php echo $this->Form->text($modelName.'.bu_zyuusyo2',array('id'=>'ad2','size'=>10,'class'=>'example2')); ?>
	<input type="button" name="googlemap2j" value="Google マップ" onClick="googlemap_ad2()" /><br />
	　　　<font size="-2">1-1</font>
   </td>
  </tr>
  <tr>
    <td id="googlemap2_outer">Googleﾏｯﾌﾟ</td>
    <td>
	<?php echo $this->Form->text($modelName.'.map2',array('id'=>'googlemap2','readonly'=>'readonly','class'=>'line1','size'=>50)); ?>　<font size="-2">詳細まで 横600*縦300</font>
	</td>
  </tr>
  <tr>
   <td id="outeren1">沿線１</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_en1',$ensenArr,array('id'=>'en1','onchange'=>'station(1)'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outereki1">駅１</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_eki1',$ekiArSe[1],array('id'=>'eki1'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outerko1">交通種別１</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_ko1',$eki_koArr,array('empty'=>false,'id'=>'ko1'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outersm1">分１</td>
   <td>
<?php echo $this->Form->text($modelName.'.eki_hun1',array('class'=>'numbek','size'=>5,'id'=>'hun1')); ?>　分　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgsm1"></span>
   </td>
  </tr>
  <tr>
   <td id="outeren2">沿線２</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_en2',$ensenArr,array('id'=>'en2','onchange'=>'station(2)'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outereki2">駅２</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_eki2',$ekiArSe[2],array('id'=>'eki2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outerko2">交通種別２</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_ko2',$eki_koArr,array('empty'=>false,'id'=>'ko2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outersm2">分２</td>
   <td>
<?php echo $this->Form->text($modelName.'.eki_hun2',array('class'=>'numbek','size'=>5,'id'=>'hun2')); ?>　分　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgsm2"></span>
   </td>
  </tr>
  <tr>
   <td id="outeren3">沿線３</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_en3',$ensenArr,array('id'=>'en3','onchange'=>'station(3)'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outereki3">駅３</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_eki3',$ekiArSe[3],array('id'=>'eki3'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outerko3">交通種別３</td>
   <td>
<?php echo $this->Form->select($modelName.'.eki_ko3',$eki_koArr,array('empty'=>false,'id'=>'ko3'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outersm3">分３</td>
   <td>
<?php echo $this->Form->text($modelName.'.eki_hun3',array('class'=>'numbek','size'=>5,'id'=>'hun3')); ?>　分　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgsm3"></span>
   </td>
  </tr>
  <tr>
   <td>間取り</td>
   <td>
<?php echo $this->Form->select($modelName.'.madori1',$madori1Arr,array('empty'=>false))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>間取り２</td>
   <td>
<?php echo $this->Form->select($modelName.'.madori2',$madori2Arr,array('empty'=>false))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outert0">土地面積</td>
   <td>
<?php echo $this->Form->text($modelName.'.totimen',array('class'=>'numbek','size'=>10)); ?>　㎡　<font size="-2">＜半角入力＞例：60.05　少数第２位まで</font>
<br /><span class="errmsg" id="msgt0"></span>
   </td>
  </tr>
  <tr>
   <td>土地面積種別</td>
   <td>
<?php echo $this->Form->select($modelName.'.totisyu',$totisyuArr,array('empty'=>false))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td id="outert1">私道面積</td>
   <td>
<?php echo $this->Form->text($modelName.'.sidoumen',array('class'=>'numbek','size'=>10)); ?>　㎡　<font size="-2">＜半角入力＞例：60.05　少数第２位まで</font>
<br /><span class="errmsg" id="msgt1"></span>
   </td>
  </tr>
  <tr>
   <td id="outert2">建物面積</td>
   <td>
<?php echo $this->Form->text($modelName.'.tatemen',array('class'=>'numbek','size'=>10)); ?>　㎡　<font size="-2">＜半角入力＞例：60.05　少数第２位まで</font>
<br /><span class="errmsg" id="msgt2"></span>
   </td>
  </tr>
  <tr>
   <td>１階間取り</td>
   <td>
<?php echo $this->Form->text($modelName.'.madori1f',array('size'=>40,'class'=>'example2')); ?>　<font size="-2">リビング15・和室6・浴室・トイレ　等</font>
   </td>
  </tr>
  <tr>
   <td>２階間取り</td>
   <td>
<?php echo $this->Form->text($modelName.'.madori2f',array('size'=>40,'class'=>'example2')); ?>　<font size="-2">洋室6・洋室6　等</font>
   </td>
  </tr>
  <tr>
   <td>３階間取り</td>
   <td>
<?php echo $this->Form->text($modelName.'.madori3f',array('size'=>40,'class'=>'example2')); ?>　<font size="-2">洋室6・洋室6　等</font>
   </td>
  </tr>
  <tr>
   <td>その他間取り</td>
   <td>
<?php echo $this->Form->text($modelName.'.madorita',array('size'=>40,'class'=>'example2')); ?>
   </td>
  </tr>
  <tr>
   <td id="outer0">価格</td>
   <td>
<?php echo $this->Form->text($modelName.'.kakaku',array('class'=>'numbek','size'=>10)); ?>　円　<font size="-2">＜金額　半角入力・カンマなし＞</font>
<br /><span class="errmsg" id="msg0"></span>
   </td>
  </tr>
  <tr>
   <td>内消費税額</td>
   <td>
<?php echo $this->Form->text($modelName.'.tax',array('class'=>'numbe','size'=>10)); ?>　円　<font size="-2">＜金額　半角入力・カンマなし＞・非課税は「なし」等</font>
   </td>
  </tr>
  <tr>
    <td>構造</td>
   <td>
<?php echo $this->Form->select($modelName.'.kouzou',$kouzouArr,array('empty'=>false))."\n"; ?>　造
   </td>
  </tr>
  <tr>
   <td>棟数</td>
   <td>
<?php echo $this->Form->text($modelName.'.tousuu',array('size'=>10,'class'=>'example2')); ?>　<font size="-2">連棟の場合入力　5戸1　等</font>
   </td>
  </tr>
  <tr>
   <td id="outerti0">地上階数</td>
   <td>
<?php echo $this->Form->text($modelName.'.tizyoukai',array('class'=>'numbek','size'=>5)); ?>　階　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgti0"></span>
   </td>
  </tr>
  <tr>
   <td id="outerti1">地下階数</td>
   <td>
<?php echo $this->Form->text($modelName.'.tikakai',array('class'=>'numbek','size'=>5)); ?>　階　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgti1"></span>
   </td>
  </tr>
  <tr>
   <td id="outersm4">築年</td>
   <td>
<?php echo $this->Form->text($modelName.'.tiku_nen',array('class'=>'numbek','size'=>10)); ?>　年　<font size="-2">＜半角入力＞　西暦</font>
<br /><span class="errmsg" id="msgsm4"></span>
   </td>
  </tr>
  <tr>
   <td>築月</td>
   <td>
<?php echo $this->Form->select($modelName.'.tiku_tuki',$monthAr); ?>　月
   </td>
  </tr>
  <tr>
   <td>国土法</td>
   <td>
<?php echo $this->Form->select($modelName.'.kokudo',$kokudoArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>地目</td>
   <td>
<?php echo $this->Form->select($modelName.'.timoku',$timokuArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>都市計画</td>
   <td>
<?php echo $this->Form->select($modelName.'.tosikei',$tosikeiArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>用途地域</td>
   <td>
<?php echo $this->Form->select($modelName.'.youtoti',$youtotiArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td id="outersm0">建ペイ率</td>
   <td>
<?php echo $this->Form->text($modelName.'.kenpei',array('class'=>'numbek','size'=>10)); ?>　％　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgsm0"></span>
   </td>
  </tr>
  <tr>
   <td id="outersm5">容積率</td>
   <td>
<?php echo $this->Form->text($modelName.'.youseki',array('class'=>'numbek','size'=>10)); ?>　％　<font size="-2">＜半角入力＞</font>
<br /><span class="errmsg" id="msgsm5"></span>
   </td>
  </tr>
  <tr>
   <td>法規</td>
   <td>
<?php
$no = 1;
foreach( $seigenArr as $key => $val ){
	if($val != ''){
		echo $this->Form->checkbox($modelName.'.seigen'.$key)."\n".
		$this->Form->label($modelName.'.seigen'.$key,$val)."\n";
		$no++;
		if($no == 5){$no = 1;echo '<br />'."\n";}
	}
}
?>
   </td>
  </tr>
  <tr>
   <td>地勢</td>
   <td>
<?php echo $this->Form->select($modelName.'.tisei',$tiseiArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>土地権利</td>
   <td>
<?php echo $this->Form->select($modelName.'.totiken',$totikenArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>付帯権利</td>
   <td>
<?php echo $this->Form->select($modelName.'.hutaiken',$hutaikenArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>現状</td>
   <td>
<?php echo $this->Form->select($modelName.'.genzyou',$genzyouArr,array('empty'=>false)); ?>
   </td>
  </tr>
  <tr>
   <td>引渡時期</td>
   <td>
<?php echo $this->Form->text($modelName.'.hikiwatasi',array('size'=>10,'class'=>'example2')); ?>　<font size="-2">即時/相談/期日指定</font>
   </td>
  </tr>
  <tr>
   <td>設備</td>
   <td>
<?php
$no = 1;
foreach( $setubiArr as $key => $val ){
	if($val != ''){
		echo $this->Form->checkbox($modelName.'.setubi'.$key)."\n".
		$this->Form->label($modelName.'.setubi'.$key,$val)."\n";
		$no++;
		if($no == 5){$no = 1;echo '<br />'."\n";}
	}
}
?>
   </td>
  </tr>
  <tr>
   <td>コメント<font size="-2">(お客様用)</font></td>
   <td>
<?php echo $this->Form->textarea($modelName.'.comment',array('style'=>'width: 500px;height: 46px;','class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主形態</td>
   <td>
<?php echo $this->Form->select($modelName.'.urinusikei',$urinusikeiArr,array('empty'=>false))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>取引態様</td>
   <td>
<?php echo $this->Form->select($modelName.'.torihikitai',$torihikitaiArr,array('empty'=>false))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>受取り報酬</td>
   <td>
<?php echo $this->Form->text($modelName.'.uketorikei',array('size'=>40,'class'=>'example2'))."\n"; ?>　<font size="-2">正規・分かれ・金額等</font>
   </td>
  </tr>
  <tr>
   <td>鍵所在</td>
   <td>
<?php echo $this->Form->text($modelName.'.kagi_syozai',array('size'=>10,'class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主：氏名(会社名)</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_simei',array('size'=>40,'class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>担当</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_tantou',array('size'=>40,'class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主：住所</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_zyuusyo',array('size'=>40,'class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主：TEL</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_tel',array('size'=>20,'class'=>'example4'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主：FAX</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_fax',array('size'=>20,'class'=>'example4'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>売主：eMail</td>
   <td>
<?php echo $this->Form->text($modelName.'.u_email',array('size'=>40,'class'=>'example4'))."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>備考<font size="-2">（社内用）</font></td>
   <td>
<?php echo $this->Form->textarea($modelName.'.bikou',array('style'=>'width: 500px;height: 46px;','class'=>'example2'))."\n"; ?>
   </td>
  </tr>
  <tr>
  <td>お客様HP表示</td>
   <td>
<?php echo $this->Form->checkbox($modelName.'.hp_hyouzi').
		$this->Form->label($modelName.'.hp_hyouzi','&nbsp;無し')."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>NEW!!表示</td>
   <td>
<?php echo $this->Form->checkbox($modelName.'.new').
		$this->Form->label($modelName.'.new','&nbsp;有り')."\n"; ?>
   </td>
  </tr>
  <tr>
   <td>入力日</td>
   <td>
<?php
$today = date('Y-m-d');
echo $this->Form->hidden($modelName.'.touroku_date',array('value'=>$today)).$today."\n";
?>
　　<font size="-2">（登録・変更日）</font>
   </td>
  </tr>
  <tr>
   <td>入力者</td>
   <td>
<?php echo $this->Form->hidden($modelName.'.nyuuryokusya').$this->request->data[$modelName]['nyuuryokusya']."\n"; ?>
   </td>
  </tr>
 </table>
<div align="center">
  <p><?php echo $copy; ?>
    <input type="button" id="busub" value="<?php echo $submit; ?>" onClick="check_in()">
  </p>
</div>
<?php echo $this->Form->end(); ?>

<script type="text/javascript">
var trains = [];
var address = [];

// 駅リストを沿線コードから生成
function station(no = 1) {
  const lineSelect = document.getElementById('en' + no);
  const ekiSelect = document.getElementById('eki' + no);
  if (!lineSelect || !ekiSelect) return;
  ekiSelect.length = 1;
  ekiSelect.selectedIndex = 0;

  const selectedLineCode = lineSelect.value;
  if (selectedLineCode === '') return;

  const stationsMap = {};
  trains.forEach((station) => {
    if (station.linecode === selectedLineCode) {
      stationsMap[station.stationcode] = station.stationname_en;
    }
  });

  Object.entries(stationsMap).forEach(([code, name]) => {
    const option = document.createElement('option');
    option.value = code;
    option.textContent = name;
    ekiSelect.appendChild(option);
  });
}

// 路線リストを生成（pref関係なく全て）
function line() {
  const enSelect = document.getElementById('en');
  if (!enSelect) return;
  enSelect.length = 1;

  const lineSet = new Set();
  const lineMap = {};

  trains.forEach((station) => {
    if (!lineSet.has(station.linename_en)) {
      lineSet.add(station.linename_en);
      lineMap[station.linename_en] = station.linecode;
    }
  });

  Array.from(lineSet).forEach((name) => {
    const option = document.createElement('option');
    option.value = lineMap[name];
    option.textContent = name;
    enSelect.appendChild(option);
  });

  const prevLine = <?php echo json_encode($this->request->query('en') ?? ''); ?>;
  if (prevLine !== '') {
    enSelect.value = prevLine;
    station(1);
    station(2);
    station(3);
  }
}

// JSONロードして初期化
Promise.all([
  fetch('/search/trains.json').then(res => res.json()),
  fetch('/search/address.json').then(res => res.json())
])
.then(([trainsData, addressData]) => {
  trains = trainsData;
  address = addressData;

  // イベント登録
  document.getElementById('en1')?.addEventListener('change', () => station(1));
  document.getElementById('en2')?.addEventListener('change', () => station(2));
  document.getElementById('en3')?.addEventListener('change', () => station(3));

  line(); // 路線を初期表示
})
.catch(err => {
  console.error('JSON load error:', err);
});
</script>

<p align="center">&nbsp;</p>
<div class="copyright">
	<hr width="750" size="1">
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
