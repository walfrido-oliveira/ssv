@extends('adminlte::page')

@section('title', config('app.name', 'SSV') )

@section('content_header')
    <h1 class="m-0 text-dark">{{ __('Details Customer') }}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid" src="{{ asset($client->image) }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $client->nome_fantasia }}</h3>
                            <p class="text-muted text-center">{{ $client->razao_social }}</p>
                            <p class="text-muted text-center">
                                @if($client->type == 'PJ')
                                    {{mask($client->client_id, '##.###.###/####-##')}}
                                @else
                                    {{mask($client->client_id, '###.###.###-##')}}
                                @endif
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{ __('Created at') }}</b>
                                    <a class="float-right">{{ !is_null($client->created_at) ? $client->created_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Updated at') }}</b>
                                    <a class="float-right">{{ !is_null($client->updated_at) ? $client->updated_at->format('d/m/Y') : '' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Status') }}</b>
                                    <a class="float-right">
                                        <span class="badge badge-{{  $client->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $client->status == 'active' ? __('Active') : __('Disabled') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 pl-0">
                        <a href="{{ route('admin.clients.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#company-info" data-toggle="tab">{{ __('Company Info') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#adress" data-toggle="tab">{{ __('Adress') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">{{ __('Contact') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="company-info">
                                    <dl>
                                        <dt>{{ __('IM') }}</dt>
                                        <dd>{{ $client->im }}</dd>

                                        <dt>{{ __('IE') }}</dt>
                                        <dd>{{ $client->ie }}</dd>

                                        <dt>{{ __('Client Activity')  }}</dt>
                                        <dd>{{ $client->activity->name }}</dd>

                                        <dt>{{ __('Home Page')  }}</dt>
                                        <dd><a href="{{ $client->home_page }}">{{ $client->home_page }}</a></dd>

                                        <dt>{{ __('Description')  }}</dt>
                                        <dd>{{ $client->description }}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane" id="adress">
                                    <dl>
                                        <dt>{{ __('Street') }}</dt>
                                        <dd>{{ $client->adress }}</dd>

                                        <dt>{{ __('Adress Number') }}</dt>
                                        <dd>{{ $client->adress_number }}</dd>

                                        <dt>{{ __('Complement')  }}</dt>
                                        <dd>{{ $client->activity->adress_comp }}</dd>

                                        <dt>{{ __('District')  }}</dt>
                                        <dd>{{ $client->adress_district }}</a></dd>

                                        <dt>{{ __('City')  }}</dt>
                                        <dd>{{ $client->city }}</dd>

                                        <dt>{{ __('State')  }}</dt>
                                        <dd>{{ $client->adress_state }}</dd>

                                        <dt>{{ __('Zip code')  }}</dt>
                                        <dd>{{ $client->adress_cep }}</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane" id="contact">
                                    @foreach ($client->contacts as $contact)
                                        <p><strong>{{ $contact->contactType->name }}</strong></p>
                                        <dl>
                                            <dt>{{ __('Contact') }}</dt>
                                            <dd>{{ $contact->contact }}</dd>

                                            <dt>{{ __('Department') }}</dt>
                                            <dd>{{ $contact->department }}</dd>

                                            <dt>{{ __('Phone')  }}</dt>
                                            <dd><a href="tel:+{{ $contact->phone }}">{{ $contact->phone }}</a></dd>

                                            <dt>{{ __('Mobile Phone')  }}</dt>
                                            <dd>{{ $contact->mobile_phone }}</a></dd>

                                            <dt>{{ __('Email')  }}</dt>
                                            <dd><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></dd>
                                        </dl>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



