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
$labels['batchaddaccount'] = 'Batch create account';
$labels['account'] = 'account number';
$labels['accountnotice'] = "One account per line<br/>The account number must contain the complete email address, for example：`postmaster@ifun.com`";
$labels['passwdnotice'] = 'If the password is not filled in, the initial password will be used by default：`$passwdInitial`';
$labels['create'] = 'Create';

// set $messages translate
$messages['noaccount'] = 'Please enter the account number';
$messages['passwordshort'] = 'Password must be at least $length characters long.';
$messages['nolegalaccount'] = 'Account number is illegal or already exists';
$messages['creating'] = 'Creating...';
$messages['createsuccess'] = 'Created successfully. Totally created accounts: $number';
$messages['createerror'] = 'Creation failed';