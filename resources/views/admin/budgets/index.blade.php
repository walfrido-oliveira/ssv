@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Budgets') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('layouts.card-header', ['index' => route('admin.budgets.index'), 'create' => route('admin.budgets.create')])
                <div class="card-body table-responsive">
                    <table class="table table-hover table-head-fixed text-nowrap table-search">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>Status</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td><a href="{{ route('admin.budgets.show', ['budget' => $budget->id]) }}">{{ $budget->formattedId }}</a></td>
                                    <td>
                                        <a class="text-limit" href="{{ route('admin.budgets.show', ['budget' => $budget->id]) }}"
                                            title="{{ $budget->client->razao_social }}">{{ $budget->client->razao_social }}</a>
                                    </td>
                                    <td><a href="{{ route('admin.budgets.show', ['budget' => $budget->id]) }}">{{ alternative_money($budget->amount, '$', 2, ',', '.') }}</a></td>
                                    <td class="project-state">
                                        <a href="{{ route('admin.budgets.index', ['status' => $budget->status]) }}">
                                            <span class="badge @if($budget->status == "created") badge-primary @elseif($budget->status == 'approved') badge-success @else badge-danger @endif">
                                                @if($budget->status == "created")
                                                    {{ __('Created') }}
                                                @elseif($budget->status == 'approved')
                                                    {{ __('Approved') }}
                                                @else
                                                    {{ __('Disapproved') }}
                                                @endif
                                            </span>
                                        </a>
                                    </td>
                                    <td width="15%">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.budgets.show', ['budget' => $budget->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-book"></i> {{ __('details') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                        <a href="{{ route('admin.budgets.edit', ['budget' => $budget->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-pencil-alt"></i> {{ __('edit') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-danger btn-sm delete-modal-click" data-toggle="modal" data-target="#delete-modal" data-id={{ $budget->id }}>
                                                <i class="fas fa-trash-alt"></i> {{ __('delete') }}</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $budgets->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to delete this item?') }}</div>
                <div class="modal-footer">
                    <form action="{{route('admin.budgets.destroy', ['budget' => '#'])}}" method="post" id="delete-modal-form">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ mix('js/list.js') }}"></script>
@stop



