@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Order Method') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Order Info') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="budget_id">{{ __('Budget') }}</label>
                                    @php
                                        $budgets = App\Models\Budget\Budget::where('id', old('budget_id'))->get()->pluck('id', 'id');
                                    @endphp
                                    <div class="input-group">
                                        {!! Form::select('budget_id', $budgets, old('budget_id'), ['class' => 'select2-with-remote-data ' . $errors->first('budget_id','is-invalid') , 'data-placeholder' => __('Budget')]) !!}
                                        {!! $errors->first('budget_id','<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="client">{{ __('Customer') }}</label>
                                    @php
                                        $clients = App\Models\Client\Client::where('id', old('client_id'))->get()->pluck('nome_fantasia', 'id');
                                    @endphp
                                    {!! Form::select('client_id', $clients, old('client_id'), ['class' => 'select2-with-remote-data ' . $errors->first('client_id','is-invalid') , 'data-placeholder' => __('Customer')]) !!}
                                    {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observation">{{ __('Observation') }}</label>
                                {!! Form::textarea('observation', null, ['class' => 'form-control ' . $errors->first('observation','is-invalid'), 'rows' => 4, 'id' => 'observation', 'placeholder' => __("Observation")]) !!}
                                {!! $errors->first('observation','<div class="invalid-feedback">:message</div>') !!}
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
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="{{ mix('js/order.js') }}"></script>
@stop
