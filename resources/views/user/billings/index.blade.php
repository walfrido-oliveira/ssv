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
                                    <td><a href="{{ route('user.billings.show', ['billing' => $billing->id]) }}">{{ $billing->formattedId }}</a></td>
                                    <td><a href="{{ route('user.billings.show', ['billing' => $billing->id]) }}">{{ date_format($billing->created_at, 'd/m/Y') }}</a></td>
                                    <td><a href="{{ route('user.billings.show', ['billing' => $billing->id]) }}">{{ date_format($billing->due_date, 'd/m/Y') }}</a></td>
                                    <td><a href="{{ route('user.billings.show', ['billing' => $billing->id]) }}">{{ alternative_money($billing->amount, '$', 2, ',', '.') }}</a></td>
                                    <td class="project-state">
                                        <span class="badge @if($billing->status == "pending") badge-secondary @elseif($billing->status == 'paid') badge-success @else badge-danger @endif">
                                            @if($billing->status == "pending")
                                                {{ __('Pending') }}
                                            @elseif($billing->status == 'paid')
                                                {{ __('Paid') }}
                                            @else
                                                {{ __('Overdue') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td width="15%">
                                        @if($billing->status == "created")
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-success btn-sm approve" data-toggle="modal" data-target="#approve-modal" data-id={{ $billing->id }}>
                                                    <i class="fas fa-check"></i> {{ __('approve') }}</i>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-danger btn-sm disapprove" data-toggle="modal" data-target="#disapprove-modal" data-id={{ $billing->id }}>
                                                    <i class="fas fa-ban"></i> {{ __('disapprove') }}</i>
                                                </a>
                                            </div>
                                        @endif
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



