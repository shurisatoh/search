<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------
class User extends AppModel {

  public function beforeSave($options=array()) {
  	if(!empty($this->data['User']['password'])){
	    $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
  	}
    return true;
  }

}
