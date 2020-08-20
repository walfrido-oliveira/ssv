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
                <i class="fas fa-user-plus"></i>
              </div>
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
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalBudgets }}">0</h3>
                <p>{{ __('Budgets') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-bar"></i>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3 class="animated-value" data-animated-value="{{ $totalBudgets }}">0</h3>
                <p>{{ __('Orders') }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-toolbox"></i>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <canvas id="budgetChart"></canvas>
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
                responsive: true,
                maintainAspectRatio: false,
            },
        });
        budgetChart.canvas.parentNode.style.height = '400px';
    </script>
@stop
