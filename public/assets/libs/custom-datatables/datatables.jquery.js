jQuery.fn.CustomDataTables = function(options){

    let page = 1;
    let limit = options.limit || 100;
    let sortField = options.sort ? options.sort[0] : 'id';
    let sortMode = options.sort ? options.sort[1] : 'desc';

    let url = options.url;
    let columns = options.columns;
    let prepareResponse = options.prepareResponse;
    let filters = Object.assign({}, options.filters || {});
    let search = '';

    let $table = jQuery(this);
    let $pagination = jQuery(`<ul class="pagination mb-0"></ul>`);

    let requestId = 0, initiated = false;

    function scrollTo(){
        window.scrollTo(0, $table.get(0).getBoundingClientRect().top + window.pageYOffset - 200);
    }

    function loadData(callback){

        let currentRequestId = ++requestId;

        $.post(url, {
            ...filters,
            page,
            limit,
            sort_field : sortField,
            sort_mode : sortMode,
            search
        }).done(function(json){

            if(currentRequestId === requestId){

                callback(
                    prepareResponse ? prepareResponse(json) : json
                );

            }

        });

    }

    function buildTh(column){

        let width = column.width ? (column.width + 'px') : 'auto';
        let textAlign = column.textAlign || 'left';

        if(column.sortable){
            return `<th style="width: ${width};max-width:${width};min-width:${width};text-align: ${textAlign}"><a data-code="${ column.code }" href="#" class="custom-datatables-sort-trigger ${ column.code === sortField ? 'active' : '' } ${ column.code === sortField ? sortMode : '' }">${column.name}</a></th>`;
        }else{
            return `<th style="width: ${width};max-width:${width};min-width:${width};">${column.name}</th>`;
        }


    }

    function buildThead(){

        let thead =  '<tr>' + columns.map(buildTh).join('') + '</tr>';

        if(options.theadContent){
            thead += `<tr><td colspan="${ columns.length }">${ options.theadContent() }</td>`;
        }

        $table.find('thead').html(thead);

    }

    function buildPagination(current, total){

        let html = '';

        let createButton = (text, page, isActive = false) => {
            return `<li class="page-item ${ isActive ? 'active' : ''}">
               <a class="page-link" href="javascript:void(0);" data-page="${page}">${text}</a>
            </li>`;
        };

        if (current > 1) {
            html += createButton('<', current - 1);
        }

        if (total <= 3) {
            for (let i = 1; i <= total; i++) {
                html += createButton(i, i, i === current);
            }
        } else {
            if (current === 1) {
                html += createButton(1, 1, true);
                html += createButton(2, 2);
                html += createButton('...', null);
                html += createButton(total, total);
            } else if (current === 2) {
                html += createButton(1, 1);
                html += createButton(2, 2, true);
                html += createButton(3, 3);
                if (total > 3) {
                    html += createButton('...', null);
                    html += createButton(total, total);
                }
            } else if (current === total) {
                html += createButton(1, 1);
                html += createButton('...', null);
                html += createButton(total - 1, total - 1);
                html += createButton(total, total, true);
            } else if (current === total - 1) {
                html += createButton(1, 1);
                if (total > 4) html += createButton('...', null);
                html += createButton(total - 2, total - 2);
                html += createButton(total - 1, total - 1, true);
                html += createButton(total, total);
            } else {
                html += createButton(1, 1);
                if (current - 1 > 2) html += createButton('...', null);
                html += createButton(current - 1, current - 1);
                html += createButton(current, current, true);
                html += createButton(current + 1, current + 1);
                if (current + 1 < total - 1) html += createButton('...', null);
                html += createButton(total, total);
            }
        }

        if (current < total) {
            html += createButton('>', current + 1);
        }

        $pagination.html(html);

    }

    function buildTd(column, item){

        let width = column.width ? (column.width + 'px') : 'auto';
        let textAlign = column.textAlign || 'left';

        let td = document.createElement('td');
        td.style.width = width;
        td.style.maxWidth = width;
        td.style.minWidth = width;
        td.style.textAlign = textAlign;

        $(td).append(
            column.data(item)
        );

        return td;
    }

    function buildData(data, needScrollTo = true){

        buildPagination(data.current_page, data.pages);


        if(data.items.length){

            let fragment = document.createDocumentFragment();

            data.items.forEach(item => {

                let tr = document.createElement('tr');

                columns.forEach(col => {
                    tr.appendChild(buildTd(col, item));
                })

                fragment.appendChild(tr);

            });

            $table.find('tbody').empty().append(fragment);

        }else{

            let empty = ` <tr><td colspan="20" class="text-center py-3 text-muted">Нет данных</td></tr>`;

            $table.find('tbody').html(empty);

        }

        if(initiated) {
            if(needScrollTo){
                scrollTo();
            }
        }else{
            initiated = true;
        }

    }

    function reload(needScrollTo = true){

        $table.addClass('loading');

        loadData(function(data){
            buildData(data, needScrollTo);

            $table.removeClass('loading');
        });

    }

    ///////
    $table.addClass('custom-datatables');

    let $paginationBox = jQuery(`<div class="d-flex align-items-center p-3">
                    <div class="ms-auto">
                        <nav aria-label="Page navigation" class="pagination-style-4">

                        </nav>
                    </div>
                </div>`);

    $paginationBox.find('nav').append($pagination);

    $table.after($paginationBox);

    buildThead();

    $table.on('click', '.custom-datatables-sort-trigger', function(e){

        e.preventDefault();

        let newSortField = this.getAttribute('data-code');

        if(newSortField === sortField){
            sortMode = sortMode === 'desc' ? 'asc' : 'desc';
        }else{
            sortField = newSortField;
            sortMode = 'desc';
        }

        $table.find('.custom-datatables-sort-trigger').removeClass('active desc asc');

        $(this).addClass(sortMode).addClass('active');

        reload();

    });

    $pagination.on('click', '.page-link', function(e){

        e.preventDefault();

        let p = +this.getAttribute('data-page');

        if(p && p !== page){

            page = p;

            // $pagination.find('.page-item').removeClass('active');
            // $(this).parent().addClass('active');

            reload();

        }

    });

    ///////

    let delayTimeout = null;

    let entity = {

        setFilter(name, value){

            if(!value) {
                delete filters[name];
            }else{
                filters[name] = value;
            }

            return this;

        },

        setSearch(value){
            search = value || '';

            return this;
        },

        setPage(n){

            page = n;

            return this;

        },

        reload(p, needScrollTo = true){

            if(delayTimeout){

                clearTimeout(delayTimeout);

                delayTimeout = null;

            }

            if(p){
                page = p;
            }

            reload(needScrollTo);

            return this;

        },

        reloadWithDelay(delay, needScrollTo = true){

            if(delayTimeout){
                clearTimeout(delayTimeout);
            }

            delayTimeout = setTimeout(() => reload(needScrollTo), delay);

            return this;

        }

    }

    $table.data('custom-datatable', entity);

    setTimeout(reload, 200);

    return entity;

}
