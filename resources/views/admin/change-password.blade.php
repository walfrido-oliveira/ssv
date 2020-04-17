@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Change Password') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.profile.credentials.update', [ 'user' => $user->id ]) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="current-passwo">{{ __('Current Password') }}</label>
                            {!! Form::password('current-password', ['class' => 'form-control ' . $errors->first('current-password','is-invalid'), 'id' => 'current-password', 'placeholder' => __("Current Password")]) !!}
                            {!! $errors->first('current-password','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __("New Password") }}</label>
                            {!! Form::password('password', ['class' => 'form-control ' . $errors->first('password','is-invalid'), 'id' => 'password', 'placeholder' => __("New Password")]) !!}
                            {!! $errors->first('password','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __("Re-enter Password") }}</label>
                            {!! Form::password('password_confirmation', ['class' => 'form-control ' . $errors->first('password_confirmation','is-invalid'), 'id' => 'password_confirmation', 'placeholder' => __("Re-enter Password")]) !!}
                            {!! $errors->first('password_confirmation','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop


