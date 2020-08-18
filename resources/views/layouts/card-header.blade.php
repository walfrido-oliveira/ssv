<div class="card-header">
    @isset ($create)
        <a href="{{ $create }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> {{ __('Add New') }}</i></a>
    @endif
    <div class="card-tools">
        <form action="{{ $index }}" method="GET">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control float-right" placeholder="{{ __('Search') }}" value="{{ request()->get('q') }}">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
                <a class="btn btn-default" href="{{ $index }}"><i class="fas fa-redo-alt"></i></a>
            </div>
        </form>
    </div>
</div>
