@props(['action', 'patch' => null, 'post' => null, 'put' => null, 'delete' => null, 'get' => null])

<form action="{{ $action }}" method="{{ $get ?: 'post' }}" {{ $attributes }}>
    @csrf

    @if ($put)
        @method('PUT')
    @endif
    @if ($patch)
        @method('PATCH')
    @endif
    @if ($delete)
        @method('DELETE')
    @endif

    {{ $slot }}
</form>
