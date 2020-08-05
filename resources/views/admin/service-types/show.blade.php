@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Service Type') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ $serviceType->name }}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($serviceType->created_at) ? $serviceType->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($serviceType->updated_at) ? $serviceType->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 pl-0">
                        <a href="{{ route('admin.service-types.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



