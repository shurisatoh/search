/*jQuery LightBox Plugin---------------------------------------------------------*/
$(document).ready(function() {
	$('a[rel*=lightbox]').lightBox({
//		overlayBgColor:'#FFF',//オーバーレイの背景色
		overlayOpacity:0.6,//オーバーレイの透明度
		imageLoading:'../js/jquery-lightbox-0.5/lightbox-ico-loading.gif',//画像読み込み中に表示される画像
		imageBtnClose:'../js/jquery-lightbox-0.5/lightbox-btn-close.gif',//右下の「CLOSE」ボタンの画像
		imageBtnPrev:'../js/jquery-lightbox-0.5/lightbox-btn-prev.gif',//「PREV」ボタンの画像
		imageBtnNext:'../js/jquery-lightbox-0.5/lightbox-btn-next.gif',//「NEXT」ボタンの画像
		containerResizeSpeed:350//リサイズ時のスピード。指定はミリ秒で設定
	});
});

