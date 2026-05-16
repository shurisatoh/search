<?php
define("LINK_CHECK", 'realestateguide.jp');

function contact_setup($mailCoAr = array()) {
    // 必須キーを初期化
    $default = array(
        'bukken' => '',
        'fname'  => '',
        'fmail'  => '',
        'ftel'   => '',
        'fnaiyou'=> ''
    );
    $mailCoAr = array_merge($default, $mailCoAr);

    $mailArr = array();
    $mailArr['toppage'] = 'https://realestateguide.jp';
    $mailArr['address'] = 'sato.aonissin@gmail.com';
    $mailArr['mobile']  = '';
    $mailArr['subject'] = 'Inquiry about property in the homepage';

    // 会社へのメール
    $mailArr['message'] = <<<EOM
{$mailArr['subject']}

Content------------------------------------------------------------------------------
About Property：
{$mailCoAr['bukken']}

Name：{$mailCoAr['fname']}
EMAIL：{$mailCoAr['fmail']}
Tel：{$mailCoAr['ftel']}
CONTENT：{$mailCoAr['fnaiyou']}
----------------------------------------------------------------------------------------
EOM;

    // お客様への返信
    $mailArr['re_subject'] = 'Thanks for the inquiry to the property.';
    $mailArr['re_message'] = <<<EOM
{$mailArr['re_subject']}

Sent following inquiry.

Content------------------------------------------------------------------------------
Property about：
{$mailCoAr['bukken']}

Name：{$mailCoAr['fname']}
EMAIL：{$mailCoAr['fmail']}
Tel：{$mailCoAr['ftel']}

Content：{$mailCoAr['fnaiyou']}
----------------------------------------------------------------------------------------
EOM;

    return $mailArr;
}
