@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Budgets') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                      <div class="input-group input-group-sm">
                        <input type="text" name="table_search" class="form-control float-right input-search" placeholder="{{ __('Search') }}">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-head-fixed text-nowrap table-search">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td><a href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}">{{ $budget->id }}</a></td>
                                    <td><a href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}">{{ $budget->client->razao_social }}</a></td>
                                    <td><a href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}">{{ alternative_money($budget->amount, '$', 2, ',', '.') }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $budgets->links() }}
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="{{ mix('js/list.js') }}"></script>
@stop



