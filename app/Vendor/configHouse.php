<?php /* <meta content="charset=UTF-8"?> */
//----------------------------------------------------------


//--------------------------------------戸建
function syubetuArr(){//-----種別
	return array(
		'',
		'House',//　         1
		'Mansion',// 2
		'Land'//   3
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
		''    => '',
		'R'   => 'R',
		'K'   => 'K',
		'DK'  => 'DK',
		'LDK' => 'LDK'
	);
}
function totisyuArr(){//-----土地面積種別
	return array(
		'',
		'公簿',//  1
		'実測'//   2
	);
}
function kouzouArr(){//-----構造
	return array(
		'',
		'Wood',//                1
		'Block',//             2
		'Steel Frame',//              3
		'RC',//      4
		'SRC',//  5
		'Light Steel Frame',//          6
		'ＰＣ',//               7
		'Other'//              8
	);
}
function kokudoArr(){//-----国土法
	return array(
		'',
		'要',//  1
		'中',//  2
		'否'//  3
	);
}
function timokuArr(){//-----地目
	return array(
		'',
		'宅地',//  1
		'田',//  2
		'畑',//  3
		'山林',//  4
		'雑種',//  5
		'その他'//  6
	);
}
function tosikeiArr(){//-----都市計画
	return array(
		'',
		'市街化区域',//  1
		'市街化調整区域',//  2
		'未線引区域',//  3
		'都市計画区域外'//  4
	);
}
function youtotiArr(){//-----用途地域
	return array(
		'',
		'Residential',//  1
		'Residential-Commercial',//  2
		'Commercial',//  3
		'Industrial',//  4
		'Forest Mountain',//  5
		'Other'//  6
	);
}
function seigenArr(){//-----法規
	return array(
		1=>'防火',
		2=>'準防火',
		3=>'高度',
		4=>'高度利用',
		5=>'風致',
		6=>'文教',
		7=>'その他',
		8=>'',//予備
		9=>'',//予備
		10=>''//予備
	);
}
function tiseiArr(){//-----地勢
	return array(
		'',
		'平坦',//  1
		'高台',//  2
		'低地',//  3
		'ひな段',//  4
		'傾斜地',//  5
		'その他'//  6
	);
}
function hutaikenArr(){//-----付帯権利
	return array(
		'',
		'抵当権',//  1
		'根抵当権',//  2
		'温泉利用権'//  3
	);
}
function totikenArr(){//-----土地権利
	return array(
		'',
		'Freehold',//  1
		'Leasehold',//  2
		'（Old Law）Leasehold',//  3
		'Normal Leasehold（Surface Right）',//  4
		'Fixed Term Leasehold（Surface Right）',//  5
		'Normal Leasehold（Leasehold）',//  6
		'Fixed Term Leasehold（Leasehold）'//  7
	);
}
function genzyouArr(){//-----現状
	return array(
		'',
		'Owner is Using',//  1
		'Vacant',//  2
		'In Renting',//  3
		'Under Construction'//  4
	);
}
function urinusikeiArr(){//-----売主形態
	return array(
		'',
		'売主直',//  1
		'業者'//  2
	);
}
function torihikitaiArr(){//-----取引態様
	return array(
		'',
		'一般',//  1
		'専任',//  2
		'専属専任',//  3
		'代理',//  4
		'売主'//  5
	);
}
function eki_koArr(){//-----交通種別
	return array(
		'',
		'徒歩',//  1
		'バス'//  2
	);
}
function setubiArr(){//-----設備
	return array(
		1=>'Auto Bath',
		2=>'Renovated',
		3=>'Auto Lock',
		4=>'Delivery Box',
		5=>'Pet OK',
		6=>'Elevator',
		7=>'Roof Balcony',
		8=>'Floor Heating System',
		9=>'Balcony',
		10=>'Trunk Room',
		11=>'All Electricity',
		12=>'Yard',
		13=>'Separated Bath/Toilet',
		14=>'System Kitchen',
		15=>'Bathroom Dryer',
		16=>'Washlet',
		17=>'Monitor Intercom',
		18=>'Guest Room',
		19=>'Dish Washer',
		20=>'Gym',//予備
		21=>'Counter Kitchen',//予備
		22=>'Car Park'//予備
	);
}
//--------------------------------------戸建検索項目
function tiikiArr(){
	return array(
		0 => '',
		1 => 'Saitama',
		2 => 'Chiba',
		3 => 'Tokyo',
		4 => 'Kanagawa'
	);
}
function kakakuStartArr(){
    return array(
        ''    => '',
        4000000   => number_format(4000000),
        6000000   => number_format(6000000),
        8000000   => number_format(8000000),
        10000000  => number_format(10000000),
        12000000  => number_format(12000000),
        14000000  => number_format(14000000),
        16000000  => number_format(16000000),
        18000000  => number_format(18000000),
        20000000  => number_format(20000000),
        25000000  => number_format(25000000),
        30000000  => number_format(30000000),
        40000000  => number_format(40000000),
        50000000  => number_format(50000000),
        60000000  => number_format(60000000),
        70000000  => number_format(70000000),
        80000000  => number_format(80000000),
        90000000  => number_format(90000000),
        100000000  => number_format(100000000),
        120000000  => number_format(120000000),
        140000000  => number_format(140000000),
        160000000  => number_format(160000000),
        180000000  => number_format(180000000),
        200000000  => number_format(200000000)
    );
}

function kakakuEndArr(){
    return array(
        ''    => '',
        4000000   => number_format(4000000),
        6000000   => number_format(6000000),
        8000000   => number_format(8000000),
        10000000  => number_format(10000000),
        12000000  => number_format(12000000),
        14000000  => number_format(14000000),
        16000000  => number_format(16000000),
        18000000  => number_format(18000000),
        20000000  => number_format(20000000),
        25000000  => number_format(25000000),
        30000000  => number_format(30000000),
        40000000  => number_format(40000000),
        50000000  => number_format(50000000),
        60000000  => number_format(60000000),
        70000000  => number_format(70000000),
        80000000  => number_format(80000000),
        90000000  => number_format(90000000),
        100000000  => number_format(100000000),
        120000000  => number_format(120000000),
        140000000  => number_format(140000000),
        160000000  => number_format(160000000),
        180000000  => number_format(180000000),
        200000000  => number_format(200000000)
    );
}

define("DATE_NEW", 14); //「New!」何日前まで表示
define("PAGE_NUM", 10); //１ページ表示件数（管理ページ）
define("PAGE_NUMK", 10); //１ページ表示件数（公開ページ）
//--------------------------------------戸建詳細表示項目
define("VIEW_SETUBIMOZISUU", 110); //お客様　設備1行の文字数（バイト計算）
define("DAITYOU_SETUBIMOZISUU", 80); //台帳　設備1行の文字数（バイト計算）
define("KANBAN_SETUBIMOZISUU", 90); //看板　設備1行の文字数（バイト計算）
