<?php echo $this->element('top_content'); ?>
<?php


$this->Html->css('home', null, array('inline' => false));
$this->Html->script(
		array('jquery-1.7.2.min','jquery-accordion','check_contact'),
		array( 'inline' => false )
);
App::import('Vendor', 'configRent');
$syubetuArr = syubetuArr();
$madori1Arr = madori1Arr();
$madori2Arr = madori2Arr();
$eki_koArr = eki_koArr();
$hosyou_kuArr = hosyou_kuArr();
$kaiyaku_kuArr = kaiyaku_kuArr();

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

$address_en = '';
if (!empty($data)) {
    $zipcode = $data[$modelName]['zipcode'];
    $address_en = getEnglishAddress($zipcode, $addressArr);
	
}


App::import('Vendor', 'configRentEki');
$ensenArr = ensenArr();
$ekiArr = ekiArr();

$table = '';
if(!empty($data[$modelName]['gaikan_img'])){
	if($data[$modelName]['gaikan_img'] == 1){
		$data[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/rent/gazou/'.$data[$modelName]['id'] . '_0.jpg" width="100" border="0" />';
	}elseif($data[$modelName]['gaikan_img'] == 2){
		$data[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/rent/gazou/'.$data[$modelName]['id'] . '_0.jpg" height="100" border="0" />';
	}else{
		$data[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/rent/gazou/'.$data[$modelName]['id'] . '_0.jpg" border="0" />';
	}
}else{
	$data[$modelName]['gaikan_img'] = '<img src="'.$this->webroot.'img/rent/gazou/'.$data[$modelName]['id'] . '_0.jpg" border="0" />';
}
//--金額カンマ挿入処理
$nfArray = array('yatin_k','kyoueki_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){$data[$modelName][$va] = number_format($data[$modelName][$va]);}
}
$nfArray = array('hosyou_k','kaiyaku_k');
foreach( $nfArray  as $va ){
	if(is_numeric($data[$modelName][$va])){
		$data[$modelName][$va] = number_format($data[$modelName][$va]).' months';
	}
}
if(is_numeric($data[$modelName]['heibei'])){
	$data[$modelName]['heibei'] = sprintf('%0.2f',$data[$modelName]['heibei']);
}
$enEkiKoHu = '';
for($a = 1; $a <= 3; $a++) {
	if(!empty($data[$modelName]['eki_eki'.$a])){
		$data[$modelName]['eki_eki'.$a] = $ekiArr[$data[$modelName]['eki_en'.$a]][$data[$modelName]['eki_eki'.$a]];
	}
	if(!empty($data[$modelName]['eki_en'.$a])){
		$data[$modelName]['eki_en'.$a] = $ensenArr[$data[$modelName]['eki_en'.$a]];
	}
	$data[$modelName]['eki_ko'.$a] = $eki_koArr[$data[$modelName]['eki_ko'.$a]];
	if(!empty($data[$modelName]['eki_hun'.$a])){
		$data[$modelName]['eki_hun'.$a] = $data[$modelName]['eki_hun'.$a].'minutes';
	}
	if(!empty($data[$modelName]['eki_en'.$a])){
		$enEkiKoHu .= $data[$modelName]['eki_en'.$a].$data[$modelName]['eki_eki'.$a].$data[$modelName]['eki_ko'.$a].
			$data[$modelName]['eki_hun'.$a]."\n";
	}
}
if(!empty($data[$modelName]['syubetu'])){
	$data[$modelName]['syubetu'] = $syubetuArr[$data[$modelName]['syubetu']];
}
if($data[$modelName]['new'] == 1){
	$dateTo = preg_replace("/-/", '', $data[$modelName]['touroku_date']);
	$dateNew =date("Ymd", strtotime(date("Y-m-d").' -'.DATE_NEW.' day'));
	if($dateTo >= $dateNew){
		$data[$modelName]['new'] = '<span class="new">NEW!</span><br />';
		$new = 'new';
	}else{
		$data[$modelName]['new'] = '';
		$new = '';
	}
}else{
	$data[$modelName]['new'] = '';
	$new = '';
}
$table .= '
<div class="post">
		<table class="list"><tr><td width="115" align="center">'.$data[$modelName]['gaikan_img'].'</td></tr></table>
		<table class="list"><tr><td align="center" width="145">
			<span class="pu">'.$data[$modelName]['yatin_k'].'</span> Yen<br />
			'.$data[$modelName]['kyoueki_k'].'</span><br />
			'.$hosyou_kuArr[$data[$modelName]['hosyou_ku']].' '.$data[$modelName]['hosyou_k'].'<br>
			'.$kaiyaku_kuArr[$data[$modelName]['kaiyaku_ku']].' '.$data[$modelName]['kaiyaku_k'].'
		</td></tr></table>
		<table class="list"><tr><td align="center" width="85">
			<span class="pu">'.$madori1Arr[$data[$modelName]['madori1']].$data[$modelName]['madori2'].'</span><br />
			'.$data[$modelName]['heibei'].'㎡<br />
			'.$data[$modelName]['syozaikai'].'th floor
		</td></tr></table>
		<table class="list"><tr><td align="center" width="209">
			'.$address_en.'<br />
			'.$data[$modelName]['eki_en1'].' '.$data[$modelName]['eki_eki1'].' '.$data[$modelName]['eki_ko1'].$data[$modelName]['eki_hun1'].'<br />
			'.$data[$modelName]['eki_en2'].' '.$data[$modelName]['eki_eki2'].' '.$data[$modelName]['eki_ko2'].$data[$modelName]['eki_hun2'].'<br />
			'.$data[$modelName]['eki_en3'].' '.$data[$modelName]['eki_eki3'].' '.$data[$modelName]['eki_ko3'].$data[$modelName]['eki_hun3'].'
		</td></tr></table>
		<table class="list"><tr><td align="center" width="99">
			'.$data[$modelName]['new'].'
			No.'.$data[$modelName]['id'].'<br />
			'.$data[$modelName]['syubetu'].'<br />
			'.$data[$modelName]['tiku_nen'].' '.'
		</td></tr></table>
</div>
';
$this->request->data['bukken'] = '【Rental】　No.'.$data[$modelName]['id'].'　'.$new."\n".
'Rent:'.$data[$modelName]['yatin_k'].' Yen　Maintenance fee:'.$data[$modelName]['kyoueki_k']."\n".
$hosyou_kuArr[$data[$modelName]['hosyou_ku']].' '.$data[$modelName]['hosyou_k'].'　'.
$kaiyaku_kuArr[$data[$modelName]['kaiyaku_ku']].' '.$data[$modelName]['kaiyaku_k']."\n".
$madori1Arr[$data[$modelName]['madori1']].$data[$modelName]['madori2'].'　'.
$data[$modelName]['heibei'].'㎡　'.$data[$modelName]['syozaikai'].'th floor'."\n".

$enEkiKoHu.
$data[$modelName]['syubetu'].'　Built Year'.$data[$modelName]['tiku_nen'].' '.'';
?>
<script type="text/javascript">
inph = new Array('fname','fnaiyou');
inpe = new Array('fmail');
inpec = new Array('fmailcopy');
inps = new Array('ftel');
</script>
<style type="text/css">
#fkibouEMail {
	margin-left: 10px;
}
#fkibouTel {
	margin-left: 30px;
}
</style>
<!-- コンテンツ -->
<div id="content">
<p>&nbsp;</p>
<div class="post">
<h2 style="margin-bottom: 0px;"> Inquiry</h2>
</div>
<div class="post">
<table class="item" align="center"><tr><td width="115" align="center" class="bkco">Photo</td></tr></table>
<table class="item" align="center"><tr><td width="145" align="center" class="bkco">
Rent<br />Maintenance fee<br />Deposit<br />Key money</td></tr></table>
<table class="item" align="center"><tr><td width="85" align="center" class="bkco">
Layout<br />㎡<br />Total floors</td></tr></table>
<table class="item" align="center"><tr><td width="209" align="center" class="bkco">
Address<br />walk to the station</td></tr></table>
<table class="item" align="center"><tr><td width="99" align="center" class="bkco">
Property No<br />Type<br />Built in</td></tr></table>
</div>
<?php echo $table; ?>
<div class="post">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'contact2','name'=>'formCo','id'=>'formCo'))."\n"; ?>
<table class="contact_item"><tr><td align="center" valign="top" class="bkco" id="fnamei">
	  Name<font color="#FF0000" size="1">(Must)</font>
