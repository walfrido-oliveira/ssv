@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Edit Payment Method') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.payment-methods.update', ['payment_method' => $paymentMethod->id]) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                {!! Form::text('name', $paymentMethod->name, ['class' => 'form-control ' . $errors->first('name','is-invalid'), 'id' => 'name', 'placeholder' => __("Name")]) !!}
                                {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
@stop

