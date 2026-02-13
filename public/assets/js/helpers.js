function confirmModal(text, cb){

    let $modal = $("#confirmation_modal");

    $modal.find('.modal-body').text(text);

    $modal.modal('show');

    $("#confirmation_modal_button")
        .off('click')
        .on('click', function (e){

            e.preventDefault();

            cb({
                hide(){
                    $modal.modal('hide')
                },
                changeButtonText(text){
                    $("#confirmation_modal_button").text(text);
                },
                resetButtonText(){
                    $("#confirmation_modal_button").text('Подтвердить');
                }
            });

        });

}

function ajaxConfirmationModal(url, text, cb){

    let loading = false;
    confirmModal(text, (m) => {

        if(loading){
            return;
        }

        loading = true;

        m.changeButtonText('Минутку...');

        $.post(url)
            .done(json => {

                if(json.status){
                    cb(m);
                }else{
                    errorNotification(json.error);
                }

            })
            .always(() => {

                loading = false;

                m.resetButtonText();

            });

    });

}

function initDatatableFilter(dataTable, name, el){

    $(el).on('change', function(){
        dataTable.setFilter(name, this.value).reload(1);
    });

}

function initDatatableSearch(dataTable, el){

    $(el).on('input', function(){
        dataTable.setSearch(this.value || null).reloadWithDelay(700);
    });


}

function initDatatableRemoveButton(dataTable, selector, title){

    $(document).on('click', selector, function(e){

        e.preventDefault();

        confirmModal(title, () => {

            $.post(this.href).done(json => {

                if(json.status){

                    successNotification('Успешно!');

                    $("#confirmation_modal").modal('hide');

                    dataTable.reload(null, false);

                }else{

                    errorNotification(json.error);

                }

            });

        });

    });


}

function initDatatableDateFilter(dataTable, el){

    let from = moment().subtract(1, 'year').format('DD.MM.yyyy');
    let to = moment().add(1, 'days').format('DD.MM.yyyy')

    flatpickr($(el).get(0), {
        mode: "range",
        dateFormat: "d.m.Y",
        disableMobile: true,
        defaultDate : [
            from, to
        ],
        onChange(selectedDates, str, instance){

            if(selectedDates.length > 1) {
                dataTable.setFilter('from', instance.formatDate(selectedDates[0], "d.m.Y"))
                dataTable.setFilter('to', instance.formatDate(selectedDates[1], "d.m.Y"));
                dataTable.reload(1);
            }

        }
    });

    dataTable.setFilter('from', from);
    dataTable.setFilter('to', to);

}

function jsAjaxForm(form, afterSave, beforeRequest = null){

    let $forms = $(form);

    if($forms.length > 1){
        return $forms.map(function(){
            return jsAjaxForm(this, afterSave, beforeRequest);
        });
    }

    let $form = $forms.eq(0);

    return $form.on('submit', function(e){

        e.preventDefault();

        if($form.hasClass('loading')){
            return;
        }

        $form.addClass('loading');

        let $loader = $form.find('button[type="submit"] span.label-btn-icon');

        $loader.show().prev('i').hide();

        if(beforeRequest){
            beforeRequest();
        }

        $.ajax({
            url : this.action,
            processData: false,
            contentType: false,
            type: 'POST',
            data: new FormData($form.get(0))
        })
        .done(function(json){

            if(json.status){
                afterSave(json);
            }else{
                errorNotification(json.error);
            }

        })
        .always(function(){

            $loader.hide().prev('i').show();

            $form.removeClass('loading');

        });

    });

}

function htmlTemplateDate(date){

    let m = moment(date);

    return `
                                <div>
                                   <a href="javascript:void(0);" class="fw-medium">${m.format('HH:mm')}</a>
                                   <span class="d-block text-muted fs-10">${moment().diff('days', m) > 2 ? m.format('DD.MM.yyyy') : m.fromNow()}</span>
                                </div>`

}

function htmlTemplateUser(name, hint = null, url = '#', picture = ''){

    return `<div class="d-flex align-items-center gap-2">
                                                                <div class="lh-1">
                                                                    <span class="avatar avatar-sm avatar-rounded">
                                                                        <img src="${picture || '/assets/images/ecommerce/jpg/2.jpg'}" alt="">
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <a href="${ url }" class="d-block fw-medium">${ htmlize(name) }</a>
                                                                    ${ hint ? `<span class="fs-12 text-muted">${ htmlize(hint) }</span>` : ``}
                                                                </div>
                                                            </div>`;

}

function htmlTemplateSwitch(options = {}){

    return `<div class="form-check form-switch mb-2">
                            <input class="form-check-input ${ options.className || '' }" type="checkbox" role="switch"
                                id="switch-primary" ${ options.checked ? 'checked' : '' } autocomplete="off" value="${ options.value || '' }" name="${ options.name || '' }">
                        </div>`;

}

function getSummerNoteText(el){

    let code = $(el).data('summernote').invoke('code');

    let div = document.createElement('div');
    div.innerHTML = code;

    return div.textContent;

}
