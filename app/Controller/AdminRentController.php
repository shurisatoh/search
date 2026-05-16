<?php

class AdminRentController extends AppController {

	public $layout = "admin";
	public $uses = array('rent');
	public $components = array('Auth','Acl');
	public $paginate = array();

	public function beforeFilter(){
		$uname = $this->Auth->user('username');
		$act = $this->action;
		$act = in_array($act, ['search', 'add', 'imgAdd', 'imgRoad', 'daityou', 'daityouUra', 'kanban', 'zyouhou', 'updateRecord', 'delRecord']) ? 'read' : $act;
		$this->Session->write('act',$act);
		if(!$this->Acl->check($uname, 'adminRent',$act)){
			$this->redirectHttpsAcl();
		}
	}

	public function search(){
		$this->set('title_for_layout','管理 賃貸 検索');
		$modelName = 'rent';
		App::import('Vendor', 'configRent');
		$setubiArr = setubiArr();
		$tiikiArr = tiikiArr();
		$tinryouStartArr = tinryouStartArr();
		$tinryouEndArr = tinryouEndArr();
		$this->paginate['limit'] = PAGE_NUM;
		$this->paginate['fields'] = array($modelName.'.id',$modelName.'.syubetu',$modelName.'.zipcode',$modelName.'.bukkenmei',
			$modelName.'.bu_zyuusyo1',$modelName.'.madori1',$modelName.'.madori2',
			$modelName.'.heibei',$modelName.'.yatin_k',$modelName.'.kyoueki_k',$modelName.'.hosyou_ku',
			$modelName.'.hosyou_k',$modelName.'.kaiyaku_ku',$modelName.'.kaiyaku_k',$modelName.'.kaisuu',
			$modelName.'.tiku_nen',$modelName.'.tiku_tuki',$modelName.'.eki_en1',$modelName.'.eki_eki1',
			$modelName.'.eki_ko1',$modelName.'.eki_hun1',$modelName.'.eki_en2',$modelName.'.eki_eki2',
			$modelName.'.eki_ko2',$modelName.'.eki_hun2',$modelName.'.eki_en3',$modelName.'.eki_eki3',
			$modelName.'.eki_ko3',$modelName.'.eki_hun3',$modelName.'.syozaikai',$modelName.'.new',
			$modelName.'.touroku_date',$modelName.'.hp_hyouzi',$modelName.'.gaikan_img');
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
		//-----種別・間取り１・間取り２・お客様HP表示なし （完全一致）
		$coAr = array('syubetu'=>'sy','madori1'=>'ms','madori2'=>'mt','id'=>'id','hp_hyouzi'=>'oh');
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
		//-----賃料（範囲一致）
		if(!empty($this->request->query['ts']) && $this->request->query['ts'] != 0){
			$this->request->data['ts'] = $this->request->query['ts'];
			$this->paginate['conditions']['and'][] = array($modelName.'.yatin_k >=' => $tinryouStartArr[$this->request->query['ts']]);
		}
		if(!empty($this->request->query['te']) && $this->request->query['te'] != 0){
			$this->request->data['te'] = $this->request->query['te'];
			$this->paginate['conditions']['and'][] = array($modelName.'.yatin_k <=' => $tinryouEndArr[$this->request->query['te']]);
		}
		//-----物件番号 （完全一致）
		if(!empty($this->request->query['id'])){
			$this->request->data['id'] = $this->request->query['id'];
			$this->paginate['conditions'][$modelName.'.id'] =  $this->request->query['id'];
		}
		//-----Word（一部一致）
		if(!empty($this->request->query['wo'])){
			$this->request->data['wo'] = $this->request->query['wo'];
			$coAr = array('bukkenmei','yanusi_mei','kanri_mei','comment','daityou_bi');
			foreach($coAr as $val){
				$this->paginate['conditions']['or'][$modelName.'.'.$val.' LIKE'] =  '%'.$this->request->query['wo'].'%';
			}
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
		//ebs3\lib\Cake\Controller\Component\PaginatorComponent.php
		//をコピーして
		//ebs3\app\Controller\Component\PaginatorComponent.php
		//に追加　335をコメントアウトして336追加
		//335 //$options['order'] = array($options['sort'] => $direction);
		//336 if(!empty($options['order'])){
		//    	$options['order'] = array_merge(array($options['sort'] => $direction), $options['order']);
		//    }else{
		//    	$options['order'] = array($options['sort'] => $direction);
		//    }
		//----------------------------------------------------------複数条件ソートで追加
		$this->paginate['direction'] = 'desc';
		$this->set('data',$this->paginate($modelName));
		$this->set('modelName',$modelName);
	}
	public function add(){
		$modelName = 'rent';
		$this->set('modelName',$modelName);
		if(isset($this->request->data[$modelName]['id'])){
			$this->set('title_for_layout', '管理 賃貸 変更');
			$data = $this->$modelName->find('first',array(
				'conditions'=>array($modelName.'.id' => $this->request->data[$modelName]['id'])
			));
			foreach( $data[$modelName] as $key => $va ){
				$this->request->data[$modelName][$key] = $data[$modelName][$key];
			}
		}else{
			$this->set('title_for_layout', '管理 賃貸 登録');
		}
		$this->request->data[$modelName]['nyuuryokusya'] = $this->Auth->user('name');
	}
	public function imgAdd(){
		$this->set('title_for_layout','管理 賃貸 画像');
		$modelName = 'rent';

		$img_syurui = $this->request->data['img_syurui'];
		$id = $this->request->data[$modelName]['id'];
		$img_index = array(
			'gaikan_img' => 0,
			'madori_img' => 1,
			'syousai_img1' => 2,
			'syousai_img2' => 3,
			'syousai_img3' => 4,
			'syousai_img4' => 5,
			'syousai_img5' => 6,
			'syousai_img6' => 7,
			'syousai_img7' => 8,
			'syousai_img8' => 9,
			'syousai_img9' => 10,
			'syousai_img10' => 11,
		);
		$index = isset($img_index[$img_syurui]) ? $img_index[$img_syurui] : 99;

		if(!empty($this->request->data['del'])){
			if(!empty($this->request->data[$modelName][$img_syurui])){
				if($img_syurui == 'siryou_img'){
					$imgFileDel = '../../siryouImage/rent/'.$id.'_siryou.jpg';
				} else {
					$imgFileDel = '../webroot/img/rent/gazou/'.$id.'_'.$index.'.jpg';
				}
				$this->request->data[$modelName][$img_syurui] = '';
				if(file_exists($imgFileDel)) unlink($imgFileDel);
			}
			$this->$modelName->save($this->data[$modelName]);
		}

		if(!empty($_FILES['data']['tmp_name']['img'])){
			$imgfile = $_FILES['data']['tmp_name']['img'];
			$image = ImageCreateFromJPEG($imgfile);
			$width = ImageSX($image);
			$height = ImageSY($image);
			$wh = ($width < $height) ? 2 : 1;

			if($img_syurui == 'siryou_img'){
				$max = 1800;
				$imgfile_new = '../../siryouImage/rent/'.$id.'_siryou.jpg';
			} else {
				$max = 640;
				$imgfile_new = '../webroot/img/rent/gazou/'.$id.'_'.$index.'.jpg';
			}

			if($width > $max || $height > $max){
				if($width >= $height){
					$new_width = $max;
					$new_height = $max * $height / $width;
				} else {
					$new_height = $max;
					$new_width = $max * $width / $height;
				}
			} else {
				$new_width = $width;
				$new_height = $height;
			}

			$new_image = ImageCreateTrueColor($new_width, $new_height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			if(file_exists($imgfile_new)) unlink($imgfile_new);
			ImageJPEG($new_image, $imgfile_new, 90);
			chmod($imgfile_new, 0644);
			$this->request->data[$modelName][$img_syurui] = $wh;
			$this->$modelName->save($this->data[$modelName]);
		}

		$data = $this->$modelName->find('first',array(
			'conditions'=>array('id' => $id)
		));
		foreach($data[$modelName] as $key => $val){
			$this->request->data[$modelName][$key] = $val;
		}
		$this->set('modelName',$modelName);
	}

	public function imgRoad(){
		$this->autoRender = false;
		header('Content-type: image/jpeg');
		readfile('../../siryouImage/rent/'.$this->request->query['no'].'_siryou.jpg');
	}
	public function daityou(){
		$this->set('title_for_layout', '管理 賃貸 台帳');
		$modelName = 'rent';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function daityouUra(){
		$this->set('title_for_layout', '管理 賃貸 台帳 裏');
		$modelName = 'rent';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function kanban(){
		$this->set('title_for_layout', '管理 賃貸 看板');
		$modelName = 'rent';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function zyouhou(){
		$this->set('title_for_layout', '管理 賃貸 情報誌');
		$modelName = 'rent';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function updateRecord(){
		$modelName = 'rent';
		$redirect = 'search'.$this->request->data['page'];
		//----------------------------------------------------コピーの場合
		if(!empty($this->request->data['copy'])){
			$mId = $this->request->data[$modelName]['id'];
			$this->request->data[$modelName]['id'] = '';
		}
		//----------------------------------------------------コピーの場
		$this->$modelName->save($this->data[$modelName]);
		//----------------------------------------------------コピーの場合
		if(!empty($this->request->data['copy'])){
			$newId = $this->$modelName->getLastInsertID();//直前に保存されたIDを取得
			$data = $this->$modelName->find('first',array(
				'conditions'=>array($modelName.'.id' => $mId),
				'fields' =>array($modelName.'.gaikan_img',$modelName.'.madori_img',$modelName.'.siryou_img'
					,$modelName.'.gaikan_co',$modelName.'.madori_co',$modelName.'.siryou_co'
					,$modelName.'.syousai_img1',$modelName.'.syousai_img2',$modelName.'.syousai_img3'
					,$modelName.'.syousai_img4',$modelName.'.syousai_img5',$modelName.'.syousai_img6'
					,$modelName.'.syousai_img7',$modelName.'.syousai_img8',$modelName.'.syousai_img9'
					,$modelName.'.syousai_img10'
					,$modelName.'.syousai_co1',$modelName.'.syousai_co2',$modelName.'.syousai_co3'
					,$modelName.'.syousai_co4',$modelName.'.syousai_co5',$modelName.'.syousai_co6'
					,$modelName.'.syousai_co7',$modelName.'.syousai_co8',$modelName.'.syousai_co9'
					,$modelName.'.syousai_co10')
			));
			$data[$modelName]['id'] = $newId;
			$imgArray = array('gaikan_img','madori_img'
				,'syousai_img1','syousai_img2','syousai_img3','syousai_img4','syousai_img5'
				,'syousai_img6','syousai_img7','syousai_img8','syousai_img9','syousai_img10');
			foreach( $imgArray as $va ){
				if(!empty($data[$modelName][$va])){
					$img_m = '../webroot/img/rent/'.$va.'/no'.$mId.$va.'.jpg';
					$img_s = '../webroot/img/rent/'.$va.'/no'.$newId.$va.'.jpg';;
					copy($img_m,$img_s);
				}
			}
			if(!empty($data[$modelName]['siryou_img'])){
				$img_m = '../../siryouImage/rent/no'.$mId.'siryou_img.jpg';
				$img_s = '../../siryouImage/rent/no'.$newId.'siryou_img.jpg';
				copy($img_m,$img_s);
			}
			$this->$modelName->save($data[$modelName]);
		}
		//----------------------------------------------------コピーの場合
		$this->redirect($redirect);
	}
	public function delRecord(){
		$modelName = 'rent';
		$redirect = 'search'.$this->request->data['page'];
		//----------------------------------------------------画像削除
		$data = $this->$modelName->find('first',array(
			'conditions'=>array('id' => $this->request->data[$modelName]['id']),
			'fields' =>array($modelName.'.gaikan_img',$modelName.'.madori_img',$modelName.'.siryou_img',
				$modelName.'.syousai_img1',$modelName.'.syousai_img2',$modelName.'.syousai_img3',
				$modelName.'.syousai_img4',$modelName.'.syousai_img5',$modelName.'.syousai_img6',
				$modelName.'.syousai_img7',$modelName.'.syousai_img8',$modelName.'.syousai_img9',
				$modelName.'.syousai_img10')
		));
		foreach( $data[$modelName] as $key => $va ){
			if(!empty($va)){
				if($key == 'siryou_img'){
					$imgFileDel = '../../siryouImage/rent/no'.
						$this->request->data[$modelName]['id'].$key.'.jpg';
				}else{
					$imgFileDel = '../webroot/img/rent/'.$key.'/no'.
						$this->request->data[$modelName]['id'].$key.'.jpg';
				}
				unlink($imgFileDel);
			}
		}
		//----------------------------------------------------画像削除
		$this->{$modelName}->delete($this->data[$modelName]['id']);
		$this->redirect($redirect);
	}
}
