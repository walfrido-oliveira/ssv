@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Budget') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.budgets.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Budget Info') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label>{{ __('Customer') }}</label>
                                    {!! Form::select('client_id', [], null,['class' => 'select2-with-remote-data ' . $errors->first('client_id','is-invalid') , 'data-placeholder' => __('Customer')]) !!}
                                    {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Contact') }}</label>
                                    {!! Form::select('client_contact_id', [], null,['class' => 'select2-with-remote-data ' . $errors->first('client_contact_id','is-invalid') , 'data-placeholder' => __('Contact')]) !!}
                                    {!! $errors->first('client_contact_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-2">
                                    <label>{{ __('Validity') }}</label>
                                    {!! Form::date('validity', null,['class' => 'form-control ' . $errors->first('validity','is-invalid') , 'data-placeholder' => __('Validity')]) !!}
                                    {!! $errors->first('validity','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label>{{ __('Budget Type') }}</label>
                                    {!! Form::select('budget_type_id', $budgetTypes, null,['class' => 'select2-with-tag ' . $errors->first('budget_type_id','is-invalid') , 'data-placeholder' => __('Budget Type')]) !!}
                                    {!! $errors->first('budget_type_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Payment Method') }}</label>
                                    {!! Form::select('payment_method_id', $paymentMethods, null,['class' => 'select2-with-tag ' . $errors->first('payment_method_id','is-invalid') , 'data-placeholder' => __('Payment Method')]) !!}
                                    {!! $errors->first('payment_method_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Transport Method') }}</label>
                                    {!! Form::select('transport_method_id', $transportMethods, null,['class' => 'select2-with-tag ' . $errors->first('transport_method_id','is-invalid') , 'data-placeholder' => __('Transport Method')]) !!}
                                    {!! $errors->first('transport_method_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control ' . $errors->first('description','is-invalid'), 'rows' => 4, 'id' => 'description', 'placeholder' => __("Description")]) !!}
                                {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Services') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Products') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.budgets.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="{{ mix('js/budget.js') }}"></script>
@stop

