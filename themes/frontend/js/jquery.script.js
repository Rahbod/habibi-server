$(document).ready(function() {
    // Csrf Token setup
    $.ajaxSetup({
        data: {
            'YII_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function () {
        if($(window).width() > 992)
            $("body").removeClass("overflow-fix filter-box-open");
            $(".header").removeClass("open");
    });

    if($(window).width() > 992)
        $('[data-title]').tooltip();
    if ($('.select-picker').length && $.fn.selectpicker)
        $('.select-picker').selectpicker({
            dropupAuto: false,
            size: 7
        });

    $('.digitFormat').digitFormat();

    $(document).on("click", ".content-box .filter-box .head .toggle-icon", function () {
        $(this).toggleClass("plus").toggleClass("minus");
    }).on('keyup', '.range-min-input', function () {
        var strMin = $(this).val(),
            strMax = $('.range-max-input').val();
        for (var i = 0; i < ($(this).val().match(/,/g) || []).length; i++)
            strMin = strMin.replace(/,/, '');

        for (var j = 0; j < ($('.range-max-input').val().match(/,/g) || []).length; j++)
            strMax = strMax.replace(/,/, '');
        //$(this).parent().find('.range-slider').slider("option", "values", [parseInt(strMin), parseInt(strMax)]);
        changePriceFilterBtnUrl(strMin ? parseInt(strMin) : null, strMax ? parseInt(strMax) : null);
    }).on('keyup', '.range-max-input', function () {
        var strMax = $(this).val(),
            strMin = $('.range-min-input').val();
        for (var i = 0; i < ($(this).val().match(/,/g) || []).length; i++)
            strMax = strMax.replace(/,/, '');

        for (var j = 0; j < ($('.range-min-input').val().match(/,/g) || []).length; j++)
            strMin = strMin.replace(/,/, '');
        $(this).parent().find('.range-slider').slider("option", "values", [parseInt(strMin), parseInt(strMax)]);
        changePriceFilterBtnUrl(strMin ? parseInt(strMin) : null, strMax ? parseInt(strMax) : null);
    }).on('click', '.price-filter', function () {
        var strMax = $('.range-max-input').val(),
            strMin = $('.range-min-input').val();
        for (var i = 0; i < ($('.range-max-input').val().match(/,/g) || []).length; i++)
            strMax = strMax.replace(/,/, '');
        for (var j = 0; j < ($('.range-min-input').val().match(/,/g) || []).length; j++)
            strMin = strMin.replace(/,/, '');
        changePriceFilterBtnUrl(strMin ? parseInt(strMin) : null, strMax ? parseInt(strMax) : null);
    }).on('keyup', '.dealership-name', function () {
        var strName = $(this).val();

        changeNameFilterBtnUrl(strName);
    }).on('keyup', '.filter-box.by-brand .text-field', function () {
        var query = $(this).val();

        if (query == '')
            $(this).parent().find('.brands-list li').removeClass('hidden');
        else {
            $(this).parent().find('.brands-list li').each(function () {
                var regex = new RegExp(query + ".*");
                if ($(this).find('label .title').text().match(regex) == null)
                    $(this).addClass('hidden');
                else
                    $(this).removeClass('hidden');
            });
        }
    }).on('click', '.advertise-info-box .image-container .image-slider-item', function (e) {
        e.preventDefault();
        var src = $(this).find('img').data('origin') ? $(this).find('img').data('origin') : $(this).find('img').attr('src');
        $(this).parents('.image-container').find('.main-image-container img').attr('src', src);
    }).on('click', '.advertise-info-box #show-full-phone', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).data("url"),
            type: "POST",
            data: {method: "getContact", hash: $(this).data("hash")},
            dataType: "JSON",
            success: function (data) {
                if (data.status)
                    $('#phone-number').text(data.phone).addClass('text-success text-bold');
            }
        });
        $(this).addClass('hidden');
    }).on('show.bs.collapse', '.car-list.accordion', function (e) {
        $(".car-list.accordion .collapse.in").each(function () {
            $(this).collapse('hide');
        });
    }).on('click', '.linear-link', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if ($(href).parents(".nicescroll").length)
            $(href).parents(".nicescroll").getNiceScroll(0).doScrollTop($(href).offset().top, 2000);
        else if (href.substr(1, href.length))
            $('html, body').animate({
                scrollTop: ($(href).offset().top)
            }, 2000);
    }).on("click", ".carousel-item", function () {
        var parent = $(this).parents(".carousel");
        if (!parent.data("multiple"))
            parent.find(".carousel-item").not($(this)).removeClass("active");
        $(this).toggleClass("active");
    }).on("show.bs.modal", "#suggest-way-modal", function () {
        $(this).find(".tab-content > .tab-pane:not(:first-of-type)").removeClass("active in");
        $(this).find(".tab-content > .tab-pane:first-of-type").addClass("active in");
    }).on("show.bs.modal", "#login-modal", function () {
        $(this).find("form input[type=text], form input[type=tel], form input[type=password], form input[type=email], form textarea").val("");
        $(this).find("form .error").removeClass("error");
        $(this).find("form .errorMessage").hide();
        $(this).find(".tab-content > .tab-pane:not(:first-of-type)").removeClass("active in");
        $(this).find(".tab-content > .tab-pane:first-of-type").addClass("active in");
    }).on("keyup", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("change", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("keyup", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("change", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("click", function (e) {
        // Hidden auto complete result box
        if ($(e.target).hasClass("autocomplete-item") || $(e.target).hasClass("auto-complete"))
            return;
        else
            $('.autocomplete-result').addClass('hidden');
    }).on("focus", ".auto-complete", function () {
        if ($('.autocomplete-result ul li').length != 0)
            $('.autocomplete-result').removeClass('hidden');
    }).on("click", ".menu-trigger", function () {
        if($('.header').hasClass('open')){
            $('.header').removeClass('open');
            $('body').removeClass('overflow-fix');
        }else{
            $('.header').addClass('open');
            $('body').addClass('overflow-fix');
        }
    }).on("click", ".item-actions-trigger", function () {
        var $article = $(this).parents('article');
        if($article.hasClass('open-menu')){
            $article.removeClass('open-menu');
        }else{
            $('.advertise-panel-list article').removeClass('open-menu');
            $article.addClass('open-menu');
        }
    }).on("click", ".filter-box-trigger", function () {
        if ($('body').hasClass('filter-box-open')) {
            $('body').removeClass('overflow-fix filter-box-open');
        } else
            $('body').addClass('overflow-fix filter-box-open');
    });

    $(".nicescroll").each(function () {
        var options = $(this).data();

        $.each(options, function (key, value) {
            if (typeof value == "string" && value.indexOf("js:") != -1)
                options[key] = JSON.parse(value.substr(3));
        });

        $(this).niceScroll(options);
    });

    $(".datepicker").each(function () {
        $(this).persianDatepicker(eval($(this).data("config")));
    });

    $(".is-carousel").each(function () {
        if ($(this).children().length > 0) {
            var nestedItemSelector = $(this).data('item-selector'),
                dots = ($(this).data('dots') == 1) ? true : false,
                nav = ($(this).data('nav') == 1) ? true : false,
                responsive = $(this).data('responsive'),
                margin = $(this).data('margin'),
                loop = ($(this).data('loop') == 1) ? true : false,
                autoPlay = ($(this).data('autoplay') == 1) ? true : false,
                autoPlayHoverPause = ($(this).data('autoplay-hover-pause') == 1) ? true : false,
                mouseDrag = ($(this).data('mouse-drag') == 1) ? true : false;
            if (typeof nestedItemSelector == 'undefined') {
                $(this).owlCarousel({
                    slideBy: 1,
                    loop: loop,
                    autoplay: autoPlay,
                    items: 1,
                    dots: dots,
                    nav: nav,
                    margin: margin,
                    autoplayHoverPause: autoPlayHoverPause,
                    mouseDrag: mouseDrag,
                    navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                    responsive: responsive,
                    rtl: true
                });
            } else {
                $(this).owlCarousel({
                    slideBy: 1,
                    loop: loop,
                    autoplay: autoPlay,
                    items: 1,
                    nestedItemSelector: nestedItemSelector,
                    dots: dots,
                    nav: nav,
                    autoplayHoverPause: autoPlayHoverPause,
                    mouseDrag: mouseDrag,
                    navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                    responsive: responsive,
                    rtl: true
                });
            }
        }
    });

    $('.range-slider').each(function () {
        $(this).slider({
            range: true,
            min: $(this).data('min'),
            max: $(this).data('max'),
            step: $(this).data('step'),
            values: $(this).data('values'),
            slide: function (event, ui) {
                $($(this).data('min-input')).val(ui.values[0]);
                $($(this).data('max-input')).val(ui.values[1]);
                $('.digitFormat').digitFormat();
                changePriceFilterBtnUrl(ui.values[0], ui.values[1]);
            }
        });
    });

    $("body").on("keyup", ".brand-search-trigger", function () {
        var $table = $(this).parents('.panel').find('.car-list');
        var rex = new RegExp($(this).val(), 'i');
        $table.find('.brand-list').hide();
        $table.find('.brand-list').filter(function () {
            return rex.test($(this).find(".list-title").text());
        }).show();
        if ($table.find('.brand-list:visible').length === 0) {
            $table.find('.not-found').show();
        } else {
            $table.find('.not-found').hide();
        }
    });

    $('[data-toggle="popover"]').popover();
});

$.fn.digitFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
};

$.fn.numericFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "");
        });
    });
};

function clearAutoCompleteResult() {
    $('.autocomplete-result').addClass('hidden');
}

function submitAjaxForm(form ,url ,loading ,callback) {
    loading = typeof loading !== 'undefined' ? loading : null;
    callback = typeof callback !== 'undefined' ? callback : null;
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        dataType: "json",
        beforeSend: function () {
            if(loading)
                loading.show();
        },
        success: function (html) {
            if(loading)
                loading.hide();
            if (typeof html === "object" && typeof html.status === 'undefined') {
                $.each(html, function (key, value) {
                    $("#" + key + "_em_").show().html(value.toString()).parent().removeClass('success').addClass('error');
                });
            }else
                eval(callback);
        }
    });
}