@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Customer') }}</h1>
@stop

@section('content')

    @include('flash::message')

    <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="content">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Company Info') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                          </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nome_fantasia">{{ __('Fancy Name') }}</label>
                                {!! Form::text('nome_fantasia', null, ['class' => 'form-control ' . $errors->first('nome_fantasia','is-invalid'), 'id' => 'nome_fantasia', 'placeholder' => __("Fancy Name")]) !!}
                                {!! $errors->first('nome_fantasia','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-9">
                                    <label for="razao_social">{{ __('Company Name') }}</label>
                                    {!! Form::text('razao_social', null, ['class' => 'form-control ' . $errors->first('razao_social','is-invalid'), 'id' => 'razao_social', 'placeholder' => __("Company Name")]) !!}
                                    {!! $errors->first('razao_social','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-3">
                                    <label for="type">{{ __('Company Type') }}</label>
                                    {!! Form::select('roles[]', ['PJ' => 'PJ', 'PF' => 'PF'], null, ['class' => 'form-control custom-select ' . $errors->first('roles','is-invalid') , 'data-placeholder' => __('Select a Role')]) !!}
                                    {!! $errors->first('type','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="client_id">{{ __('Customer ID') }}</label>
                                {!! Form::text('client_id', null, ['class' => 'form-control ' . $errors->first('client_id','is-invalid'), 'id' => 'client_id', 'placeholder' => __("Customer ID (only digits)")]) !!}
                                {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="im">{{ __('IM') }}</label>
                                    {!! Form::text('im', null, ['class' => 'form-control ' . $errors->first('im','is-invalid'), 'id' => 'im', 'placeholder' => __("IM")]) !!}
                                    {!! $errors->first('im','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-6">
                                    <label for="ie">{{ __('IE') }}</label>
                                    {!! Form::text('ie', null, ['class' => 'form-control ' . $errors->first('ie','is-invalid'), 'id' => 'ie', 'placeholder' => __("IE")]) !!}
                                    {!! $errors->first('ie','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="home_page">{{ __('Home Page') }}</label>
                                {!! Form::text('home_page', null, ['class' => 'form-control ' . $errors->first('home_page','is-invalid'), 'id' => 'home_page', 'placeholder' => __("Home Page")]) !!}
                                {!! $errors->first('home_page','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control ' . $errors->first('description','is-invalid'), 'rows' => 4, 'id' => 'description', 'placeholder' => __("A short description for this company (do not required)")]) !!}
                                {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Adress') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                          </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <label for="adress">{{ __('Street') }}</label>
                                    {!! Form::text('adress', null, ['class' => 'form-control ' . $errors->first('adress','is-invalid'), 'id' => 'adress', 'placeholder' => __("Ex.:Street,Avenue,Etc...")]) !!}
                                    {!! $errors->first('adress','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="adress_number">{{ __('Adress Number') }}</label>
                                    {!! Form::text('adress_number', null, ['class' => 'form-control ' . $errors->first('adress_number','is-invalid'), 'id' => 'razao_social', 'placeholder' => __("If there is no number set 0")]) !!}
                                    {!! $errors->first('adress_number','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adress_comp">{{ __('Complement') }}</label>
                                {!! Form::text('adress_comp', null, ['class' => 'form-control ' . $errors->first('adress_comp','is-invalid'), 'id' => 'adress_comp', 'placeholder' => __("Ex.:Apt. # 250...")]) !!}
                                {!! $errors->first('adress_comp','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="adress_district">{{ __('District') }}</label>
                                {!! Form::text('adress_district', null, ['class' => 'form-control ' . $errors->first('adress_district','is-invalid'), 'id' => 'adress_district', 'placeholder' => __("District")]) !!}
                                {!! $errors->first('adress_district','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <label for="adress_city">{{ __('City') }}</label>
                                    {!! Form::text('adress_city', null, ['class' => 'form-control ' . $errors->first('adress_city','is-invalid'), 'id' => 'adress_city', 'placeholder' => __("City")]) !!}
                                    {!! $errors->first('adress_city','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="adress_state">{{ __('State') }}</label>
                                    {!! Form::text('adress_state', null, ['class' => 'form-control ' . $errors->first('adress_state','is-invalid'), 'id' => 'adress_state', 'placeholder' => __("State")]) !!}
                                    {!! $errors->first('adress_state','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="#" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop


