$(document).ready(function(){
    $(document).on('click', '.add-dynamic-input', function () {
        var container = $(this).attr('data-input-container'),
            html = $(container).find('.dynamic-input-container:last-child').html(),
            count = $(this).attr('data-count');
        $($(container).html()).find('input').each(function (key, value) {
            var inputHtml = this.outerHTML;
            this.name = (this.name).replace("[" + (count - 1) + "]", "[" + count + "]")
            this.defaultValue = "";

            if($(this).hasClass('date-picker')){
                var config = $.parseJSON($(this).attr('data-config'));
                config.altField = config.altField.substr(0, config.altField.lastIndexOf('-') + 1) + count;
                $(this).attr('data-config', JSON.stringify(config));
            }

            if($(this).hasClass('date-picker-alt-field')){
                var id = $(this).attr('id');
                id = id.substr(0, id.lastIndexOf('-') + 1) + count;
                $(this).attr('id', id);
            }

            html = html.replace(inputHtml, this.outerHTML);
        });

        $($(container).html()).find('select').each(function (key, value) {
            var inputHtml = this.outerHTML;
            this.name = (this.name).replace("[" + (count - 1) + "]", "[" + count + "]")
            html = html.replace(inputHtml, this.outerHTML);
        });
        $(this).attr('data-count', (parseInt(count) + 1).toString());
        $(container).append('<div class="dynamic-input-container">' + html + '</div>');
        dynamicFieldCallback();
    }).on('click', '.remove-dynamic-field', function (e) {
        e.preventDefault();
        $(this).parents('.dynamic-input-container').remove();
    });
});

window.dynamicFieldCallback = function(){};