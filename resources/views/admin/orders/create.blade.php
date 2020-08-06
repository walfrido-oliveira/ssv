@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
<h1 class="m-0 text-dark">{{ __('Add Order Method') }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method("POST")

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
                                    @php
                                        $budgets = App\Models\Budget\Budget::where('id', old('budget_id'))->get()->pluck('id', 'id');
                                    @endphp
                                    <div class="input-group">
                                        {!! Form::select('budget_id', $budgets, old('budget_id'), ['class' => 'select2-with-remote-data ' . $errors->first('budget_id','is-invalid') , 'data-placeholder' => __('Budget')]) !!}
                                        {!! $errors->first('budget_id','<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="client">{{ __('Customer') }}</label>
                                    @php
                                        $clients = App\Models\Client\Client::where('id', old('client_id'))->get()->pluck('nome_fantasia', 'id');
                                    @endphp
                                    {!! Form::select('client_id', $clients, old('client_id'), ['class' => 'select2-with-remote-data ' . $errors->first('client_id','is-invalid') , 'data-placeholder' => __('Customer')]) !!}
                                    {!! $errors->first('client_id','<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observation">{{ __('Observation') }}</label>
                                {!! Form::textarea('observation', null, ['class' => 'form-control ' . $errors->first('observation','is-invalid'), 'rows' => 4, 'id' => 'observation', 'placeholder' => __("Observation")]) !!}
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
                                    @if (old('services'))
                                        @php $index = 0; @endphp
                                        @foreach (old('services') as $service)
                                            <tr id="row-service-{{ $index }}">
                                                <td>{{ $index+1 }}
                                                    <input type="hidden" name="services[{{ $index }}][budget_service_id]" value="{{ $service['budget_service_id'] }}">
                                                    <input type="hidden" name="services[{{ $index }}][service_type_id]" value="{{ $service['service_type_id'] }}">
                                                    <input type="hidden" name="services[{{ $index }}][index]" value="{{ $service['index'] }}">
                                                </td>
                                                <td width="80%">{{ $service['service_name'] }}
                                                    <input type="hidden" name="services[{{ $index }}][service_name]" value="{{ $service['service_name'] }}">
                                                </td>
                                                <td width="80%">{{ $service['executed_at'] }}
                                                    <input type="hidden" name="services[{{ $index }}][executed_at]" value="{{ $service['executed_at'] }}">
                                                </td>
                                                <td width="80%">{{ $service['equipment_id'] }}
                                                    <input type="hidden" name="services[{{ $index }}][equipment_id]" value="{{ $service['equipment_id'] }}">
                                                </td>
                                                <td width="80%">{{ $service['service_type_name'] }}
                                                    <input type="hidden" name="services[{{ $index }}][service_type_name]" value="{{ $service['service_type_name'] }}">
                                                </td>
                                                <td width="80%">{{ $service['description'] }}
                                                    <input type="hidden" name="services[{{ $index }}][description]" value="{{ $service['description'] }}">
                                                </td>
                                                <td width="80%">{{ $service['user_name'] }}
                                                    <input type="hidden" name="services[{{ $index }}][user_name]" value="{{ $service['user_name'] }}">
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
                            {!! Form::select('service', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Service')]) !!}
                        <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            {!! Form::select('service_type', [], null, ['class' => 'select2-with-tag ', 'data-placeholder' => __('Choose a Type Service')]) !!}
                            <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            {!! Form::text('executed_at', old('executed_at'),['class' => 'form-control ' . $errors->first('executed_at','is-invalid') ,
                            'placeholder' => __('Executed at'), 'onfocus' => '(this.type="date")']) !!}
                            <div class="invalid-feedback">{{ __('This field is empty') }}</div>
                        </div>
                        <div class="form-group">
                            {!! Form::text('equipment_id', old('equipment_id'),['class' => 'form-control ' . $errors->first('equipment_id','is-invalid') ,
                            'placeholder' => __('Equipament ID')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::textarea('description', old('description'),['class' => 'form-control ' . $errors->first('description','is-invalid') ,
                            'placeholder' => __('Description')]) !!}
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
