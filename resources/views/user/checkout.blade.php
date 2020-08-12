@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark text-center">{{ __('Payment') }}</h1>
@stop

@section('content')

<form action="{{ route('user.checkout.proccess')}}" method="POST" enctype="multipart/form-data" name="pay" id="pay">

        @csrf
        @method("POST")

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 d-block mx-auto pt-2 pb-2">
                        <img class="img-fluid" src="https://imgmp.mlstatic.com/org-img/MLB/MP/BANNERS/tipo2_575X40.jpg?v=1"
                            alt="Mercado Pago - Meios de pagamento" title="Mercado Pago - Meios de pagamento"
                            width="575" height="40"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-block mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                    {!! Form::textarea('description','ok', ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'description', 'placeholder' => __("Description"), 'readonly']) !!}
                                    {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="transaction_amount">{{ __('Amount') }}</label>
                                    {!! Form::text('transaction_amount', alternative_money($billing->budget->amount, '$', 2, ',', '.'), ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'transaction_amount', 'placeholder' => __("Amount"), 'readonly']) !!}
                                    {!! $errors->first('transaction_amount','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber">{{ __('Card Number') }}</label>
                                    {!! Form::text('cardNumber', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'cardNumber', 'placeholder' => __("Card Number"), 'data-checkout' => 'cardNumber',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    {!! $errors->first('cardNumber','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="cardholderName">{{ __('Card Holder Name') }}</label>
                                    {!! Form::text('cardholderName', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'cardholderName', 'placeholder' => __("Card Holder Name"), 'data-checkout' => 'cardholderName']) !!}
                                    {!! $errors->first('cardholderName','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="cardExpirationMonth">{{ __('Card Expiration Month') }}</label>
                                    {!! Form::text('cardExpirationMonth', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'cardExpirationMonth', 'placeholder' => __("Card Expiration Month"), 'data-checkout' => 'cardExpirationMonth',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    {!! $errors->first('cardExpirationMonth','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="cardExpirationYear">{{ __('Card Expiration Year') }}</label>
                                    {!! Form::text('cardExpirationYear', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'cardExpirationYear', 'placeholder' => __("Card Expiration Year"), 'data-checkout' => 'cardExpirationYear',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    {!! $errors->first('cardExpirationYear','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="securityCode">{{ __('Security Code') }}</label>
                                    {!! Form::text('securityCode', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'securityCode', 'placeholder' => __("Security Code"), 'data-checkout' => 'securityCode',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    {!! $errors->first('securityCode','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="installments">{{ __('Installments') }}</label>
                                    {!! Form::select('installments', [], null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'installments', 'placeholder' => __("Installments")]) !!}
                                    {!! $errors->first('installments','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="docType">{{ __('Doc Type') }}</label>
                                    {!! Form::select('docType', $docTypes, null,
                                    ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'docType', 'placeholder' => __("Doc Type"), 'data-checkout' => 'docType']) !!}
                                    {!! $errors->first('docType','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="docNumber">{{ __('Doc Number') }}</label>
                                    {!! Form::text('docNumber', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'docNumber', 'placeholder' => __("Doc Number"), 'data-checkout' => 'docNumber']) !!}
                                    {!! $errors->first('docNumber','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    {!! Form::email('email', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'),
                                    'id' => 'email', 'placeholder' => __("Email")]) !!}
                                    {!! $errors->first('email','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                {!! Form::hidden('payment_method_id', null, ['id' => 'payment_method_id']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-block mx-auto card-footer">
                        <a href="" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        <input type="submit" value="{{ __('Pay') }}" class="btn btn-primary float-right">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

    <script>
        window.Mercadopago.setPublishableKey("{!! env('MERCADOPAGO_PUBLIC_KEY') !!}");

        document.getElementById('cardNumber').addEventListener('keyup', guessPaymentMethod);
        document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

        function guessPaymentMethod(event) {
            let cardnumber = document.getElementById("cardNumber").value;

            if (cardnumber.length >= 6) {
                let bin = cardnumber.substring(0,6);
                window.Mercadopago.getPaymentMethod({
                    "bin": bin
                }, setPaymentMethod);
            }
        };

        function setPaymentMethod(status, response) {
            if (status == 200) {
                let paymentMethodId = response[0].id;
                let element = document.getElementById('payment_method_id');
                element.value = paymentMethodId;
                getInstallments();
            } else {
                alert(`payment method info error: ${response}`);
            }
        }

        function getInstallments(){
            window.Mercadopago.getInstallments({
                "payment_method_id": document.getElementById('payment_method_id').value,
                "amount": parseFloat(document.getElementById('transaction_amount').value)

            }, function (status, response) {
                if (status == 200) {
                    document.getElementById('installments').options.length = 0;
                    response[0].payer_costs.forEach( installment => {
                        let opt = document.createElement('option');
                        opt.text = installment.recommended_message;
                        opt.value = installment.installments;
                        document.getElementById('installments').appendChild(opt);
                    });
                } else {
                    alert(`installments method info error: ${response}`);
                }
            });
        }

        doSubmit = false;
        document.querySelector('#pay').addEventListener('submit', doPay);

        function doPay(event){
            event.preventDefault();
            if(!doSubmit){
                var $form = document.querySelector('#pay');

                window.Mercadopago.createToken($form, sdkResponseHandler);

                return false;
            }
        };

        function sdkResponseHandler(status, response) {
            if (status != 200 && status != 201) {
                alert("verify filled data");
            }else{
                var form = document.querySelector('#pay');
                var card = document.createElement('input');
                card.setAttribute('name', 'token');
                card.setAttribute('type', 'hidden');
                card.setAttribute('value', response.id);
                form.appendChild(card);
                doSubmit=true;
                form.submit();
            }
        };
    </script>

@stop



