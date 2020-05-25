@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Edit User') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <label for="profile_image">{{ __('Profile Image') }}</label>
                                    </div>
                                    <div class="col-1 pl-2" id="image_profile_preview_container">
                                        <img class="img-circle elevation-2 image-profine-preview" src="{{ asset( $user->adminlte_image()) }}" alt="" id="preview_image_profile">
                                    </div>
                                    <div class="col-12 mt-1">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" accept="image/x-png,image/jpeg"  class="custom-file-input" id="profile_image" name="profile_image">
                                                <label class="custom-file-label" for="profile_image" id="custom-file-label">{{ __('Choose image') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                {!! Form::text('name', old('name', $user->name), ['class' => 'form-control', 'id' => 'name', 'placeholder' => __("Name"), 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __("Email") }}</label>
                                {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'id' => 'email', 'placeholder' => __("Email"), 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                <label>{{ __('Role') }}</label>
                                {!! Form::select('roles[]', $roles, $userRole,['class' => 'select2 ' . $errors->first('roles','is-invalid') , 'multiple', 'data-placeholder' => __('Select a Role'), 'style' => 'width: 100%;']) !!}
                                {!! $errors->first('roles','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="{{ mix('js/image.js') }}"></script>
@stop

