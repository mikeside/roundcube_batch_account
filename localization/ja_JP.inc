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
$labels['batchaddaccount'] = '一括作成アカウント';
$labels['account'] = 'アカウント';
$labels['accountnotice'] = "1行1アカウント<br/>アカウントには完全なメールアドレス例を含める必要があります：`postmaster@ifun.com`";
$labels['passwdnotice'] = 'パスワードを入力しない場合、デフォルトでは初期パスワードが使用されます：`$passwdInitial`';
$labels['create'] = '作成';

// set $messages translate
$messages['noaccount'] = 'アカウントを入力してください';
$messages['passwordshort'] = 'パスワードは少なくとも $length 文字の長さが必要です。';
$messages['nolegalaccount'] = 'アカウントが不正または存在します';
$messages['creating'] = '作成中...';
$messages['createsuccess'] = 'アカウントの作成に成功しました：$number 個';
$messages['createerror'] = '作成に失敗しました';