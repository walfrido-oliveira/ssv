@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Billings') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('layouts.card-header', ['index' => route('admin.billings.index')])
                <div class="card-body table-responsive">
                    <table class="table table-hover table-head-fixed text-nowrap table-search">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Billing Date') }}</th>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billings as $billing)
                                <tr>
                                    <td><a href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}">{{ $billing->formattedId }}</a></td>
                                    <td>
                                        <a class="text-limit" href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}"
                                            title="{{ $billing->client->razao_social }}">{{ $billing->client->razao_social }}</a>
                                    </td>
                                    <td><a href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}">{{ date_format($billing->created_at, 'd/m/Y') }}</a></td>
                                    <td><a href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}">{{ date_format($billing->due_date, 'd/m/Y') }}</a></td>
                                    <td><a href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}">{{ alternative_money($billing->amount, '$', 2, ',', '.') }}</a></td>
                                    <td class="project-state">
                                        <a href="{{ route('admin.billings.index', ['status' => $billing->status]) }}">
                                            <span class="badge @if($billing->status == "pending") badge-secondary @elseif($billing->status == 'paid') badge-success @else badge-danger @endif">
                                                @if($billing->status == "pending")
                                                    {{ __('Pending') }}
                                                @elseif($billing->status == 'paid')
                                                    {{ __('Paid') }}
                                                @else
                                                    {{ __('In Process') }}
                                                @endif
                                            </span>
                                        </a>
                                    </td>
                                    <td width="15%">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.billings.show', ['billing' => $billing->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-book"></i> {{ __('details') }}</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $billings->links() }}
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
@stop



