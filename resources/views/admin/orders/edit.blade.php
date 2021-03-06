@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Edit Order') . ' - #' . $order->formattedId }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.orders.update', ['order' => $order->id]) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("PUT")

        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Order Info') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="budget_id">{{ __('Budget') }}</label>
                                    <div class="input-group">
                                        {!! Form::select('budget_id', $budgets, $order->budget_id, ['class' => 'select2-with-remote-data ' . $errors->first('budget_id','is-invalid') , 'data-placeholder' => __('Budget')]) !!}
                                        {!! $errors->first('budget_id','<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="client">{{ __('Customer') }}</label>
                                    {!! Form::select('client_id', $clients, $order->client_id, ['class' => 'select2-with-remote-data ' . $errors->first('client_id','is-invalid') , 'data-placeholder' => __('Customer')]) !!}
                                    {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observation">{{ __('Observation') }}</label>
                                {!! Form::textarea('observation', $order->observation, ['class' => 'form-control ' . $errors->first('observation','is-invalid'), 'rows' => 4, 'id' => 'observation', 'placeholder' => __("Observation")]) !!}
                                {!! $errors->first('observation','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Services') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="col-12 p-2">
                                <button  type="button" class="btn btn-sm btn-primary add-service" data-toggle="modal" data-target="#service-modal">
                                    <i class="fas fa-plus"></i> {{ __('Add Service') }}
                                </button>
                            </div>
                            <table class="table table-hover table-head-fixed text-nowrap table-service">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Executed at') }}</th>
                                        <th>{{ __('Equipament ID') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Responsible') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($order->services)
                                        @php $index = 0; @endphp
                                        @foreach ($order->services as $service)
                                            <tr id="row-service-{{ $index }}" data-row="{{ $index }}">
                                                <td>{{ $index+1 }}
                                                    <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                                                    <input type="hidden" name="services[{{ $index }}][budget_id]" value="{{ $service->budget_id }}">
                                                    <input type="hidden" name="services[{{ $index }}][budget_service_id]" value="{{ $service->budget_service_id }}">
                                                    <input type="hidden" name="services[{{ $index }}][service_type_id]" value="{{ $service->service_type_id }}">
                                                    <input type="hidden" name="services[{{ $index }}][index]" value="{{ $service->index }}">
                                                </td>
                                                <td width="80%">{{ $service->service->name}}
                                                    <input type="hidden" name="services[{{ $index }}][service_name]" value="{{ $service->service->name }}">
                                                </td>
                                                <td width="80%">{{ date_format($service->executed_at, 'd/m/Y') }}
                                                    <input type="hidden" name="services[{{ $index }}][executed_at]" value="{{ date_format($service->executed_at, 'Y-m-d') }}">
                                                </td>
                                                <td width="80%">{{ $service->equipment_id }}
                                                    <input type="hidden" name="services[{{ $index }}][equipment_id]" value="{{ $service->equipment_id }}">
                                                </td>
                                                <td width="80%">{{ $service->serviceType->name }}
                                                    <input type="hidden" name="services[{{ $index }}][service_type_name]" value="{{ $service->serviceType->name }}">
                                                </td>
                                                <td width="80%" class="cell-wrap">{{ $service->description }}
                                                    <input type="hidden" name="services[{{ $index }}][description]" value="{{ $service->description }}">
                                                </td>
                                                <td width="80%">{{ $service->user->name  }}
                                                    <input type="hidden" name="services[{{ $index }}][user_name]" value="{{ $service->user->name }}">
                                                </td>
                                                <td width="15%">
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-secondary btn-sm btn-edit-service" data-toggle="modal" data-target="#service-modal" data-row="row-service-{{ $index }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-{{ $index }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Products') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="col-12 p-2">
                                <button  type="button" class="btn btn-sm btn-primary add-product" data-toggle="modal" data-target="#product-modal">
                                    <i class="fas fa-plus"></i> {{ __('Add Product') }}
                                </button>
                            </div>
                            <table class="table table-hover table-head-fixed text-nowrap table-product">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Responsible') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($order->products)
                                        @php $index = 0; @endphp
                                        @foreach ($order->products as $product)
                                            <tr id="row-product-{{ $index }}" data-row="{{ $index }}">
                                                <td>{{ $index+1 }}
                                                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                                    <input type="hidden" name="products[{{ $index }}][budget_id]" value="{{ $product->budget_id }}">
                                                    <input type="hidden" name="products[{{ $index }}][budget_product_id]" value="{{ $product->budget_product_id }}">
                                                    <input type="hidden" name="products[{{ $index }}][index]" value="{{ $product->index }}">
                                                </td>
                                                <td width="80%">{{ $product->product->name}}
                                                    <input type="hidden" name="products[{{ $index }}][product_name]" value="{{ $product->product->name }}">
                                                </td>
                                                <td width="80%" class="cell-wrap">{{ $product->description }}
                                                    <input type="hidden" name="products[{{ $index }}][description]" value="{{ $product->description }}">
                                                </td>
                                                <td width="80%">{{ $product->user->name  }}
                                                    <input type="hidden" name="products[{{ $index }}][user_name]" value="{{ $product->user->name }}">
                                                </td>
                                                <td width="15%">
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-secondary btn-sm btn-edit-product" data-toggle="modal" data-target="#product-modal" data-row="row-product-{{ $index }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-{{ $index }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 card-footer">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>

     <!-- service-modal -->
     <div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Add Service') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="service">{{ __('Service') }}</label>
                            {!! Form::select('service', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Service')]) !!}
                        <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="service_type">{{ __('Service Type') }}</label>
                            {!! Form::select('service_type', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Type Service')]) !!}
                            <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="executed_at">{{ __('Executed at') }}</label>
                            {!! Form::date('executed_at', old('executed_at'),['class' => 'form-control ' . $errors->first('executed_at','is-invalid') ,
                            'placeholder' => __('Executed at')]) !!}
                            <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="equipment_id">{{ __('Equipament ID') }}</label>
                            {!! Form::text('equipment_id', old('equipment_id'),['class' => 'form-control ' . $errors->first('equipment_id','is-invalid') ,
                            'placeholder' => __('Equipament ID')]) !!}
                        </div>
                        <div class="form-group">
                            <label for="service-description">{{ __('Description') }}</label>
                            {!! Form::textarea('service-description', old('service-description'),['class' => 'form-control ' . $errors->first('service-description','is-invalid') ,
                            'placeholder' => __('Description')]) !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-add-service">{{ __('OK') }}</button>
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- product-modal -->
    <div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Add Product') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="product">{{ __('Product') }}</label>
                            {!! Form::select('product', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Product')]) !!}
                            <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="product-description">{{ __('Description') }}</label>
                            {!! Form::textarea('product-description', old('description'),['class' => 'form-control ' . $errors->first('description','is-invalid') ,
                            'placeholder' => __('Description')]) !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-add-product">{{ __('OK') }}</button>
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete-modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">{{ __('Do you really want to delete this item?') }}</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-delete">{{ __('Yes') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script> var CURRENT_USER = '{{ auth()->user()->name }}'; </script>
    <script src="{{ mix('js/order.js') }}"></script>
@stop
