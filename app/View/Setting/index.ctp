<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('admin.add', null, array('inline' => false));
?>
<style type="text/css">
.hissuu {
	font-size: x-small;
	color: #F00;
}
</style>
<script type="text/javascript">
var inphe = new Array('host','login','password','database','mail');
function check_in(){
	var re_in = true;
	for (i = 0; i < inphe.length; i++) {
		if(document.getElementById(inphe[i]).value == ''){
			document.getElementById('msghe'+i).innerHTML = '必須項目です';
			document.getElementById(inphe[i]).focus();
			document.getElementById(inphe[i]).style.backgroundColor = '#ffeeee';
			document.getElementById('outerhe'+i).style.backgroundColor = '#ffeeee';
			re_in = false;
		}else{
			if(document.getElementById(inphe[i]).value.match(/[^A-Za-z0-9\.\-_@]+/)){
				document.getElementById('msghe'+i).innerHTML = '英数半角のみです';
				document.getElementById(inphe[i]).focus();
				document.getElementById(inphe[i]).style.backgroundColor = '#ffeeee';
				document.getElementById('outerhe'+i).style.backgroundColor = '#ffeeee';
				re_in = false;
			}else{
				document.getElementById('msghe'+i).innerHTML = '';
				document.getElementById(inphe[i]).style.backgroundColor = '';
				document.getElementById('outerhe'+i).style.backgroundColor = '';
			}
		}
	}
	if(re_in){document.form1.submit();}
}
</script>
<p id="page_title"><?php echo $title_for_layout; ?></p>
<?php echo $errmsg; ?>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'mail','name'=>'form1'))."\n"; ?>
<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2"><br />データベースの設定 [MySQL]<br /><br /></td>
  </tr>
  <tr>
    <td colspan="2">データベースの文字コードは、[utf8]に設定しておいてください</td>
  </tr>
  <tr>
    <td id="outerhe0">データベース サーバ　例[mysql456.db.sakura.ne.jp]　<span class="hissuu">（必須）</span></td>
    <td>
    <?php echo $this->Form->text('host',array('size'=>30)); ?>
    <br /><span class="errmsg" id="msghe0"></span>
    </td>
  </tr>
  <tr>
    <td id="outerhe1">データベース ユーザ名　例[dbuser]　<span class="hissuu">（必須）</span></td>
    <td>
    <?php echo $this->Form->text('login',array('size'=>30)); ?>
    <br /><span class="errmsg" id="msghe1"></span>
    </td>
  </tr>
  <tr>
    <td id="outerhe2">接続用パスワード　例[ps123]　<span class="hissuu">（必須）</span></td>
    <td>
    <?php echo $this->Form->text('password',array('size'=>30)); ?>
    <br /><span class="errmsg" id="msghe2"></span>
    </td>
  </tr>
  <tr>
    <td id="outerhe3">データベース名　例[its_db]　<span class="hissuu">（必須）</span></td>
    <td>
    <?php echo $this->Form->text('database',array('size'=>30)); ?>
    <br /><span class="errmsg" id="msghe3"></span>
    </td>
  </tr>
  <tr>
    <td colspan="2"><br />管理者・メンバーの[UserName・Password]発行<br /><br /></td>
  </tr>
  <tr>
    <td colspan="2">
    下記、「管理者メールアドレス」に 管理者・メンバーの[UserName・Password]をメールにて送信しますので、<br />
    管理者のメールアドレスを入力してください。
    </td>
  </tr>
  <tr>
    <td id="outerhe4">管理者メールアドレス　<span class="hissuu">（必須）</span></td>
    <td>
    <?php echo $this->Form->text('mail',array('size'=>30)); ?>
    <br /><span class="errmsg" id="msghe4"></span>
    </td>
  </tr>
</table>
<div align="center">
  <p><input type="button" id="busub" value="設定" onClick="check_in()"></p>
</div>
<?php echo $this->Form->end(); ?>
<p align="center">&nbsp;</p>
<hr width="750" size="1">
<div class="copyright">不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a></div>
