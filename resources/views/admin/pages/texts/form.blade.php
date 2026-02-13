@extends('admin.layouts.app')

@php($title = 'Текста')

@section('title', $title)

@push('styles')
    <style>
        .text-hint{
            border: none;
            color: #a4a4a4;
            padding: 0;
            background: transparent;
        }
    </style>
@endpush

@section('content')
    <div class="mb-2">
        <input class="form-control me-2" id="texts_search" placeholder="Поиск..." style="width:200px" autocomplete="off">
    </div>


    <ul class="nav nav-tabs mb-3 nav-justified nav-style-1 d-sm-flex d-block" role="tablist">
        @foreach($textGroups as $i => $textGroup)
            <li class="nav-item">
                <a class="nav-link @if(!$i) active @endif" data-bs-toggle="tab" role="tab" href="#{{ $textGroup->id }}"
                   aria-selected="false">{{ $textGroup->name }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($textGroups as $i => $textGroup)
            <div class="tab-pane @if(!$i) active @endif" id="{{ $textGroup->id }}" role="tabpanel">
                @php($filtered = $texts->where('text_group_id', $textGroup->id))
                @foreach($filtered as $text)
                    <div class="card shadow mb-4 text-card">
                        <div class="card-header d-block">
                            <p class="card-title">{{ $text->id }}</p>
                            <div><input autocomplete="off" type="text" class="w-40 text-hint" value="{{ $text->hint ?: 'Без названия' }}" data-url="{{ route('admin.api.texts.edit-hint', $text->id) }}"></div>
                        </div>
                        <form action="{{ route('admin.api.texts.edit', $text->id) }}" method="post" class="card-body text-form" autocomplete="off">
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <textarea name="value" id="" cols="30" rows="10" class="form-control">{{ $text->value }}</textarea>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary label-btn">
                                        <i class="ri-save-2-fill label-btn-icon me-2"></i>
                                        <span class="label-btn-icon" style="display: none">
                                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                                    </span>
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>


@endsection
@push('scripts')
    <script>

        function getBlockValue(el){

            return getSummerNoteText(
                $(el).find('textarea')
            ).toLowerCase();

        }

        function getBlockTitle(el){

            let name = $(el).find('.card-title').text() + $(el).find('.text-hint').val();

            return name.toLowerCase();

        }

        jsAjaxForm($(".text-form"), (json) => {
            successNotification('Текст успешно сохранен');
        });

        $('#texts_search').on('input', function(e) {

            let value = $(this).val().toLowerCase();

            $('.text-card').each(function(){

                let textarea = getBlockValue(this);
                let title = getBlockTitle(this);

                if(title.indexOf(value) >= 0 || textarea.indexOf(value) >= 0){
                    $(this).show();
                }else{
                    $(this).hide();
                }

            });


        });

        $(document).on('change', '.text-hint', function(){
            $.post(this.getAttribute('data-url'), {
                hint : this.value
            }).done(function(data){

                if(data.status){
                    successNotification('Комментарий сохранен!');
                }

            });
        });

        $(window).on('load', () => {

            $(".text-form textarea").summernote({
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

        });

    </script>
@endpush
