<?php /* <meta content="charset=UTF-8"?> */

//--------------------------------------賃貸
function syubetuArr(){//-----種別
	return array(
		'',
		'Apartment',//   1
		'House',//     2
		'Shop',//     3
		'Office',//   4
		'Others'//    5
	);
}
function madori1Arr(){//-----間取り１
	return array(
		'',
		'1',//  1
		'2',//  2
		'3',//  3
		'4',//  4
		'5'//   5
	);
}
function madori2Arr(){//-----間取り２
	return array(
		'',
		'R',//  1
		'K',//  2
		'DK',// 3
		'LDK'// 4
	);
}
function hosyou_kuArr(){//-----保証区分
	return array(
		'',
		'Deposit',//    1
		'Deposit',//  2
		'その他'//   3
	);
}
function kaiyaku_kuArr(){//-----解約引区分
	return array(
		'',
		'Key Money',//    1
		'Key Money',//  2
		'その他'//   3
	);
}
function kouzouArr(){//-----構造
	return array(
		'',
		'Steel frame',//  1
		'RC',//              2
		'SRC',//          3
		'Wood',//  4
		'Others',//                5
		'その他'//             6
	);
}
function eki_koArr(){//-----交通種別
	return array(
		'',
		'Walk',//  1
		'Bus'//   2
	);
}
function setubiArr(){//-----設備
	return array(
		1=>'Washing Machine Place',
		2=>'EV',
		3=>'Separated Bath/Toilet',
		4=>'AC',
		5=>'Flooring',
		6=>'Washlet',
		7=>'Bathroom Dryer',
		8=>'Shampoo Dresser',
		9=>'TV Intercom',
		10=>'Pet OK',
		11=>'Internet',
		12=>'Facing South',
		13=>'Upper than 2nd floor',
		14=>'Walk in Closet',
		15=>'All electric',
		16=>'Floor Heating',
		17=>'Delivery Box',
		18=>'Furnished',
		19=>'Car Park',
		20=>'System Kitchen'
	);
}
function gasuArr(){//-----ガス
	return array(
		'',
		'都市ガス',//      1
		'プロパンガス',//    2
		'その他'//         3
	);
}
function denkiArr(){//-----電気
	return array(
		'',
		'関西電力',// 1
		'その他'//     2
	);
}
function suidouArr(){//-----水道
	return array(
		'',
		'公営水道',// 1
		'簡易水道',// 2
		'その他'//     3
	);
}
function barukoniiArr(){//-----バルコニー（他、有無）
	return array(
		'',
		'With Balcony',// 1
		'No Balcony'//  2
	);
}
function mukiArr(){//-----向き
	return array(
		'',
		'North',//   1
		'North East',// 2
		'East',// 3
		'South East',//   4
		'South',//   5
		'South West',//   6
		'West',// 7
		'North West'//  8
	);
}
function kasai_nenArr(){//-----保険年数
	return array(
		'',
		1=>1,
		2=>2
	);
}
function keiyaku_kiArr(){//-----契約期間
	return array(
		'',
		1=>1,
		2=>2
	);
}
function kousin_syuArr(){//-----更新種別
	return array(
		'',
		'自動更新',//   1
		'更新料要',// 2
		'手数料要',// 3
		'更新無し'//  4
	);
}
//--------------------------------------賃貸検索項目
function tiikiArr(){
	return array(
		0 => '',
		1 => 'Saitama',
		2 => 'Chiba',
		3 => 'Tokyo',
		4 => 'Kanagawa',
		5 => 'Osaka',
		6 => 'Kyoto',
		7 => 'Aichi'
	);
}

function tinryouStartArr(){//-----賃料～（カンマなしで記入）
	return array(
		'',
		50000   => number_format(50000),
		60000   => number_format(60000),
		70000   => number_format(70000),
		80000   => number_format(80000),
		90000   => number_format(90000),
		100000   => number_format(100000),
		110000   => number_format(110000),
		120000   => number_format(120000),
		130000   => number_format(130000),
		140000   => number_format(140000),
		150000   => number_format(150000),
		160000   => number_format(160000),
		170000   => number_format(170000),
		180000   => number_format(180000),
		190000   => number_format(190000),
		200000   => number_format(200000),
		300000   => number_format(300000),
		400000   => number_format(400000),
		500000   => number_format(500000),
		600000   => number_format(600000),
		700000   => number_format(700000),
		800000   => number_format(800000),
		900000   => number_format(900000),
		1000000   => number_format(1000000),
		1200000   => number_format(1200000),
		1400000   => number_format(1400000),
		1600000   => number_format(1600000),
		1800000   => number_format(1800000),
		2000000   => number_format(2000000)

	);
}
function tinryouEndArr(){//-----～賃料（カンマなしで記入）
	return array(
		'',
		50000   => number_format(50000),
		60000   => number_format(60000),
		70000   => number_format(70000),
		80000   => number_format(80000),
		90000   => number_format(90000),
		100000   => number_format(100000),
		110000   => number_format(110000),
		120000   => number_format(120000),
		130000   => number_format(130000),
		140000   => number_format(140000),
		150000   => number_format(150000),
		160000   => number_format(160000),
		170000   => number_format(170000),
		180000   => number_format(180000),
		190000   => number_format(190000),
		200000   => number_format(200000),
		300000   => number_format(300000),
		400000   => number_format(400000),
		500000   => number_format(500000),
		600000   => number_format(600000),
		700000   => number_format(700000),
		800000   => number_format(800000),
		900000   => number_format(900000),
		1000000   => number_format(1000000),
		1200000   => number_format(1200000),
		1400000   => number_format(1400000),
		1600000   => number_format(1600000),
		1800000   => number_format(1800000),
		2000000   => number_format(2000000)
	);
}
define("DATE_NEW", 14); //「New!」何日前まで表示
define("PAGE_NUM", 10); //１ページ表示件数（管理ページ）
define("PAGE_NUMK", 10); //１ページ表示件数（公開ページ）
//--------------------------------------賃貸詳細表示項目
define("VIEW_SETUBIMOZISUU", 110); //お客様　設備1行の文字数（バイト計算）
define("DAITYOU_SETUBIMOZISUU", 100); //台帳　設備1行の文字数（バイト計算）
define("KANBAN_SETUBIMOZISUU", 90); //看板　設備1行の文字数（バイト計算）
