@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Service') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <label for="name">{{ __('Name') }}</label>
                                    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'), 'id' => 'name', 'placeholder' => __("Name")]) !!}
                                    {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="price">{{ __('Price') }}</label>
                                    {!! Form::number('price', null, ['class' => 'form-control ' . $errors->first('price','is-invalid'), 'id' => 'price', 'placeholder' => __("Price"), 'step'=>'any']) !!}
                                    {!! $errors->first('price','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control ' . $errors->first('description','is-invalid'), 'rows' => 4, 'id' => 'description', 'placeholder' => __("A short description for this company (do not required)")]) !!}
                                {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
@stop

