<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this DefaultController */
?>
<form action="" method="post" class="setup-form">
    <label>Create Table For <b><?php echo Yii::app()->name?></b></label>
    <dl class="setup-list-table">
        <dt>List tables will be created</dt>
        <dd>
            <ul>
                <?php
                foreach ($tables as $value) {
                    echo '<li>'.$value.'</li>';
                }
                ?>
            </ul>
        </dd>
    </dl>
    <input type="hidden" name="createTable" value="1">
    <button type="submit">Next</button>
</form>
