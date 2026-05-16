<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css('menu', null, array('inline' => false));
App::import('Vendor', 'configTopPage');
$osusumeAddress = osusumeAddress();
?>
<p id="page_title">不動産検索システム ebs3 index</p>
<p><span style="font-size: 10px">ログインユーザー：</span><?php echo $authUserName; ?>　　　
<a href="./users/logout" style="font-size: 10px;color: #000;">ログアウト</a></p>
<table width="600" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="center" class="koumoku">管理ページ</td>
  	</tr>
  <tr>
    <td align="center">
    <a href="./AdminRent/search" target="_blank"><font color="#FF0000">賃貸</font></a>　　　
    <a href="./AdminHouse/search" target="_blank"><font color="#0000FF">売買</font></a>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="600" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="center" class="koumoku">お客様ページ</td>
  	</tr>
  <tr>
    <td align="center">
    <a href="./Rent/search" target="_blank"><font color="#FF0000">賃貸</font></a>　
    <a href="./Rent/map?ti=1" target="_blank"><font color="#FF0000">賃貸Map</font></a>　　　
    <a href="./House/search" target="_blank"><font color="#0000FF">売買</font></a>　
    <a href="./House/map?ti=1" target="_blank"><font color="#0000FF">売買Map</font></a>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="400" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
    <a href="./Menu/pickup" target="_blank">お勧め</a>　　　
    <a href="../<?php echo $osusumeAddress; ?>" target="_blank">サンプルTOPページ</a>　　　
    <a href="./Menu/config" target="_blank">設定</a>
    </td>
  </tr>
</table>
<div class="copyright">
<hr width="600" size="1">
不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a></div>
