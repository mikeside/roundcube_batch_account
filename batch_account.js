/**
 * Batch Account plugin script
 *
 * @licstart  The following is the entire license notice for the
 * JavaScript code in this file.
 *
 * Copyright (c) The Roundcube Dev Team
 *
 * The JavaScript code in this page is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * @licend  The above is the entire license notice
 * for the JavaScript code in this file.
 */

window.rcmail && rcmail.addEventListener('init', function(evt) {
    // register command handler
    rcmail.register_command('plugin.batch_account_create', function() {

        var account = rcube_find_object('account'),
            passwd = rcube_find_object('passwd');

        if ($.trim(account.value) == '') {
            rcmail.alert_dialog(rcmail.get_label('noaccount', 'batch_account'), function() {
                account.focus();
            });
            return false;
        }

        // send request to server
        var lock = rcmail.display_message(rcmail.get_label('creating', 'batch_account'), 'loading');
        rcmail.http_post('settings/plugin.batch_account_create', { account: account.value, passwd: passwd.value }, lock);
        window.setTimeout(function () {
            account.value = '';
            passwd.value = '';
        }, 1000);

    }, true);

    // Executes plugin.batch_account callback methods
    rcmail.addEventListener('plugin.batch_account', function (prop) {

        $("#account-danger-msg").remove();
        if (prop != ''){
            var illegalLable = rcmail.get_label('nolegalaccount', 'batch_account') + '：';
            $.each(prop,function(index,value){
                illegalLable += '<br/>' + value
            });

            $('#batch-account').append('<div class="boxwarning ui alert alert-danger" id="account-danger-msg"><i class="icon"></i><span>' + illegalLable +'</span></div>');
        }

    });
});
