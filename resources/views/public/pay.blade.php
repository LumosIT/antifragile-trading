@extends('layouts.form', [
    'title' => 'Оплата'
])

@section('content')
    @if(!$payments_enabled)
        <div class="form">
            <h1 class="h1">Упс...</h1>
            <h2 class="h2">В данный момент оплата недоступна</h2>
        </div>
    @else
        <form action="" class="form" autocomplete="off" method="post">
            <h1 class="h1">Оплата подписки</h1>
            <h2 class="h2">Тариф: {{ $tariff->name }}</h2>
            <label class="group">
                <input type="text" name="fio" class="input" placeholder="" required maxlength="255" value="{{ $user->fio }}">
                <span class="label">Введите ваше имя *</span>
            </label>
            <label class="group">
                <input type="text" name="phone" class="input" placeholder="" required maxlength="255" value="{{ $user->phone }}">
                <span class="label">Введите ваш номер телефона *</span>
            </label>
            <label class="group">
                <input type="text" name="email" class="input" placeholder="" required maxlength="255" value="{{ $user->email }}">
                <span class="label">Введите ваш e-mail *</span>
            </label>
            <label class="group">
                <input type="text" name="promocode" class="input" style="text-transform: uppercase" maxlength="255">
                <span class="label">Промокод</span>
            </label>
            <label class="checkbox">
                <input type="checkbox" class="checkbox-input" autocomplete="off" required>
                <div class="checkbox-body">
                    <i class="checkbox-icon"></i>
                </div>
                <p class="checkbox-text">Я разрешаю автоматические платежи за доступ к Клубу 257 в соответствии со своим тарифом до тех пор, пока я не отменю подписку</p>
            </label>
            <label class="checkbox">
                <input type="checkbox" class="checkbox-input" autocomplete="off" required>
                <div class="checkbox-body">
                    <i class="checkbox-icon"></i>
                </div>
                <p class="checkbox-text">Я прочитал и согласен с <a href="https://antifragile-trading.ru/offer_subscribe" target="_blank">публичной офертой</a> и
                    <a href="https://antifragile-trading.ru/confidencial" target="_blank">политикой конфиденциальности</a></p>
            </label>
            @csrf
            <button type="submit" class="button" disabled>Перейти к оплате</button>
        </form>
    @endif
    @push('scripts')
        <script type="text/javascript">

            let $inputs = $('input');

            $inputs.on('input', function(e){

                if(this.value.length){
                    $(this).addClass('filled');
                }else{
                    $(this).removeClass('filled');
                }

            });

            $inputs.on('input', function(e){

                let filled = $inputs.filter('[required]').get().every(function(el){
                    return el.type === 'checkbox' ? el.checked : el.value.length;
                })

                $('.button').prop('disabled', !filled);

            });

            $inputs.trigger('input');


        </script>
    @endpush
@endsection
