@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Budget') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.budgets.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

        <div class="content">
            <div class="row">
                <div class="col-sm-3 col-6">
                    <div class="callout callout-info">
                        @php
                            $totalService=0;
                            $totalProduct=0;

                            if (is_array(old('services')))
                            {
                                $totalService = array_map(function($line) {
                                    return $line['total'];
                                }, old('services'));
                                $totalService = array_sum($totalService);
                            }
                            if (is_array(old('products')))
                            {
                                $totalProduct = array_map(function($line) {
                                    return $line['total'];
                                }, old('products'));
                                $totalProduct = array_sum($totalProduct);
                            }

                            $totalBudget = $totalService + $totalProduct;
                        @endphp
                        <h5 class="description-header text-success total-budget">{{ alternative_money($totalBudget, '$', 2, ',') }}</h5>
                        <span class="description-text">{{ __('TOTAL BUDGET') }}</span>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="callout callout-info">
                        <h5 class="description-header text-success total-services">{{ alternative_money($totalService, '$', 2, ',') }}</h5>
                        <span class="description-text">{{ __('TOTAL SERVICES') }}</span>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="callout callout-info">
                        <h5 class="description-header text-success total-products">{{ alternative_money($totalProduct, '$', 2, ',') }}</h5>
                        <span class="description-text">{{ __('TOTAL PRODUCTS') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Budget Info') }}</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label>{{ __('Customer') }}</label>
                                    @php
                                        $clients = App\Models\Client\Client::where('id', old('client_id'))->get()->pluck('nome_fantasia', 'id');
                                    @endphp
                                    {!! Form::select('client_id', $clients, old('client_id'),['class' => 'select2-with-remote-data ' . $errors->first('client_id','is-invalid') , 'data-placeholder' => __('Customer')]) !!}
                                    {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Contact') }}</label>
                                    @php
                                        $contacts = App\Models\Client\Contact\ClientContact::where('id', old('client_contact_id'))->get()->pluck('full_description', 'id');
                                    @endphp
                                    {!! Form::select('client_contact_id', $contacts, old('client_contact_id'), ['class' => 'select2-with-remote-data ' . $errors->first('client_contact_id','is-invalid') , 'data-placeholder' => __('Contact')]) !!}
                                    {!! $errors->first('client_contact_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-2">
                                    <label>{{ __('Validity') }}</label>
                                    {!! Form::date('validity', null,['class' => 'form-control ' . $errors->first('validity','is-invalid') , 'data-placeholder' => __('Validity')]) !!}
                                    {!! $errors->first('validity','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label>{{ __('Budget Type') }}</label>
                                    {!! Form::select('budget_type_id', $budgetTypes, null,['class' => 'select2-with-tag ' . $errors->first('budget_type_id','is-invalid') , 'data-placeholder' => __('Budget Type')]) !!}
                                    {!! $errors->first('budget_type_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Payment Method') }}</label>
                                    {!! Form::select('payment_method_id', $paymentMethods, null,['class' => 'select2-with-tag ' . $errors->first('payment_method_id','is-invalid') , 'data-placeholder' => __('Payment Method')]) !!}
                                    {!! $errors->first('payment_method_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="col-sm-4">
                                    <label>{{ __('Transport Method') }}</label>
                                    {!! Form::select('transport_method_id', $transportMethods, null,['class' => 'select2-with-tag ' . $errors->first('transport_method_id','is-invalid') , 'data-placeholder' => __('Transport Method')]) !!}
                                    {!! $errors->first('transport_method_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control ' . $errors->first('description','is-invalid'), 'rows' => 4, 'id' => 'description', 'placeholder' => __("Description")]) !!}
                                {!! $errors->first('description','<div class="invalid-feedback">:message</div>') !!}
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
                                <button  type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#service-modal">
                                    <i class="fas fa-plus"></i> {{ __('Add Service') }}
                                </button>
                            </div>
                            <table class="table table-hover table-head-fixed text-nowrap table-service">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (old('services'))
                                        @php $index = 0; @endphp
                                        @foreach (old('services') as $service)
                                            <tr id="row-service-{{ $index }}">
                                            <td>{{ $index+1 }}
                                                <input type="hidden" name="services[{{ $index }}][service_id]" value="{{ $service['service_id'] }}">
                                            </td>
                                                <td>{{ old('services')[ $index ]['service_name'] }}
                                                    <input type="hidden" name="services[{{ $index }}][service_name]" value="{{ $service['service_name'] }}">
                                                </td>
                                                <td>{{ alternative_money((float)old('services')[ $index ]['service_price'], '$', 2, ',') }}
                                                    <input type="hidden" name="services[{{ $index }}][service_price]" value="{{ $service['service_price'] }}">
                                                </td>
                                                <td>{{ old('services')[ $index ]['amount'] }}
                                                    <input type="hidden" name="services[{{ $index }}][amount]" value="{{ $service['amount'] }}">
                                                </td>
                                                <td class="total-service-item">{{ alternative_money((float)old('services')[ $index ]['total'], '$', 2, ',') }}
                                                    <input type="hidden" name="services[{{ $index }}][total]" value="{{ $service['total'] }}">
                                                </td>
                                                <td width="15%">
                                                    <a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-{{ $index }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                <button  type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#product-modal">
                                    <i class="fas fa-plus"></i> {{ __('Add Product') }}
                                </button>
                            </div>
                            <table class="table table-hover table-head-fixed text-nowrap table-product">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (old('products'))
                                        @php $index = 0; @endphp
                                        @foreach (old('products') as $product)
                                            <tr id="row-product-{{ $index }}">
                                                <td>{{ $index+1 }}
                                                    <input type="hidden" name="products[{{ $index }}][product_id]" value="{{ $product['product_id'] }}">
                                                </td>
                                                <td>{{ old('products')[ $index ]['product_name'] }}
                                                    <input type="hidden" name="products[{{ $index }}][product_name]" value="{{ $product['product_name'] }}">
                                                </td>
                                                <td>{{ alternative_money((float)old('products')[ $index ]['product_price'], '$', 2, ',') }}
                                                    <input type="hidden" name="products[{{ $index }}][product_price]" value="{{ $product['product_price'] }}">
                                                </td>
                                                <td>{{ old('products')[ $index ]['amount'] }}
                                                    <input type="hidden" name="products[{{ $index }}][amount]" value="{{ $product['amount'] }}">
                                                </td>
                                                <td class="total-product-item">{{ alternative_money((float)old('products')[ $index ]['total'], '$', 2, ',') }}
                                                    <input type="hidden" name="products[{{ $index }}][total]" value="{{ $product['total'] }}">
                                                </td>
                                                <td width="15%">
                                                    <a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-{{ $index }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
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
                    <a href="{{ route('admin.budgets.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary float-right">
                </div>
            </div>
        </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Choose a service and your quantity') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            {!! Form::select('service', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Service')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::number('service_amount', 1, ['class' => 'form-control', 'data-placeholder' => __('Choose a Quantity'), 'min' => '1']) !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-add-service">{{ __('Add') }}</button>
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Choose a product and your quantity') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            {!! Form::select('product', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Product')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::number('product_amount', 1, ['class' => 'form-control', 'data-placeholder' => __('Choose a Quantity'), 'min' => '1']) !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-add-product">{{ __('Add') }}</button>
                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">{{ __('Cancel') }}</button>
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
                    <button type="submit" class="btn btn-primary btn-delete">{{ __('Yes') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ mix('js/budget.js') }}"></script>
@stop

