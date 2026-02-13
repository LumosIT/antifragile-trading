@extends('layouts.form', [
    'title' => 'Анкета предзаписи'
])

@section('content')
    @if($user->meta_is_pre_form_filled)
        <div class="form">
            <h1 class="h1">Форма успешно заполнена!</h1>
            <h2 class="h2">Ожидайте, мы скоро свяжемся с вами</h2>
        </div>
    @else
        <form action="" class="form" autocomplete="off" method="post">
            <h1 class="h1">Оставьте ваши контактные данные</h1>
            <h2 class="h2">и мы свяжемся с вами</h2>
            <label class="group">
                <input type="text" name="fio" class="input" placeholder="" required maxlength="255">
                <span class="label">Введите ваше имя *</span>
            </label>
            <label class="group">
                <input type="text" name="phone" class="input" placeholder="" required maxlength="255">
                <span class="label">Введите ваш номер телефона *</span>
            </label>
            <label class="group">
                <input type="text" name="email" class="input" placeholder="" required maxlength="255">
                <span class="label">Введите ваш e-mail *</span>
            </label>
            <label class="group">
                <select name="profit" class="select" id="" required>
                    <option value="">-- Не выбрано --</option>
                    <option value="0 - 50 000 рублей">0 - 50 000 рублей</option>
                    <option value="50 000 - 100 000 рублей">50 000 - 100 000 рублей</option>
                    <option value="100 000 - 300 000 рублей">100 000 - 300 000 рублей</option>
                    <option value="300 000 - 500 000 рублей">300 000 - 500 000 рублей</option>
                    <option value="500 000 - 1 000 000 рублей">500 000 - 1 000 000 рублей</option>
                    <option value="1 000 000 рублей +">1 000 000 рублей +</option>
                </select>
                <span class="label">Ваш ежемесячный доход</span>
            </label>
            <label class="group">
                <select name="capital" class="select" id="" required>
                    <option value="">-- Не выбрано --</option>
                    <option value="до 500 000 рублей">до 500 000 рублей</option>
                    <option value="500 000 - 1 000 000 рублей">500 000 - 1 000 000 рублей</option>
                    <option value="1 000 000 - 3 000 000 рублей">1 000 000 - 3 000 000 рублей</option>
                    <option value="3 000 000 - 5 000 000 рублей">3 000 000 - 5 000 000 рублей</option>
                    <option value="5 000 000 - 10 000 000 рублей">5 000 000 - 10 000 000 рублей</option>
                    <option value="10 000 000 рублей +">10 000 000 рублей +</option>
                </select>
                <span class="label">Какой размер вашего капитала на рынке?</span>
            </label>
            <label class="group">
                <select name="duration" class="select" id="" required>
                    <option value="">-- Не выбрано --</option>
                    <option value="Жду с нетерпением, когда откроется набор">Жду с нетерпением, когда откроется набор</option>
                    <option value="Заинтересован, но все будет зависеть от цены">Заинтересован, но все будет зависеть от цены</option>
                    <option value="Пока трудно сказать, надо подумать">Пока трудно сказать, надо подумать</option>
                </select>
                <span class="label">Насколько вы готовы оформить подписку на сервис?</span>
            </label>
            @csrf
            <button type="submit" class="button" disabled>Отправить заявку</button>
        </form>
    @endif
    @push('scripts')
        <script type="text/javascript">

            $('input').on('input', function(e){

                if(this.value.length){
                    $(this).addClass('filled');
                }else{
                    $(this).removeClass('filled');
                }

            })

            let $inputs = $('input, select');

            $inputs.on('change input', function(e){

                let filled = $inputs.get().every(function(el){
                    return el.value.length;
                })

                $('.button').prop('disabled', !filled);

            })


        </script>
    @endpush
@endsection
