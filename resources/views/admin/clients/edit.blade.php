@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Add Customer') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.clients.update', ['client' => $client->id]) }}" method="POST" enctype="multipart/form-data">

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
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <label for="profile_image">{{ __('Logo') }}</label>
                                    </div>
                                    <div class="col-3 p-2" id="image_profile_preview_container">
                                        <img class="img-circle elevation-2 image-profine-preview" src="{{ asset($client->image) }}" alt="" id="preview_image_profile">
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" accept="image/x-png,image/jpeg"  class="custom-file-input" id="profile_image" name="logo">
                                                <label class="custom-file-label" for="profile_image" id="custom-file-label">{{ __('Choose image') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nome_fantasia">{{ __('Fancy Name') }}</label>
                                {!! Form::text('nome_fantasia', $client->nome_fantasia, ['class' => 'form-control ' . $errors->first('nome_fantasia','is-invalid'), 'id' => 'nome_fantasia', 'placeholder' => __("Fancy Name")]) !!}
                                {!! $errors->first('nome_fantasia','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-9">
                                    <label for="razao_social">{{ __('Company Name') }}</label>
                                    {!! Form::text('razao_social', $client->razao_social, ['class' => 'form-control ' . $errors->first('razao_social','is-invalid'), 'id' => 'razao_social', 'placeholder' => __("Company Name")]) !!}
                                    {!! $errors->first('razao_social','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-3">
                                    <label for="type">{{ __('Company Type') }}</label>
                                    {!! Form::select('type', ['PJ' => 'PJ', 'PF' => 'PF'], $client->type, ['class' => 'form-control custom-select ' . $errors->first('roles','is-invalid') , 'data-placeholder' => __('Select a Role')]) !!}
                                    {!! $errors->first('type','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="client_id">{{ __('Customer ID') }}</label>
                                {!! Form::text('client_id', $client->client_id, ['class' => 'form-control ' . $errors->first('client_id','is-invalid'), 'id' => 'client_id', 'placeholder' => __("Customer ID (only numbers)")]) !!}
                                {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="im">{{ __('IM') }}</label>
                                    {!! Form::text('im', $client->im, ['class' => 'form-control ' . $errors->first('im','is-invalid'), 'id' => 'im', 'placeholder' => __("IM")]) !!}
                                    {!! $errors->first('im','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-6">
                                    <label for="ie">{{ __('IE') }}</label>
                                    {!! Form::text('ie', $client->ie, ['class' => 'form-control ' . $errors->first('ie','is-invalid'), 'id' => 'ie', 'placeholder' => __("IE")]) !!}
                                    {!! $errors->first('ie','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Client Activity') }}</label>
                                {!! Form::select('activity_id', $activities, $client->activity->id,['class' => 'select2-with-tag ' . $errors->first('roles','is-invalid') , 'data-placeholder' => __('Select a Role'), 'style' => 'width: 100%;']) !!}
                                {!! $errors->first('roles','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="home_page">{{ __('Home Page') }}</label>
                                {!! Form::text('home_page', $client->home_page, ['class' => 'form-control ' . $errors->first('home_page','is-invalid'), 'id' => 'home_page', 'placeholder' => __("Home Page")]) !!}
                                {!! $errors->first('home_page','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                {!! Form::textarea('description', $client->description, ['class' => 'form-control ' . $errors->first('description','is-invalid'), 'rows' => 4, 'id' => 'description', 'placeholder' => __("A short description for this company (do not required)")]) !!}
                                {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
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
                                    {!! Form::text('adress', $client->adress, ['class' => 'form-control ' . $errors->first('adress','is-invalid'), 'id' => 'adress', 'placeholder' => __("Ex.:Street,Avenue,Etc...")]) !!}
                                    {!! $errors->first('adress','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="adress_number">{{ __('Adress Number') }}</label>
                                    {!! Form::text('adress_number', $client->adress_number, ['class' => 'form-control ' . $errors->first('adress_number','is-invalid'), 'id' => 'razao_social', 'placeholder' => __("If there is no number set 0")]) !!}
                                    {!! $errors->first('adress_number','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adress_comp">{{ __('Complement') }}</label>
                                {!! Form::text('adress_comp', $client->adress_comp, ['class' => 'form-control ' . $errors->first('adress_comp','is-invalid'), 'id' => 'adress_comp', 'placeholder' => __("Ex.:Apt. # 250...")]) !!}
                                {!! $errors->first('adress_comp','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="adress_district">{{ __('District') }}</label>
                                {!! Form::text('adress_district', $client->adress_district, ['class' => 'form-control ' . $errors->first('adress_district','is-invalid'), 'id' => 'adress_district', 'placeholder' => __("District")]) !!}
                                {!! $errors->first('adress_district','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="adress_city">{{ __('City') }}</label>
                                    {!! Form::text('adress_city', $client->adress_city, ['class' => 'form-control ' . $errors->first('adress_city','is-invalid'), 'id' => 'adress_city', 'placeholder' => __("City")]) !!}
                                    {!! $errors->first('adress_city','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-6">
                                    <label for="adress_state">{{ __('State') }}</label>
                                    {!! Form::select('adress_state', $ufs, $client->adress_state, ['class' => 'form-control custom-select ' . $errors->first('adress_state','is-invalid') , 'data-placeholder' => __('State')]) !!}
                                    {!! $errors->first('adress_state','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adress_cep">{{ __('Zip code') }}</label>
                                {!! Form::text('adress_cep', $client->adress_cep, ['class' => 'form-control ' . $errors->first('adress_cep','is-invalid'), 'id' => 'adress_cep', 'placeholder' => __("Only numbers")]) !!}
                                {!! $errors->first('adress_cep','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 contact">
                    @php $index = 0; @endphp
                    @foreach ($client->contacts as $contact)
                            <input type="hidden" name="contacts[{{$index}}][id]" value="{{ $contact->id }}">
                            <div class="card card-primary entry">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Contact') }}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="contact_type_id">{{ __('Contact Type') }}</label>
                                    {!! Form::select('contacts['.$index.'][contact_type_id]', $contactType, $contact->contactType, ['class' => 'form-control custom-select ' . $errors->first('contacts.*.contact_type_id]','is-invalid') , 'data-placeholder' => __('Contact Type')]) !!}
                                    {!! $errors->first('contacts.*.contact_type_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="contact">{{ __('Contact') }}</label>
                                    {!! Form::text('contacts['.$index.'][contact]', $contact->contact, ['class' => 'form-control ' . $errors->first('contacts.*.contact','is-invalid'), 'id' => 'contact', 'placeholder' => __("Contact")]) !!}
                                    {!! $errors->first('contacts.*.contact','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="department">{{ __('Department') }}</label>
                                    {!! Form::text('contacts['.$index.'][department]', $contact->department, ['class' => 'form-control ' . $errors->first('contacts.*.department','is-invalid'), 'id' => 'department', 'placeholder' => __("Department")]) !!}
                                    {!! $errors->first('contacts.*.department','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    {!! Form::tel('contacts['.$index.'][phone]', $contact->phone, ['class' => 'form-control ' . $errors->first('contacts.*.phone','is-invalid'), 'id' => 'phone', 'placeholder' => __("Phone")]) !!}
                                    {!! $errors->first('contacts.*.phone','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="mobile_phone">{{ __('Mobile Phone') }}</label>
                                    {!! Form::tel('contacts['.$index.'][mobile_phone]', $contact->mobile_phone, ['class' => 'form-control ' . $errors->first('contacts.*.mobile_phone','is-invalid'), 'id' => 'mobile_phone', 'placeholder' => __("Mobile Phone")]) !!}
                                    {!! $errors->first('contacts.*.mobile_phone','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    {!! Form::email('contacts['.$index.'][email]', $contact->email, ['class' => 'form-control ' . $errors->first('contacts.*.email','is-invalid'), 'id' => 'email', 'placeholder' => __("Email")]) !!}
                                    {!! $errors->first('contacts.*.email','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="card-footer">
                                @if ($client->contacts->count() > 1)
                                    @if ($index == 0)
                                        <button type="button" class="btn btn-primary btn-add" disabled><i class="fas fa-plus"></i></button>
                                        <button type="button" class="btn btn-primary btn-remove btn-danger"
                                                data-url="{{ route('admin.contacts.destroy', ['contact' => $contact->id])}}"
                                                data-id="{{ $contact->id}}" data-toggle="modal" data-target="#delete-modal">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-add"><i class="fas fa-plus"></i></button>
                                        <button type="button" class="btn btn-primary btn-remove btn-danger"
                                                data-url="{{ route('admin.contacts.destroy', ['contact' => $contact->id])}}"
                                                data-id="{{ $contact->id}}" data-toggle="modal" data-target="#delete-modal">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-primary btn-add"><i class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-primary btn-remove btn-danger" disabled
                                            data-url="{{ route('admin.contacts.destroy', ['contact' => $contact->id])}}"
                                            data-id="{{ $contact->id}}" data-toggle="modal" data-target="#delete-modal">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        @php $index++; @endphp
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.clients.index')}}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to delete this item?') }}</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-modal-delete-yes">{{ __('Yes') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ mix('js/client.js') }}"></script>
    <script src="{{ mix('js/image.js') }}"></script>
@stop
