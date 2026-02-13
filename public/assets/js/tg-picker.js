$.fn.tgPicker = function tgPicker(options = {}) {

    if(this.length > 1){
        return this.each(function () {
            tgPicker.call(this);
        })
    }

    let $form = $(this);

    function unselectFile(){
        $form.find('.tg-picker-background').children().hide();
        $form.removeClass('selected');
        $form.find('.tg-picker-value').val('');
    }

    function selectFile(file){

        let route = options.getLink(file);

        unselectFile();

        $form.addClass('selected');

        switch(file.type){

            case "photo":
                $form.find('.tg-picker-photo').prop('src', route).show();
                break;

            case "video":
                $form.find('.tg-picker-video').prop('src', route).show();
                break;

            default:
                $form.find('.tg-picker-document').show().find('span').text(file.name);
                break;

        }

        $form.find('.tg-picker-show').prop('href', route);
        $form.find('.tg-picker-value').val(file.id);
    }

    function showLoader(){
        $form.find('.tg-picker-loader').show();
    }

    function hideLoader(){
        $form.find('.tg-picker-loader').hide();
    }

    $form.find('.tg-picker-input').on('change', function(){

        showLoader();

        let form = new FormData();
        form.append('file', this.files[0]);

        $.ajax({
            url: options.url,
            method: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: (json) => {

                if(json.status){
                    selectFile(json.response);
                }else{
                    errorNotification(json.error);
                    unselectFile();
                }

            },
            complete : () => {
                hideLoader();
            },
            error : () => {
                errorNotification('Ошибка при загрузке файла');
                unselectFile();
            }
        });

    });


    if(options.value){
        selectFile(options.value);
    }else{
        unselectFile();
    }

}

