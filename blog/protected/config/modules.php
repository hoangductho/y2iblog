<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
$handle = opendir($modules_dir);
$config = array();

while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && is_dir($modules_dir . $file)) {
        $confdir = $modules_dir. $file. DIRECTORY_SEPARATOR . 'config'. DIRECTORY_SEPARATOR;
        $confopen = opendir($confdir);
        while (FALSE !== ($conf = readdir($confopen))) {
            if(is_file($confdir.$conf)) {
                $config = CMap::mergeArray($config, require($confdir . $conf));
            }
        }
        closedir($confopen);
    }
}
closedir($handle);

return $config;