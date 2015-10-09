<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this DefaultController */
?>
<form action="" method="post" class="setup-form">
    <label>Add Superuser To Origin Role</label>
    <hr>
    <?php if (!empty($errmsg)) { ?>
        <div class="setup-form-section">
            <div class="setup-section-label">
                <label>Create User Error:</label>
            </div>
            <div class="setup-section-data">
                <p class='errmsg'><?php echo $errmsg; ?></p>
            </div>
        </div>
    <?php } ?>
    <div class="setup-form-section">
        <div class="setup-section-data">
            <button type="submit" class="right">
                <?php
                if(!empty($errmsg)){
                    echo 'Try Again';
                }else {
                    echo 'Next';
                }
                ?>
            </button>
        </div>
    </div>

</form>
