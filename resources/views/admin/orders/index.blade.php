@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Orders') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('layouts.card-header', ['index' => route('admin.orders.index'), 'create' => route('admin.orders.create')])
                <div class="card-body table-responsive">
                    <table class="table table-hover table-head-fixed text-nowrap table-search">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Customer') }}</th>
                                <th>Status</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', ['order' => $order->id]) }}">{{ $order->formattedId }}</a></td>
                                    <td>
                                        <a class="text-limit" href="{{ route('admin.orders.show', ['order' => $order->id]) }}" title="{{ $order->client->razao_social }}">{{ $order->client->razao_social }}</a>
                                    </td>
                                    <td class="project-state">
                                        <a href="{{ route('admin.orders.index', ['status' => $order->status]) }}">
                                            <span class="badge @if($order->status == "created") badge-primary @elseif($order->status == 'approved') badge-success @else badge-danger @endif">
                                                @if($order->status == "created")
                                                    {{ __('Created') }}
                                                @elseif($order->status == 'approved')
                                                    {{ __('Approved') }}
                                                @else
                                                    {{ __('Disapproved') }}
                                                @endif
                                            </span>
                                        </a>
                                    </td>
                                    <td width="15%">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-book"></i> {{ __('details') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                        <a href="{{ route('admin.orders.edit', ['order' => $order->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-pencil-alt"></i> {{ __('edit') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-danger btn-sm delete-modal-click" data-toggle="modal" data-target="#delete-modal" data-id={{ $order->id }}>
                                                <i class="fas fa-trash-alt"></i> {{ __('delete') }}</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
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
                    <form action="{{route('admin.orders.destroy', ['order' => '#'])}}" method="post" id="delete-modal-form">
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



