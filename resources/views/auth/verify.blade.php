@extends('layouts.login')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-logo">
                <a href="{{ $dashboard_url }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            </div>
            <div class="card form-login">

                <div class="form-content-login pb-4">

                    <p class="login-box-msg">{{ __('adminlte::adminlte.verify_message') }}</p>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('adminlte::adminlte.verify_email_sent') }}
                        </div>
                    @endif

                    {{ __('adminlte::adminlte.verify_check_your_email') }}
                    {{ __('adminlte::adminlte.verify_if_not_recieved') }},

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('adminlte::adminlte.verify_request_another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
