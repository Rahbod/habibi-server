<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->siteName . (!empty($this->pageTitle)?' - ' . $this->pageTitle:'') ?></title>
	<?php
	$baseUrl = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();
	Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/fontiran.css">
	<?php
    $cs->registerCssFile($baseUrl . '/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl . '/css/font-awesome.css');
    $cs->registerCssFile($baseUrl . '/css/AdminLTE.css');
    $cs->registerCssFile($baseUrl . '/css/skins/skin-blue.min.css');
    $cs->registerCssFile($baseUrl . '/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl . '/css/bootstrap-select.min.css');
    $cs->registerCssFile($baseUrl . '/css/rtl.css');

    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerScriptFile($baseUrl . '/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl . '/js/bootstrap-select.min.js');
    $cs->registerScriptFile($baseUrl . '/js/app.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl . '/js/script.js');
	?>
</head>

<body>
<section class="container">
	<?php echo $content; ?>
</section>
</body>
</html>