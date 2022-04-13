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
$labels['batchaddaccount'] = '批量创建账号';
$labels['account'] = '账号';
$labels['accountnotice'] = "一行一个账号<br/>账号需包含完整邮箱地址 例：`postmaster@ifun.com`";
$labels['passwdnotice'] = '不填写密码，则默认使用初始密码：`$passwdInitial`';
$labels['create'] = '创建';

// set $messages translate
$messages['noaccount'] = '请输入账号';
$messages['passwordshort'] = '密码至少为 $length 位。';
$messages['nolegalaccount'] = '账号不合法或已存在';
$messages['creating'] = '创建中...';
$messages['createsuccess'] = '创建成功, 共创建账号：$number 个';
$messages['createerror'] = '创建失败';