@extends('admin.layouts.app')

@php($title = 'Настройки')

@section('title', $title);

@section('content')
    <div class="mb-2">
        <input class="form-control me-2" id="options_search" placeholder="Поиск..." style="width:200px" autocomplete="off">
    </div>

    @foreach($options as $option)
        <form class="card shadow mb-4 option-card option-form" action="{{ route('admin.api.options.edit', $option->id) }}" method="post" autocomplete="off">
            <div class="card-header justify-content-between">
                <div style="max-width: 500px;">
                    <p class="card-title">{{ $option->id }}</p>
                    <p class="card-hint fs-12 text-muted mb-0">{{ $option->description }}</p>
                </div>
                <div class="">
                    @if($option->type !== \App\Consts\OptionTypes::BOOLEAN)
                        <button type="submit" class="btn btn-primary label-btn">
                            <i class="ri-save-2-fill label-btn-icon me-2"></i>
                            <span class="label-btn-icon" style="display: none">
                                             <span class="spinner-border spinner-border-sm align-middle"></span>
                                        </span>
                            Сохранить
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="form-group">
                            @if($option->type === \App\Consts\OptionTypes::STRING)
                                <textarea name="value" style="height: 70px;resize: vertical;" cols="15" rows="10" class="form-control">{{ $option->value }}</textarea>
                            @elseif($option->type === \App\Consts\OptionTypes::NUMBER)
                                <input type="text" class="js-int-mask form-control" name="value" value="{{ $option->value }}">
                            @elseif($option->type === \App\Consts\OptionTypes::BOOLEAN)
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input form-check-input-lg form-checked-primary option-switcher" type="checkbox" role="switch" value="1" @if($option->value) checked @endif autocomplete="off" name="value">
                                    <label class="form-check-label" for="flexSwitchCheckDefault_is_banned">Включено</label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-3">

                    </div>
                </div>
            </div>
        </form>
    @endforeach


@endsection
@push('scripts')
    <script>

        jsAjaxForm($(".option-form"), (json) => {
            successNotification('Настройка успешно сохранена');
        });

        $('#options_search').on('input', function(e) {

            let value = $(this).val().toLowerCase();

            $('.option-card').each(function(){

               if($(this).find('.card-header').text().toLowerCase().indexOf(value) >= 0){
                   $(this).show();
               }else{
                   $(this).hide();
               }

            });


        });

        $('.option-switcher').on('change', function(e){

           $(this).closest('form').trigger('submit');

        });

    </script>
@endpush
