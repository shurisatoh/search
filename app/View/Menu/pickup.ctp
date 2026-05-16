<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.img', null, array('inline' => false));
$this->Html->script( array('jquery-1.7.2.min','jquery-ui-1.10.0','check_o'), array( 'inline' => false ) );
$script =<<< EOL
$(function() {

    $(".sortable").sortable();
    $(".sortable").disableSelection();
    $("#submit").click(function() {
        var result = $(".sortable").sortable("toArray");
        $("#result").val(result);
        $("formNa").submit();
    });
});
EOL;
echo $this->Html->scriptBlock($script,array('inline'=>false,'safe'=>true));
App::import('Vendor', 'configTopPage');
$osusumeFile = '../../../'.osusumeAddress();
$message ='';
//-------------------------------------------登録／変更
if(!empty($this->request->data['t'])){
	if (get_magic_quotes_gpc()){$this->request->data['co'] = stripslashes($this->request->data['co']);}
	$no_data = 0;
	if (!empty($this->request->data['id'])){
		if(empty($data[$modelName]['id'])){
			$message .='<font color="#FF0000">該当物件がありません</font><br />';
		}else{
			if($data[$modelName]['hp_hyouzi'] == 1){
				$message .='<font color="#FF0000">お客様HP表示なし物件です。</font><br />';
			}
		}
	}
	if ($message == ''){
		if (!empty($this->request->data['id'])){
			$configArray = array(
				'rent'=>'configRent',
				'house'=>'configHouse'
			);
			App::import('Vendor', $configArray[$this->request->data['bu']]);
			$syubetuArr = syubetuArr();
			$eki_koArr = eki_koArr();
			App::import('Vendor', $configArray[$this->request->data['bu']].'Eki');
			$ensenArr = ensenArr();
			$ekiArr = ekiArr();

			$oh = array('t' => 91,'k' => 46,'m' => 44,'to' => 46);
			$nf = array('t' => array(8,'円'),'k' => array(20,'万円'),
				'm' => array(17,'万円'),'to' => array(20,'万円'));
			if($data[$modelName]['gaikan_img'] == 1){
				$wh = ' width="120"';
				$fnme = './search/img/'.$this->request->data['bu'].'/gaikan_img/no'.$data[$modelName]['id'].'gaikan_img.jpg';
			}elseif($data[$modelName]['gaikan_img'] == 2){
				$wh = ' height="120"';
				$fnme = './search/img/'.$this->request->data['bu'].'/gaikan_img/no'.$data[$modelName]['id'].'gaikan_img.jpg';
			}else{
				$wh = '';
				$fnme = './search/img/noimage100.gif';
			}
			if($this->request->data['co_no'] == 4){$ci = '<tr>';}else{$ci = '</td>';}

			if($data[$modelName]['new'] == 1){
				$dateTo = preg_replace("/-/", '', $data[$modelName]['touroku_date']);
				$dateNew =date("Ymd", strtotime(date("Y-m-d").' -'.DATE_NEW.' day'));
				if($dateTo >= $dateNew){
					$data[$modelName]['new'] = '　　<span class="new">NEW!</span>　';
				}else{
					$data[$modelName]['new'] = '';
				}
			}else{
				$data[$modelName]['new'] = '';
			}
			//--金額カンマ挿入処理
			if($this->request->data['bu'] == 'rent'){
				foreach($syubetuArr as $key => $val){
					$syubetuArr2[$key] = str_replace('<br />', '', $syubetuArr[$key]);
				}
				if(is_numeric($data[$modelName]['yatin_k'])){
					$data[$modelName]['yatin_k'] = '<span>'.number_format($data[$modelName]['yatin_k']).'</span>円';
				}
			}else{
				if(is_numeric($data[$modelName]['kakaku'])){
					$data[$modelName]['kakaku'] = '<span>'.number_format($data[$modelName]['kakaku']).'</span>万円';
				}
			}
			if(!empty($data[$modelName]['eki_en1'])){
				$koutuu = $ensenArr[$data[$modelName]['eki_en1']];
				if(!empty($data[$modelName]['eki_eki1'])){
					$koutuu .= ' '.$ekiArr[$data[$modelName]['eki_en1']][$data[$modelName]['eki_eki1']].' '.
							$eki_koArr[$data[$modelName]['eki_ko1']].' '.$data[$modelName]['eki_hun1'].'分';
				}
			}else{
				$koutuu = '';
			}
			if($this->request->data['bu'] == 'rent'){
				$madori1Arr = madori1Arr();
				$madori2Arr = madori2Arr();
				$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-3).'<> -->'.$ci.'<td valign="top">
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-2).'<> --><table width="130" height="130" border="0" cellpadding="0" cellspacing="0" id="border"><tr><td align="center" valign="middle"><a href="./search/Rent/view?id='.$data[$modelName]['id'].'"><img src="'.$fnme.'"'.$wh.' border="0" /></a></td>
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-1).'<> --></tr></table></td><td align="left" valign="top">賃貸　<a href="./search/Rent/view?id='.$data[$modelName]['id'].'">'.$data[$modelName]['id'].'</a>'.$data[$modelName]['new'].'<br />'.$koutuu.'<br />'.$data[$modelName]['bu_zyuusyo1'].'<br />'.$syubetuArr2[$data[$modelName]['syubetu']].'　<span class="title">'.$madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']].'</span><br />賃料：'.$data[$modelName]['yatin_k'].'<br />
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.$this->request->data['co_no'].'<> -->'.$this->request->data['co']."\n";
			}elseif($this->request->data['bu'] == 'house'){
				$madori1Arr = madori1Arr();
				$madori2Arr = madori2Arr();
				$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-3).'<> -->'.$ci.'<td valign="top">
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-2).'<> --><table width="130" height="130" border="0" cellpadding="0" cellspacing="0" id="border"><tr><td align="center" valign="middle"><a href="./search/House/view?id='.$data[$modelName]['id'].'"><img src="'.$fnme.'"'.$wh.' border="0" /></a></td>
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['co_no']-1).'<> --></tr></table></td><td align="left" valign="top">売買　<a href="./search/House/view?id='.$data[$modelName]['id'].'">'.$data[$modelName]['id'].'</a>'.$data[$modelName]['new'].'<br />'.$koutuu.'<br />'.$data[$modelName]['bu_zyuusyo1'].'<br /><span class="title">'.$syubetuArr[$data[$modelName]['syubetu']].'</span>　'.$madori1Arr[$data[$modelName]['madori1']].$madori2Arr[$data[$modelName]['madori2']].'<br />価格：'.$data[$modelName]['kakaku'].'<br />
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.$this->request->data['co_no'].'<> -->'.$this->request->data['co']."\n";
			}
		}else{
			if($this->request->data['co_no'] == 4){
				$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>4<> -->'.$this->request->data['co']."\n";
			}else{
				$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>8<> -->'.$this->request->data['co']."\n";
			}
			$no_data = 1;
		}

		$filepointer=fopen($osusumeFile, "a+");
		flock($filepointer, LOCK_EX);

		$data = '';
		$ci = $this->request->data['co_no']-3;
		while(!feof($filepointer)){
			$value = fgets($filepointer);
			$va = explode('<>', $value);
			if($va[0] == '<!-- ' && $va[1] == 'pickup'){
				if($no_data == 1){
					if($this->request->data['pickupNo'] == $va[2] && $this->request->data['co_no'] == $va[4]){
						$data.= $new_data;
					}else{
						$data.= $value;
					}
				}else{
					if($this->request->data['pickupNo'] == $va[2] && $ci == $va[4]){
						if($ci == 1 || $ci == 5){
							$data.= $new_data;
							$ci++;
						}elseif($ci == 4 || $ci == 8){
							$ci = 0;
						}else{
							$ci++;
						}
					}else{
						$data.= $value;
					}
				}
			}else{
				$data.= $value;
			}
		}
		ftruncate($filepointer,0);
		fputs($filepointer, $data);
		flock($filepointer, LOCK_UN);
		fclose($filepointer);
	}

}
//-------------------------------------------登録／変更
//-------------------------------------------削除
if(!empty($this->request->data['delete'])){

	if($this->request->data['delete'] == 1){$del_f = '<tr>';}else{$del_f = '</td>';}
	$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.$this->request->data['delete'].'<> -->'.$del_f.'<td valign="top">
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['delete']+1).'<> -->
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['delete']+2).'<> -->
<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>b<>'.($this->request->data['delete']+3).'<> -->'."\n";

	$filepointer=fopen($osusumeFile, "a+");
	flock($filepointer, LOCK_EX);
	$data = '';

	while(!feof($filepointer)){
		$value = fgets($filepointer);
		$va = explode('<>', $value);
		if($va[0] == '<!-- ' && $va[1] == 'pickup'){
			if($this->request->data['pickupNo'] == $va[2] && $this->request->data['delete'] == $va[4]){
				if($this->request->data['delete'] == 1 || $this->request->data['delete'] == 5){
					$data.= $new_data;
					$this->request->data['delete']++;
				}elseif($this->request->data['delete'] == 4 || $this->request->data['delete'] == 8){
					$this->request->data['delete'] = 0;
				}else{
					$this->request->data['delete']++;
				}
			}else{
				$data.= $value;
			}
		}else{
			$data.= $value;
		}
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $data);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);
}
//-------------------------------------------削除
//-------------------------------------------タイトル登録／変更／削除
if(!empty($this->request->data['tt'])){
	$message ='';
//	if (preg_match("/<>/", $this->request->data['title'])) {$message .='<font color="#FF0000">入力内容に【<>】入力禁止文字が含まれてます</font><br /><br />';}
//	if($message != ''){
//		$me_back = array('pickup','戻る');
//		message($message,$me_back);
//	}
	if (get_magic_quotes_gpc()){$this->request->data['title'] = stripslashes($this->request->data['title']);}

	$new_data = '<!-- <>pickup<>'.$this->request->data['pickupNo'].'<>t<>2<> -->'.$this->request->data['title']."\n";
	$filepointer = fopen($osusumeFile, "a+");
	flock($filepointer, LOCK_EX);
	$data = '';
	while(!feof($filepointer)){
		$value = fgets($filepointer);
		$va = explode('<>', $value);
		if($va[0] == '<!-- ' && $va[1] == 'pickup'){
			if($va[2] == $this->request->data['pickupNo'] && $va[4] == 2){
				$data.= $new_data;
			}else{
				$data.= $value;
			}
		}else{
			$data.= $value;
		}
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $data);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);
}
//-------------------------------------------タイトル登録／変更／削除
//-------------------------------------------枠追加
if(!empty($this->request->data['title_up']) || !empty($this->request->data['contents_up'])){

	$filepointer=fopen($osusumeFile, "a+");
	flock($filepointer, LOCK_EX);
	$data = '';
	$pickupNo = 1;
	while(!feof($filepointer)){
		$value = fgets($filepointer);
		$va = explode('<>', $value);
		if($va[0] == '<!-- ' && $va[1] == 'pickup'){
			if('last' == $va[3]){
				if($this->request->data['title_up']){
					$new_data = '<!-- <>pickup<>'.$pickupNo.'<>t<>1<> --><tr><td colspan="4" align="center" valign="middle"><h2>
<!-- <>pickup<>'.$pickupNo.'<>t<>2<> -->
<!-- <>pickup<>'.$pickupNo.'<>t<>3<> --></h2></td></tr>
<!-- <>pickup<><>last<><> -->'."\n";
				}else{
					$new_data = '<!-- <>pickup<>'.$pickupNo.'<>b<>1<> --><tr><td valign="top">
<!-- <>pickup<>'.$pickupNo.'<>b<>2<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>3<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>4<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>5<> --></td><td valign="top">
<!-- <>pickup<>'.$pickupNo.'<>b<>6<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>7<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>8<> -->
<!-- <>pickup<>'.$pickupNo.'<>b<>9<> --></td></tr>
<!-- <>pickup<><>last<><> -->'."\n";
				}
				$data.= $new_data;
			}else{
				$data.= $value;
				if($va[2]){$pickupNo = $va[2]+1;}
			}
		}else{
			$data.= $value;
		}
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $data);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);

}
//-------------------------------------------枠追加
//-------------------------------------------枠の削除
if(!empty($this->request->data['w_del'])){

	$filepointer=fopen($osusumeFile, "a+");
	flock($filepointer, LOCK_EX);
	$data = '';
	while(!feof($filepointer)){
		$value = fgets($filepointer);
		$va = explode('<>', $value);
		if($va[0] == '<!-- ' && $va[1] == 'pickup'){
			if($this->request->data['pickupNo'] == $va[2]){
			}else{
				$data.= $value;
			}
		}else{
			$data.= $value;
		}
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $data);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);

}
//-------------------------------------------枠の削除
//-------------------------------------------枠の並び替え
if(!empty($this->request->data['result'])){
	$resultmAr = explode(',',$this->request->data['result']);
	$resultAr = array();
	foreach( $resultmAr as $key => $va ){
		$resultAr[$va] = $key + 1;
	}
	$filepointer = fopen($osusumeFile, "a+");
	flock($filepointer, LOCK_EX);
	$data = '';
	$newData = '';
	$newDataAr = array();
	$newDataNo = 1;
	$endPickup = 0;
	while(!feof($filepointer)){
		$value = fgets($filepointer);
		$va = explode('<>', $value);
		if($va[0] == '<!-- ' && $va[1] == 'pickup'){
			$endPickup = 1;
			if($newDataNo == $va[2]){
				$newData .= $value;
			}else{
				$newData = preg_replace('/pickup<>'.$newDataNo.'/', 'pickup<>'.$resultAr[($newDataNo)], $newData);
				$newDataAr[$resultAr[($newDataNo)]] = $newData;
				if($va[3] == 'last'){
				}else{
					$newData = '';
					$newDataNo = $va[2];
					$newData .= $value;
				}
			}
		}else{
			if($endPickup == 1){
				while(!empty($newDataAr[$endPickup])){
					$data.= $newDataAr[$endPickup];
					$endPickup++;
				}
				$data.= '<!-- <>pickup<><>last<><> -->'."\n";
			}
			$data.= $value;
		}
	}
	ftruncate($filepointer,0);
	fputs($filepointer, $data);
	flock($filepointer, LOCK_UN);
	fclose($filepointer);

}
//-------------------------------------------枠の並び替え
//-------------------------------------------お勧め設定表示
$pickup = '';
$bukken1 = '';
$bukken2 = '';
$last_no = 0;
$sites = file($osusumeFile);  //お勧めページ読み込み
foreach( $sites as $value ){
	$va = explode('<>', $value);
	if($va[0] == '<!-- ' && $va[1] == 'pickup'){
		if($va[3] == 't' && $va[4] == 2){
			$last_no = $va[2];
			$va[5] = preg_replace('/ -->/', '', $va[5]);
			$va[5] = trim($va[5]);
			$pickup .= '
		<li id="'.$va[2].'" class="titlew">
		<div class="member_divw">
			<table border="0" align="center">
			<tr><td colspan="2" align="center" valign="middle" id="border">
			<table border="0" id="'.$va[2].'">
			<tr><td>'.$va[5].'</td></tr>
			<tr><td>
				<table border="0" align="center">
				<tr><td class="input">
				<form id="form'.$va[2].'" name="form'.$va[2].'" method="post" action="pickup#'.($va[2]-1).'" onSubmit="return check_title('.$va[2].')">
				<label>タイトル：
				<input name="title" type="text" id="title" value="'.htmlspecialchars($va[5]).'" size="50" class="example2" />
				</label>
				<input type="hidden" name="tt" value="1">
				<input type="hidden" name="pickupNo" value="'.$va[2].'">
				<input type="submit" name="Submit" value="登録／変更／削除" />
				<br />
				<span style="font-size:small;color:#F00;" id="title_msg'.$va[2].'"></span>
				</form>
				</td></tr>
				</table>
			</td></tr>
			</table>
			</tr>
			</table>
		</div>
		</li>';
		}

		if($va[3] == 'b'){
			if($va[4] == 2 || $va[4] == 3 || $va[4] == 4){$bukken1 .= $value;}
			if($va[4] == 4){
				$va[5] = preg_replace('/ -->/', '', $va[5]);
				$va[5] = trim($va[5]);
				$bc1 = $va[5];
			}
		}
		if($va[3] == 'b'){
			if($va[4] == 6 || $va[4] == 7 || $va[4] == 8){$bukken2 .= $value;}
			if($va[4] == 8){
				$va[5] = preg_replace('/ -->/', '', $va[5]);
				$va[5] = trim($va[5]);
				$bc2 = $va[5];
			}
		}

		if($va[3] == 'b' && $va[4] == 9){
			$last_no = $va[2];

			$buErAr1 = array('rent'=>'','house'=>'');
			$buErAr2 = array('rent'=>'','house'=>'');
			$errBu1 = '';$errBu2 = '';$erStBu1 = '';$erStBu2 = '';$buVa1 = '';$buVa2 = '';
			if($message != ''){
				if($this->request->data['pickupNo'] == $va[2]){
					if($this->request->data['co_no'] == 4){
						$errBu1 = $message;
						$erStBu1 = ' style="background-color:#ffeeee;"';
						$buVa1 = ' value="'.$this->request->data['id'].'"';
						$buErAr1[$this->request->data['bu']] = ' selected';
					}else{
						$errBu2 = $message;
						$erStBu2 = ' style="background-color:#ffeeee;"';
						$buVa2 = ' value="'.$this->request->data['id'].'"';
						$buErAr2[$this->request->data['bu']] = ' selected';
					}
				}
			}

			$pickup .= '
		<li id="'.$va[2].'">
		<div class="member_div">
			<table border="0" align="center">
			<tr><td align="center" valign="middle" id="border">
			<table border="0" id="'.$va[2].'">
				<tr><td>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr><td>
					'.$bukken1.'
					</td></tr>
				</table>
				</td></tr>
				<tr><td>
				<table border="0" align="center">
					<tr><td class="input">
					<form id="form'.$va[2].'_1" name="form'.$va[2].'_1" method="post" action="pickup#'.($va[2]-1).'" onSubmit="return check_in(\''.$va[2].'_1\')">
					分類/物件番号：
					<select name="bu"'.$erStBu1.'>
					<option value=""></option>
					<option value="rent"'.$buErAr1['rent'].'>賃貸</option>
					<option value="house"'.$buErAr1['house'].'>売買</option>
					</select>
					<input name="id" type="text" id="id" size="5"'.$erStBu1.' class="example3" />
					<br /><span style="font-size:small;color:#F00;" id="no_msg'.$va[2].'_1">'.$errBu1.'</span>
					コメント：
					<input name="co" type="text" size="20" value="'.htmlspecialchars($bc1).'" class="example2" />
					<br /><span style="font-size:small;color:#F00;" id="co_msg'.$va[2].'_1"></span>
					<input type="hidden" name="t" value="1">
					<input type="hidden" name="pickupNo" value="'.$va[2].'">
					<input type="hidden" name="co_no" value="4">
					<input type="submit" name="Submit" value="登録／変更" />
					</form>
					</td></tr>
					<tr><td>
					<form method="post" action="pickup#'.($va[2]-1).'" onSubmit="return check(\'掲載物件\')">
					<input type="hidden" name="delete" value="1">
					<input type="hidden" name="pickupNo" value="'.$va[2].'">
					<input type="submit" name="Submit" value="削除" />
					</form>
					</td></tr>
				</table>
				</td></tr>
			</table>
			</td><td align="center" valign="middle" id="border">
			<table border="0">
				<tr><td>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr><td>
					'.$bukken2.'
					</td></tr>
				</table>
				</td></tr>
				<tr><td>
				<table border="0" align="center">
					<tr><td class="input">
					<form id="form'.$va[2].'_2" name="form'.$va[2].'_2" method="post" action="pickup#'.($va[2]-1).'" onSubmit="return check_in(\''.$va[2].'_2\')">
					分類/物件番号：
					<select name="bu"'.$erStBu2.'>
					<option value=""></option>
					<option value="rent"'.$buErAr2['rent'].'>賃貸</option>
					<option value="house"'.$buErAr2['house'].'>売買</option>
					</select>
					<input name="id" type="text" id="id" size="5"'.$erStBu2.$buVa2.' class="example3" />
					<br /><span style="font-size:small;color:#F00;" id="no_msg'.$va[2].'_2">'.$errBu2.'</span>
					コメント：
					<input name="co" type="text" size="20" value="'.htmlspecialchars($bc2).'" class="example2" />
					<br />
					<span style="font-size:small;color:#F00;" id="co_msg'.$va[2].'_2"></span>
					<input type="hidden" name="t" value="1">
					<input type="hidden" name="pickupNo" value="'.$va[2].'">
					<input type="hidden" name="co_no" value="8">
					<input type="submit" name="Submit" value="登録／変更" />
					</form>
					</td></tr>
					<tr><td>
					<form method="post" action="pickup#'.($va[2]-1).'" onSubmit="return check(\'掲載物件\')">
					<input type="hidden" name="delete" value="5">
					<input type="hidden" name="pickupNo" value="'.$va[2].'">
					<input type="submit" name="Submit" value="削除" />
					</form>
					</td></tr>
				</table>
				</td></tr>
			</table>
			</td></tr>
			</table>
		</div>
		</li>';
			$bukken1 = '';
			$bukken2 = '';
		}
	}
}
$pickup = preg_replace('/\/search/', '.', $pickup);
$list = $pickup;
//-------------------------------------------お勧め設定表示
?>
<style type="text/css">
#osusumesetumei {
	margin-left: 100px;
}

