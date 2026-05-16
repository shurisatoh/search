<?php

class HouseController extends AppController {

	public $layout = "homepage";
	public $uses = array('house');
	public $paginate = array();

	public function search(){
		$this->set('title_for_layout', 'Search properties for sale');
		$modelName = 'house';
		App::import('Vendor', 'configHouse');
		$setubiArr = setubiArr();
		$tiikiArr = tiikiArr();
		$kakakuStartArr = kakakuStartArr();
		$kakakuEndArr = kakakuEndArr();
		$this->paginate['limit'] = PAGE_NUMK;
		$this->paginate['fields'] = array($modelName.'.id',$modelName.'.syubetu',$modelName.'.shicd',$modelName.'.zipcode',
			$modelName.'.bu_zyuusyo1',$modelName.'.bu_zyuusyo2',$modelName.'.madori1',$modelName.'.madori2',$modelName.'.totimen',
			$modelName.'.tatemen',$modelName.'.kakaku',$modelName.'.tiku_nen',$modelName.'.tiku_tuki',
			$modelName.'.eki_en1',$modelName.'.eki_eki1',$modelName.'.eki_ko1',$modelName.'.eki_hun1',
			$modelName.'.eki_en2',$modelName.'.eki_eki2',$modelName.'.eki_ko2',$modelName.'.eki_hun2',
			$modelName.'.eki_en3',$modelName.'.eki_eki3',$modelName.'.eki_ko3',$modelName.'.eki_hun3',
			$modelName.'.new',$modelName.'.touroku_date',$modelName.'.hp_hyouzi',$modelName.'.gaikan_img');
		//-----お客様HP表示なし
		$this->paginate['conditions']['NOT'] =  array($modelName.'.hp_hyouzi' => 1);
		//-----地域（一部一致）
		$district = $this->request->query('district');
		$zipcode = $this->request->query('zipcode');
		$shicd = $this->request->query('shicd');
		$ti = $this->request->query('ti');

		if (isset($zipcode) && $zipcode !== '' && $zipcode !== '0') {
    $this->request->data['zipcode'] = $zipcode;
    $this->paginate['conditions'][$modelName . '.zipcode'] = $zipcode;
} if (isset($shicd) && $shicd !== '' && $shicd !== '0') {
    $this->request->data['shicd'] = $shicd;
    $this->paginate['conditions'][$modelName . '.shicd'] = $shicd;
} elseif (isset($ti) && $ti !== '' && $ti !== '0') {
    $this->request->data['ti'] = $ti;
    $tiToShicdPrefix = array(
        '1' => '11',
        '2' => '12',
        '3' => '13',
        '4' => '14'
    );
    if (isset($tiToShicdPrefix[$ti])) {
        $tiPrefix = $tiToShicdPrefix[$ti];
        $this->paginate['conditions'][] = "$modelName.shicd LIKE '$tiPrefix%'";
    }
}
		//-----種別・間取り１・間取り２・お客様HP表示なし ・新築 （完全一致）
		$coAr = array('syubetu'=>'sy','madori1'=>'ms','madori2'=>'mt','id'=>'id','hp_hyouzi'=>'oh','sintiku'=>'si');
		foreach($coAr as $key => $val){
			if(!empty($this->request->query[$val]) && $this->request->query[$val] != 0){
				$this->request->data[$val] = $this->request->query[$val];
				$this->paginate['conditions'][$modelName.'.'.$key] =  $this->request->query[$val];
			}
		}
		//-----沿線　駅（完全一致）

		if (!empty($this->request->query['en'])) {
			$en = str_pad($this->request->query['en'], 4, '0', STR_PAD_LEFT);
			$this->request->data['en'] = $this->request->query['en'];
			if (!empty($this->request->query['ek'])) {
				$ek = str_pad($this->request->query['ek'], 7, '0', STR_PAD_LEFT);
				$this->request->data['ek'] = $this->request->query['ek'];
				for ($a = 1; $a <= 3; $a++) {
					$this->paginate['conditions']['OR'][] = array(
						$modelName . '.eki_en' . $a => $en,
						$modelName . '.eki_eki' . $a => $ek
					);
				}
			} else {
				for ($a = 1; $a <= 3; $a++) {
					$this->paginate['conditions']['OR'][] = array(
						$modelName . '.eki_en' . $a => $en
					);
				}
			}
		}
		//-----価格（範囲一致）
		if(!empty($this->request->query['ts']) && $this->request->query['ts'] != 0){
			$this->request->data['ts'] = $this->request->query['ts'];
			$this->paginate['conditions']['and'][] = array($modelName . '.kakaku >=' => (int)$this->request->query['ts']);
		}
		if(!empty($this->request->query['te']) && $this->request->query['te'] != 0){
			$this->request->data['te'] = $this->request->query['te'];
			$this->paginate['conditions']['and'][] = array($modelName . '.kakaku <=' => (int)$this->request->query['te']);
		}
		//-----設備 （完全一致）
		foreach($setubiArr as $key => $val){
			if($val != ''){
				if(!empty($this->request->query['s'.$key])){
					$this->paginate['conditions'][$modelName.'.setubi'.$key] =  $this->request->query['s'.$key];
				}
			}
		}
		$this->paginate['sort'] = $modelName.'.id';//--設定3/3
		//----------------------------------------------------------複数条件ソートで追加
		if(!empty($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'madori1'){
			$this->paginate['order'] = array(
				$modelName.'.madori1' => $this->request->params['named']['direction'],
				$modelName.'.madori2'=>$this->request->params['named']['direction']
			);
		}elseif(!empty($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'tiku_nen'){
			$this->paginate['order'] = array(
				$modelName.'.tiku_nen' => $this->request->params['named']['direction'],
				$modelName.'.tiku_tuki'=>$this->request->params['named']['direction']
			);
		}
		//-----【cakephpのControllerのコード変更して複数ソート可能に変更　メモ】-----
	
		$this->paginate['direction'] = 'desc';
		$this->set('data',$this->paginate($modelName));
		$this->set('modelName',$modelName);
	}
	public function map(){
		$this->set('title_for_layout', '売買 Map検索');
		$modelName = 'house';
		App::import('Vendor', 'configHouse');
		$setubiArr = setubiArr();
		$tiikiArr = tiikiArr();
		$kakakuStartArr = kakakuStartArr();
		$kakakuEndArr = kakakuEndArr();
		$this->paginate['limit'] = PAGE_NUMK;
		$query = $this->request->query;
		$conditions = [];
		$this->paginate['fields'] = array($modelName.'.id',$modelName.'.syubetu',$modelName.'.shicd',$modelName.'.zipcode',
			$modelName.'.bu_zyuusyo1',$modelName.'.madori1',$modelName.'.madori2',$modelName.'.totimen',
			$modelName.'.tatemen',$modelName.'.kakaku',$modelName.'.tiku_nen',$modelName.'.tiku_tuki',
			$modelName.'.eki_en1',$modelName.'.eki_eki1',$modelName.'.eki_ko1',$modelName.'.eki_hun1',
			$modelName.'.eki_en2',$modelName.'.eki_eki2',$modelName.'.eki_ko2',$modelName.'.eki_hun2',
			$modelName.'.eki_en3',$modelName.'.eki_eki3',$modelName.'.eki_ko3',$modelName.'.eki_hun3',
			$modelName.'.new',$modelName.'.touroku_date',$modelName.'.hp_hyouzi',$modelName.'.gaikan_img',$modelName.'.map2');
		//-----お客様HP表示なし
		$this->paginate['conditions']['NOT'] =  array($modelName.'.hp_hyouzi' => 1);
		//-----地域（一部一致）
		$query = $this->request->query;

    // Zipcode > shicd > ti
    if (!empty($query['zipcode'])) {
        $zipcode = (int)$query['zipcode'];
        $this->request->data['zipcode'] = $zipcode;
        $conditions[$modelName . '.zipcode'] = $zipcode;
    } elseif (!empty($query['shicd'])) {
        $shicd = $query['shicd'];
        $this->request->data['shicd'] = $shicd;
        $conditions[] = ["CAST($modelName.shicd AS CHAR) LIKE" => "$shicd%"];
    } elseif (!empty($query['ti'])) {
        $ti = $query['ti'];
        $this->request->data['ti'] = $ti;

        $prefMap = array('1' => '11', '2' => '12', '3' => '13', '4' => '14');
        if (isset($prefMap[$ti])) {
            $conditions[] = ["CAST($modelName.shicd AS CHAR) LIKE" => $prefMap[$ti] . '%'];
        }
    }
		//-----種別・間取り１・間取り２・お客様HP表示なし ・新築 （完全一致）
		$coAr = array('syubetu'=>'sy','madori1'=>'ms','madori2'=>'mt','id'=>'id','hp_hyouzi'=>'oh','sintiku'=>'si');
		foreach($coAr as $key => $val){
			if(!empty($this->request->query[$val]) && $this->request->query[$val] != 0){
				$this->request->data[$val] = $this->request->query[$val];
				$this->paginate['conditions'][$modelName.'.'.$key] =  $this->request->query[$val];
			}
		}
		//-----沿線　駅（完全一致）
 if (!empty($this->request->query['en'])) {
    $en = str_pad($this->request->query['en'], 4, '0', STR_PAD_LEFT);
    $this->request->data['en'] = $this->request->query['en'];

    if (!empty($this->request->query['ek'])) {
        $ek = str_pad($this->request->query['ek'], 7, '0', STR_PAD_LEFT);
        $this->request->data['ek'] = $this->request->query['ek'];
        for ($a = 1; $a <= 3; $a++) {
            $this->paginate['conditions']['OR'][] = array(
                $modelName . '.eki_en' . $a => $en,
                $modelName . '.eki_eki' . $a => $ek
            );
        }
    } else {
        for ($a = 1; $a <= 3; $a++) {
            $this->paginate['conditions']['OR'][] = array(
                $modelName . '.eki_en' . $a => $en
            );
        }
    }
}


		//-----価格（範囲一致）
		if(!empty($this->request->query['ts']) && $this->request->query['ts'] != 0){
			$this->request->data['ts'] = $this->request->query['ts'];
			$this->paginate['conditions']['and'][] = array($modelName . '.kakaku >=' => (int)$this->request->query['ts']);
		}
		if(!empty($this->request->query['te']) && $this->request->query['te'] != 0){
			$this->request->data['te'] = $this->request->query['te'];
			$this->paginate['conditions']['and'][] = array($modelName . '.kakaku <=' => (int)$this->request->query['te']);
		}
		//-----設備 （完全一致）
		foreach($setubiArr as $key => $val){
			if($val != ''){
				if(!empty($this->request->query['s'.$key])){
					$this->paginate['conditions'][$modelName.'.setubi'.$key] =  $this->request->query['s'.$key];
				}
			}
		}
		$this->paginate['sort'] = $modelName.'.id';//--設定3/3
		//----------------------------------------------------------複数条件ソートで追加
		if(!empty($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'madori1'){
			$this->paginate['order'] = array(
				$modelName.'.madori1' => $this->request->params['named']['direction'],
				$modelName.'.madori2'=>$this->request->params['named']['direction']
			);
		}elseif(!empty($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'tiku_nen'){
			$this->paginate['order'] = array(
				$modelName.'.tiku_nen' => $this->request->params['named']['direction'],
				$modelName.'.tiku_tuki'=>$this->request->params['named']['direction']
			);
		}

		$this->paginate['conditions'] += $conditions;

		$this->paginate['direction'] = 'desc';
		$this->set('data',$this->paginate($modelName));
		$this->set('modelName',$modelName);
	}
	public function view(){

		$this->set('title_for_layout', '売買 詳細');

		$modelName = 'house';

		$data = $this->$modelName->find('first',array(

			'fields' => array($modelName . '.*'), // すべてのカラムを指定
    		'conditions' => array('id' => $this->request->query['id'])

		));

		$this->set('data',$data);

		$this->set('modelName',$modelName);

	}
	public function contact(){
		$this->set('title_for_layout', '売買 お問合せ');
		$modelName = 'house';
		if(isset($this->request->query['id'])){
			$this->request->data['id'] = $this->request->query['id'];
		}
		$data = $this->$modelName->find('first',array(
			'fields' => array($modelName . '.*'), // すべてのカラムを指定
			'conditions'=>array('id' => $this->request->data['id'])
		));
		$this->set('data',$data);
		$this->set('modelName',$modelName);
	}
	public function contact2(){
		$this->set('title_for_layout', '売買 お問合せ');
	}
	public function contact3(){
		$this->set('title_for_layout', '売買 お問合せ');
		App::import('Vendor', 'configContact');
		//-------------------------------------------フォーム元チェック
		if(LINK_CHECK != ''){
			$link_check2 = $_SERVER['HTTP_REFERER'];
			$link_check2 = explode('/', $link_check2);
			if($link_check2[2] == LINK_CHECK || $link_check2[2] == 'www.'.LINK_CHECK){
				$link_check3 = 1;
			}else{
				$link_check3 = 0;
			}
		}else{
			$link_check3 = 1;
		}
		if ($link_check3 == 0){
			echo '【エラー】フォームよりご入力ください。';
			exit;
		}
		//-------------------------------------------送信
		mb_language('uni');//mb_language('ja');にすると㎡が?になる
		mb_internal_encoding('UTF-8');
		$reArray = array('bukken','fname','fkana','fmail','ftel','fkibou','fteltime','fnaiyou');
		if(get_magic_quotes_gpc()){
			foreach ($reArray as $va) {
				$this->request->data[$va] = stripslashes($this->request->data[$va]);
			}
		}
		$mailCoAr = array();
		foreach ($reArray as $va) {
			$mailCoAr[$va] = htmlspecialchars_decode($this->request->data[$va], ENT_QUOTES);
		}
		$mailArr = contact_setup($mailCoAr);

		$header  = 'From:'.$this->request->data['fmail'];
		mb_send_mail($mailArr['address'], $mailArr['subject'], $mailArr['message'], $header);

		if($mailArr['mobile'] != ''){
			$mo_message_over = '';
			if(600 < mb_strlen( $mailArr['message'], 'UTF-8' )){$mo_message_over = "\n".'...【続きがあります続きは、PCメールでご確認ください】';}
			$mo_message = mb_substr($mailArr['message'], 0,600,'UTF-8');
			$mo_message .= $mo_message_over;
			mb_send_mail($mailArr['mobile'], $mailArr['subject'], $mo_message, $header);
		}

		$re_header  = 'From:'.$mailArr['address'];
		$re_address = $this->request->data['fmail'];
		mb_send_mail($re_address, $mailArr['re_subject'], $mailArr['re_message'], $re_header);
		$this->set('toppage',$mailArr['toppage']);
	}
}
