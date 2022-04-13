<?php

/**
 * batch create account
 * @author:Mike
 * @date: 2022/3/3 15:38
 */
class batch_account extends rcube_plugin
{
    public $task    = 'settings';
    protected $rcmail;
    private $db;

    function init()
    {
        $this->rcmail = rcmail::get_instance();

        // Load plugin's config file
        $this->load_config();

        if ($this->isAllowAuth()){

            $this->add_texts('localization/', true);

            $this->add_hook('settings_actions', array($this, 'settingAction'));
            $this->register_action('plugin.batch_account', array($this, 'batchAccount'));
            $this->register_action('plugin.batch_account_create', array($this, 'batchAccountCreate'));
        }
    }

    /**
     * @notes: is allowed auth
     * @author:Mike
     * @date: 2022/3/3 23:44
     * @return bool
     */
    function isAllowAuth(): bool
    {
        if (empty($authAccount = $this->rcmail->config->get('auth_account'))){
            return false;
        }

        return substr_count($_SESSION['username'], $authAccount) > 0;
    }

    function settingAction($args): array
    {
        // register as settings action
        $args['actions'][] = array(
            'action' => 'plugin.batch_account',
            'class'  => 'identities',
            'label'  => 'batchaddaccount',
            'title'  => 'batchaddaccount',
            'domain' => 'batch_account',
        );

        return $args;
    }

    function batchAccount()
    {
        $this->register_handler('plugin.body', array($this, 'batchAccountForm'));

        $this->rcmail->output->set_pagetitle($this->gettext('batchaddaccount'));

        $this->rcmail->output->send('plugin');
    }

    function batchAccountForm(): string
    {
        $table = new html_table(array('cols' => 2, 'class' => 'propform', 'id' => 'batch-account'));

        $accountInput = new html_textarea(array(
            'id' => 'account',
            'cols' => 60,
            'rows' => 12,
        ));
        $accountNotice = html::div(array('class' => 'boxwarning'), $this->gettext('accountnotice'));
        $table->add('title', html::label('account', rcube::Q($this->gettext('account'))));
        $table->add('null', $accountInput->show() . $accountNotice);

        $passwdInitial = $this->rcmail->config->get('password_initial', 'postmaster');
        $passwdInput = new html_passwordfield(array(
            'id'           => 'passwd',
            'size'         => 20,
            'autocomplete' => 'off',
            'placeholder' => $passwdInitial,
        ));
        $passwdNotice = html::div(array('class' => 'boxwarning'), $this->gettext(array(
            'name' => 'passwdnotice',
            'vars' => array('passwdInitial' => $passwdInitial)
        )));
        $table->add('title', html::label('password', rcube::Q($this->gettext('password'))));
        $table->add(null, $passwdInput->show() . $passwdNotice);

        $createButton = $this->rcmail->output->button(array(
            'command' => 'plugin.batch_account_create',
            'class'   => 'button mainaction submit',
            'label'   => 'create',
            'domain' => 'batch_account'
        ));
        $formButtons = html::p(array('class' => 'formbuttons footerleft'), $createButton);

        $this->include_script('batch_account.js');

        return html::div(array('class' => 'boxtitle'), $this->gettext('batchaddaccount'))
            . html::div(array('class' => 'box formcontainer scroller'),
                html::div(array('class' => 'boxcontent formcontent'), $table->show())
                . $formButtons);
    }

    function batchAccountCreate()
    {
        $accounts = trim(rcube_utils::get_input_value('account', rcube_utils::INPUT_POST));
        $passwd = trim(rcube_utils::get_input_value('passwd', rcube_utils::INPUT_POST));

        if (empty($accounts)){
            $this->rcmail->output->command('display_message', $this->gettext('noaccount'), 'error');
            return;
        }

        // password handle
        if (empty($passwd)){
            $passwd = $this->rcmail->config->get('password_initial', 'postmaster');
        } else{
            $passwdLength = $this->rcmail->config->get('password_minimum_length', 6);
            if (strlen($passwd) < $passwdLength){
                $this->rcmail->output->command('display_message', $this->gettext(array(
                    'name' => 'passwordshort',
                    'vars' => array('length' => $passwdLength)
                )), 'error');
                return;
            }
        }

        $accountInfo = $this->accountHandle($accounts);
        if (empty($accountInfo['legalAccount'])){
            $this->rcmail->output->command('display_message', $this->gettext('nolegalaccount'), 'error');
            return;
        }

        // account save
        $this->vmailDsn()->startTransaction();
        try {

            $affectedRows = $this->batchAccountSave($accountInfo['legalAccount'], $passwd);
            if (empty($affectedRows)){
                throw new Exception($this->gettext('createerror'));
            }

            $this->vmailDsn()->endTransaction();
            $this->rcmail->output->command('display_message', $this->gettext(array(
                'name' => 'createsuccess',
                'vars' => array('number' => $affectedRows)
            )), 'notice');

        }catch (\Exception $e){

            $this->vmailDsn()->rollbackTransaction();
            $this->rcmail->output->command('display_message', $e->getMessage(), 'error');
        }
    }

