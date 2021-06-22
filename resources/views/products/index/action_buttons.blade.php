@if (Route::has($resource_route.'.show'))
    @if ((auth()->check() && auth()->user()->can('view', $model)) || auth()->guest())
        <a href="{{ route($resource_route.'.show', [ $model->getKey(), 'redirect' => request()->fullUrl() ]) }}"
           class="btn btn-success btn-sm btn-xs" title="{{ __('Show') }}"><i class="fa fa-eye"></i></a>
    @endif
@endif
@if (Route::has($resource_route.'.adjust'))
    @if ((auth()->check() && auth()->user()->can('adjust', $model)) || auth()->guest())
        <a href="{{ route($resource_route.'.adjust', [ $model->getKey(), 'redirect' => request()->fullUrl() ]) }}"
           class="btn btn-primary btn-sm btn-xs" title="{{ __('Adjust') }}"><i class="fa fa-adjust"></i></a>
    @endif
@endif
@if (Route::has($resource_route.'.edit'))
    @if ((auth()->check() && auth()->user()->can('update', $model)) || auth()->guest())
        <a href="{{ route($resource_route.'.edit', [ $model->getKey(), 'redirect' => request()->fullUrl() ]) }}"
           class="btn btn-warning btn-sm btn-xs" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>
    @endif
@endif
@if (Route::has($resource_route.'.destroy'))
    @if ((auth()->check() && auth()->user()->can('delete', $model)) || auth()->guest())
        <form style="display:inline"
              action="{{ route($resource_route.'.destroy', [ $model->getKey(), 'redirect' => request()->fullUrl() ]) }}"
              method="POST"
              onsubmit="return confirm('Menghapus {{$model->name}} juga akan menghapus semua transaksi yang pernah dilakukan dari barang ini. Anda Yakin?');">
            {{ csrf_field() }}
{{--            onsubmit="return confirm('{{ __('Are you sure you want to :do?', [ 'do' => ucwords(__('Delete')) ]) }}');"--}}
            <button type="submit" class="btn btn-danger btn-sm btn-xs" name="_method"
                    value="DELETE" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
        </form>
    @endif
@endif
