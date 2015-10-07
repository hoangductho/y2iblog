<?php
/* @var $this Controller */
$modcss = '/css/setupmod.css';
$setupCssPath = dirname(Yii::app()->basePath) . $modcss;
if (file_exists($setupCssPath)) {
    try {
        unlink($setupCssPath);
    } catch (Exception $ex) {
        
    }
}
copy($this->module->basePath . $modcss, $setupCssPath);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/setupmod.css">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div id="setup-page">
            <div id="logo" style="font-family: 'Times New Roman'; font-size: 2.5em; font-weight: bold">
                <span style="font-style: italic; color: #4F5B93">PHP</span><span style="color: #B52E31">Angular</span>
            </div>
            <div id="setup-header">
                Setup Blog Application
            </div><!-- header -->

            <div id='setup-content'>
                <?php echo $content; ?>
            </div>

            <div class="clear"></div>

            <div id="setup-footer">
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
<?php echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
