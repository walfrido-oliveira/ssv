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
                        <form action="{{ route('user.budgets.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" name="q" class="form-control float-right" placeholder="{{ __('Search') }}" value="{{ request()->get('q') }}">
                                <div class="input-group-append">
                                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                                <a class="btn btn-default" href="{{ route('user.budgets.index') }}"><i class="fas fa-redo-alt"></i></a>
                            </div>
                          </form>
                    </div>
                  </div>
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
                                    <td><a href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}">{{ $budget->formattedId }}</a></td>
                                    <td>
                                        <a class="text-limit" href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}"
                                            title="{{ $budget->client->razao_social }}">{{ $budget->client->razao_social }}</a>
                                    </td>
                                    <td><a href="{{ route('user.budgets.show', ['budget' => $budget->id]) }}">{{ alternative_money($budget->amount, '$', 2, ',', '.') }}</a></td>
                                    <td class="project-state">
                                        <a href="{{ route('user.budgets.index', ['status' => $budget->status]) }}">
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
                                        @if($budget->status == "created")
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-success btn-sm approve" data-toggle="modal" data-target="#approve-modal" data-id={{ $budget->id }}>
                                                    <i class="fas fa-check"></i> {{ __('approve') }}</i>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-danger btn-sm disapprove" data-toggle="modal" data-target="#disapprove-modal" data-id={{ $budget->id }}>
                                                    <i class="fas fa-ban"></i> {{ __('disapprove') }}</i>
                                                </a>
                                            </div>
                                        @endif
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
    <div class="modal fade" id="approve-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to approve this budget?') }}</div>
                <div class="modal-footer">
                    <form action="{{route('user.budgets.approve', ['budget' => '#'])}}" method="post" id="approve-modal-form">
                        @csrf
                        @method("PUT")
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="disapprove-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to disapprove this budget?') }}</div>
                <div class="modal-footer">
                    <form action="{{route('user.budgets.disapprove', ['budget' => '#'])}}" method="post" id="disapprove-modal-form">
                        @csrf
                        @method("PUT")
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="{{ mix('js/budget-user.js') }}"></script>
@stop



