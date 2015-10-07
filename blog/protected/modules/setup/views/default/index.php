<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this DefaultController */
?>
<form action="" method="post" class="setup-form">
    <label>Database Connection</label>
    <hr>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Connection String:</label>
        </div>
        <div class="setup-section-data">
            <input type="text" name="connectionString" placeholder="Connection String"
                   <?php 
                   if(!empty($connectionString)) echo 'value="'.$connectionString.'"';
                   else echo 'value="mysql:host=localhost;dbname=test"';
                   ?>
            >
        </div>
    </div>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Username:</label>
        </div>
        <div class="setup-section-data">
            <input type="text" name="username" placeholder="Username"
                   <?php if(!empty($username)) echo 'value="'.$username.'"';?>>
        </div>
    </div>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Password:</label>
        </div>
        <div class="setup-section-data">
            <input type="text" name="password" placeholder="Password"
                   <?php if(!empty($password)) echo 'value="'.$password.'"';?>>
        </div>
    </div>
    <?php if(!empty($errmsg)){?>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Connect Database Error:</label>
        </div>
        <div class="setup-section-data">
            <p class='errmsg'><?php echo $errmsg;?></p>
        </div>
    </div>
    <?php }?>
    <div class="setup-form-section">
        <div class="setup-section-data">
            <button type="submit" class="right">Next</button>
        </div>
    </div>
    
</form>
