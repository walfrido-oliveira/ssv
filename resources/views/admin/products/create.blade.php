@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Product') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <label for="profile_image">{{ __('Image') }}</label>
                                    </div>
                                    <div class="col-3 p-2" id="image_profile_preview_container">
                                        <img class="img-circle elevation-2 image-profine-preview" src="{{ asset('storage/img/empty.png') }}" alt="" id="preview_image_profile">
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" accept="image/x-png,image/jpeg"  class="custom-file-input" id="profile_image" name="image">
                                                <label class="custom-file-label" for="profile_image" id="custom-file-label">{{ __('Choose image') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <label for="name">{{ __('Name') }}</label>
                                    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name','is-invalid'), 'id' => 'name', 'placeholder' => __("Name")]) !!}
                                    {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="price">{{ __('Price') }}</label>
                                    {!! Form::text('price', null, ['class' => 'form-control ' . $errors->first('price','is-invalid'), 'id' => 'price', 'placeholder' => __("Price")]) !!}
                                    {!! $errors->first('price','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <label for="product_category_id">{{ __('Category') }}</label>
                                    {!! Form::select('product_category_id', $categories, null, ['class' => 'select2-with-tag ' . $errors->first('product_category_id','is-invalid') , 'data-placeholder' => __('Category')]) !!}
                                    {!! $errors->first('product_category_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label for="amount_in_stock">{{ __('Initial Stock') }}</label>
                                    {!! Form::number('amount_in_stock', null, ['class' => 'form-control ' . $errors->first('amount_in_stock','is-invalid'), 'id' => 'amount_in_stock', 'placeholder' => __("Initial Stock"), 'step'=>'1']) !!}
                                    {!! $errors->first('amount_in_stock','<div class="invalid-feedback">:message</div>') !!}
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
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="{{ mix('js/image.js') }}"></script>
@stop

