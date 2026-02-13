@extends('admin.layouts.app')

@isset($role)
    @php($title = 'Редактирование роли ' . $role->name)
@else
    @php($title = 'Создание роли')
@endisset

@section('title', $title);

@section('content')

    @include('components.other.breadcrumbs', [
        'items' => [
            'Управление' => '#',
            'Роли' => route('admin.roles'),
            $title
        ]
    ])

    <div class="row">
        <div class="col-6">
            <form id="my_form" action="{{ isset($role) ? route('admin.api.roles.edit', $role->id) : route('admin.api.roles.create') }}" class="card" method="post" autocomplete="off">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                       {{ $title }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Название</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-book-2-line"></i></div>
                            <input type="text" class="form-control border-dashed" required name="name" value="{{ isset($role) ? $role->name : '' }}" placeholder="Администратор">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label fs-14 text-dark">Права</label>
                        @foreach(Permissions::getTitles() as $code => $title)
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="permissions[]" value="{{ $code }}"
                                       id="flexSwitchCheckDefault_{{ $code }}" @if(isset($role) && $role->hasPermission($code)) checked @endif autocomplete="off">
                                <label class="form-check-label" for="flexSwitchCheckDefault_{{ $code }}">{{ $title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        @isset($role)
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
                                Создать роль
                            </button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script>

        jsAjaxForm($("#my_form"), (json) => {

            @isset($role)
                successNotification('Роль успешно сохранена');
            @else

                successNotification('Роль успешно создана!');

                setTimeout(() => {
                    location.href = "{{ route('admin.roles.edit', ':param') }}".replace(':param', json.response.id);
                }, 500);

            @endisset

        });

    </script>
@endpush