.osusume table {
	text-align: center;
	font-size: small;
}

.osusume td {
	padding: 5px;
	line-height: 25px;
}

.osusume #border {
	border: 1px solid #999999;
}

.osusume h2 {
	margin: 0px;
	padding: 10px;
	font-size: 14px;
	background-image: url(../img/post_bar.jpg);
	text-align: center;
	border: 1px solid rgb(204, 204, 204);
	font-weight: normal;
	height: 22px;
}
.osusume span {
	color: #666;
	font-size: x-large;
}
.osusume .title{
	color: #666;
	font-size: 20px;
	font-weight: normal;
}
#member_list {
	width: 740px; margin-right: auto; margin-left: auto;
}
#member_list ul{
	margin: 0px;
	padding: 0px;
}
#member_list ul .title {
	border: 1px solid rgb(102, 102, 102);
	width: 740px;
	margin-bottom: 5px;
	list-style-type: none;
	height: 50px;
	background-color: #EFEFEF;
}
#member_list ul li {
	border: 1px solid rgb(102, 102, 102);
	width: 740px;
	margin-bottom: 5px;
	list-style-type: none;
	height: 370px;
	background-color: #EFEFEF;
}
#member_list ul li .member_div {
	border: 1px solid rgb(102, 102, 102);
	margin: 5px;
	padding: 5px;
	width: 720px;
	float: left;
	text-align: center;
	background-color: #FFF;
	height: 348px;
	cursor:pointer;
}
#member_list ul li .member_div td {
	border: 0px;
}
#member_list ul li .member_div td .title {
	border: 0px;
	background-color: #FFF;
}
#member_list ul .titlew {
	border: 1px solid rgb(102, 102, 102);
	width: 740px;
	margin-bottom: 5px;
	list-style-type: none;
	height: 90px;
	background-color: #EFEFEF;
}
#member_list ul li .member_divw {
	border: 1px solid rgb(102, 102, 102);
	margin: 5px;
	padding: 5px;
	width: 720px;
	float: left;
	text-align: center;
	background-color: #FFF;
	height: 68px;
	cursor:pointer;
}
#member_list ul li .member_divw td {
	border: 0px;
	margin: 0px;
	padding: 0px;
}
#member_list ul li .member_time_div {
	border: 1px solid rgb(102, 102, 102);
	margin: 5px;
	padding: 5px;
	width: 120px;
	height: 25px;
	float: left;
	background-color: #FFF;
}
#member_list ul li .member_time_div .submit {
	float: right;
}
#member_list ul li .member_time2_div {
	border: 1px solid rgb(102, 102, 102);
	margin: 5px;
	padding: 5px;
	width: 80px;
	height: 25px;
	float: left;
	background-color: #FFF;
	text-align: center;
}
#member_list ul li .member_time3_div {
	border: 1px solid rgb(102, 102, 102);
	margin: 5px;
	padding: 5px;
	width: 120px;
	height: 25px;
	float: left;
	background-color: #FFF;
	text-align: center;
}
#copyright div {
	margin-top: 25px;
	margin-right: 5px;
	margin-bottom: 5px;
	margin-left: 5px;
	padding: 0px;
	font-size: small;
	text-align: right;
	vertical-align: bottom;
}
.osusume .new {
    background-color: #D9534F;
    border-radius: 3px;
    color: #fff;
    display: inline-block;
    margin: 0px;
    padding: 2px 5px 2px 5px;
    font-size: 5px;
    font-weight: bold;
    line-height: 15px;
}
</style>
<div id="member_list" class="osusume">
<ul><li class="title">
<div style="margin:5px;font-size: 0.75em;">
不動産検索システム ebs3 管理 お勧め　設定
</div>
</li><li class="title">
<div style="margin:5px;font-size: small;">
※並び替えは、「タイトル枠」「物件枠」をドラッグ＆ドロップで移動して<br />
「並べ替え」をクリックしてください。

