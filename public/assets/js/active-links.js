let $activeMenus = $(".main-menu .side-menu__item")
    .filter(function(){

        function _s(str){
            str = str.split("#").shift();
            return str.substr(-1) === '/' ? str : (str + '/');
        }

        return (_s(location.href).indexOf(_s(this.href)) >= 0);

    })
    .sort(function(el){
        return el.href.length;
    })
    .eq(0)
    .addClass('active')
    .parent()
    .addClass('active');
