@if($user->type == 'telegram')

    {{-- TELEGRAM --}}
    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Имя профиля (Telegram)</label>
        <div class="input-group position-relative">
            <div class="input-group-text"><i class="ri-send-plane-fill"></i></div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->name }}">
        </div>
    </div>

    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Юзернейм (Telegram)</label>
        <div class="input-group position-relative">
            <div class="input-group-text">@</div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->username }}">
        </div>
    </div>

    {{-- MAX --}}
    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Имя профиля (MAX)</label>
        <div class="input-group position-relative">
            <div class="input-group-text"><i class="ri-user-fill"></i></div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->name_2 }}">
        </div>
    </div>

    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Юзернейм (MAX)</label>
        <div class="input-group position-relative">
            <div class="input-group-text">@</div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->username_2 }}">
        </div>
    </div>

@elseif($user->type == 'max')

    {{-- MAX --}}
    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Имя профиля (MAX)</label>
        <div class="input-group position-relative">
            <div class="input-group-text"><i class="ri-user-fill"></i></div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->name }}">
        </div>
    </div>

    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Юзернейм (MAX)</label>
        <div class="input-group position-relative">
            <div class="input-group-text">@</div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->username }}">
        </div>
    </div>

    {{-- TELEGRAM --}}
    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Имя профиля (Telegram)</label>
        <div class="input-group position-relative">
            <div class="input-group-text"><i class="ri-send-plane-fill"></i></div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->name_2 }}">
        </div>
    </div>

    <div class="form-group mb-4">
        <label class="form-label fs-14 text-dark">Юзернейм (Telegram)</label>
        <div class="input-group position-relative">
            <div class="input-group-text">@</div>
            <input type="text" class="form-control border-dashed" readonly value="{{ $user->username_2 }}">
        </div>
    </div>

@endif