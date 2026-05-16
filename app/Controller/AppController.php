<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public function redirectHttps($classAction){
		//さくらインターネットの場合httpsからhttpへリダイレクトされてしまうのでhttps判定追加
		//$_SERVER['HTTP_X_SAKURA_FORWARDED_FOR']中止で$_SERVER['HTTPS']に変更2019/08/07
		if(isset($_SERVER['HTTPS'])) {$http = 'https://';}else{$http = 'http://';}
		$this->redirect($http.$_SERVER['HTTP_HOST'].$this->webroot.$classAction); // リダイレクト
	}
	public function redirectHttpsAcl(){
		//さくらインターネットの場合httpsからhttpへリダイレクトされてしまうのでhttps判定追加
		//$_SERVER['HTTP_X_SAKURA_FORWARDED_FOR']中止で$_SERVER['HTTPS']に変更2019/08/07
		if(isset($_SERVER['HTTPS'])) {$http = 'https://';}else{$http = 'http://';}
		$this->Session->write('login_redirect',$http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$this->redirect($http.$_SERVER['HTTP_HOST'].$this->webroot."users/login"); // リダイレクト
	}
}
