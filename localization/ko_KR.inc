<?php

/*
 +-----------------------------------------------------------------------+
 | Localization file of the Roundcube Webmail Batch Account plugin            |
 |                                                                       |
 | Copyright (C) The Roundcube Dev Team                                  |
 |                                                                       |
 | Licensed under the GNU General Public License version 3 or            |
 | any later version with exceptions for skins & plugins.                |
 | See the README file for a full license statement.                     |
 +-----------------------------------------------------------------------+

 For translation see https://www.transifex.com/projects/p/roundcube-webmail/resource/plugin-password/
*/

// set $labels translate
$labels['batchaddaccount'] = '대량 계정 만들기';
$labels['account'] = '계정';
$labels['accountnotice'] = "한 줄에 한 계좌 번호<br/>계정은 전체 메일주소의 예를 포함해야 합니다：`postmaster@ifun.com`";
$labels['passwdnotice'] = '암호를 입력하지 않으면 초기 암호가 기본적으로 사용됩니다：`$passwdInitial`';
$labels['create'] = '창설';

// set $messages translate
$messages['noaccount'] = '아이디 입력';
$messages['passwordshort'] = '암호는 문자가 $length개 이상이어야 합니다.';
$messages['nolegalaccount'] = '계정이 비합법적이거나 이미 존재합니다';
$messages['creating'] = '생성 중...';
$messages['createsuccess'] = '창설 성공, 총 창설 계정：$number 개';
$messages['createerror'] = '생성 실패';