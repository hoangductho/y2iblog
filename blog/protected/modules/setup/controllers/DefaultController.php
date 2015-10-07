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
            'username' => 'varchar(32) NOT NULL UNIQUE',
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
            'created' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'CONSTRAINT rid' => 'PRIMARY KEY (_id)'
        );

        //table user_role
        $tables['user_role'] = array(
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
                }
                
                $this->redirect('setup/default/table');
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
    public function actionTable() {
        $tables = $this->_listTable();
        $exist = true;
        $model = new Setup;
        foreach ($tables as $key => $value) {
            if ($exist) {
                $exist = $model->exist($key);
            }
        }

        if ($exist) {
            $this->redirect('account');
        } else {
            if (isset($_POST['createTable']) && $_POST['createTable']) {
                $create = $model->create($this->_listTable());
                $this->redirect('account');
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
    public function actionAccount() {
        $config = Yii::app()->getComponents(false);
        var_dump($config['db']);
    }

}
