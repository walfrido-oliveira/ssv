@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Budget') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h2 class="profile-username text-center">#{{ $budget->formattedId }}</h2>
                            <h3 class="profile-username text-center">{{ $budget->client->nome_fantasia }}</h3>
                            <p class="text-muted text-center">{{ alternative_money($budget->amount, '$', 2, ',', '.') }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($budget->created_at) ? $budget->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($budget->updated_at) ? $budget->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Validity') }}</b>
                                    <a class="float-right">{{ !is_null($budget->validity) ? $budget->validity->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Status') }}</b>
                                    <a class="float-right">
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
                                </li>
                                @if($budget->status == 'approved')
                                    <li class="list-group-item">
                                        <b>{{ __('Approved at') }}</b>
                                        <a class="float-right">{{ !is_null($budget->approved_at) ? $budget->approved_at->format('d/m/Y') : '' }}</a>
                                    </li>
                                @endif
                                @if($budget->status == 'disapproved')
                                    <li class="list-group-item">
                                        <b>{{ __('Disapproved at') }}</b>
                                        <a class="float-right">{{ !is_null($budget->disapproved_at) ? $budget->disapproved_at->format('d/m/Y') : '' }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 pl-0">
                        <a href="{{ route('admin.budgets.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#budget-info" data-toggle="tab">{{ __('Info') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#services" data-toggle="tab">{{ __('Services') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#products" data-toggle="tab">{{ __('Products') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="budget-info">
                                    <dl>

                                        @php $contact = $budget->clientContact; @endphp

                                        <dt>{{ __('Contact') }}</dt>
                                        <dd><a href="#" class="show-contact-info">{{ $contact->contact }}</a></dd>

                                        <dl class="contact-info" style="display: none;">
                                            <dt>{{ __('Type') }}</dt>
                                            <dd>{{ $contact->contactType->name }}</dd>

                                            <dt class="{{ empty( $contact->department ) ? 'd-none' : '' }}">{{ __('Department') }}</dt>
                                            <dd class="{{ empty( $contact->department ) ? 'd-none' : '' }}">{{ $contact->department }}</dd>

                                            <dt class="{{ empty( $contact->phone ) ? 'd-none' : '' }}">{{ __('Phone')  }}</dt>
                                            <dd class="{{ empty( $contact->phone ) ? 'd-none' : '' }}"><a href="tel:+{{ $contact->phone }}">{{ $contact->phone }}</a></dd>

                                            <dt class="{{ empty( $contact->mobile_phone ) ? 'd-none' : '' }}">{{ __('Mobile Phone')  }}</dt>
                                            <dd class="{{ empty( $contact->mobile_phone ) ? 'd-none' : '' }}">{{ $contact->mobile_phone }}</a></dd>

                                            <dt class="{{ empty( $contact->email ) ? 'd-none' : '' }}">{{ __('Email')  }}</dt>
                                            <dd class="{{ empty( $contact->email ) ? 'd-none' : '' }}"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></dd>
                                        </dl>

                                        <dt>{{ __('Type') }}</dt>
                                        <dd>{{ $budget->budgetType->name }}</dd>

                                        <dt>{{ __('Payment Method') }}</dt>
                                        <dd>{{ $budget->paymentMethod->name }}</dd>

                                        <dt>{{ __('Transport Method') }}</dt>
                                        <dd>{{ $budget->transportMethod->name }}</dd>

                                        <dt>{{ __('Description') }}</dt>
                                        <dd>{{ $budget->description }}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane table-responsive" id="services">
                                    <table class="table table-hover table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Service') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0; @endphp
                                            @foreach ($budget->services as $service)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>{{ alternative_money((float)$service->price, '$', 2, ',', '.') }}</td>
                                                    <td>{{ $service->pivot->amount }}</td>
                                                    <td>{{ alternative_money((float)$service->pivot->amount * $service->price, '$', 2, ',', '.') }}</td>
                                                </tr>
                                                @php $index++; @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>{{ __('Total') }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ alternative_money((float)$budget->serviceAmount, '$', 2, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="tab-pane table-responsive" id="products">
                                    <table class="table table-hover table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0; @endphp
                                            @foreach ($budget->products as $product)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ alternative_money((float)$product->price, '$', 2, ',', '.') }}</td>
                                                    <td>{{ $product->pivot->amount }}</td>
                                                    <td>{{ alternative_money((float)$product->pivot->amount * $product->price, '$', 2, ',', '.') }}</td>
                                                </tr>
                                                @php $index++; @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>{{ __('Total') }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ alternative_money((float)$budget->productAmount, '$', 2, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



