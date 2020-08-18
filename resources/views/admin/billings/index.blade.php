@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Billings') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <form action="{{ route('admin.billings.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" name="q" class="form-control float-right" placeholder="{{ __('Search') }}" value="{{ request()->get('q') }}">
                                <div class="input-group-append">
                                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                                <a class="btn btn-default" href="{{ route('admin.billings.index') }}"><i class="fas fa-redo-alt"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="approve-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to approve this billing?') }}</div>
                <div class="modal-footer">
                    <form action="" method="post" id="approve-modal-form">
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
                <div class="modal-body">{{ __('Do you really want to disapprove this billing?') }}</div>
                <div class="modal-footer">
                    <form action="" method="post" id="disapprove-modal-form">
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
@stop



