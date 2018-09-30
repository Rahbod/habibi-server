<?php
/**
 * @var $slideShow Slideshow[]
 * @var $topBrands Brands[]
 * @var $cs CClientScript
 * @var $baseUrl string
 */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
?>


<?php if($slideShow):?>
    <?php
    $cs->registerCssFile($baseUrl.'/assets/slider/css/layerslider.css');
    $cs->registerCssFile($baseUrl.'/assets/slider/css/style-layerslider.css');
    $cs->registerCssFile($baseUrl.'/assets/slider/layerslider_skins/fullwidth/skin.css');
    // scripts
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/greensock.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/jquery.layerslider.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/layerslider.transitions.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/jquery-animate-background-position.js',CClientScript::POS_END);
    ?>
    <div class="slideshow-container">
        <div class="slideshow" id="slider">
            <?php foreach ($slideShow as $item):
                $this->renderPartial('//site/_slide_show_item_view',array('data' => $item));
            endforeach;
            $skinPath = $baseUrl.'/assets/slider/layerslider_skins/';
            $cs->registerScript('slider-js','
                if($(window).width() > 768){
                    if($("#slider").find(".ls-bg.hidden-xs").length ==0)
                        $("#slider").addClass("hidden");
                    else{
                        var sh;
                        sh = $(window).width() * 600 / 1920 - 5;
                        $("#slider").css({height:sh});
                    }
                }else{
                    if($("#slider").find(".ls-bg.hidden-lg.hidden-md.hidden-sm").length ==0)
                        $("#slider").addClass("hidden");
                }
                $(window).resize(function(){
                    if($(window).width() > 768){
                        if($("#slider").find(".ls-bg.hidden-xs").length ==0)
                            $("#slider").addClass("hidden");
                        else{
                            var sh;
                            sh = $(window).width() * 600 / 1920 - 5;
                            $("#slider").css({height:sh}).removeClass("hidden");
                        }
                    }else{
                        if($("#slider").find(".ls-bg.hidden-lg.hidden-md.hidden-sm").length ==0)
                            $("#slider").addClass("hidden");
                        else
                            $("#slider").removeClass("hidden");
                    }
                });
                
                $("#slider").layerSlider({
                    startInViewport: false,
                    responsive : true,
                    responsiveUnder : 768,
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
        <div class="ls-items">
            <div class="ls-item">
                <i class="star-icon"></i>
                <h4><?= Controller::parseNumbers(Cars::ZeroKmCarCounts()); ?></h4>
                <span>صفر کیلومتر</span>
            </div>
            <div class="ls-item">
                <i class="edit-icon"></i>
                <h4><?= Controller::parseNumbers(Cars::ResearchCounts()); ?></h4>
                <span>بررسی خودرو</span>
            </div>
            <div class="ls-item">
                <i class="clock-icon"></i>
                <h4><?= Controller::parseNumbers(Cars::getDailySell()) ?></h4>
                <span>آگهی امروز</span>
            </div>
        </div>
    </div>
<?php endif;?>


<div class="boxes-container">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 right-side">
<!--                <a href="#suggest-way-modal" data-toggle="modal" class="linear-link">روش پیشنهادی</a>-->
        <div class="content">
            <div class="steps">
                <i class="step-1"></i>
                <i class="step-2"></i>
                <i class="step-3"></i>
                <i class="step-4"></i>
            </div>
            <h2>جستجوی وسیله نقلیه به صورت مرحله ای</h2>
            <p>در این روش شما می توانید به صورت مرحله ای و به صورت هوشمند، وسیله نقیله، برند، شاسی، مدل، قیمت را انتخاب نموده و سریعتر و دقیقتر به نتیجه برسید.</p>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 left-side">
        <div class="search-box">
            <h4>جستجوی وسیله نقلیه</h4>
            <div class="input-group">
                <?= CHtml::textField('Search[model]', null, [
                    'class' => 'form-control custom-search auto-complete',
//                    'onblur' => 'clearAutoCompleteResult()',
                    'placeholder' => 'مدل وسیله نقلیه را تایپ نمایید...',
                ]);?>
            <span class="input-group-btn">
                <?= CHtml::htmlButton('<i class="search-icon"></i>', ['class' => 'btn', 'type' => 'button']);?>
            </span>
            </div>
            <div class="autocomplete-result nicescroll hidden" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-autohidemode="leave">
                <ul></ul>
            </div>
        </div>
        <div class="desc-box">
            <i class="dollar-car-icon"></i>
            <h4>خودرو خود را برای فروش به ما بسپارید...</h4>
            <p>شما می توانید مشخصات خودرو خود را برای فروش بین تمامی کاربران سایت به اشتراک بگذارید و با استفاده از طرح های ما بسیار سریع به فروش برسانید.</p>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 enamad-logo">
<!--        samandehi-->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
            <img id='jxlzesgtfukzfukznbqefukz' style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=106626&p=rfthobpdgvkagvkauiwkgvka", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt='logo-samandehi' src='https://logo.samandehi.ir/logo.aspx?id=106626&p=nbpdlymawlbqwlbqodrfwlbq'/>
            <img src="https://trustseal.enamad.ir/logo.aspx?id=78522&amp;p=yAB3wY5aHpIEuczA" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=78522&amp;p=yAB3wY5aHpIEuczA&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)" style="cursor:pointer" id="yAB3wY5aHpIEuczA">
        </div>
<!--        enamad-->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="app-logo-box">
                <a class="app-logo android-logo"></a>
                <a class="app-logo ios-logo"></a>
                <h3>به زودی ...</h3>
            </div>
        </div>
    </div>
</div>

<?php
if($topBrands):
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);
?>

<div class="top-brands">
    <div class="is-carousel" data-margin="10" data-dots="0" data-nav="1" data-mouse-drag="1" data-responsive='{"1920":{"items":"11"},"1200":{"items":"9"},"992":{"items":"7"},"768":{"items":"5"},"480":{"items":"4"},"360":{"items":"3"},"0":{"items":"2"}}'>
        <?php
        $logoPath = Yii::getPathOfAlias("webroot").'/uploads/brands/';
        foreach($topBrands as $brand):
            if($brand->logo && file_exists($logoPath.$brand->logo)):
        ?>
            <div class="item">
                <a href="<?= Yii::app()->createUrl('/car/brand/'.$brand->slug) ?>"><img width="100px" height="100px" alt="<?= $brand->title ?>" src="<?= Yii::app()->getBaseUrl(true).'/uploads/brands/'.$brand->logo ?>" class="grayscale"><span><?= Controller::parseNumbers(number_format($brand->carsCount)) ?></span></a>
            </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>
</div>


<div class="modal fade" id="suggest-way-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        جستجوی پیشرفته خودرو
                        <button type="button" data-dismiss="modal" class="close">&times;</button>
                    </h4>
                </div>
                <div class="modal-body nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railalign="left" data-autohidemode="leave">
                    <form>
                        <div class="tab-content">
                            <section id="step1">
                                <div class="container">
                                    <h4 class="step-title">نوع شاسی موردنظر خود را انتخاب کنید</h4>
                                    <div class="carousel" data-multiple="false">
                                        <div class="carousel-inline-inner">
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon svg svg-mini-car"></div>
                                                <div class="carousel-title">کوپه</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons ltr">
                                        <a class="btn btn-hover-success btn-rounded" href="#step2">
                                            <span class="svg svg-back-alt"></span>
                                        </a>
                                        <button class="btn btn-hover-info btn-rounded" type="submit">
                                            <span class="svg svg-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </section>
                            <section id="step2">
                                <div class="container">
                                    <h4 class="step-title">برند موردنظر خود را انتخاب کنید</h4>
                                    <div class="carousel" data-multiple="false">
                                        <div class="carousel-inline-inner">
                                            <div class="carousel-item">
                                                <div class="carousel-icon">
                                                    <img src="uploads/brands/maserati.png" class="grayscale">
                                                </div>
                                                <div class="carousel-title">مازراتی</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon">
                                                    <img src="uploads/brands/kia.png" class="grayscale">
                                                </div>
                                                <div class="carousel-title">کیا موتور</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons ltr">
                                        <a class="btn btn-hover-success btn-rounded" href="#step3">
                                            <span class="svg svg-back-alt"></span>
                                        </a>
                                        <button class="btn btn-hover-info btn-rounded" type="submit">
                                            <span class="svg svg-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </section>
                            <section id="step3">
                                <div class="container">
                                    <h4 class="step-title">برند موردنظر خود را انتخاب کنید</h4>
                                    <div class="carousel" data-multiple="false">
                                        <div class="carousel-inline-inner">
                                            <div class="carousel-item">
                                                <div class="carousel-icon">
                                                    <img src="uploads/brands/maserati.png" class="grayscale">
                                                </div>
                                                <div class="carousel-title">مازراتی</div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="carousel-icon">
                                                    <img src="uploads/brands/kia.png" class="grayscale">
                                                </div>
                                                <div class="carousel-title">کیا موتور</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons ltr">
                                        <button class="btn btn-hover-info btn-rounded" type="submit">
                                            <span class="svg svg-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
endif;

Yii::app()->clientScript->registerScript('autoComplete', "
    var currentRequest = null;
    $('.auto-complete').on('keyup', function(e){
        if(e.keyCode >= 37 && e.keyCode <= 40)
            return;

        if($(this).val().length >= 2){
            var query = $(this).val();
            currentRequest = $.ajax({
                url: 'car/search/autoComplete',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    query: query
                },
                beforeSend : function(){
                    $('.autocomplete-result').removeClass('hidden');
                    $('.autocomplete-result ul').html('<li class=\"loading\">در حال جستجو...</li>');

                    if(currentRequest != null)
                        currentRequest.abort();
                },
                success: function (data) {
                    if(data.length != 0){
                        $('.autocomplete-result ul').html('');
                        $.each(data, function(index, model){
                            $('.autocomplete-result ul').append('<li><a href=\"' + model.link + '\" class=\"autocomplete-item\">' + model.title + '</a></li>');
                        });
                    }else{
                        $('.autocomplete-result ul').html('<li class=\"loading\">نتیجه ای یافت نشد.</li>');
                    }
                }
            });
        }
    });
");