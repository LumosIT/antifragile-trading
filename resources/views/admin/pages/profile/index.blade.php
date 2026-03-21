@extends('admin.layouts.app')

@section('title', 'Профиль')

@section('content')

<div class="container-fluid">
    <div class="row g-4">
        <!-- Профиль -->
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        Ваш профиль
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="form-label fs-14 text-dark">Логин</label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="ri-key-2-fill"></i>
                            </div>
                            <input type="text"
                                   class="form-control border-dashed"
                                   readonly
                                   value="{{ $admin->login }}">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-end gap-2">
                        @include('components.profile.change-password', [
                            'route' => route('admin.api.profile.change-password')
                        ])
                    </div>
                </div>
            </div>
        </div>

        <!-- 2FA -->
        <div class="col-12 col-md-4 col-lg-3">
            @include('components.profile.two-factory', [
                'entity' => $admin,
                'routes' => [
                    'generate' => route('admin.api.tfa.generate'),
                    'confirm' => route('admin.api.tfa.confirm'),
                    'remove' => route('admin.api.tfa.remove')
                ]
            ])
        </div>
    </div>
</div>

@endsection
