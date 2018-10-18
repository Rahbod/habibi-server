<?php
/** @var $this Controller */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->siteName . (!empty($this->pageTitle)?' - ' . $this->pageTitle:'') ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="<?= strip_tags($this->description) ?>">
    <meta name="author" content="Rahbod Developing Software Co">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>" />

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/fontiran.css">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
    $cs->registerScript('icheck','
//        $(\'input\').iCheck({
//          checkboxClass: \'icheckbox_square-blue\',
//          radioClass: \'iradio_square-blue\',
//          increaseArea: \'20%\' // optional
//        });
    ',CClientScript::POS_READY);
    ?>
</head>

<body class="skin-blue sidebar-mini" data-last-push="<?= Requests::getMaxID() ?>">
    <div class="wrapper">
        <?php $this->renderPartial('//partial-views/_header') ?>
        <?php $this->renderPartial('//partial-views/_sidebar') ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->pageHeader ?>
                    <small><?php echo $this->pageDescription ?></small>
                </h1>
                <?php if(isset($this->breadcrumbs)):?>
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                        'homeLink'=>false,
                        'htmlOptions'=>array('class'=>'breadcrumb')
                    )); ?><!-- breadcrumbs -->
                <?php endif?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php echo $content; ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

<!-- Require the footer -->
<?php $this->renderPartial('//partial-views/_footer') ?>


<div class="push-notification" id="push-notification"></div>
<audio style="display: none" id="sound1"><source src="<?= $baseUrl.'/css/beep.ogg' ?>"></audio>
<?php
Yii::app()->clientScript->registerScript('load-push','
    var lastPush = $("body").data("last-push");
    
    push();
    setInterval(function(){
        push();
    }, 15000);
    
    function push(){
        $.ajax({
            url:"'.$this->createUrl('/requests/manage/pending?pendingAjax=true&push=true&last=').'"+lastPush,
            type: "get",
            dataType: "json",
            success: function(data){
                if(data.push){
                    $(data.push).each(function(key, tr) {
                        $("#push-notification").append(tr);
                        var el = $("#push-notification .push-item:last-of-type");
                        setTimeout(function(){
                            el.fadeOut(function(){
                                el.remove();
                            });                            
                        },5000);
                    });
                    PlaySound("sound1");
                }
                lastPush = data.last;
            }
        });
    }
    
    function PlaySound(soundObj) {
      var sound = document.getElementById(soundObj);
      sound.play();
    }
', CClientScript::POS_END);
?>
</body>
</html>