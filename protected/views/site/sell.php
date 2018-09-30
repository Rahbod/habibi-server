<?php if($slideShow):?>
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/assets/slider/css/layerslider.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/assets/slider/css/style-layerslider.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/assets/slider/layerslider_skins/fullwidth/skin.css');
    // scripts
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/slider/js/greensock.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/slider/js/jquery.layerslider.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/slider/js/layerslider.transitions.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/slider/js/jquery-animate-background-position.js',CClientScript::POS_END);
    ?>
    <div class="slider" id="slider">
        <?php foreach ($slideShow as $item):
            $this->renderPartial('//site/_slide_show_item_view',array('data' => $item));
        endforeach;
        $skinPath = Yii::app()->theme->baseUrl.'/assets/slider/layerslider_skins/';
        Yii::app()->clientScript->registerScript('slider-js','
            $("#slider").layerSlider({
                startInViewport: false,
                responsive : false ,
                responsiveUnder : 768 ,
                forceLoopNum: false,
                autoPlayVideos: false,
                skinsPath: \''.$skinPath.'\',
                skin: \'fullwidth\',
                navPrevNext: false,
                navStartStop: false,
                pauseOnHover: false,
                thumbnailNavigation: \'hover\'
            });
        ');
        ?>
    </div>
<?php endif;?>