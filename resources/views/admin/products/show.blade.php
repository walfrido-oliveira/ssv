@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Product') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid" src="{{ asset($product->imageLink) }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $product->name }}</h3>
                            <p class="text-muted text-center">{{ alternative_money($product->price) }}</p>
                            <p class="text-muted text-center">{{ number_format($product->amount_in_stock, 0,'', '.') }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($product->created_at) ? $product->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($product->updated_at) ? $product->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Category') }}</b>
                                    <a class="float-right">{{ $product->productCategory->name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Status') }}</b>
                                    <a class="float-right">
                                        <span class="badge badge-{{  $product->amount_in_stock > 0 ? 'success' : 'danger' }}">
                                            {{ $product->amount_in_stock > 0 ? __('In Stoke') : __('Out of Stoke') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <h3 class="profile-username">{{ __('Description') }}</h3>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.products.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop



