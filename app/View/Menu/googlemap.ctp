<?php
//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

$this->Html->css(array('admin_o','googlemap'), null, array('inline' => false));
if($_GET['map'] == 1){$button_value = '登録';}else{$button_value = '登録';}
App::import('Vendor', 'configGoogleMapsApiKey');
?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEMAPAPIKEY; ?>"></script>
<script type="text/javascript" src="../js/googlemap.js"></script>
<script type="text/javascript">
//<![CDATA[
var map;
var marker;
var marker_lat;
var marker_lng;
var add = "<?php echo $_GET['q']; ?>";
var mapno = "<?php echo $_GET['map']; ?>";
window.onload = googlemap();
//]]>
</script>
<h1>不動産検索システム ebs3 【管理】 googlemap</h1>
<noscript>
	<p><font color="#0000ff">javascriptを有効にしてください（正常に動作しません）</font></p>
</noscript>

<div id="map_canvas<?php echo $_GET['map']; ?>"></div>
<br />

<form id="googlemap" name="googlemap"  method="post">
<table align="center"><tr><td align="right">
</td></tr><tr><td align="right">
	マーカーの表示：
</td><td align="left">
	<label for="marker_on1">
	<input type="radio" name="marker_on" id="marker_on1" value="1" onclick="review(1)" checked />
	表示　
	</label>
	<label for="marker_on2">
	<input type="radio" name="marker_on" id="marker_on2" value="0" onclick="review(0)"  />
	非表示
	</label>
</td></tr><tr><td align="right">
	マーカーの緯度：
</td><td align="left">
	<input type="text" size="20" class="map" name="marker_lat" id="marker_lat" value="" readonly="readonly" />
	マーカーの経度：
	<input type="text" size="20" class="map" name="marker_lng" id="marker_lng" value="" readonly="readonly" />
</td></tr><tr><td align="right">
	地図の緯度：
</td><td align="left">
	<input type="text" size="20" class="map" name="map_lat" id="map_lat" value="" readonly="readonly" />
	地図の経度：
	<input type="text" size="20" class="map" name="map_lng" id="map_lng" value="" readonly="readonly" />
</td></tr><tr><td align="right">
	Zoom：
</td><td align="left">
	<input type="text" size="20" class="map" name="map_zoom" id="map_zoom" value="" readonly="readonly" />
</td></tr><tr><td colspan="2" align="center">
	<input type="button" name="googlemap_button" value="<?php echo $button_value; ?>" onClick="map_set(<?php echo $_GET['map']; ?>,'<?php echo $_GET['q']; ?>');window.close()" />
</td></tr><tr><td>

</td><td align="left">
<pre>
地図設定方法：
マーカー位置確認
マーカー表示・非表示チェックで変更出来ます。
地図緯度経度　地図をマウスでドラックして位置変更出来ます。
マーカーの位置をドラック＆ドロップで位置を修正出来ます。
Zoom　地図左上の「+-」でZoom変更出来ます。
</pre>
</td></tr></table>
</form>

<hr width="750" size="1">
<div class="copyright">不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a></div>
</body>
</html>
