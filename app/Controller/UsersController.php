<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
class UsersController extends AppController {

	public $components = array('Auth','Acl');
	public $layout = "admin";
	public $uses = array('User');

	public function beforeFilter(){
		$this->Auth->allow('login','logout');
		if($this->action != 'login' && $this->action != 'logout'){
			$uname = $this->Auth->user('username');
			$act = $this->action;
			$act = $act == 'index' ? 'create' : $act;
			$act = $act == 'add' ? 'create' : $act;
			$act = $act == 'updateRecord' ? 'create' : $act;
			$act = $act == 'delRecord' ? 'create' : $act;
			$act = $act == 'config' ? 'create' : $act;
			$act = $act == 'userAclPs' ? 'create' : $act;
			$this->Session->write('act',$act);
			if ($this->Acl->check($uname, 'users',$act)){
			} else {
				$this->redirectHttpsAcl();
			}
		}
	}
	public function index(){
		$this->set('title_for_layout', 'メンバー設定');
		$this->uses[] = 'Aro';
		$this->User->primaryKey = 'username';
		$this->User->bindModel(
				array('hasOne'=>array(
					'Aro' =>array(
						'className'=>'Aro',
						'dependent'=>false,
						'limit'=>0,
						'exclusive'=>false,
						'finderQuery'=>'',
						'foreignKey'=>'alias',
						'fields'=>array('id','parent_id')
					)
				))
		);
		$data = $this->User->find('all',array(
				'fields' => array('User.id','User.username','User.password','User.name','Aro.id','Aro.parent_id'),
				'order' => array('User.id')
		));
		$this->set('data',$data);
	}
	public function login(){

		App::import('Vendor', 'configDb');
		if(DBCONFIG == 0){$this->redirectHttps('Setting/');}

		if ($this->request->isPost()) {
		  if ($this->Auth->login()) {
		  	$this->redirect($this->Session->read('login_redirect'));
		  }
		}
		$this->set('title_for_layout', 'Ebs3System');
	}
	public function logout() {
		$this->Auth->logout();
		$this->Session->destroy();
	}
	public function add(){
		$this->set('title_for_layout', 'メンバー設定');
		if(isset($this->request->data['User']['id'])){
			$data = $this->User->find('first',array(
				'conditions'=>array('User.id' => $this->request->data['User']['id']),
				'fields'=>array('User.id','User.username','User.name')
			));
			foreach( $data['User'] as $key => $val ){
				$this->request->data['User'][$key] = $val;
			}
		}
	}
	public function updateRecord(){
		if($this->request->data['User']['password'] == ''){
			unset($this->request->data['User']['password']);
		}
		$this->User->save($this->data);
		if(!empty($this->request->data['Aro']['id'])){
			$aroData = array(
				'id' => $this->request->data['Aro']['id'],
				'alias' => $this->request->data['User']['username'],
				'parent_id' => $this->request->data['aro']
			);
		}else{
			$aroData = array(
				'alias' => $this->request->data['User']['username'],
				'parent_id' => $this->request->data['aro']
			);
		}
		$aro =new Aro();
		$aro->create();
		$aro->save($aroData);
		$this->redirect('./');
	}
	public function delRecord(){
		if($this->request->data['User']['id'] != 1){
			$this->User->delete($this->data['User']['id']);
			$this->uses[] = 'Aro';
			$this->Aro->delete($this->data['Aro']['id']);
			$this->redirect('./');
		}else{
			$this->redirect('./');
		}
	}
	public function userAclPs(){
		$this->uses[] = 'Aro';
		$this->uses[] = 'Aco';
		$this->uses[] = 'Aros_aco';
		if(!empty($this->request->data['aro_delete'])){
			$this->Aro->delete($this->request->data['aro_delete']);
		}
		if(!empty($this->request->data['aco_delete'])){
			$this->Aco->delete($this->request->data['aco_delete']);
		}
		if(!empty($this->request->data['aroaco_delete'])){
			$this->Aros_aco->delete($this->request->data['aroaco_delete']);
		}
		if(!empty($this->request->data['aro'])&& !empty($this->request->data['alias'])){
			if(!empty($this->request->data['alias'])&&!empty($this->request->data['parent_id'])){
				$aroData = array(
					'alias' => $this->request->data['alias'],
					'parent_id' => $this->request->data['parent_id']
				);
			}else{
				$aroData = array(
					'alias' => $this->request->data['alias']
				);
			}
			$aro =new Aro();
			$aro->create();
			$aro->save($aroData);
		}
		if(!empty($this->request->data['aco'])&& !empty($this->request->data['alias'])){
			$acoData = array(
				'alias' => $this->request->data['alias']
			);
			$aco =new Aco();
			$aco->create();
			$aco->save($acoData);
		}
		if(!empty($this->request->data['aroaco'])&&
				!empty($this->request->data['aroaco1'])&&
				!empty($this->request->data['aroaco2'])){
					if(!empty($this->request->data['aroaco3'])&&!empty($this->request->data['aroaco4'])){
						if($this->request->data['aroaco1'] == 'allow'){
							$this->Acl->allow(
									$this->request->data['aroaco2'],
									$this->request->data['aroaco3'],
									$this->request->data['aroaco4']
									);
						}elseif($this->request->data['aroaco1'] == 'deny'){
							$this->Acl->deny(
									$this->request->data['aroaco2'],
									$this->request->data['aroaco3'],
									$this->request->data['aroaco4']
									);
						}
					}elseif(!empty($this->request->data['aroaco3'])){
						if($this->request->data['aroaco1'] == 'allow'){
							$this->Acl->allow(
									$this->request->data['aroaco2'],
									$this->request->data['aroaco3']
									);
						}elseif($this->request->data['aroaco1'] == 'deny'){
							$this->Acl->deny(
									$this->request->data['aroaco2'],
									$this->request->data['aroaco3']
									);
						}
					}
		}
		if(!empty($this->request->data['ps'])
				&& !empty($this->request->data['User']['id'])){
					$this->User->save($this->data);
		}
		$this->set('title_for_layout', 'メンバーAclパスワード設定');
		$userData = $this->User->find('all',array(
			'fields' => array('User.id','User.username','User.password','User.name')
		));
		$this->set('userData',$userData);
		$acosData = $this->Aco->find('all');
		$this->set('acosData',$acosData);
		$arosData = $this->Aro->find('all',array(
			'order' => array('Aro.parent_id')
		));
		$this->set('arosData',$arosData);
		$aroacoData = $this->Aros_aco->find('all',
				array(
					'order' => array('Aros_aco.aco_id','Aros_aco.aro_id')//order　並び順　順番違うとエラーでる
				)
				);
		$this->set('aroacoData',$aroacoData);
		//print_r($userData);
	}
}
