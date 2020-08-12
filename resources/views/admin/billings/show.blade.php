@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Billing') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h2 class="profile-username text-center">#{{ $billing->id }}</h2>
                            <h3 class="profile-username text-center">{{ $billing->client->nome_fantasia }}</h3>
                            <p class="text-muted text-center">{{ alternative_money($billing->amount, '$', 2, ',', '.') }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($billing->created_at) ? $billing->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($billing->updated_at) ? $billing->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Due Date') }}</b>
                                    <a class="float-right">{{ !is_null($billing->due_date) ? $billing->due_date->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Status') }}</b>
                                    <a class="float-right">
                                        <span class="badge @if($billing->status == "pending") badge-secondary @elseif($billing->status == 'paid') badge-success @else badge-danger @endif">
                                            @if($billing->status == "pending")
                                                {{ __('Pending') }}
                                            @elseif($billing->status == 'paid')
                                                {{ __('Paid') }}
                                            @else
                                                {{ __('Overdue') }}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @if($billing->status == 'paid')
                                    <li class="list-group-item">
                                        <b>{{ __('Paid at') }}</b>
                                        @foreach ($billing->transactionPayments as $payment)
                                            @if ($payment->payment->status == 'approved' &&
                                                 $payment->payment->status_detail == 'accredited')
                                                 @php
                                                     $date_approved = strtotime($payment->payment->date_approved);
                                                 @endphp
                                                <a class="float-right">{{  date('d/m/Y', $date_approved) }}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 pl-0 pr-0">
                        <a href="{{ route('admin.billings.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#billing-info" data-toggle="tab">{{ __('Info') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#services" data-toggle="tab">{{ __('Services') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#products" data-toggle="tab">{{ __('Products') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="billing-info">
                                    <dl>

                                        @php $contact = $billing->budget->clientContact; @endphp

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
                                        <dd>{{ $billing->budget->budgetType->name }}</dd>

                                        <dt>{{ __('Payment Method') }}</dt>
                                        <dd>{{ $billing->budget->paymentMethod->name }}</dd>

                                        <dt>{{ __('Transport Method') }}</dt>
                                        <dd>{{ $billing->budget->transportMethod->name }}</dd>

                                        <dt>{{ __('Description') }}</dt>
                                        <dd>{{ $billing->budget->description }}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane" id="services">
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
                                            @foreach ($billing->budget->services as $service)
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
                                                <td>{{ alternative_money((float)$billing->budget->serviceAmount, '$', 2, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="tab-pane" id="products">
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
                                            @foreach ($billing->budget->products as $product)
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
                                                <td>{{ alternative_money((float)$billing->budget->productAmount, '$', 2, ',', '.') }}</td>
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

@section('js')
@stop



