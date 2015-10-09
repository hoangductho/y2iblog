<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this DefaultController */
?>
<form action="" method="post" name="Account" class="setup-form">
    <label>Create SuperUser</label>
    <hr>

    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>E-mail:</label>
        </div>
        <div class="setup-section-data">
            <input type="email" name="Account[email]" placeholder="E-mail"
                   <?php if(!empty($email)) echo 'value="'.$email.'"'?>>
        </div>
    </div>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Password:</label>
        </div>
        <div class="setup-section-data">
            <input type="password" name="Account[password]" placeholder="Password">
        </div>
    </div>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Confirm Password:</label>
        </div>
        <div class="setup-section-data">
            <input type="password" name="Account[cfpassword]" placeholder="Confirm Password">
        </div>
    </div>
    <?php if(!empty($errmsg)){?>
    <div class="setup-form-section">
        <div class="setup-section-label">
            <label>Create User Error:</label>
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