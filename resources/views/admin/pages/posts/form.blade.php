@extends('admin.layouts.app')

@php($title = 'Авторассылки: ' . $allTypes[$type])

@section('title', $title)

@section('content')
    <ul class="nav nav-tabs mb-3 nav-justified nav-style-1 d-sm-flex d-block">
        @foreach($allTypes as $value => $name)
            <li class="nav-item">
                <a class="nav-link @if($type === $value) active @endif" href="{{ route('admin.posts.type', $value) }}"
                   aria-selected="false">{{ $name }}</a>
            </li>
        @endforeach
    </ul>
    <div class="text-blocks"></div>
    <div class="text-block-controls">
        <button class="btn btn-primary text-block-add js-add label-btn" type="button">
            <i class="ri-add-box-line label-btn-icon me-2"></i>
            Добавить пост
        </button>
    </div>
@endsection
@push('styles')
    <style>
        .text-block-controls{
            display: block;
            height: 100px;
            position: relative;

            &:before, &:after {
                content: '';
                position: absolute;
                width: 1px;
                top: 0;
                bottom: 0;
                background-color: #c0b9ff;
                z-index: -1;
            }

            &:before {
                left: 50px;
            }

            &:after {
                right: 50px;
            }

        }

        .text-block-delay{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 200px;
        }

        .text-block-delay .input-group-text:first-child{
            background: #dfcdfb;
        }
        .text-block-add{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
        }
        .text-block{
            transition: opacity 0.5s;
        }
        .text-block-hidden{
            opacity: 0;
        }
        .text-block-remove{
            position: absolute;
            bottom: 0;
            height: 22px;
            padding-top: 0;
            padding-bottom: 0;
            line-height: 1;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            right: 0;
            transition: all 0.2s;
        }

        .text-block-remove:hover{
            height: 30px;
            line-height: 1.4;
            background: tomato;
        }
        .text-block-switch{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .text-block:first-child .text-block-switch{
            display: none;
        }
        html,body{
            scroll-behavior: auto !important;
        }
    </style>
@endpush
@push('scripts')

    <template id="text-block">
        <form action="{{ route('admin.api.posts.create') }}" method="post" autocomplete="off" class="text-block text-block-hidden">
            <div class="text-block-controls">
                <div class="text-block-delay input-group">
                    <span class="input-group-text">
                        <i class="ri ri-time-fill"></i>
                    </span>
                    <input type="text" class="js-int-mask form-control" placeholder="Задержка" name="delay" required>
                    <span class="input-group-text">мин</span>
                </div>
                <button class="text-block-switch btn btn-primary-light" type="button">
                    <i class="ri ri-arrow-up-down-fill fs-20"></i>
                </button>
                <button class="btn btn-primary text-block-add label-btn" type="button">
                    <i class="ri-add-box-line label-btn-icon me-2"></i>
                    Добавить пост
                </button>
                <a href="" class="text-block-remove btn btn-danger">
                    <i class="ri ri-close-line fs-20"></i>
                </a>
            </div>
            <div class="card shadow mb-0 text-card">
                <div class="card-header d-block">
                    <p class="card-title">Блок <span class="text-block-index"></span></p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <textarea name="value" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-3">
                            @include('components.forms.telegram-file-picker', [
                                   'placeholder' => 'Выбрать файл',
                                   'name' => 'file_id',
                                   'accept' => '.jpeg,.jpg,.png,.mp4,.doc,.txt,.xls,.ppt,.pptx,.docx,.xlsx',
                                   'no_initiate' => true
                               ])
                                <button type="submit" class="btn btn-success label-btn mt-2" style="position: absolute;bottom: 16px;right: 17px;">
                                    <i class="ri-save-2-fill label-btn-icon me-2"></i>
                                    <span class="label-btn-icon" style="display: none">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                            </span>
                                    Сохранить
                                </button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type" value="{{ $type }}">
        </form>
    </template>

    <script>

        function buildRemoveRoute(id){
            return "{{ route('admin.api.posts.remove', ':pattern') }}".replace(':pattern', id);
        }

        function buildEditRoute(id){
            return "{{ route('admin.api.posts.edit-content', ':pattern') }}".replace(':pattern', id);
        }

        function buildEditDelayRoute(id){
            return "{{ route('admin.api.posts.edit-delay', ':pattern') }}".replace(':pattern', id);
        }

        function setBlockId(block, id){

            let $block = $(block);

            $block.attr('data-id', id);
            $block.attr('action', buildEditRoute(id));
            $block.find('.text-block-remove').prop('href', buildRemoveRoute(id));
            $block.find('.text-block-delay input').attr('data-href', buildEditDelayRoute(id));

        }

        function buildBlock(text, delay, id = null, file = null){

            let $block = $($("#text-block").html());

            if(id){
                setBlockId($block, id);
            }

            jsAjaxForm($block, (json) => {

                successNotification('Текст успешно сохранен');

                setBlockId($block, json.response.id);
                saveIndexes();

            });

            $block.find('.text-block-delay input').val(delay);

            $block.find("textarea").html(text).summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['link'],
                    ['view', ['codeview']]
                ],
                allowedTags: [
                    'b', 'strong',
                    'i', 'em',
                    'u', 'ins',
                    's', 'strike', 'del',
                    'code', 'pre',
                    'a'
                ],
                allowedAttributes: {
                    'a': ['href']
                },
                height: 400,
                disableDragAndDrop: true,
                shortcuts: false
            });

            $block.find('.js-int-mask').intMask();

            $block.find('.tg-picker').tgPicker({
                url : '{{ route('admin.api.files.upload') }}',
                getLink(file){
                    return "{{ route('admin.api.files.get', '_var_1') }}".replace('_var_1', file.id);
                },
                value : file
            });

            return $block;

        }

        function getSummerNoteText(el){

            let code = $(el).data('summernote').invoke('code');

            let div = document.createElement('div');
            div.innerHTML = code;

            return div.textContent;

        }

        function appendBlock(block, beforeBlock){

            if(beforeBlock){
                $(beforeBlock).before(block);
            }else{
                $(".text-blocks").append(block);
            }

            $('.text-block').each(function(){

                $(this).find('.text-block-index').val(
                    $(this).index()
                );

            })

        }

        function redrawIndexes(){

            $(".text-block").each(function(){
                $(this).find('.text-block-index').text(
                    $(this).index() + 1
                );
            })

        }

        function saveIndexes(){

            let data = [];
            $('.text-block').each(function(){

                let id = this.getAttribute('data-id');
                let index = $(this).index();

                if(id){
                    data.push({id, index});
                }

            });

            $.post("{{ route('admin.api.posts.set-indexes') }}", {data});

        }


        $(document).on('click', '.text-block-add', function(e){

            let $block = buildBlock('', 0);

            let $parent = $(this).closest('.text-block');

            appendBlock($block, $parent.get(0));
            redrawIndexes();

            setTimeout(function(){
                $block.removeClass('text-block-hidden');
            }, 200);

        });

        $(document).on('click', '.text-block-remove', function(e){

            e.preventDefault();

            let $block = $(this).closest('.text-block');
            let link = $(this).attr('href');

            confirmModal('Удалить текст?', (data) => {

                if(link){
                    $.post(link);
                }

                $block.addClass('text-block-hidden');

                setTimeout(function(){
                    $block.remove();
                }, 200);

                data.hide();

                redrawIndexes();

            });


        });

        $(document).on('change', '.text-block-delay input', function(e){

            let href = this.getAttribute('data-href');

            if(href){

                $.post(href, {
                    delay : this.value
                }).done(function(){
                    successNotification('Успешно сохранено!');
                });

            }

        });

        $(document).on('click', '.text-block-switch', function(e){

            let scroll = window.pageYOffset;

            let $me = $(this).closest('.text-block');
            let $prev = $me.prev('.text-block');

            $me.after($prev);

            setTimeout(function(){
                window.scrollTo(0, scroll);
            }, 50);

            redrawIndexes();
            saveIndexes();

        });

        ///////////

        $(window).on('load', function(){

            @foreach($posts as $post)
                appendBlock(
                    buildBlock(
                        @js($post->value),
                        {{ $post->delay }},
                        {{ $post->id }},
                        @json($post->file)
                    )
                );
            @endforeach

            redrawIndexes();

            $(".text-block").removeClass('text-block-hidden');

        });


    </script>
@endpush