    /**
     * @notes: Batch Account Save
     * @param $accounts
     * @param $passwd
     * @return mixed
     * @throws Exception
     * @author:Mike
     * @date: 2022/3/9 13:58
     */
    function batchAccountSave($accounts, $passwd)
    {
        $created = date('Y-m-d H:i:s', time());
        $query = "INSERT INTO " . $this->vmailDsn()->table_name('mailbox', true) . "(`username`, `password`, `name`, `storagebasedirectory`, `storagenode`, `maildir`, `quota`, `domain`, `created`, `modified`) values";

        foreach ($accounts as $account) {
            list($username, $domain) = explode('@', $account);
            $query    .= " ('$account', '".password::hash_password($passwd, 'ssha512')."', '$username', '/var/vmail', 'vmail1', '". $domain ."/". $username ."/', '10240', '$domain', '$created', '$created'),";
        }
        $query = rtrim($query, ',');
        $query .= ';';

        $result = $this->vmailDsn()->query($query);
        if ($this->vmailDsn()->is_error($result)){
            throw new Exception($this->gettext('createerror').'！<br/>'.$this->vmailDsn()->is_error($result));
        }

        return $this->vmailDsn()->affected_rows();
    }

    /**
     * Initialize database handler
     */
    function vmailDsn()
    {
        if (!$this->db) {
            if ($dsn = $this->rcmail->config->get('vmail_db_dsn')) {
                // connect to the vmail database
                $this->db = rcube_db::factory($dsn);
                $this->db->set_debug((bool)$this->rcmail->config->get('sql_debug'));
                $this->db->db_connect('w'); // connect in write mode
            }else{
                // connect default dsn
                $this->db = $this->rcmail->get_dbh();
            }
        }

        return $this->db;
    }

    /**
     * @notes: Account Handle
     * @author:Mike
     * @date: 2022/3/7 16:05
     * @param $accounts
     * @return array
     */
    function accountHandle($accounts): array
    {
        $legalAccount = [];
        $illegalAccount = [];

        $accounts = explode(PHP_EOL, $accounts);
        foreach ($accounts as $key => $account) {

            // Filtering empty Accounts
            if (empty(trim($account))){
                unset($accounts[$key]);
                continue;
            }

            // Account Validity Check
            list($username, $domain) = explode('@', $account);
            $domains = $this->rcmail->config->get('domains');
            if (empty($username) || !in_array($domain, $domains)){
                $illegalAccount[] = $account;
                unset($accounts[$key]);
            }else{
                $legalAccount[] = $account;
            }
        }

        // Check whether it has been added
        $existAccount = $this->findUsernameByUsernames($legalAccount);
        $legalAccount = array_diff($legalAccount, $existAccount);

        // output illegal account
        $this->rcmail->output->command('plugin.batch_account', $illegalAccount);

        return compact('legalAccount', 'illegalAccount');
    }

    /**
     * @notes: Username By Usernames
     * @param $usernames
     * @return array
     * @author:Mike
     * @date: 2022/3/8 14:47
     */
    function findUsernameByUsernames($usernames): array
    {
        $usernames = "'" . join("','", $usernames) . "'";
        $query = $this->vmailDsn()->query("SELECT username FROM " . $this->vmailDsn()->table_name('mailbox', true)
            ." WHERE `username` IN ($usernames)");

        $existUsernames = [];
        while ($row = $this->vmailDsn()->fetch_array($query)) {
            $existUsernames[] = $row[0];
        }

        return $existUsernames;
    }
}