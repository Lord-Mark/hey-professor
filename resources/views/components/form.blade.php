@props(['action', 'post' => null, 'put' => null, 'delete' => null, 'get' => null])

<form action="{{ $action }}" method="{{ $get ?: 'post' }}">
    @csrf

    @if ($put)
        @method('PUT')
    @endif
    @if ($delete)
        @method('DELETE')
    @endif

    {{ $slot }}
</form>
