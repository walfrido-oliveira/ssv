@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Profile') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.profile.update', [ 'user' => $user->id ]) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            {!! Form::text('name', old('name', $user->name), ['class' => 'form-control ' . $errors->first('name','is-invalid'), 'id' => 'name', 'placeholder' => __("Name")]) !!}
                            {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __("Email") }}</label>
                            {!! Form::text('email', old('email', $user->email), ['class' => 'form-control ' . $errors->first('email','is-invalid'), 'id' => 'email', 'placeholder' => __("Email")]) !!}
                            {!! $errors->first('email','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <label for="profile_image">{{ __('Profile Image') }}</label>
                                </div>
                                <div class="col-1 pl-2" id="image_profile_preview_container">
                                    <img class="img-circle elevation-2 image-profine-preview" src="{{ asset('storage/'.$user->profile_image) }}" alt="" id="preview_image_profile">
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
                            <label>{{ __('Role') }}</label>
                            {!! Form::select('roles[]', $roles, $userRole,['class' => 'select2 ' . $errors->first('roles','is-invalid') , 'multiple', 'data-placeholder' => __('Select a Role'), 'style' => 'width: 100%;']) !!}
                            {!! $errors->first('roles','<div class="invalid-feedback">:message</div>') !!}
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

@section('js')
    <script>
        var profileImage = document.getElementById('profile_image'),
        preview = document.getElementById('preview_image_profile'),
        container = document.getElementById('image_profile_preview_container'),
        label = document.getElementById('custom-file-label');

        profileImage.addEventListener('change', function() {
            var fileName = this.value.split("\\").pop();
            label.classList.add("selected")
            label.innerHTML = fileName;
            changeImageProfile(this);
        })

        function changeImageProfile(input) {
            var render;

            if (input.files && input.files[0]) {
                render = new FileReader();

                render.onload = function(e) {
                    preview.setAttribute('src', e.target.result);
                }

                render.readAsDataURL(input.files[0]);
                container.style.display = 'block';
            }
        }
    </script>
@stop



