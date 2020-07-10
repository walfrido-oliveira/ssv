<div class="row">
    <div class="col-6">
        <strong>Copyright © {{ date('Y') }} <a href="{{ url('/') }}">{{  config('app.name', 'SSV') }}</a>.</strong> All rights reserved.
    </div>
    <div class="col-6 text-right">
        <b>Version</b> {{ env('APP_VERSION', '') }}
    </div>
</div>
