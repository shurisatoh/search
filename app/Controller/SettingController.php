<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
class SettingController extends AppController {

	public $components = array('Auth','Acl');
	public $layout = "admin";
	public $uses = array('User');

	public function beforeFilter(){
		$this->Auth->allow('index','mail');
		App::import('Vendor', 'configDb');
		if(DBCONFIG != 0){exit;}
	}
	public function index(){
		$this->set('title_for_layout', '初期設定　ebs3');
		$this->set('errmsg','');
	}
	public function mail(){
		//------------------------------------------テーブル作成
		$db = array();
		$userPsAr = array();
		for($a = 1; $a <= 2; $a++) {
			$userPsAr[$a] = '';
			$userPsAr[$a] .= substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4);
			$userPsAr[$a] .= substr(str_shuffle('1234567890'), 0, 4);
			$db['ps'.$a] = AuthComponent::password($userPsAr[$a]);
		}
		App::import('Vendor', 'NewTableLibrary');
		$db['dbServer'] = $this->request->data['host'];
		$db['dbUser'] = $this->request->data['login'];
		$db['dbPass'] = $this->request->data['password'];
		$db['dbName'] = $this->request->data['database'];
		//--実行
		$flag = tableAddRecord($db);
		if($flag == TRUE){
			//------------------------------------------データベースをdatabase.phpに情報書き込み
			$data = '';
			$filepointer = fopen('../Config/database.php', "a+");
			flock($filepointer, LOCK_EX);
			while(!feof($filepointer)){
				$value = fgets($filepointer);
				$value = preg_replace(preg_quote("/'host' => ''/"), "'host' => '{$this->request->data['host']}'", $value);
				$value = preg_replace(preg_quote("/'login' => ''/"), "'login' => '{$this->request->data['login']}'", $value);
				$value = preg_replace(preg_quote("/'password' => ''/"), "'password' => '{$this->request->data['password']}'", $value);
				$value = preg_replace(preg_quote("/'database' => ''/"), "'database' => '{$this->request->data['database']}'", $value);
				$data.= $value;
			}
			ftruncate($filepointer,0);
			fputs($filepointer, $data);
			flock($filepointer, LOCK_UN);
			fclose($filepointer);
			//------------------------------------------フラグ設定
			$data = '';
			$filepointer = fopen('../Vendor/configDb.php', "a+");
			flock($filepointer, LOCK_EX);
			while(!feof($filepointer)){
				$value = fgets($filepointer);
				$value = preg_replace(preg_quote("/'DBCONFIG', 0/"), "'DBCONFIG', 1", $value);
				$data.= $value;
			}
			ftruncate($filepointer,0);
			fputs($filepointer, $data);
			flock($filepointer, LOCK_UN);
			fclose($filepointer);
			$this->set('title_for_layout', '送信完了　TimeRecorder ITS');
			//------------------------------------------管理者・メンバーusername・password　メール送信
			$menuUrl = preg_replace(preg_quote("/Setting/"), 'Menu', $_SERVER['HTTP_REFERER']);
			//$menuUrl = substr($menuUrl, 0, -1);
			$fromName = 'ebs3';// 送信者
			$from = 'info@'.$_SERVER["SERVER_NAME"];// 送信元
			$to = $this->request->data['mail'];// 宛先
			$subject = mb_encode_mimeheader('ebs3　管理者・メンバーusername・password',"ISO-2022-JP");// タイトル
			$message = '<br />
			管理者　username：ebs3admin<br />
			管理者　password：'.$userPsAr[1].'<br />
			メンバー　username：ebs3member<br />
			メンバー　password：'.$userPsAr[2].'<br />
			メニューURL：'.$menuUrl.'<br />
			<br /><br />
			ebs3';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= 'From: '.mb_encode_mimeheader($fromName,"ISO-2022-JP").' <'.$from.'>' . "\r\n";
			mail($to, $subject, $message, $headers);// 送信
		}else{
				$this->set('title_for_layout', '初期設定　ebs3');
				$this->set('errmsg','<p id="page_title"><span class="errmsg">初期設定に失敗しました'.
					'（データベースの設定 [MySQL]の入力内容を確認してください）</span></p>');
				$this->render('index');
		}
	}
}
