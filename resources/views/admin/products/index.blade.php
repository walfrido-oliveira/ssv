@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Products') }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('Add Product') }}</i></a>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>Status</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td><a href="{{ route('admin.products.show', ['product' => $product->slug]) }}">{{$product->id}}</a></td>
                                    <td><a href="{{ route('admin.products.show', ['product' => $product->slug]) }}">{{$product->name}}</a></td>
                                    <td><a href="{{ route('admin.products.show', ['product' => $product->slug]) }}">{{ alternative_money($product->price, '$', 2, ',') }}</a></td>
                                    <td><a href="{{ route('admin.products.show', ['product' => $product->slug]) }}">{{ number_format($product->amount_in_stock, 0,'', '.') }}</a></td>
                                    <td class="project-state">
                                        <span class="badge badge-{{  $product->amount_in_stock > 0 ? 'success' : 'danger' }}">
                                            {{ $product->amount_in_stock > 0 ? __('In Stoke') : __('Out of Stoke') }}
                                        </span>
                                    </td>
                                    <td width="15%">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.products.show', ['product' => $product->slug]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-book"></i> {{ __('details') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                        <a href="{{ route('admin.products.edit', ['product' => $product->slug]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-pencil-alt"></i> {{ __('edit') }}</i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-danger btn-sm delete-modal-click" data-toggle="modal" data-target="#delete-modal" data-id={{ $product->id }}>
                                                <i class="fas fa-trash-alt"></i> {{ __('delete') }}</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
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
                    <form action="{{route('admin.products.destroy', ['product' => '#'])}}" method="post" id="delete-modal-form">
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



