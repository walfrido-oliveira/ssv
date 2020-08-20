@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalBudgets }}">0</h3>
                <p>{{ __('Budgets') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="{{ route('user.budgets.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalOders }}">0</h3>
                <p>{{ __('Orders') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-toolbox"></i>
              </div>
              <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalBillings }}">0</h3>
                <p>{{ __('Billings') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <a href="{{ route('user.billings.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script>
        window.animateValue();
    </script>

@stop


