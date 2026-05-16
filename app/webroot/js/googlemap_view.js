//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function googlemap(){

	var latlng = new google.maps.LatLng(lat, lng);

	if(marker_flag == 1){
		var mk = new google.maps.LatLng(marker_lat, marker_lng);
	}

	var myOptions = {
	    zoom: zoomp,
	    center: latlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	if(marker_flag == 1){
		//アイコンの設定
		var icon = new google.maps.MarkerImage(
			'../img/mapicon.png',
			new google.maps.Size(32,37),
			new google.maps.Point(0,0)
		);

		//マーカー設定
		var marker = new google.maps.Marker({
			icon: icon,
		    position: mk, /* マーカーを立てる場所の緯度・経度 */
			//visible: false,
		    map: map /*マーカーを配置する地図オブジェクト */
		});
	}

}

