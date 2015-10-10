<?php

final class DefaultController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/setup';

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    // list tables will be create
    private $_tables = array();

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * Declare list table will be create
     * Table declared by sql create table query
     */
    private function _listTable() {
        // table account
        $tables['account'] = array(
            '_id' => 'int NOT NULL AUTO_INCREMENT',
            'email' => 'varchar(64) NOT NULL UNIQUE',
            'password' => 'char(64) NOT NULL',
            'status' => "ENUM('pending','actived','deactived','banned','blocked') DEFAULT 'pending'",
            'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'CONSTRAINT aid' => 'PRIMARY KEY (_id)'
        );

        // table role
        $tables['role'] = array(
            '_id' => 'int NOT NULL AUTO_INCREMENT',
            'rolename' => 'varchar(16) NOT NULL UNIQUE',
            'description' => 'TINYTEXT',
            'family' => 'TINYTEXT',
            'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'CONSTRAINT rid' => 'PRIMARY KEY (_id)'
        );

        //table user_role
        $tables['account_role'] = array(
            'aid' => 'int NOT NULL',
            'rid' => 'int NOT NULL',
            'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'CONSTRAINT arid' => 'PRIMARY KEY (aid, rid)',
            'CONSTRAINT fk_aid' => 'FOREIGN KEY (aid) REFERENCES account(_id)',
            'CONSTRAINT fk_rid' => 'FOREIGN KEY (rid) REFERENCES role(_id)'
        );

        return $tables;
    }

    /**
     * List role origin
     */
    private function _originRole() {
        $role['root'] = array(
            'rolename' => 'root',
            'description' => 'root of all roles',
            'family' => '0'
        );

        $role['admin'] = array(
            'rolename' => 'admin',
            'description' => 'role of administrantors',
            'family' => '0.1'
        );

        $role['member'] = array(
            'rolename' => 'member',
            'description' => 'All of members\'s roles',
            'family' => '0.1.2'
        );

        return $role;
    }

    /**
     * Default function of setup website controller.
     * This function will be show list options for admin
     * 
     * No-param input
     */
    public function actionIndex() {
        $config = Yii::app()->getComponents(false);
        $dbconnect = $config['db'];
        $connectError = false;

        if (!empty($_POST['connectionString']) && !empty($_POST['username'])) {
            foreach ($dbconnect as $key => $value) {
                $dbconnect[$key] = isset($_POST[$key]) ? $_POST[$key] : $dbconnect[$key];
            }
        }
        if (!empty($dbconnect['connectionString']) && !empty($dbconnect['username']) && !$connectError) {
            try {
                
                $pdo = new PDO($dbconnect['connectionString'], $dbconnect['username'], $dbconnect['password']);
                
                $path = Yii::app()->basePath . '/config/database.php';
                $file = file_get_contents($path);
                $change = false;

                foreach ($dbconnect as $key => $value) {
                    if ($config['db'][$key] !== $value) {
                        $file = str_replace($config['db'][$key], $value, $file);
                        $change = true;
                    }
                }

                if ($change) {
                    file_put_contents($path, $file);
                    Yii::app()->setComponent('db', $dbconnect);
                }
                
                $this->redirect($this->createTable());
            } catch (Exception $ex) {
                $connectError = TRUE;
                $dbconnect['errmsg'] = $ex->getMessage();
            }
        }
        
        $this->render('index', $dbconnect);
    }

    /**
     * Create tables for system
     * 
     * If tables not existed, this will be create
     * Else redirect to create root account page
     */
    public function createTable() {
        $tables = $this->_listTable();
        $exist = true;
        $model = new Setup;
        foreach ($tables as $key => $value) {
            if ($exist) {
                $exist = $model->exist($key);
            }
        }

        if ($exist) {
            $this->redirect($this->createAccount());
        } else {
            if (isset($_POST['createTable']) && $_POST['createTable']) {
                $create = $model->create($this->_listTable());
                $this->redirect($this->createAccount());
            }

            $this->render('table', array('tables' => array_keys($this->_listTable())));
        }
    }

    /**
     * Create root account
     * 
     * If root account not existed, this feature will be call to create\
     * Else redirect to login feature
     */
    public function createAccount() {
        $data = array();
        $root = Account::model()->findByPk(1);
        if (empty($root)) {
            $root = Account::model()->findByPk(1);
            if (isset($_POST['Account'])) {
                $_POST['Account']['password'] = md5($_POST['Account']['password']);
                $_POST['Account']['cfpassword'] = md5($_POST['Account']['cfpassword']);
                $_POST['Account']['status'] = 'actived';
                $account = new Account('account');
                $account->attributes = $_POST['Account'];
                if ($account->validate()) {
                    try {
                        if ($account->save()) {
                            $this->redirect($this->createRoleOrigin());
                        }
                    } catch (Exception $ex) {
                        $data['errmsg'] = $ex->getMessage();
                    }
                } else {
                    $data['errmsg'] = 'Data input incorrect';
                }
                $data['email'] = $_POST['Account']['email'];
            }
        } else {
            $this->redirect($this->createRoleOrigin());
        }

        $this->render('account', $data);
    }

    /**
     * Create Role root - Original Role for System
     * 
     * Role name: root
     * Create automatic: Yes
     */
    public function createRoleOrigin() {
        $root = Role::model()->findByPk(1);
        if (empty($root)) {
            $listRole = $this->_originRole();
            $data = array();
            try {
                foreach ($listRole as $value) {
                    $role = new Role('setup');
                    $role->setAttributes($value);
                    $role->save();
                }
                $this->redirect($this->addRootOrigin());
            } catch (Exception $ex) {
                $data['roles'] = array_keys($listRole);
                $data['errmsg'] = $ex->getMessage();
            }

            $this->render('role', $data);
        } else {
            $this->redirect($this->addRootOrigin());
        }
    }

    /**
     * Add Role for super user
     * 
     * Add user have id = 1 to role's id = 1
     */
    public function addRootOrigin() {
        $rootOrigin = array('aid' => 1, 'rid' => 1);
        $origin = Origin::model()->findByPk($rootOrigin);
        if (empty($origin)) {
            $add = new Origin();
            $add->attributes = $rootOrigin;
            try {
                $add->save();
                $this->redirect('/admin');
            } catch (Exception $ex) {
                $data['errmsg'] = $ex->getMessage();
                $this->render('origin', $data);
            }
        } else {
            $this->redirect('/admin');
        }
    }

}
