@foreach (['danger', 'warning', 'success', 'info', 'error'] as $msg)
    @if(session()->has($msg))
        <div class="flash-message {{ $msg  }}">
            <p class="alert alert-success">
                {{ session()->get($msg) }}
            </p>
        </div>
    @endif
@endforeach
@if ($errors->any())
    <div class="mb-4 font-medium text-sm text-red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
