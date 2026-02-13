@extends('layouts.app')

@section('title')
    @yield('title')
@endsection

@section('styles')

    <style>
        html[data-menu-styles="dark"] .side-menu__label1.bg-light-transparent{
            background-color: rgba(255,255,255,0.1) !important;
            color: white !important;
        }
    </style>

    @stack('styles')
@endsection

@section('modals')
    @stack('modals')
@endsection

@section('header:end')
    <li class="header-element dropdown">
        <!-- Start::header-link|dropdown-toggle -->
        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
           data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <div class="d-flex align-items-center">
                <div class="me-xl-2 me-0 lh-1 d-flex align-items-center ">
                            <span class="avatar avatar-xs avatar-rounded bg-primary-transparent">
                                <img src="/assets/images/faces/5.jpg" alt="img">
                            </span>
                </div>
                <div class="d-xl-block d-none lh-1">
                    <span class="fw-medium lh-1">{{ auth('admin')->user()->login }}</span>
                </div>
            </div>
        </a>
        <!-- End::header-link|dropdown-toggle -->
        <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
            aria-labelledby="mainHeaderProfile">
            <li class="border-bottom"><a class="dropdown-item d-flex flex-column" href="#"><span
                        class="fs-12 text-muted">Wellcome!</span><span class="fs-14">{{ auth('admin')->user()->login }}</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}"><i
                        class="ti ti-user me-2 fs-18 text-primary"></i>Профиль</a></li>
            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"><i
                        class="ti ti-logout me-2 fs-18 text-danger"></i>Выйти</a></li>
        </ul>
    </li>
@endsection

@section('header:menu')
    <ul class="main-menu">
        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">Данные</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        @permission(Permissions::USERS)
            <li class="slide">
                <a href="{{ route('admin.users') }}" class="side-menu__item">
                    <i class="ri-group-fill side-menu__icon"></i>
                    {{--<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"></path><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></svg>--}}
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Пользователи</span>
                </a>
            </li>
        @endpermission
        @permission(Permissions::PAYMENTS)
        <li class="slide">
            <a href="{{ route('admin.payments') }}" class="side-menu__item">
                <i class="ri-secure-payment-fill side-menu__icon"></i>

                <i class="ri-arrow-right-s-line side-menu__angle"></i>
                <span class="side-menu__label">Платежи</span>
            </a>
        </li>
        @endpermission
        @permission(Permissions::MAILING)
        <li class="slide">
            <a href="{{ route('admin.mailing') }}" class="side-menu__item">
                <i class="ri-mail-check-fill side-menu__icon"></i>
                {{--<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"></path><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></svg>--}}
                <i class="ri-arrow-right-s-line side-menu__angle"></i>
                <span class="side-menu__label">Рассылки</span>
            </a>
        </li>
        <li class="slide">
            <a href="{{ route('admin.posts') }}" class="side-menu__item">
                <i class="ri-mail-check-fill side-menu__icon"></i>
                {{--<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"></path><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></svg>--}}
                <i class="ri-arrow-right-s-line side-menu__angle"></i>
                <span class="side-menu__label">Авторассылки</span>
            </a>
        </li>
        @endpermission
        @permission(Permissions::STATISTIC)
        <li class="slide">
            <a href="{{ route('admin.statistic') }}" class="side-menu__item">
                <i class="ri-bar-chart-fill side-menu__icon"></i>
                {{--<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"></path><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></svg>--}}
                <i class="ri-arrow-right-s-line side-menu__angle"></i>
                <span class="side-menu__label">Статистика</span>
            </a>
        </li>
        @endpermission
        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">Управление</span></li>
        <!-- End::slide__category -->
        @permission(Permissions::GOVERNMENT)
            <li class="slide">
                <a href="{{ route('admin.roles') }}" class="side-menu__item">
                    <i class="ri-shield-check-fill side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Роли</span>
                </a>
            </li>
            <li class="slide">
                <a href="{{ route('admin.admins') }}" class="side-menu__item">
                    <i class="ri-police-badge-fill side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Сотрудники</span>
                </a>
            </li>
        @endpermission
        @permission(Permissions::TARIFFS)
            <li class="slide">
                <a href="{{ route('admin.tariffs') }}" class="side-menu__item">
                    <i class="ri-calculator-fill side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Тарифы</span>
                </a>
            </li>
        @endpermission
        @permission(Permissions::PROMOCODES)
            <li class="slide">
                <a href="{{ route('admin.promocodes') }}" class="side-menu__item">
                    <i class="ri-coupon-2-fill side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Промокоды</span>
                </a>
            </li>
        @endpermission
        @permission(Permissions::TEXTS)
            <li class="slide">
                <a href="{{ route('admin.texts') }}" class="side-menu__item">
                    <i class="ri-text side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Текста</span>
                </a>
            </li>
        @endpermission
        @permission(Permissions::OPTIONS)
            <li class="slide">
                <a href="{{ route('admin.options') }}" class="side-menu__item">
                    <i class="ri-settings-2-fill side-menu__icon"></i>

                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    <span class="side-menu__label">Переменные</span>
                </a>
            </li>
        @endpermission
    </ul>
@endsection

@section('content')
    @yield('content')
@endsection

@section('scripts')
    @stack('scripts')
@endsection
