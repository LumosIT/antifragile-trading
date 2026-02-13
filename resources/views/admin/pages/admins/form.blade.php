@extends('admin.layouts.app')

@isset($admin)
    @php($title = 'Редактирование администратора ' . $admin->login)
@else
    @php($title = 'Создание администратора')
@endisset

@section('title', $title)

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Управление' => '#',
            'Сотрудники' => route('admin.admins'),
            $title
        ]
    ])

    <div class="row">
        <div class="col-6">
            <form id="my_form" action="{{ isset($admin) ? route('admin.api.admins.edit', $admin->id) : route('admin.api.admins.create') }}" class="card" method="post" autocomplete="off">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                       {{ $title }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Логин</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-2-line"></i></div>
                            <input type="text" class="form-control border-dashed" required name="login" value="{{ isset($admin) ? $admin->login : '' }}" @isset($admin) readonly @endisset placeholder="Root">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Пароль</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-lock-2-line"></i></div>
                            <input type="password" class="form-control border-dashed" name="password" value="" autocomplete="off" @isset($admin) @else required @endisset>
                        </div>
                        @isset($admin)
                            <p class="text-muted fs-10">Оставьте пустым, если не хотите менять</p>
                        @endisset
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Роль</label>
                        <select class="form-control w-100" data-trigger name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(isset($admin) && $admin->role_id === $role->id) selected @endisset>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        @isset($admin)
                            <button type="submit" class="btn btn-primary label-btn">
                                <i class="ri-save-2-fill label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Сохранить
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary label-btn">
                                <i class="ri-add-line label-btn-icon me-2"></i>
                                <span class="label-btn-icon" style="display: none">
                                         <span class="spinner-border spinner-border-sm align-middle"></span>
                                    </span>
                                Создать администратора
                            </button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3">
            @isset($admin)
                @include('components.profile.remove-two-factory', [
                    'entity' => $admin,
                    'route' => route('admin.api.admins.remove-two-factory', $admin->id)
               ])
            @endisset
        </div>
    </div>

@endsection
@push('scripts')
    <script>

        jsAjaxForm($("#my_form"), (json) => {

            @isset($admin)
                successNotification('Администратор успешно сохранен');
            @else

                successNotification('Администратор успешно создан!');

                setTimeout(() => {
                    location.href = "{{ route('admin.admins.edit', ':param') }}".replace(':param', json.response.id);
                }, 500);

            @endisset

        });

    </script>
@endpush