</li></ul>
<ul class="sortable">
<?php echo $list; ?>
</ul>
<ul><li class="title">
<?php
echo $this->Form->create(false,array('type'=>'post'
,'style'=>'text-align:center;padding:10px;float:left;','url' => 'pickup'))."\n".
$this->Form->hidden('title_up',array('value'=>1))."\n".
$this->Form->end('タイトル枠追加')."\n";
?>
<?php
echo $this->Form->create(false,array('type'=>'post'
,'style'=>'text-align:center;padding:10px;float:left;','url' => 'pickup'))."\n".
$this->Form->hidden('contents_up',array('value'=>1))."\n".
$this->Form->end('物件枠追加')."\n";
?>
<?php
echo $this->Form->create(false,array('type'=>'post'
,'style'=>'text-align:center;padding:10px;float:left;','url' => 'pickup'))."\n".
$this->Form->hidden('w_del',array('value'=>1))."\n".
$this->Form->hidden('pickupNo',array('value'=>$last_no))."\n".
$this->Form->end('枠削除')."\n";
?>
<p style="font-size: small;margin-top: 11px;">※一番下の枠の追加・削除になります。</p>
</li></ul>
<ul><li class="title">
<?php
echo $this->Form->create(false,array('type'=>'post','name'=>'formNa','id'=>'formNa'
,'style'=>'text-align:center;padding-top:10px;'
,'url'=>"pickup"))."\n".
$this->Form->hidden('result',array('value'=>1))."\n".
'<button id="submit">並べ替え</button>'."\n".
$this->Form->end()."\n";
?>
</li></ul>
<ul><li id="copyright" class="title">
<div>Copyright © ITS All Rights Reserved</div>
</li></ul>
</div>
