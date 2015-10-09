<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Account extends CActiveRecord {
    
    public $_id;
    public $email;
    public $password;
    public $cfpassword;
    public $status;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'account';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('password', 'length', 'min' => 8, 'max' => 64),
            array('cfpassword', 'required', 'on' => 'account'),
            array('password', 'compare', 'compareAttribute' => 'cfpassword'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
//            array('id, username, password, fullname', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
