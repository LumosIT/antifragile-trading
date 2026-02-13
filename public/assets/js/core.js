function setPageTitle(title){

    let hint = document.title.split("|").pop().trim();

    document.title = title + ' | ' + hint;
}

function htmlize(html){
    return he.encode(String(html), {
        allowUnsafeSymbols: false
    });
}

function copyToClipboard(message){
    copy(message);
}

function repeat(time, fn){

    fn(() => {

        setTimeout(() => {
            repeat(time, fn);
        }, time);

    });

}

function repeatAjax(time, url, onLoad){

    repeat(time, (cb) => {

        $.post(url).done(json => {

            if(json.status){
                onLoad(json);
            }else{
                console.log(json.error);
            }

        }).always(cb);

    });

}

function formatNumber(number, decimals = 0, decimalsSymbol = '.', thousandsSymbol = ' ') {
    return accounting.formatNumber(+number, decimals, thousandsSymbol, decimalsSymbol)
}

function formatNumberAuto(number, maxDecimals = 0, decimalsSymbol = '.', thousandsSymbol = ' ') {

    if(!maxDecimals){
        return formatNumber(number, maxDecimals, decimalsSymbol, thousandsSymbol)
    }

    let parts = (+number).toFixed(maxDecimals)
        .replace(/0+$/, '')
        .split('.');

    return formatNumber(number, parts[1].length, decimalsSymbol, thousandsSymbol);

}


function formatPhone(phone){

    try{
        return libphonenumber.parsePhoneNumber('+' + phone).formatInternational();
    }catch(e){
        return '+' + phone;
    }

}

function throttler(time, fn){

    let last = 0;

    return function (...args) {

        let now = Date.now();

        if (now - last >= time) {
            last = now;
            fn.apply(this, args);
        }

    }

}
