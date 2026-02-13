jQuery.fn.decimalMask = function(){

    return this.each(function(){

        this.addEventListener('keydown', (e) => {

            let code = e.key.toLowerCase();

            if(!(e.ctrlKey || e.metaKey) || !['c', 'x', 'v', 'a'].includes(code)) {

                if (!['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'backspace', 'arrowleft', 'arrowright', 'delete', '.', 'enter'].includes(code)) {
                    e.preventDefault();
                }

            }


            if(code === '.' && this.value.indexOf('.') >= 0){
                e.preventDefault();
            }

        });

        this.addEventListener('change', (e) => {
            this.value = parseFloat(this.value) || 0;
        });

        this.addEventListener('paste', (e) => {

            e.preventDefault();

            if(e.clipboardData){

                let value = e.clipboardData.getData('text');

                this.value = (parseFloat(value) || '').toString();

            }

            $(this).trigger('input');

        });

    });

}

jQuery.fn.intMask = function(){

    return this.each(function() {

        this.addEventListener('keydown', (e) => {

            let code = e.key.toLowerCase();

            if (!(e.ctrlKey || e.metaKey) || !['c', 'x', 'v', 'a'].includes(code)) {

                if (!['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'backspace', 'arrowleft', 'arrowright', 'delete', 'enter'].includes(code)) {
                    e.preventDefault();
                }

            }

        });

        this.addEventListener('change', (e) => {
            this.value = parseFloat(this.value) || 0;
        });

        this.addEventListener('paste', (e) => {

            e.preventDefault();

            if (e.clipboardData) {

                let value = e.clipboardData.getData('text');

                this.value = (parseInt(value) || '').toString();

            }

            $(this).trigger('input');

        });

    });

}



jQuery.fn.numericMask = function(){

    return this.each(function() {


        this.addEventListener('keydown', (e) => {

            let code = e.key.toLowerCase();

            if (!(e.ctrlKey || e.metaKey) || !['c', 'x', 'v', 'a'].includes(code)) {

                if (!['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'backspace', 'arrowleft', 'arrowright', 'delete', 'enter'].includes(code)) {
                    e.preventDefault();
                }

            }

        });

        this.addEventListener('paste', (e) => {

            e.preventDefault();

            if (e.clipboardData) {

                let value = e.clipboardData.getData('text');

                this.value = value.replace(/[^0-9]/g, '');

            }

            $(this).trigger('input');

        });

    });

}
