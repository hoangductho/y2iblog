<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this DefaultController */
?>
<form action="" method="post" class="setup-form">
    <label>Create Origin Role</label>
    <hr>
    <div class="setup-form-section">
        <dl class="setup-list-table">
            <dt>List roles will be created</dt>
            <dd>
                <ul>
                    <?php
                    foreach ($roles as $rolename) {
                        echo "<li>$rolename</li>";
                    }
                    ?>
                </ul>
            </dd>
        </dl>
    </div>
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
