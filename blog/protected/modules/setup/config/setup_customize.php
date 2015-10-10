<?php

$module_name = basename(dirname(dirname(__FILE__)));
$default_controller = 'default';

return array(
    'import' => array(
        'application.modules.' . $module_name . '.models.*',
    ),
    'modules' => array(
        $module_name => array(
            'defaultController' => $default_controller,
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    'components' => array(
        'urlManager' => array(
            'rules' => array(
                $module_name . '/<action:\w+>/<id:\d+>' => $module_name . '/' . $default_controller . '/<action>',
                $module_name . '/<action:\w+>' => $module_name . '/' . $default_controller . '/<action>',
            ),
        ),
    ),
);
