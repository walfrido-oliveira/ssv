@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 class="text-white animated-value" data-animated-value="{{ $totalUsers }}">0</h3>
                <p class="text-white">{{ __('Users') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <a href="{{ route('admin.users.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalClients }}">0</h3>
                <p>{{ __('Customers') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('admin.clients.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 class="animated-value primary-value" data-animated-value="{{ $totalBudgets }}">0</h3>
                <h3 class="second-value" style="display: none">{{ alternative_money($amountBudgets, '$', '2', ',') }}</h3>
                <p>{{ __('Budgets') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="{{ route('admin.budgets.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
              <a href="{{ route('admin.orders.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3  class="card-title">{{ __('Budgets Reports') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-6">
                        <canvas id="budgetChart"  width="500" height="250"></canvas>
                    </div>
                    <div class="col-6">

                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        window.animateValue();
    </script>

    <script>
        var months = @json($months);
        var label = '{!! $label !!}';
        var totalBudgetMonth = @json($totalBbudgetMonth);
        var ctx = document.getElementById('budgetChart').getContext('2d');
        var budgetChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: label,
                    data: totalBudgetMonth,
                    backgroundColor: [
                        '#74a5c2'
                    ],
                    borderColor: [
                        '#3c8dbc'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                },
                responsive: false,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            },
        });
    </script>
@stop
