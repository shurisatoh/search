<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
class MenuController extends AppController {

	public $layout = "admin";
	public $helpers = array('Js');
	public $components = array('Auth','Acl');

	public function beforeFilter(){//このクラスの共通処理
		$uname = $this->Auth->user('username');
		$act = $this->action;
		$act = $act == 'index' ? 'read' : $act;
		$act = $act == 'config' ? 'create' : $act;
		$act = $act == 'configAdd' ? 'create' : $act;
		$act = $act == 'googlemap' ? 'read' : $act;
		$act = $act == 'pickup' ? 'read' : $act;
		$this->Session->write('act',$act);
		if($this->Acl->check($uname, 'menu',$act)){// アクセスできる場合の処理
		}else{$this->redirectHttpsAcl();}// アクセスできない場合の処理
	}

	public function index(){
		$this->set('title_for_layout', 'メニュー');
		$this->set('authUserName',$this->Auth->user('name'));
	}
	public function config(){
		$this->set('title_for_layout', '設定');
	}
	public function configAdd(){
		$this->set('title_for_layout', '各種設定');
	}
	public function googlemap(){
		$this->set('title_for_layout', 'googlemap 設定');
	}
	public function pickup(){
		$this->set('title_for_layout', 'お勧め 設定');
		if(!empty($this->request->data['bu'])){
			$modelName = $this->request->data['bu'];
			$this->uses[] = $modelName;
			$data = $this->$modelName->find('first',array(
				'conditions'=>array($modelName.'.id' => $this->request->data['id'])
			));
			$this->set('data',$data);
			$this->set('modelName',$modelName);
		}
	}
}
