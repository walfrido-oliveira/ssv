@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Order') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h2 class="profile-username text-center">#{{ $order->formattedId }}</h2>
                            <h3 class="profile-username text-center">{{ $order->client->nome_fantasia }}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($order->created_at) ? $order->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($order->updated_at) ? $order->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Status') }}</b>
                                    <a class="float-right">
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
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Budget') }}</b>
                                    <a class="float-right" href="{{ route('admin.budgets.show', ['budget' => $order->budget->id]) }}">{{ '#' . $order->budget->formattedId }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 pl-0">
                        <a href="{{ route('admin.orders.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#order-info" data-toggle="tab">{{ __('Info') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#services" data-toggle="tab">{{ __('Services') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="order-info">
                                    <dl>

                                        @php $contact = $order->budget->clientContact; @endphp

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

                                        <dt>{{ __('Observation') }}</dt>
                                        <dd>{{ $order->observation }}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane table-responsive" id="services">
                                    <table class="table table-hover table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Service') }}</th>
                                                <th>{{ __('Executed at') }}</th>
                                                <th>{{ __('Equipament ID') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Responsible') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0; @endphp
                                            @foreach ($order->services as $service)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $service->service->name }}</td>
                                                    <td>{{ date_format($service->executed_at, 'd/m/Y') }}</td>
                                                    <td>{{ $service->equipment_id }}</td>
                                                    <td>{{ $service->serviceType->name }}</td>
                                                    <td>{{ $service->description }}</td>
                                                    <td>{{ $service->user->name }}</td>
                                                </tr>
                                                @php $index++; @endphp
                                            @endforeach
                                        </tbody>
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



