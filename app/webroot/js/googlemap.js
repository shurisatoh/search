//----------------------------------------------------------
// 不動産検索システム ebs3
// 著作権は、放棄してませんのでスクリプトの再配布を禁止します。
// 制作 ITS kazuyuki nakatsu
// HomePage:https://infotese.com
// Copyright (c) ITS All Rights Reserved.
//----------------------------------------------------------

function googlemap(){
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( {'address' : add}, function(results, status) {
		map = new google.maps.Map(document.getElementById("map_canvas"+mapno));
		map.setCenter(results[0].geometry.location);

		var center = map.getCenter();

		//住所位置取得
		marker_lat =  center.lat();
		marker_lng =  center.lng();
		document.getElementById("marker_lat").value = marker_lat;
		document.getElementById("marker_lng").value = marker_lng;

		//初期の地図位置取得
		document.getElementById("map_lat").value = marker_lat;
		document.getElementById("map_lng").value = marker_lng;

		//アイコンの設定
		var icon = new google.maps.MarkerImage(
			'../img/mapicon.png',
			new google.maps.Size(32,37),
			new google.maps.Point(0,0)
		);

		//ズームレベル設定
		map.setZoom(16);

		map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

		marker = new google.maps.Marker( {
			position : results[0].geometry.location,
			icon: icon,
			//visible: false,
			draggable: true, //マーカードラック設定
			map : map
		});

		// マーカーのドロップ（ドラッグ終了）時のイベント
		google.maps.event.addListener( marker, 'dragend', function(ev){
			document.getElementById("marker_lat").value = ev.latLng.lat();
			document.getElementById("marker_lng").value = ev.latLng.lng();
		});

		//初期のズームレベル取得
    	document.getElementById("map_zoom").value = map.getZoom();

		//ズームレベル変更時ズームレベル取得
    	google.maps.event.addListener(map, 'zoom_changed', function() {
    		document.getElementById("map_zoom").value = map.getZoom();
    	});

		//地図のセンター変更時地図のセンター取得
    	google.maps.event.addListener(map, "center_changed", function() {
    		var mapcenter = map.getCenter();
    		document.getElementById("map_lng").value = mapcenter.lng();
    		document.getElementById("map_lat").value = mapcenter.lat();
    	});

	});
}

function review(marker_flag){
	if(marker_flag == 0){
		marker.setMap(null);
		document.getElementById("marker_lat").value = '';
		document.getElementById("marker_lng").value = '';
		document.getElementById("hukidasi").value = '';
	}else{
		marker.setMap(map);
		document.getElementById("marker_lat").value = marker_lat;
		document.getElementById("marker_lng").value = marker_lng;
		document.getElementById("hukidasi").value = add;
	}
}

function map_set(textarea,map_q){
	if(map_q == ''){
		var value8 = '';
	}else{
		if(document.googlemap.marker_on[0].checked == true){
			var value1 = '';
			var value2 = document.googlemap.marker_on[0].value;
			var value3 = document.googlemap.marker_lat.value;
			var value4 = document.googlemap.marker_lng.value;
		}else{
			var value1 = '';
			var value2 = document.googlemap.marker_on[1].value;
			var value3 = 0;
			var value4 = 0;
		}
		var value5 = document.googlemap.map_lat.value;
		var value6 = document.googlemap.map_lng.value;
		var value7 = document.googlemap.map_zoom.value;
		//吹き出し/マーカー有無/マーカー緯度/マーカー経度/地図緯度/地図経度/Zoom
		var value8 = value1+'/'+value2+'/'+value3+'/'+value4+'/'+value5+'/'+value6+'/'+value7;
	}
	if(textarea == 1){
		opener.window.document.getElementById("googlemap1").value = value8;
	}else{
		opener.window.document.getElementById("googlemap2").value = value8;
	}
}

