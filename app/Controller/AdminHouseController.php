<?php

class AdminHouseController extends AppController {

	public $layout = "admin";
	public $uses = array('house');
	public $components = array('Auth','Acl');
	public $paginate = array();

	public function beforeFilter(){
		$uname = $this->Auth->user('username');
		$act = $this->action;
		$act = $act == 'search' ? 'read' : $act;
		$act = $act == 'add' ? 'read' : $act;
		$act = $act == 'imgAdd' ? 'read' : $act;
		$act = $act == 'imgRoad' ? 'read' : $act;
		$act = $act == 'daityou' ? 'read' : $act;
		$act = $act == 'daityouUra' ? 'read' : $act;
		$act = $act == 'kanban' ? 'read' : $act;
		$act = $act == 'zyouhou' ? 'read' : $act;
		$act = $act == 'updateRecord' ? 'read' : $act;
		$act = $act == 'delRecord' ? 'read' : $act;
		$this->Session->write('act',$act);
		if($this->Acl->check($uname, 'adminHouse',$act)){
		}else{$this->redirectHttpsAcl();}
	}

	public function search(){
		$this->set('title_for_layout','管理 売買 検索');
		$modelName = 'house';
		App::import('Vendor', 'configHouse');
		$setubiArr = setubiArr();
		$tiikiArr = tiikiArr();
		$kakakuStartArr = kakakuStartArr();
		$kakakuEndArr = kakakuEndArr();
		$this->paginate['limit'] = PAGE_NUM;
		$this->paginate['fields'] = array($modelName.'.id',$modelName.'.syubetu',
			$modelName.'.bukkenmei',$modelName.'.bu_zyuusyo1',
			$modelName.'.madori1',$modelName.'.madori2',$modelName.'.totimen',$modelName.'.tatemen',
			$modelName.'.kakaku',$modelName.'.tiku_nen',$modelName.'.tiku_tuki',
			$modelName.'.eki_en1',$modelName.'.eki_eki1',$modelName.'.eki_ko1',$modelName.'.eki_hun1',
			$modelName.'.eki_en2',$modelName.'.eki_eki2',$modelName.'.eki_ko2',$modelName.'.eki_hun2',
			$modelName.'.eki_en3',$modelName.'.eki_eki3',$modelName.'.eki_ko3',$modelName.'.eki_hun3',
			$modelName.'.new',$modelName.'.touroku_date',$modelName.'.hp_hyouzi',$modelName.'.gaikan_img');
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
		//-----種別・間取り１・間取り２・お客様HP表示なし ・新築（完全一致）
		$coAr = array('syubetu'=>'sy','madori1'=>'ms','madori2'=>'mt','id'=>'id','hp_hyouzi'=>'oh','sintiku'=>'si');
		foreach($coAr as $key => $val){
			if(!empty($this->request->query[$val]) && $this->request->query[$val] != 0){
				$this->request->data[$val] = $this->request->query[$val];
				$this->paginate['conditions'][$modelName.'.'.$key] =  $this->request->query[$val];
			}
		}
		//-----沿線　駅（完全一致）
		if(!empty($this->request->query['en']) && $this->request->query['en'] != 0){
			$this->request->data['en'] = $this->request->query['en'];
			if(!empty($this->request->query['ek']) && $this->request->query['ek'] != 0){
				$this->request->data['ek'] = $this->request->query['ek'];
				for($a = 1; $a <= 3; $a++) {
					$this->paginate['conditions']['or'][$a]['and'][$modelName.'.eki_en'.$a] =  $this->request->query['en'];
					$this->paginate['conditions']['or'][$a]['and'][$modelName.'.eki_eki'.$a] =  $this->request->query['ek'];
				}
			}else{
				for($a = 1; $a <= 3; $a++) {
					$this->paginate['conditions']['or'][$modelName.'.eki_en'.$a] =  $this->request->query['en'];
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
		//-----物件番号 （完全一致）
		if(!empty($this->request->query['id'])){
			$this->request->data['id'] = $this->request->query['id'];
			$this->paginate['conditions'][$modelName.'.id'] =  $this->request->query['id'];
		}
		//-----Word（一部一致）
		if(!empty($this->request->query['wo'])){
			$this->request->data['wo'] = $this->request->query['wo'];
			$coAr = array('bukkenmei','u_simei','u_tantou','comment','bikou');
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
		$modelName = 'house';
		$this->set('modelName',$modelName);
		if(isset($this->request->data[$modelName]['id'])){
			$this->set('title_for_layout', '管理 売買 変更');
			$data = $this->$modelName->find('first',array(
				'conditions'=>array($modelName.'.id' => $this->request->data[$modelName]['id'])
			));
			foreach( $data[$modelName] as $key => $va ){
				$this->request->data[$modelName][$key] = $data[$modelName][$key];
			}
		}else{
			$this->set('title_for_layout', '管理 売買 登録');
		}
		$this->request->data[$modelName]['nyuuryokusya'] = $this->Auth->user('name');
	}
	public function imgAdd(){
		$this->set('title_for_layout','管理 売買 画像');
		$modelName = 'house';

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
					$imgFileDel = '../../siryouImage/house/'.$id.'_siryou.jpg';
				} else {
					$imgFileDel = '../webroot/img/house/gazou/'.$id.'_'.$index.'.jpg';
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

			// リサイズ処理
			if($img_syurui == 'siryou_img'){
				$max = 1800;
				$imgfile_new = '../../siryouImage/house/'.$id.'_siryou.jpg';
			} else {
				$max = 640;
				$imgfile_new = '../webroot/img/house/gazou/'.$id.'_'.$index.'.jpg';
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
		readfile('../../siryouImage/house/'.$this->request->query['no'].'_siryou.jpg');
	}

	public function daityou(){
		$this->set('title_for_layout', '管理 売買 台帳');
		$modelName = 'house';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function daityouUra(){
		$this->set('title_for_layout', '管理 売買 台帳 裏');
		$modelName = 'house';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function kanban(){
		$this->set('title_for_layout', '管理 売買 看板');
		$modelName = 'house';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function zyouhou(){
		$this->set('title_for_layout', '管理 売買 情報誌');
		$modelName = 'house';
		$data = $this->$modelName->find('first',array(
			'conditions'=>array($modelName.'.id' => $this->request->query['id'])
		));
		$this->set('modelName',$modelName);
		$this->set('data',$data);
	}
	public function updateRecord(){
		$modelName = 'house';
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
					$img_m = '../webroot/img/house/'.$va.'/no'.$mId.$va.'.jpg';
					$img_s = '../webroot/img/house/'.$va.'/no'.$newId.$va.'.jpg';;
					copy($img_m,$img_s);
				}
			}
			if(!empty($data[$modelName]['siryou_img'])){
				$img_m = '../../siryouImage/house/no'.$mId.'siryou_img.jpg';
				$img_s = '../../siryouImage/house/no'.$newId.'siryou_img.jpg';
				copy($img_m,$img_s);
			}
			$this->$modelName->save($data[$modelName]);
		}
		//----------------------------------------------------コピーの場合
		$this->redirect($redirect);
	}
	public function delRecord(){
		$modelName = 'house';
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
					$imgFileDel = '../../siryouImage/house/no'.
						$this->request->data[$modelName]['id'].$key.'.jpg';
				}else{
					$imgFileDel = '../webroot/img/house/'.$key.'/no'.
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