</td></tr></table>
<table class="contact_input"><tr><td align="left" valign="middle">
<?php echo $this->Form->text('fname',array('class'=>'input_text example2'))."\n"; ?>
	    <br /><span class="errmsg" id="msgh0"></span>
</td></tr></table>

<table class="contact_item"><tr><td align="center" valign="top" class="bkco" id="fmaili">
	  E-mail<font size="-2"></font><font color="#FF0000" size="1">(Must)</font>
	  <br /><br />
	  (Once more)
</td></tr></table>
<table class="contact_input"><tr><td align="left" valign="top">
<?php echo $this->Form->text('fmail',array('class'=>'input_text example3'))."\n"; ?>
	    <br /><span class="errmsg" id="msge0"></span><br />
<?php echo $this->Form->text('fmailcopy',array('class'=>'input_text example3'))."\n"; ?>
        <br /><span class="errmsg" id="msgec0"></span>
</td></tr></table>
<table class="contact_item"><tr><td align="center" valign="top" class="bkco" id="fteli">
	  Tel<font size="-2"></font>
</td></tr></table>
<table class="contact_input"><tr><td align="left" valign="middle">
<?php echo $this->Form->text('ftel',array('class'=>'input_text example3'))."\n"; ?>
      <br /><span class="errmsg" id="msgs0"></span>
</td></tr></table>

<table class="contact_item"><tr><td align="center" valign="middle" class="bkco" id="fnaiyoui">
<br />Content<font color="#FF0000" size="1">(Must)</font>
<br />&nbsp;
</td></tr></table>
<table class="contact_input"><tr><td align="left" valign="middle">
<?php echo $this->Form->textarea('fnaiyou',array('rows'=>4,'class'=>'input_text example2'))."\n"; ?>
	    <br /><span class="errmsg" id="msgh1"></span>
</td></tr></table>
<table class="contact_submit"><tr><td height="50" colspan=2 align="center" valign="middle">
<?php echo $this->Form->hidden('id')."\n".$this->Form->hidden('bukken')."\n"; ?>
	  <input type="button" id="busub" value="　Confirm　" onClick="check_in()">
</td></tr></table>
<?php echo $this->Form->end(); ?>
</div>
<p>&nbsp;</p>
<?php echo $this->element('bottom_content'); ?>
