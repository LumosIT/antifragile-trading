@extends('layouts.form', [
    'title' => 'Перенаправление...'
])

@section('content')
    <div class="form" id="success" style="display: none">
        <h1 class="h1">Упс...</h1>
        <h2 class="h2">Кажется, мы проводим технические работы</h2>
    </div>
    @push('scripts')
        <script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
        <script type="text/javascript">
            (function () {
                var widget = new cp.CloudPayments();

                var receipt = {
                    Items: [
                        {
                            label: 'Оплата подписки на обучающие информационно-аналитические материалы. Тариф {{ $tariff->name }}',
                            price: {{ $tariff->price }},
                            quantity: 1,
                            amount: {{ $tariff->price }},
                            vat: 0,
                            method: 4,
                            object: 4
                        }
                    ],
                    taxationSystem: 0,
                    email: "{{ $user->email }}",
                    phone: "{{ $user->phone }}",
                    isBso: true,
                    amounts:
                        {
                            electronic: {{ $tariff->price }},
                            advancePayment: 0.00,
                            credit: 0.00,
                            provision: 0.00
                        }
                };

                widget.pay('charge', 
                    {
                        publicId:  "{{ $public_id }}",
                        description: 'Оплата подписки',
                        amount: {{ $order->amount }},
                        currency: 'RUB',
                        accountId: {{ $user->id }},
                        invoiceId: '{{ $order->code }}',
                        email: "{{ $user->email }}",
                        skin: "mini",
                        successRedirectUrl : "{{ route('public.redirect') }}",
                        failRedirectUrl : "{{ route('public.redirect') }}",
                        data: Object.assign({
                            order_id : {{ $order->id }}
                        }, {
                            CustomerReceipt: receipt,
                            CloudPayments : {
                                CustomerReceipt: receipt
                            }
                        }),
                        configuration: {
                            common: {
                                successRedirectUrl: "{{ route('public.redirect') }}",
                                failRedirectUrl: "{{ route('public.redirect') }}"
                            }
                        },
                    },
                    {
                        onSuccess: function (options) {
                            location.href = "{{ route('public.redirect') }}";
                        },
                        onFail: function (reason, options) {
                        },
                        onComplete: function (paymentResult, options) {
                        }
                    }
                )
            })();
        </script>
    @endpush
@endsection
