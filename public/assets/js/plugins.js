moment.locale('ru');

$('.js-int-mask').intMask();
$('.js-numeric-mask').numericMask();
$('.js-decimal-mask').decimalMask();

$(".datatable_filters_button").each(function(){

    new bootstrap.Popover(this, {
        placement: 'bottom',
        html: true,
        content: $(this).closest('form').find(".datatable_filters").get(0)
    });

}).on('click', function(){

    let loop = () => {

        if(!this.hasAttribute('aria-describedby')){
            $(this).trigger('click');
            setTimeout(loop, 100);
        }

    }

    setTimeout(loop, 100);

});

$(document).on('click', function(e){

    if(!$(e.target).closest('.popover, .btn').length){
        $('.popover').remove();
    }

});

$(".js-date-picker").each(function(){

    let fl = flatpickr(this, {
        mode: "single",
        dateFormat: "d.m.Y",
        disableMobile: true,
        defaultDate : [this.value]
    });

    $(this).data('flatpickr', fl);

});

$(".js-datetime-picker").each(function(){

    let fl = flatpickr(this, {
        enableTime: true,
        time_24hr: true,
        mode: "single",
        dateFormat: "d.m.Y H:i",
        disableMobile: true,
        defaultDate : [this.value]
    });

    $(this).data('flatpickr', fl);

});

hljs.highlightAll();

$("code").filter(function(){
    return this.className.indexOf('language-') >= 0;
}).attr('style', 'padding: 0 !important;background:transparent;');
