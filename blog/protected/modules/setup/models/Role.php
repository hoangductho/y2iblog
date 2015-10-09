<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Role extends CActiveRecord {
    
    /**
     * name of role
     */
    public $rolename;
    
    /**
     * description of role
     */
    public $description;
    
    /**
     * family of role
     * 
     * Family type: 0.(role_id_level1).(role_id_level2).(...)
     * Family using: role father have all rule of current role
     */
    public $family;


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'role';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rolename, family', 'required'),
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