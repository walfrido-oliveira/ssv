@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Customers') }}</h1>
@stop

@section('content')

    @include('flash::message')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->nome_fantasia}}</td>
                                    <td width="15%">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-book"></i> {{ __('details') }}</i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-pencil-alt"></i> {{ __('edit') }}</i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-danger btn-sm delete-modal-click" data-toggle="modal" data-target="#delete-modal" data-id={{ $client->id }}>
                                                <i class="fas fa-trash-alt"></i> {{ __('delete') }}</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clients->links() }}
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
                    <form action="{{route('admin.clients.destroy', ['client' => '#'])}}" method="post" id="delete-modal-form">
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


