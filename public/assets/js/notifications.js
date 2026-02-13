!function(){

    function buildNotificationElement(color, message){

        let $el = $("#primaryToast").clone();

        $el.addClass('bg-' + color + '-transparent');
        $el.find('.toast-body').text(message);
        $el.find('.toast-header').addClass('bg-' + color);
        $el.find('strong').text(color === 'danger' ? 'Упс...' : color === 'success' ? 'Успешно!' : '...')

        $(".toast-container").append($el);

        return $el.get(0);

    }

    function successNotification(message, delay = 3000) {

        let toast = new bootstrap.Toast(
            buildNotificationElement('success', message),
            {
                delay
            }
        );
        toast.show()

    }

    function errorNotification(message, delay = 3000) {

        let toast = new bootstrap.Toast(
            buildNotificationElement('danger', message),
            {
                delay
            }
        );
        toast.show()

    }

    window.successNotification = successNotification;
    window.errorNotification = errorNotification;

}();
