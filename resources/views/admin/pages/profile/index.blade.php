@extends('admin.layouts.app')

@section('title', 'Профиль')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Ваш профиль
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label for="" class="form-label fs-14 text-dark">Логин</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-key-2-fill"></i></div>
                                <input type="text" class="form-control border-dashed" readonly value="{{ $admin->login }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                           @include('components.profile.change-password', [
                                'route' => route('admin.api.profile.change-password')
                           ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
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
