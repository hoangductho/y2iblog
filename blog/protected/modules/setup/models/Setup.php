<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Setup extends CDbCommand
{
    private $_db;
    
    public function __construct() {
        $this->_db = Yii::app()->db;
    }

    /**
     * Build create table query
     * 
     * @param   string  name of table
     * @param   array   list fields of table and detail of them
     * 
     * @return  string
     */
    private function _build_create_query($name, array $fields) {
        $list = array();
        foreach ($fields as $key => $value) {
            $list[] = "$key $value";
        }
        
        $detail = implode(', ', $list);
        
        $query = "CREATE TABLE IF NOT EXISTS $name ($detail)";
        
        return $query;
    }
    
    /**
     * Create table query
     * 
     * @param   string  name of table
     * @param   array   list fields of table and detail of them
     * 
     * @return  bool
     */
    private function _create_table($name, array $fields) {
        $query = $this->_build_create_query($name, $fields);
        
        $command = $this->_db->createCommand($query);
        
        $create = $command->execute();
        
        if($create)            
            return TRUE;
        
        return FALSE;
    }
    
    /**
     * Create tables
     * 
     * @param   array   list talbes need create
     * 
     * @return  array   result create tables
     */
    public function create($tables) {
        $create = array();
        try{
            foreach($tables as $name => $fields) {
                $create[] = $this->_create_table($name, $fields);
            }
        } catch (Exception $ex) {
//            var_dump($ex);
            die($ex->errorInfo[2]);
        }
        
        return $create;
    }
    
    /**
     * Check table exist
     * 
     * @param   string  name of table
     * 
     * @return  bool
     */
    public function exist($name){
//        $exist = $this->_db->schema->getTable($name);
        try {
            $exist = $this->_db->schema->getTable($name);
            return !empty($exist);
        } catch (Exception $ex) {
            return FALSE;
        }
    }
}