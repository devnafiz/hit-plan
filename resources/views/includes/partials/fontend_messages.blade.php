@if (session()->get('flash_success'))
    {{ alert()->success('Success !', session()->get('flash_success')) }}
@endif

@if (session()->get('flash_warning'))
    {{ alert()->warning('warning !', session()->get('flash_warning')) }}
@endif

@if (session()->get('flash_info'))
    {{ alert()->info('info !', session()->get('flash_info')) }}
@endif

@if (session()->get('flash_danger'))
    {{ alert()->danger('danger !', session()->get('flash_danger')) }}
@endif
