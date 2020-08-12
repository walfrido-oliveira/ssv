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
                                    {!! Form::textarea('description','ok', ['class' => 'form-control ',
                                    'id' => 'description', 'placeholder' => __("Description"), 'readonly', 'rows' => '3']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-description"></div>
                                </div>
                                <div class="form-group">
                                    <label for="transaction_amount">{{ __('Amount') }}</label>
                                    {!! Form::text('transaction_amount', alternative_money($billing->budget->amount, '$', 2, ',', '.'),
                                    ['class' => 'form-control ',
                                    'id' => 'transaction_amount', 'placeholder' => __("Amount"), 'readonly']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-transaction_amount"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber">{{ __('Card Number') }}</label>
                                    {!! Form::text('cardNumber', null, ['class' => 'form-control ',
                                    'id' => 'cardNumber', 'placeholder' => __("Card Number"), 'data-checkout' => 'cardNumber',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-cardNumber"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cardholderName">{{ __('Card Holder Name') }}</label>
                                    {!! Form::text('cardholderName', null, ['class' => 'form-control ',
                                    'id' => 'cardholderName', 'placeholder' => __("Card Holder Name"), 'data-checkout' => 'cardholderName']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-cardholderName"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cardExpirationMonth">{{ __('Card Expiration Month') }}</label>
                                    {!! Form::text('cardExpirationMonth', null, ['class' => 'form-control ',
                                    'id' => 'cardExpirationMonth', 'placeholder' => __("Card Expiration Month"), 'data-checkout' => 'cardExpirationMonth',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-cardExpirationMonth"></div>
                                </div>
                                <div class="form-group">
                                    <label for="cardExpirationYear">{{ __('Card Expiration Year') }}</label>
                                    {!! Form::text('cardExpirationYear', null, ['class' => 'form-control ',
                                    'id' => 'cardExpirationYear', 'placeholder' => __("Card Expiration Year"), 'data-checkout' => 'cardExpirationYear',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-cardExpirationYear"></div>
                                </div>
                                <div class="form-group">
                                    <label for="securityCode">{{ __('Security Code') }}</label>
                                    {!! Form::text('securityCode', null, ['class' => 'form-control ',
                                    'id' => 'securityCode', 'placeholder' => __("Security Code"), 'data-checkout' => 'securityCode',
                                    'onselectstart' => 'return false', 'onpaste' => 'return false', 'onCopy' => 'return false',
                                    'onCut' => 'return false', 'onDrag' => 'return false', 'onDrop' => 'return false',
                                    'autocomplete' => 'off']) !!}
                                    <div class="invalid-feedback d-block" id="invalid-securityCode"></div>
                                </div>
                                <div class="form-group">
                                    <label for="installments">{{ __('Installments') }}</label>
                                    {!! Form::select('installments', [], null, ['class' => 'form-control ',
                                    'id' => 'installments', 'placeholder' => __("Installments")]) !!}
                                    <div class="invalid-feedback d-block" id="invalid-installments"></div>
                                </div>
                                <div class="form-group">
                                    <div class="invalid-feedback d-block" id="invalid-card-token"></div>
                                </div>
                                {!! Form::hidden('payment_method_id', null, ['id' => 'payment_method_id']) !!}
                                {!! Form::hidden('billing_id', $billing->id, ['id' => 'billing_id']) !!}
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
                let invalidCardnumber = document.getElementById("invalid-cardNumber");
                invalidCardnumber.innerHTML = response;
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
                    let invalidCardnumber = document.getElementById("invalid-cardNumber");
                    invalidCardnumber.innerHTML = response;
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
                setCodeErrorResponse(response.cause);
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

        function setCodeErrorResponse(cause) {
            var invalidCardnumber = document.getElementById("invalid-cardNumber");
            var cardnumber = document.getElementById("cardNumber");

            var invalidCardExpirationMonth  = document.getElementById("invalid-cardExpirationMonth");
            var cardExpirationMonth  = document.getElementById("cardExpirationMonth");

            var invalidCardExpirationYear = document.getElementById("invalid-cardExpirationYear");
            var cardExpirationYear = document.getElementById("cardExpirationYear");

            var invalidCardholderName = document.getElementById("invalid-cardholderName");
            var cardholderName = document.getElementById("cardholderName");

            var invalidSecurityCode = document.getElementById("invalid-securityCode");
            var securityCode = document.getElementById("securityCode");

            var invalidCardToken = document.getElementById("invalid-card-token");

            var paymentMethodId = document.getElementById("payment_method_id").value;

            cause.forEach(element => {
                switch (element.code) {
                    case '205':
                        invalidCardnumber.innerHTML = 'Digite o número do seu cartão.';
                        cardnumber.classList.add('is-invalid');
                        break;
                    case '208':
                        invalidCardExpirationMonth.innerHTML = 'Escolha um mês.';
                        cardExpirationMonth.classList.add('is-invalid');
                        break;
                    case '209':
                        invalidCardExpirationYear.innerHTML = 'Escolha um ano.';
                        cardExpirationYear.classList.add('is-invalid');
                        break;
                    case '221':
                        invalidCardholderName.innerHTML = 'Digite o nome e sobrenome.';
                        cardholderName.classList.add('is-invalid');
                        break;
                    case '224':
                        invalidSecurityCode.innerHTML = 'Digite o código de segurança.';
                        securityCode.classList.add('is-invalid');
                        break;
                    case 'E301':
                        invalidCardnumber.innerHTML = 'Digite o número do seu cartão.';
                        cardnumber.classList.add('is-invalid');
                        break;
                    case 'E302':
                        invalidSecurityCode.innerHTML = 'Confira o código de segurança.';
                        securityCode.classList.add('is-invalid');
                        break;
                    case '316':
                        invalidCardholderName.innerHTML = 'Por favor, digite um nome válido.';
                        cardholderName.classList.add('is-invalid');
                        break;
                    case '325':
                        invalidCardExpirationMonth.innerHTML = 'Confira a data.';
                        cardExpirationMonth.classList.add('is-invalid');
                        break;
                    case '326':
                        invalidCardExpirationYear.innerHTML = 'Escolha um ano.';
                        cardExpirationYear.classList.add('is-invalid');
                        break;
                    case '106':
                        invalidCardToken.innerHTML = 'Não pode efetuar pagamentos a usuários de outros países.';
                        break;
                    case '109':
                        invalidCardToken.innerHTML = 'O ${paymentMethodId} não processa pagamentos parcelados. Escolha outro cartão ou outra forma de pagamento.';
                        break;
                    case '126':
                        invalidCardToken.innerHTML = 'Não conseguimos processar seu pagamento.';
                        break;
                    case '129':
                        invalidCardToken.innerHTML = 'O ${paymentMethodId} não processa pagamentos para o valor selecionado. Escolha outro cartão ou outra forma de pagamento.';
                        break;
                    case '145':
                        invalidCardToken.innerHTML = 'Uma das partes com a qual está tentando realizar o pagamento é um usuário de teste e a outra é um usuário real.';
                        break;
                    case '150':
                        invalidCardToken.innerHTML = 'Você não pode efetuar pagamentos.';
                        break;
                    case '151':
                        invalidCardToken.innerHTML = 'Você não pode efetuar pagamentos.';
                        break;
                    case '160':
                        invalidCardToken.innerHTML = 'Não conseguimos processar seu pagamento.';
                        break;
                    case '204':
                        invalidCardToken.innerHTML = 'O ${paymentMethodId} não está disponível nesse momento. Escolha outro cartão ou outra forma de pagamento.';
                        break;
                    case '801':
                        invalidCardToken.innerHTML = 'Você realizou um pagamento similar há poucos instantes. Tente novamente em alguns minutos.';
                        break;
                    case 'default':
                        invalidCardToken.innerHTML = 'Não pudemos processar seu pagamento.';
                        break;
                }
            });
        }
    </script>

@stop



